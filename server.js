require('dotenv').config();
const express = require("express");
const axios = require("axios");
const path = require("path");
const session = require("express-session");
const db = require("./config/db");
const bcrypt = require("bcryptjs");
const multer = require("multer");
const fs = require("fs");
const cors = require("cors");
const helmet = require("helmet");
const morgan = require("morgan");
const compression = require("compression");
const rateLimit = require("express-rate-limit");
const nodemailer = require("nodemailer");
const cookieParser = require("cookie-parser");
const csrf = require("csurf");
const { body, validationResult } = require("express-validator");
const stripe = require("stripe")(process.env.STRIPE_SECRET_KEY);
const { OAuth2Client } = require("google-auth-library");

const app = express();

// ─── GOOGLE OAUTH CONFIG ───
const googleClient = new OAuth2Client(
  process.env.GOOGLE_CLIENT_ID,
  process.env.GOOGLE_CLIENT_SECRET,
  process.env.GOOGLE_CALLBACK_URL
);

// ─── PRODUCTION SECURITY MIDDLEWARE ───
app.use(helmet({ contentSecurityPolicy: false })); // Security headers (CSP disabled for inline styles/scripts in EJS)
app.use(compression()); // Gzip compression
app.use(morgan('combined')); // Structured request logging

// Rate limiting for auth routes
const authLimiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 20, // 20 attempts per window
  message: 'Too many attempts, please try again after 15 minutes.',
  standardHeaders: true,
  legacyHeaders: false,
});

app.use(cors({
  origin: "*",
  methods: ["GET", "POST", "PUT", "DELETE"],
  allowedHeaders: ["Content-Type", "Authorization"],
}));
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));
app.use(express.static(path.join(__dirname, "public")));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(session({
  secret: process.env.SESSION_SECRET || 'fallback_dev_secret_change_in_production',
  resave: false,
  saveUninitialized: false,
  cookie: {
    maxAge: 24 * 60 * 60 * 1000,
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax'
  }
}));

// CSRF Protection (ignored for Stripe webhooks if any, but none here)
const csrfProtection = csrf({ cookie: true });
app.use(csrfProtection);

app.use((req, res, next) => {
  res.locals.csrfToken = req.csrfToken();
  next();
});

// ─── EMAIL TRANSPORTER ───
const emailTransporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST || 'smtp.gmail.com',
  port: parseInt(process.env.SMTP_PORT) || 587,
  secure: false,
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASS,
  },
});

// ─── ADMIN AUTH GUARD MIDDLEWARE ───
function requireAdmin(req, res, next) {
  if (!req.session.user) return res.redirect("/login");
  if (res.locals.user && (res.locals.user.user_type === 'Admin' || res.locals.user.user_type === 'admin')) {
    return next();
  }
  return res.status(403).render("error", { title: "Access Denied", message: "You do not have permission to access this page.", code: 403 });
}



//Middleware
app.use(async (req, res, next) => {
  try { const [result] = await db.query("SELECT * FROM aalierp_contents"); res.locals.content = result; next(); } catch (err) { console.error("Content DB error:", err); res.locals.content = []; next(); } 
});
app.use(async (req, res, next) => {
  try { res.locals.user = req.session.user || null; const userId = req.session.user; const status = "Approved"; if (!userId) return next();
    const [userResult] = await db.query("SELECT `user_id`, `user_image`, `user_name`, `user_username`, `user_mobile`, `user_email`, `user_password`, `user_passcode`, `user_type`, `user_ip`, `user_city`, `user_country`, `user_status`, DATE_FORMAT(created_on, '%b %d %Y') AS created_date FROM aalierp_user WHERE user_id = ?", [userId]);
    if (!userResult || userResult.length === 0) return next(); const user = userResult[0]; res.locals.user = user; next();
  } catch (err) { console.error("Middleware DB Error:", err); next(); } 
});
//User IP..
app.use(async (req, res, next) => {
  try { let ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress; const { data } = await axios.get(`http://ip-api.com/json/${ip}`);
    req.countryCode = data.countryCode;
    res.locals.ipInfo = { user_ip: ip, user_city: data.city || "", user_country: data.country || "", user_cc: data.countryCode || "", };
    res.locals.cc = data.countryCode || "";
  } catch (err) { console.error("IP API Error:", err.message); res.locals.ipInfo = { user_ip: "", user_city: "", user_country: "", user_cc: "" }; res.locals.cc = ""; } 
  next();
});
app.use(async (req, res, next) => {
  try { const { user_cc } = res.locals.ipInfo; if (!user_cc) return next();
    const [result] = await db.query("SELECT * FROM aalierp_currency WHERE cur_cc = ?", [user_cc]);
    if (result.length > 0) {res.locals.cur = result[0]; res.locals.cur_rate = result[0].cur_rate; } else { res.locals.cur = null; res.locals.cur_rate = null; }
  } catch (err) {console.error("Currency DB error:", err.message);} 
  next();
});
const storage = multer.diskStorage({ destination: function (req, file, cb) { cb(null, "public/uploads/"); }, filename: function (req, file, cb) { cb(null, Date.now() + "-" + file.originalname); } });
const upload = multer({ storage: storage });

app.use("/api", require("./routes/api"));



app.use(async (req, res, next) => {
  try { 
    if (req.session.user) {
      const [countResult] = await db.query("SELECT SUM(qty) AS totalItems FROM aalierp_cart WHERE user_id = ?", [req.session.user]);
      res.locals.cartCount = countResult[0].totalItems || 0;
    } else {
      res.locals.cartCount = 0;
    }
  } catch (err) { 
    console.error("Cart Count DB Error:", err); 
    res.locals.cartCount = 0;
  }
  next();
});

// HOME ROUTE → REDIRECT TO SPLASH
app.get("/", (req, res) => { res.redirect("/home"); });

// MODERN UI ROUTES
app.get("/splash", (req, res) => { res.render("splash"); });
app.get("/onboarding", (req, res) => { res.render("onboarding"); });
app.get("/auth-choice", (req, res) => { res.render("auth_choice"); });
app.get("/login", (req, res) => { res.render("login_modern", { message: null }); });
app.get("/signup", (req, res) => { res.render("signup"); });
app.get("/verify-otp", (req, res) => { res.render("verify_otp"); });
app.get("/forgot-password", (req, res) => { res.render("forgot_password"); });

// CART ROUTES
app.post("/cart/add", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    const { product_id, qty = 1 } = req.body;
    try {
        const [existing] = await db.query("SELECT * FROM aalierp_cart WHERE user_id = ? AND p_id = ?", [req.session.user, product_id]);
        if (existing.length > 0) {
            await db.query("UPDATE aalierp_cart SET qty = qty + ? WHERE id = ?", [qty, existing[0].id]);
        } else {
            await db.query("INSERT INTO aalierp_cart (user_id, p_id, qty, date, ip_add) VALUES (?, ?, ?, NOW(), ?)", [req.session.user, product_id, qty, req.ip]);
        }
        const referer = req.get('Referer');
        res.redirect(referer || '/cart-view');
    } catch (err) {
        console.error("Cart Add Error:", err);
        const referer = req.get('Referer');
        res.redirect(referer || '/cart-view');
    }
});

app.post("/cart/remove/:cart_id", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    try {
        await db.query("DELETE FROM aalierp_cart WHERE id = ? AND user_id = ?", [req.params.cart_id, req.session.user]);
        res.redirect("/cart-view");
    } catch (err) {
        console.error("Cart Remove Error:", err);
        res.redirect("/cart-view");
    }
});

app.get("/cart-view", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    try {
        const [items] = await db.query(`
            SELECT c.id AS cart_id, c.qty, p.product_name, p.product_price, p.product_image 
            FROM aalierp_cart c 
            JOIN aalierp_product p ON c.p_id = p.product_id 
            WHERE c.user_id = ?
        `, [req.session.user]);
        
        let total = items.reduce((acc, item) => acc + (parseFloat(item.product_price) * item.qty), 0);
        res.render("cart", { items, total });
    } catch (err) {
        console.error("Cart Fetch Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// CHECKOUT ROUTES
app.get("/checkout", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    try {
        const [items] = await db.query(`
            SELECT c.qty, p.product_price 
            FROM aalierp_cart c 
            JOIN aalierp_product p ON c.p_id = p.product_id 
            WHERE c.user_id = ? AND c.status = 'Pending'
        `, [req.session.user]);
        
        if (items.length === 0) return res.redirect("/cart-view");
        
        let total = items.reduce((acc, item) => acc + (parseFloat(item.product_price) * item.qty), 0);
        res.render("checkout", { total });
    } catch (err) {
        console.error("Checkout GET Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

app.post("/checkout/process", [
    body('full_name').trim().escape(),
    body('address_1').trim().escape(),
    body('city').trim().escape(),
    body('postcode').trim().escape(),
    body('phone').trim().escape()
], async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
        return res.status(400).send("⚠️ Invalid data in checkout form.");
    }
    const { payment_method } = req.body;
    try {
        // Just mark pending items as Processing and store payment method in ship column
        await db.query("UPDATE aalierp_cart SET status = 'Processing', ship = ? WHERE user_id = ? AND status = 'Pending'", [payment_method, req.session.user]);
        res.redirect("/order-success");
    } catch (err) {
        console.error("Checkout Process Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

app.get("/order-success", (req, res) => {
    res.render("order_success");
});

app.get("/profile", (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    res.render("profile");
});

// HOME SCREEN (CUSTOMER)
app.get("/home", async (req, res) => {
    try {
        const [categories] = await db.query("SELECT * FROM aalierp_category LIMIT 4");
        const [products] = await db.query("SELECT * FROM aalierp_product WHERE product_status = 'Active' LIMIT 6");
        res.render("home", { categories, products });
    } catch (err) {
        console.error("❌ Home route error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// SHOP VIEW (CUSTOMER LISTING)
app.get("/shop", async (req, res) => {
    try {
        const { category_id } = req.query;
        let productsQuery = "SELECT * FROM aalierp_product WHERE product_status = 'Active'";
        const queryParams = [];

        if (category_id) {
            productsQuery += " AND category_id = ?";
            queryParams.push(category_id);
        }

        const [products] = await db.query(productsQuery, queryParams);
        const [categories] = await db.query("SELECT * FROM aalierp_category");

        res.render("shop", { categories, products, activeCategoryId: category_id });
    } catch (err) {
        console.error("❌ Shop route error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// PRODUCT DETAIL PAGE (CUSTOMER)
app.get("/product/:id", async (req, res) => {
    try {
        const productId = req.params.id;
        const [rows] = await db.query(
            `SELECT p.*, c.category_name, u.unit_name 
             FROM aalierp_product p 
             LEFT JOIN aalierp_category c ON p.category_id = c.category_id 
             LEFT JOIN aalierp_unit u ON p.unit_id = u.unit_id 
             WHERE p.product_id = ? AND p.product_status = 'Active'`,
            [productId]
        );

        if (rows.length === 0) {
            return res.redirect("/home");
        }

        res.render("product_detail", { 
            product: rows[0], 
            csrfToken: req.csrfToken ? req.csrfToken() : '' 
        });
    } catch (err) {
        console.error("❌ Product Route Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// STRIPE PAYMENT INTENT
app.post("/create-payment-intent", async (req, res) => {
    const { amount } = req.body;
    try {
        const paymentIntent = await stripe.paymentIntents.create({
            amount: Math.round(amount * 100), // convert to pence/cents
            currency: "gbp",
            automatic_payment_methods: { enabled: true },
        });
        res.send({ clientSecret: paymentIntent.client_secret });
    } catch (err) {
        console.error("Stripe Error:", err);
        res.status(500).send({ error: err.message });
    }
});

// ─── GOOGLE AUTH ROUTES ───
app.get("/auth/google", (req, res) => {
  const url = googleClient.generateAuthUrl({
    access_type: "offline",
    scope: ["https://www.googleapis.com/auth/userinfo.profile", "https://www.googleapis.com/auth/userinfo.email"],
  });
  res.redirect(url);
});

app.get("/auth/google/callback", async (req, res) => {
  const { code } = req.query;
  try {
    const { tokens } = await googleClient.getToken(code);
    googleClient.setCredentials(tokens);
    const userInfo = await axios.get("https://www.googleapis.com/oauth2/v3/userinfo", {
      headers: { Authorization: `Bearer ${tokens.access_token}` },
    });
    const { email, name, sub: google_id } = userInfo.data;

    // Check if user exists
    const [existingUsers] = await db.query("SELECT * FROM aalierp_user WHERE user_email = ?", [email]);
    let user;
    if (existingUsers.length > 0) {
      user = existingUsers[0];
    } else {
      // Create new user (social logins don't have passwords)
      const username = email.split('@')[0] + Math.floor(Math.random() * 1000);
      const [insertResult] = await db.query(
        "INSERT INTO aalierp_user (user_name, user_username, user_email, user_type, user_status, created_on) VALUES (?, ?, ?, 'Customer', 'Active', NOW())",
        [name, username, email]
      );
      user = { user_id: insertResult.insertId, user_name: name, user_email: email, user_type: 'Customer' };
    }

    req.session.user = user.user_id;
    res.redirect("/home");
  } catch (err) {
    console.error("Google Auth Callback Error:", err);
    res.status(500).send("Authentication Failed");
  }
});

// LOGIN POST (rate-limited and sanitized)
app.post("/login", [
    authLimiter,
    body('identifier').trim().escape(),
    body('user_password').trim()
], async (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
        return res.render("login_modern", { message: "⚠️ Invalid input format!" });
    }
    const log = (msg) => console.log(`[LOGIN] ${msg}`);
  
  try { 
    const { identifier, user_password } = req.body; 
    log(`Login attempt for: ${identifier}`);
    
    if (!identifier || !user_password) { 
      log(`Missing credentials`);
      return res.render("login_modern", { message: "⚠️ Please enter username/email and password!" }); 
    }
    
    const sql = `SELECT * FROM aalierp_user WHERE user_email = ? OR user_username = ? LIMIT 1`; 
    log(`Running SQL: ${sql} with identifier: ${identifier}`);
    const [results] = await db.query(sql, [identifier, identifier]);
    log(`Results count: ${results.length}`);
    
    if (results.length === 0) { 
      log(`User not found`);
      return res.render("login_modern", { message: "⚠️ Invalid credentials!" }); 
    }
    
    const user = results[0];
    log(`User found: ${user.user_id}, status: ${user.user_status}, pass_type: ${user.user_password.startsWith('$2') ? 'bcrypt' : 'other'}`);
    
    const md5 = require("md5");
    let matchBcrypt = false;
    try {
      if (user.user_password.startsWith('$2')) {
        matchBcrypt = await bcrypt.compare(user_password, user.user_password);
        log(`Bcrypt match: ${matchBcrypt}`);
      } else {
        log(`Skipping bcrypt, hash doesn't look like bcrypt`);
      }
    } catch (bcErr) {
      log(`Bcrypt error: ${bcErr.message}`);
    }

    const matchMD5 = (md5(user_password) === user.user_password);
    log(`MD5 match: ${matchMD5}`);

    if (matchBcrypt || matchMD5) { 
      log(`Authentication SUCCESS. Redirecting to /home`);
      req.session.user = user.user_id; 
      return res.redirect("/home"); 
    } else { 
      log(`Authentication FAILED (wrong password)`);
      return res.render("login_modern", { message: "⚠️ Invalid credentials!" }); 
    }
  } catch (err) { 
    log(`❌ Login FATAL error: ${err.message}\n${err.stack}`);
    console.error("❌ Login error:", err); 
    res.status(500).send("Internal Server Error: " + err.message); 
  }
});

// SIGNUP POST (REAL)
app.post("/signup", async (req, res) => {
    const { user_name, user_email, user_password } = req.body;
    if (!user_name || !user_email || !user_password) {
        return res.render("signup", { message: "⚠️ All fields are required!" });
    }
    try {
        // Check if email already exists
        const [existing] = await db.query("SELECT * FROM aalierp_user WHERE user_email = ? LIMIT 1", [user_email]);
        if (existing.length > 0) {
            return res.render("signup", { message: "⚠️ Email already registered!" });
        }
        
        const hashedPassword = await bcrypt.hash(user_password, 10);
        const username = user_email.split('@')[0]; // Auto-generate username from email
        
        await db.query(
            "INSERT INTO aalierp_user (user_username, user_name, user_email, user_password, user_type, user_status, created_on) VALUES (?, ?, ?, ?, 'User', 'Approved', NOW())",
            [username, user_name, user_email, hashedPassword]
        );
        res.redirect("/login");
    } catch (err) {
        console.error("Signup Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

//Logout
app.get("/logout", (req, res) => { req.session.destroy(() => res.redirect("/")); });

// PRODUCT SEARCH
app.get("/search", async (req, res) => {
    const { q } = req.query;
    try {
        const [categories] = await db.query("SELECT * FROM aalierp_category");
        if (!q || q.trim() === '') {
            return res.render("shop", { categories, products: [], activeCategoryId: null });
        }
        const searchTerm = `%${q}%`;
        const [products] = await db.query(
            "SELECT * FROM aalierp_product WHERE product_status = 'Active' AND (product_name LIKE ? OR product_keywords LIKE ? OR product_desc LIKE ?)",
            [searchTerm, searchTerm, searchTerm]
        );
        res.render("shop", { categories, products, activeCategoryId: null });
    } catch (err) {
        console.error("Search Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// WISHLIST ROUTES
app.post("/wishlist/toggle", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    const { product_id } = req.body;
    try {
        const [existing] = await db.query("SELECT * FROM aalierp_wishlist WHERE user_id = ? AND product_id = ?", [req.session.user, product_id]);
        if (existing.length > 0) {
            await db.query("DELETE FROM aalierp_wishlist WHERE user_id = ? AND product_id = ?", [req.session.user, product_id]);
        } else {
            await db.query("INSERT INTO aalierp_wishlist (user_id, product_id) VALUES (?, ?)", [req.session.user, product_id]);
        }
        const referer = req.get('Referer');
        res.redirect(referer || '/shop');
    } catch (err) {
        console.error("Wishlist Error:", err);
        const referer = req.get('Referer');
        res.redirect(referer || '/shop');
    }
});

app.get("/wishlist", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    try {
        const [products] = await db.query(`
            SELECT p.* FROM aalierp_wishlist w 
            JOIN aalierp_product p ON w.product_id = p.product_id 
            WHERE w.user_id = ?
        `, [req.session.user]);
        const [categories] = await db.query("SELECT * FROM aalierp_category");
        res.render("shop", { categories, products, activeCategoryId: null });
    } catch (err) {
        console.error("Wishlist View Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// CUSTOMER ORDER HISTORY
app.get("/my-orders", async (req, res) => {
    if (!req.session.user) return res.redirect("/login");
    try {
        const [orders] = await db.query(`
            SELECT c.id, c.qty, c.status, c.date, c.ship AS payment_method, 
                   p.product_name, p.product_price, p.product_image,
                   (p.product_price * c.qty) AS total_amount
            FROM aalierp_cart c 
            JOIN aalierp_product p ON c.p_id = p.product_id 
            WHERE c.user_id = ? AND c.status != 'Pending'
            ORDER BY c.date DESC
        `, [req.session.user]);
        res.render("my_orders", { orders });
    } catch (err) {
        console.error("My Orders Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

// FORGOT PASSWORD
app.post("/forgot-password", async (req, res) => {
    const { user_email } = req.body;
    try {
        const [users] = await db.query("SELECT * FROM aalierp_user WHERE user_email = ? LIMIT 1", [user_email]);
        if (users.length === 0) {
            return res.render("forgot_password", { message: "⚠️ Email not found!" });
        }
        // Generate a random 6-digit OTP and store in user_email_otp
        const otp = Math.floor(100000 + Math.random() * 900000).toString();
        await db.query("UPDATE aalierp_user SET user_email_otp = ? WHERE user_email = ?", [otp, user_email]);
        
        // ACTUAL EMAIL DELIVERY
        const mailOptions = {
          from: `"NI DRIP Support" <${process.env.SMTP_USER}>`,
          to: user_email,
          subject: "Your Password Reset OTP",
          html: `
            <div style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
              <h2 style="color: #1A1A1A;">Password Reset Request</h2>
              <p>Hello,</p>
              <p>You requested a password reset. Use the following 6-digit OTP to continue:</p>
              <div style="font-size: 32px; font-weight: bold; letter-spacing: 10px; color: #00DB72; margin: 20px 0;">${otp}</div>
              <p>If you didn't request this, you can safely ignore this email.</p>
              <p>Best regards,<br>NI DRIP Team</p>
            </div>
          `
        };

        try {
          await emailTransporter.sendMail(mailOptions);
          console.log(`✅ OTP sent to ${user_email}`);
        } catch (mailErr) {
          console.error("❌ Email Delivery Error:", mailErr);
          // Fallback log for demo if SMTP fails
          console.log(`🔑 FALLBACK OTP for ${user_email}: ${otp}`);
        }
        
        req.session.resetEmail = user_email;
        req.session.resetOtp = otp;
        
        res.redirect("/verify-otp");
    } catch (err) {
        console.error("Forgot Password Error:", err);
        res.status(500).send("Internal Server Error");
    }
});

app.post("/verify-otp", async (req, res) => {
    const { otp_1, otp_2, otp_3, otp_4, otp_5, otp_6 } = req.body;
    const otp = `${otp_1}${otp_2}${otp_3}${otp_4}${otp_5}${otp_6}`;
    
    if (!req.session.resetEmail) return res.redirect("/forgot-password");
    
    if (otp === req.session.resetOtp) {
        res.render("reset_password", { email: req.session.resetEmail, message: null });
    } else {
        res.render("verify_otp", { message: "⚠️ Invalid OTP. Please try again." });
    }
});

app.post("/reset-password", async (req, res) => {
    const { email, new_password } = req.body;
    try {
        const hashedPassword = await bcrypt.hash(new_password, 10);
        await db.query("UPDATE aalierp_user SET user_password = ?, user_email_otp = NULL WHERE user_email = ?", [hashedPassword, email]);
        req.session.resetEmail = null;
        req.session.resetOtp = null;
        res.redirect("/login");
    } catch (err) {
        console.error("Reset Password Error:", err);
        res.status(500).send("Internal Server Error");
    }
});



// DASHBOARD
// ─── ADMIN PANEL ROUTES (Protected by requireAdmin) ───
// Blanket admin guard for all admin-area paths
app.use(['/dashboard', '/products', '/orders', '/stocks', '/reviews', '/tickets', '/settings', '/users'], requireAdmin);

app.get("/dashboard", (req, res) => { res.render("dashboard", { userId: req.session.user, activePage: "dashboard" }); });
// Products
app.get("/products", async (req, res) => {
    try { const [products] = await db.query("SELECT * FROM aalierp_product ORDER BY product_id DESC");
        res.render("products", { products, activePage: "products" });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
// Add Unit
app.get("/products/add-unit", async (req, res) => {
    try { const [units] = await db.query("SELECT * FROM aalierp_unit ORDER BY unit_id DESC");
        res.render("add-unit", { units, activePage: "products" });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/add-unit", async (req, res) => {
    const { unit_name, created_by } = req.body;
    const sql = `INSERT INTO aalierp_unit (unit_name, created_on, created_by) VALUES (?, NOW(), ?)`;
    try { await db.query(sql, [unit_name, created_by]); res.redirect("/products"); } catch (err) {
        console.error(err); res.status(500).send("Database Error");
    }
});
app.get("/products/update-unit/:unit_id", async (req, res) => {
    const { unit_id } = req.params;
    try {const [unitResult] = await db.query("SELECT * FROM aalierp_unit WHERE unit_id = ?", [unit_id]);
        if (!unitResult || unitResult.length === 0) return res.status(404).send("Unit not found");
        const unit = unitResult[0]; const [units] = await db.query("SELECT * FROM aalierp_unit ORDER BY unit_id DESC");
        res.render("update-unit", { unit, units, activePage: "products", user: req.session.user });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/update-unit/:unit_id", async (req, res) => {
    const { unit_id } = req.params;
    const { unit_name } = req.body;
    const updated_by = req.session.user?.user_name || "Unknown";
    const sql = `UPDATE aalierp_unit SET unit_name = ?, updated_on = NOW(), created_by = ? WHERE unit_id = ?`;
    try { await db.query(sql, [unit_name, updated_by, unit_id]); res.redirect("/products/add-unit"); 
    } catch (err) { console.error(err); res.status(500).send("Database Error");}
});
app.get("/products/delete-unit/:id", async (req, res) => {
    try {const unit_id = req.params.id;
        const [used] = await db.query("SELECT COUNT(*) AS total FROM aalierp_product WHERE unit_id = ?", [unit_id]);
        if (used[0].total > 0) {return res.redirect("/products?error=" + encodeURIComponent("Cannot delete. Unit is used in products."));}
        await db.query("DELETE FROM aalierp_unit WHERE unit_id = ?", [unit_id]);
        res.redirect("/products?success=" + encodeURIComponent("Unit deleted successfully"));
    } catch (err) {console.error(err);res.redirect("/products?error=" + encodeURIComponent("Database Error"));}
});
// Add Category
app.get("/products/add-category", async (req, res) => {
    try { const [cats] = await db.query("SELECT * FROM aalierp_category ORDER BY category_id DESC");
        res.render("add-category", { cats, activePage: "products" });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/add-category", async (req, res) => {
    const { category_name, created_by } = req.body;
    const sql = `INSERT INTO aalierp_category (category_name, created_on, created_by) VALUES (?, NOW(), ?)`;
    try { await db.query(sql, [category_name, created_by]); res.redirect("/products"); } catch (err) {
        console.error(err); res.status(500).send("Database Error");
    }
});
app.get("/products/update-category/:category_id", async (req, res) => { const { category_id } = req.params;
    try {const [catResult] = await db.query("SELECT * FROM aalierp_category WHERE category_id = ?", [category_id]);
        if (!catResult || catResult.length === 0) return res.status(404).send("Category not found");
        const cat = catResult[0];
        const [cats] = await db.query("SELECT * FROM aalierp_category ORDER BY category_id DESC");
        res.render("update-category", { cat, cats, activePage: "products", user: req.session.user });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/update-category/:category_id", async (req, res) => {
    const { category_id } = req.params;
    const { category_name } = req.body;
    const updated_by = req.session.user?.user_name || "Unknown";
    const sql = `UPDATE aalierp_category SET category_name = ?, updated_on = NOW(), created_by = ? WHERE category_id = ?`;
    try {await db.query(sql, [category_name, updated_by, category_id]); res.redirect("/products/add-category"); 
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.get("/products/delete-category/:id", async (req, res) => {
    try {const category_id = req.params.id;
        const [usedInSub] = await db.query("SELECT COUNT(*) AS total FROM aalierp_subcategory WHERE category_id = ?", [category_id]);
        const [usedInProd] = await db.query("SELECT COUNT(*) AS total FROM aalierp_product WHERE category_id = ?", [category_id]);
        if (usedInSub[0].total > 0 || usedInProd[0].total > 0) {
            return res.redirect("/products?error=" + encodeURIComponent("Cannot delete. Category is used in subcategories or products."));
        }
        await db.query("DELETE FROM aalierp_category WHERE category_id = ?", [category_id]);
        res.redirect("/products?success=" + encodeURIComponent("Category deleted successfully"));
    } catch (err) {console.error(err);res.redirect("/products?error=" + encodeURIComponent("Database Error"));}
});
// Add Sub Category
app.get("/products/add-subcategory", async (req, res) => {
    try {
        const [scats] = await db.query("SELECT s.*, c.category_name FROM aalierp_subcategory s LEFT JOIN aalierp_category c ON s.category_id = c.category_id ORDER BY s.subcategory_id DESC");
        const [categories] = await db.query("SELECT * FROM aalierp_category ORDER BY category_id DESC");
        res.render("add-subcategory", { scats, categories, activePage: "products", user: req.session.user });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/add-subcategory", async (req, res) => { const { subcategory_name, category_id } = req.body;
    const created_by = req.session.user?.user_name || "Unknown";
    const sql = `INSERT INTO aalierp_subcategory (category_id, subcategory_name, subcategory_status, created_on, created_by) VALUES (?, ?, 'Active', NOW(), ?)`;
    try { await db.query(sql, [category_id, subcategory_name, created_by]); res.redirect("/products/add-subcategory"); 
    } catch (err) { console.error(err); res.status(500).send("Database Error");  }
});
app.get("/products/update-subcategory/:subcategory_id", async (req, res) => { const { subcategory_id } = req.params;
    try {const [scatResult] = await db.query("SELECT * FROM aalierp_subcategory WHERE subcategory_id = ?", [subcategory_id]);
        if (!scatResult || scatResult.length === 0) return res.status(404).send("Sub Category not found");
        const scat = scatResult[0];
        const [scats] = await db.query(`SELECT s.*, c.category_name FROM aalierp_subcategory s LEFT JOIN aalierp_category c 
        ON s.category_id = c.category_id ORDER BY s.subcategory_id DESC`);
        const [categories] = await db.query("SELECT * FROM aalierp_category ORDER BY category_name ASC");
        res.render("update-subcategory", {scat,scats,categories,activePage: "products",user: req.session.user});
    } catch (err) { console.error(err); res.status(500).send("Database Error");}
});
app.post("/products/update-subcategory/:subcategory_id", async (req, res) => {
    const { subcategory_id } = req.params; const { subcategory_name, category_id } = req.body;
    const sql = `UPDATE aalierp_subcategory SET category_id = ?, subcategory_name = ?, updated_on = NOW() WHERE subcategory_id = ?`;
    try {await db.query(sql, [category_id, subcategory_name, subcategory_id]); res.redirect("/products/add-subcategory");
    } catch (err) { console.error(err); res.status(500).send("Database Error");}
});
app.get("/products/delete-subcategory/:id", async (req, res) => {
    try {const subcategory_id = req.params.id;
        const [used] = await db.query("SELECT COUNT(*) AS total FROM aalierp_product WHERE subcategory_id = ?", [subcategory_id]);
        if (used[0].total > 0) {
            return res.redirect("/products?error=" + encodeURIComponent("Cannot delete. Subcategory is used in products."));
        }
        await db.query("DELETE FROM aalierp_subcategory WHERE subcategory_id = ?", [subcategory_id]);
        res.redirect("/products?success=" + encodeURIComponent("Subcategory deleted successfully"));
    } catch (err) {console.error(err); res.redirect("/products?error=" + encodeURIComponent("Database Error"));}
});

//Add products
app.get("/products/add-product", async (req, res) => {
    try { const [categories] = await db.query("SELECT * FROM aalierp_category ORDER BY category_name ASC");
        const [scats] = await db.query("SELECT * FROM aalierp_subcategory ORDER BY subcategory_name ASC");
        const [units] = await db.query("SELECT * FROM aalierp_unit ORDER BY unit_name ASC");
        res.render("add-product", { categories, scats, units, activePage: "products", user: req.session.user });
    } catch (err) {console.error(err); res.status(500).send("Database Error"); }
});
app.post("/products/add-product", upload.single("product_image"), async (req, res) => {
    try {            
        const {category_id,subcategory_id,unit_id,product_name,product_price,product_old_price,product_discount,product_keywords,product_desc,product_status,product_video} = req.body;
        const created_by = req.session.user?.user_name || "Unknown";
        const product_image = req.file ? req.file.filename : null;
        const sql = `INSERT INTO aalierp_product (category_id,subcategory_id,unit_id,product_image,product_video,product_name,product_price,
        product_old_price,product_discount,product_keywords,product_desc,product_status,created_on,created_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)`;
        await db.query(sql, [category_id,subcategory_id,unit_id,product_image,product_video,product_name,product_price,product_old_price || 0,
        product_discount || 0,product_keywords,product_desc,product_status,created_by ]);
        res.redirect("/products");
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.get("/products/view-product/:id", async (req, res) => {
    try {const product_id = req.params.id;
        const [rows] = await db.query(`SELECT p.*, c.category_name, s.subcategory_name, u.unit_name FROM aalierp_product p
        LEFT JOIN aalierp_category c ON p.category_id = c.category_id LEFT JOIN aalierp_subcategory s ON p.subcategory_id = s.subcategory_id
        LEFT JOIN aalierp_unit u ON p.unit_id = u.unit_id WHERE p.product_id = ?`, [product_id]);
        if (rows.length === 0) { return res.status(404).send("Product not found"); }
        res.render("view-product", { product: rows[0], activePage: "products", user: req.session.user });
    } catch (err) {console.error(err);res.status(500).send("Database Error");}
});
app.get("/products/update-product/:id", async (req, res) => {
    try {const product_id = req.params.id;
        const [productRows] = await db.query("SELECT * FROM aalierp_product WHERE product_id = ?", [product_id]);
        if (productRows.length === 0) {return res.status(404).send("Product not found");}
        const [categories] = await db.query("SELECT * FROM aalierp_category");
        const [scats] = await db.query("SELECT * FROM aalierp_subcategory");
        const [units] = await db.query("SELECT * FROM aalierp_unit");
        res.render("update-product", {product: productRows[0],categories,scats,units,activePage: "products",user: req.session.user});
    } catch (err) {console.error(err);res.status(500).send("Database Error"); }
});
app.post("/products/update-product/:id", upload.single("product_image"), async (req, res) => {
    try {const product_id = req.params.id;
        const {category_id,subcategory_id,unit_id,product_name,product_price,product_old_price,product_discount,product_keywords,product_desc,product_status,product_video} = req.body;
        const [existing] = await db.query("SELECT product_image FROM aalierp_product WHERE product_id = ?", [product_id]);
        let product_image = existing[0].product_image;
        if (req.file) {product_image = "/uploads/" + req.file.filename; }
        const sql = `UPDATE aalierp_product SET category_id = ?, subcategory_id = ?, unit_id = ?, product_image = ?, product_video = ?, product_name = ?,
        product_price = ?, product_old_price = ?, product_discount = ?, product_keywords = ?, product_desc = ?, product_status = ?, updated_on = NOW()
        WHERE product_id = ?`;
        await db.query(sql, [category_id,subcategory_id,unit_id,product_image,product_video,product_name,product_price,product_old_price || 0,
        product_discount || 0,product_keywords, product_desc,product_status,product_id ]);
        res.redirect("/products/view-product/" + product_id);
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
app.get("/products/delete-product/:id", async (req, res) => {
    try {const product_id = req.params.id;
        await db.query("DELETE FROM aalierp_product WHERE product_id = ?", [product_id]);
        res.redirect("/products?success=" + encodeURIComponent("Product deleted successfully"));
    } catch (err) { console.error(err); res.redirect("/products?error=" + encodeURIComponent("Database Error"));}
});

// orders
app.get("/orders", async (req, res) => {
    const sql = `SELECT c.id, c.date, c.qty, c.status, u.user_name, p.product_name, p.product_price, (p.product_price * c.qty) AS total_amount
    FROM aalierp_cart c LEFT JOIN aalierp_user u ON c.user_id = u.user_id LEFT JOIN aalierp_product p ON c.p_id = p.product_id ORDER BY c.id DESC`;
    try {const [results] = await db.query(sql); res.render("orders", { activePage: "orders", orders: results });
    } catch (err) { console.error(err); res.send("Database Error"); }
});

//View order detail
app.get("/orders/view-order-detail/:id", async (req, res) => {const orderId = req.params.id;
    const sql = `SELECT c.*, u.user_name, u.user_email, u.user_mobile, p.product_name, p.product_price, p.product_image FROM aalierp_cart c
    LEFT JOIN aalierp_user u ON c.user_id = u.user_id LEFT JOIN aalierp_product p ON c.p_id = p.product_id WHERE c.id = ?`;
    try {const [results] = await db.query(sql, [orderId]); if (results.length === 0) return res.send("Order not found");
        const order = results[0]; res.render("view-order-detail", { order, activePage: "orders" });
    } catch (err) { console.error(err); res.send("Database Error"); }
});
//Change Order Status
app.get("/orders/change-order-status/:id", async (req, res) => {const orderId = req.params.id;
    try {const [results] = await db.query("SELECT * FROM aalierp_cart WHERE id = ?", [orderId]);
        if (results.length === 0) return res.send("Order not found");
        res.render("change-order-status", { order: results[0], activePage: "orders" });
    } catch (err) {console.error(err); res.send("Database Error"); }
});
app.post("/orders/change-order-status/:id", async (req, res) => { const orderId = req.params.id; const { status } = req.body;
    console.log("Updating Order ID:", orderId, "to status:", status); 
    try { const [result] = await db.query("UPDATE aalierp_cart SET status = ? WHERE id = ?", [status, orderId]);
        console.log("DB Result:", result); res.redirect("/orders");
    } catch (err) { console.error(err); res.send("Database Error"); }
});
//Update Payment Status
app.get("/orders/update-payment-status/:id", async (req, res) => {const orderId = req.params.id;
    try {const [results] = await db.query("SELECT * FROM aalierp_cart WHERE id = ?", [orderId]);
        if (results.length === 0) return res.send("Order not found");
        res.render("update-payment-status", { order: results[0], activePage: "orders" });
    } catch (err) { console.error(err); res.send("Database Error");}
});
app.post("/orders/update-payment-status/:id", async (req, res) => {const orderId = req.params.id; const { payment_method } = req.body;
    try {await db.query("UPDATE aalierp_cart SET ship = ? WHERE id = ?", [payment_method, orderId]); res.redirect("/orders");
    } catch (err) { console.error(err); res.send("Database Error"); }
});
//Delete order..
app.get("/orders/delete/:id", async (req, res) => { const orderId = req.params.id;
    try {await db.query("DELETE FROM aalierp_cart WHERE id = ?", [orderId]);
        res.redirect("/orders?success=" + encodeURIComponent("Order deleted successfully"));
    } catch (err) { console.error(err); res.redirect("/orders?error=" + encodeURIComponent("Database Error"));}
});
// Inventory
app.get("/stocks", async (req, res) => {
    try { const [products] = await db.query("SELECT * FROM aalierp_product ORDER BY product_id DESC");
        res.render("stocks", { products, activePage: "stocks" });
    } catch (err) { console.error(err); res.status(500).send("Database Error"); }
});
//Reviews
app.get("/reviews", (req, res) => { res.render("reviews", { message: null, activePage: "reviews" }); });
//Reviews
app.get("/tickets", (req, res) => { res.render("tickets", { message: null, activePage: "tickets" }); });
//Reviews
app.get("/settings", (req, res) => { res.render("settings", { message: null, activePage: "settings" }); });


//View Users..
app.get("/users", async (req, res) => {
    try {const [users] = await db.query("SELECT * FROM aalierp_user ORDER BY user_id DESC");
        const totalUsers = users.length;
        const activeUsers = users.filter(u => u.user_status === "Approved").length;
        const inactiveUsers = users.filter(u => u.user_status !== "Approved").length;
        const [topBuyers] = await db.query(`SELECT u.user_name, COUNT(c.id) AS total_orders FROM aalierp_cart c JOIN aalierp_user u ON c.user_id = u.user_id
        GROUP BY c.user_id ORDER BY total_orders DESC LIMIT 1`);
        const topBuyer = topBuyers.length > 0 ? topBuyers[0].user_name : "N/A";
        res.render("users", { users, activePage: "users", stats: { totalUsers, activeUsers, inactiveUsers, topBuyer } });
    } catch (err) { console.error(err); res.send("Database Error"); }
});
// ─── ERROR PAGES ───
app.use((req, res) => {
  res.status(404).render("error", { title: "Page Not Found", message: "The page you are looking for doesn't exist or has been moved.", code: 404 });
});

app.use((err, req, res, next) => {
  console.error('Server Error:', err.stack);
  res.status(500).render("error", { title: "Server Error", message: "Something went wrong on our end. Please try again later.", code: 500 });
});

// KEEP-ALIVE PING: Prevent Render from sleeping
const https = require('https');
setInterval(() => {
    https.get('https://nidripcentral.onrender.com', (res) => {
        console.log(`[Keep-Alive] Pinged server, status: ${res.statusCode}`);
    }).on('error', (err) => {
        console.log(`[Keep-Alive] Ping failed: ${err.message}`);
    });
}, 10 * 60 * 1000); // Ping every 10 minutes

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`✅ Server running on http://localhost:${PORT} [${process.env.NODE_ENV || 'development'}]`);
});