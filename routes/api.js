const express = require("express");
const router = express.Router();
const axios = require("axios");
const db = require("../config/db");
const { JWT_SECRET } = require("../config/config");
const nodemailer = require("nodemailer");
const crypto = require("crypto");
const jwt = require("jsonwebtoken");
const bcrypt = require("bcryptjs");
const path = require("path");
const fs = require("fs");

// ==========================================================
// ✅   Mailer OTP
// ==========================================================
let transporter = nodemailer.createTransport({
  host: "mail.mraalionline.com",
  port: 587,
  secure: false, // IMPORTANT
  auth: {
    user: "support@mraalionline.com",
    pass: "Support@786#",
  },
  tls: {
    rejectUnauthorized: false // allow self-signed / shared hosting certs
  }
});

// ==========================================================
// ✅   Login API (fixed)
// ==========================================================
router.post("/login", async (req, res) => {
  try { 
    const { identifier, mobile, user_password } = req.body; 
    let sql, values;
    
    if (identifier) {
      sql = `SELECT * FROM aalierp_user WHERE (user_email = ? OR user_username = ?) LIMIT 1`; 
      values = [identifier, identifier];
    } else if (mobile) {
      sql = `SELECT * FROM aalierp_user WHERE user_mobile = ? LIMIT 1`; 
      values = [mobile];
    } else {
      return res.status(400).json({success: false, message: "Please enter email/username or mobile number.", }); 
    }
    
    const [results] = await db.query(sql, values);
    if (results.length === 0) { return res.status(401).json({ success: false, message: "Invalid credentials!" }); }
    
    const user = results[0];
    
    // Check password using bcrypt (or plain md5 if legacy - but we transition to bcrypt)
    const isMatch = await bcrypt.compare(user_password, user.user_password);
    if (!isMatch && user_password !== user.user_password) { // added plain check fallback for legacy
       return res.status(401).json({ success: false, message: "Invalid credentials!" });
    }

    if (user.user_status !== "Approved") { return res.status(403).json({ success: false, message: "Account not approved yet.", }); }
    
    req.session.user = user.user_id; 
    req.session.save();
    console.log("✅ Session created for user:", user.user_id);
    
    const token = jwt.sign({ userId: user.user_id }, JWT_SECRET, { expiresIn: "7d" });
    return res.json({ success: true, message: "Login successful", token, user_id: user.user_id, user_status: user.user_status, });
  } catch (err) { 
    console.error("❌ API Login error:", err); 
    return res.status(500).json({ success: false, message: "Internal Server Error", error: err.message,}); 
  }
});

// ==========================================================
// ✅   Register by email
// ==========================================================
router.post("/by-email", async (req, res) => {
  try { const { email, password, user_referred_by } = req.body;
    if (!email || !password) { return res.status(400).json({ status: "error", message: "Please enter email & password!", }); }
    const user_email_otp = Math.floor(100000 + Math.random() * 900000).toString();
    const user_referral = Math.floor(10000000 + Math.random() * 90000000).toString();
    const user_username = Math.floor(10000000 + Math.random() * 90000000).toString();
    const user_pin = Math.floor(1000 + Math.random() * 9000).toString();
    const user_email = email; 
    const user_password = await bcrypt.hash(password, 10); 
    const user_passcode = password; 
    const user_type = "User"; 
    const user_status = "Pending"; 
    const created_on = new Date();
    const user_ip = req.headers["x-forwarded-for"]?.split(",")[0] || req.socket.remoteAddress?.replace("::ffff:", "") || "Unknown";
    console.log("🌐 Detected IP:", user_ip); let user_city = req.body.city?.trim() || "Unknown"; let user_country = req.body.country?.trim() || "Unknown"; let user_cc = req.body.country_code?.trim() || "XX";
    try {
      const geoRes = await axios.get(`https://ipapi.co/${user_ip}/json/`);
      if (geoRes.data && !geoRes.data.error) {user_city = geoRes.data.city || user_city; user_country = geoRes.data.country_name || user_country; user_cc = geoRes.data.country_code || user_cc; }
    } catch (geoErr) {console.warn("⚠️ GeoIP lookup failed:", geoErr.message);}
    console.log("📍 Final Location:", { user_city, user_country, user_cc }); const [existingUser] = await db.query("SELECT * FROM aalierp_user WHERE user_email = ?", [user_email]);
    if (existingUser.length > 0) { return res.status(409).json({ status: "error", message: "Email already exists!", });
    }
    await db.query(
    `INSERT INTO aalierp_user (user_username,user_email,user_password,user_passcode,user_pin,user_email_otp,user_type,user_ip,user_city,user_country,user_cc,user_referred_by,user_referral,user_status,created_on) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
    [user_username,user_email,user_password,user_passcode,user_pin,user_email_otp,user_type,user_ip,user_city,user_country,user_cc,user_referred_by,user_referral,user_status,created_on]);
    let mailOptions = {from: '"Ni Drip" <support@mraalionline.com>', to: email, subject: "Verify your Email", text: `Your OTP code is: ${user_email_otp}`, };
    try { const result = await transporter.sendMail(mailOptions); console.log("📧 Email sent successfully:", result);
    } catch (emailErr) {  console.error("❌ Email send error:", emailErr); return res.status(500).json({ status: "error",message: "Email sending failed",error: emailErr.message }); }
    console.log("Email sent successfully:", email); return res.status(200).json({status: "success", message: "OTP sent to your email. Verify now.", next: "/by-email-otp", user_cc: user_cc,  });
  } catch (error) { console.error("Error in /by-email:", error); res.status(500).json({ status: "error", message: "Internal Server Error" });}
});

// ==========================================================
// ✅   Register by email OTP
// ==========================================================
router.post("/by-email-otp", async (req, res) => {
  try { const { user_cc, user_otp } = req.body;
    if (!user_cc || !user_otp) { return res.status(400).json({ status: "error", message: "OTP or country code missing!" }); }
    const [user] = await db.query("SELECT * FROM aalierp_user WHERE user_cc = ? AND user_email_otp = ? AND user_status = 'Pending'", [user_cc, user_otp]);
    if (user.length === 0) { return res.status(400).json({ status: "error", message: "Invalid OTP or already verified!" }); }
    await db.query("UPDATE aalierp_user SET user_status = 'Approved' WHERE user_cc = ? AND user_email_otp = ?", [user_cc, user_otp]);
    return res.status(200).json({ status: "success", message: "OTP verified successfully!" });
  } catch (error) { console.error("Error in /by-email-otp:", error); res.status(500).json({ status: "error", message: "Internal Server Error" }); }
});

// ==========================================================
// ✅   Forgot Password - Send user_passcode to email
// ==========================================================
router.post("/forgot-password", async (req, res) => {
  try { const { email } = req.body;
    if (!email) { return res.status(400).json({ success: false, message: "Please provide your email address.", }); }
    const [users] = await db.query("SELECT * FROM aalierp_user WHERE user_email = ? LIMIT 1", [email]);
    if (users.length === 0) { return res.status(404).json({ success: false, message: "Email not found!", }); }
    const user = users[0];
    const mailOptions = { 
        from: '"Ni Drip" <support@mraalionline.com>', to: email, subject: "Your Password Recovery",
        text: `Hello ${user.user_username || "User"},\n\nYour password is: ${user.user_passcode}\n\nPlease keep it safe and do not share with anyone.\n\n- Ni Drip Team`,
    };
    try { const result = await transporter.sendMail(mailOptions); console.log("📧 Forgot password email sent:", result);
    } catch (emailErr) { console.error("❌ Forgot password email failed:", emailErr); return res.status(500).json({ success: false, message: "Failed to send email", error: emailErr.message, }); }
    return res.status(200).json({ success: true, message: "Password has been sent to your email.", });
  } catch (err) {console.error("❌ /forgot-password error:", err); res.status(500).json({ success: false, message: "Internal Server Error", error: err.message,}); }
});

// ==========================================================
// ✅   Get Small Banners
// ==========================================================
router.get("/banners", async (req, res) => {
  try { const [rows] = await db.query("SELECT banner_size, banner_image FROM aalierp_banner WHERE banner_size = 'Small'"); return res.json(rows);
  } catch (err) { console.error("❌ Banner API Error:", err); return res.status(500).json({ success: false, message: "Server error" }); }
});

// ==========================================================
// ✅   Get Catalogue List
// ==========================================================
router.get("/categories", async (req, res) => {
  try { const [rows] = await db.query("SELECT category_name, category_image FROM aalierp_category"); return res.json(rows);
  } catch (err) {console.error("❌ Catalogue API Error:", err); return res.status(500).json({ success: false, message: "Server error" }); }
});

// ==========================================================
// ✅   Get Products List
// ==========================================================
router.get("/products", async (req, res) => {
  try {const limit = parseInt(req.query.limit) || 6;
    const [rows] = await db.query(`SELECT p.product_id, p.product_name, p.product_image, p.product_price, p.product_old_price, p.product_discount, p.category_id, c.category_name, co.company_currency
    FROM aalierp_product AS p LEFT JOIN aalierp_category AS c ON c.category_id = p.category_id LEFT JOIN aalierp_contents AS co ON co.company_id = 1 -- assuming company_currency stored here 
    WHERE p.product_status = 'Active' ORDER BY p.created_on DESC LIMIT ?`, [limit]);
    return res.json(rows);
  } catch (err) { console.error("❌ Product API Error:", err); return res.status(500).json({ success: false, message: "Server error" }); }
});
router.get("/image/:name", (req, res) => { const filePath = path.join(__dirname, "../public/uploads", req.params.name);
  if (fs.existsSync(filePath)) {res.sendFile(filePath);  } else {  res.status(404).json({ message: "Image not found" });  }
});

// ================= ADD TO CART =================
router.post("/add_to_cart", (req, res) => {
  const { p_id, qty } = req.body;
  const ip = req.ip || "0.0.0.0";

  // Use session user_id if exists, otherwise use 0 (guest)
  const user_id = req.session?.user_id || 0;

  if (!p_id) return res.json({ success: false, message: "Product ID required" });

  // Check if product already in cart for this user
  const checkQuery =
    "SELECT * FROM aalierp_cart WHERE p_id = ? AND user_id = ? AND status = 'Pending'";
  db.query(checkQuery, [p_id, user_id], (err, result) => {
    if (err) return res.json({ success: false, message: err.message });

    if (result.length > 0) {
      // Already in cart -> increment qty
      const updateQuery =
        "UPDATE aalierp_cart SET qty = qty + ? WHERE p_id = ? AND user_id = ? AND status = 'Pending'";
      db.query(updateQuery, [qty || 1, p_id, user_id], (err2) => {
        if (err2) return res.json({ success: false, message: err2.message });
        return res.json({ success: true, message: "Cart updated" });
      });
    } else {
      // Insert new cart row
      const insertQuery =
        "INSERT INTO aalierp_cart (date, p_id, ip_add, user_id, qty, status) VALUES (NOW(), ?, ?, ?, ?, 'Pending')";
      db.query(insertQuery, [p_id, ip, user_id, qty || 1], (err3) => {
        if (err3) return res.json({ success: false, message: err3.message });
        return res.json({ success: true, message: "Added to cart" });
      });
    }
  });
});

// ================= CART COUNT =================
router.get("/cart_count", (req, res) => {
  const user_id = req.session?.user_id || 0; // guest fallback

  const query =
    "SELECT SUM(qty) as count FROM aalierp_cart WHERE user_id = ? AND status = 'Pending'";
  db.query(query, [user_id], (err, result) => {
    if (err) return res.json({ success: false, message: err.message });
    const count = result[0].count || 0;
    res.json({ count: count });
  });
});

// ✅ JWT middleware
function authenticateToken(req, res, next) { const header = req.headers["authorization"]; const token = header && header.split(" ")[1];
  if (!token) { return res.status(401).json({ success: false, message: "No token provided" }); }
  jwt.verify(token, JWT_SECRET, (err, decoded) => {
    if (err) { console.error("❌ Token verify error:", err); return res.status(403).json({ success: false, message: "Invalid token" }); }
    req.userId = decoded.userId; next();
  });
}

// ✅ Protected user info route
router.get("/info", authenticateToken, async (req, res) => {
  try {console.log("✅ Authenticated userId:", req.userId);
    const [rows] = await db.query(`SELECT u.user_id,u.user_image,u.user_name,u.user_username,u.user_mobile,u.user_email,u.user_city,u.user_country,u.user_cash_wallet,u.user_package_wallet,u.user_referral_bonus, 
    u.user_roi,u.user_profit_share,u.user_reward_title,u.user_reward,u.user_referred_by,u.user_referral,u.user_status,user_withdraw,user_send,user_recieve,user_invest,DATE_FORMAT(u.created_on, '%b %d %Y') AS created_date,
    c.cur_cc, c.cur_cur, c.cur_rate FROM aalierp_user AS u LEFT JOIN aalierp_currency AS c ON c.cur_cc = u.user_cc WHERE u.user_id = ?`, [req.userId]);
    if (!rows || rows.length === 0) return res.status(404).json({ success: false, message: "User not found" });
    const r = rows[0];
    const user = {user_id: r.user_id,user_image: r.user_image,user_name: r.user_name,user_username: r.user_username,user_mobile: r.user_mobile,user_email: r.user_email,user_city: r.user_city,user_country: r.user_country,
    user_cash_wallet: r.user_cash_wallet,user_package_wallet: r.user_package_wallet,user_invest: r.user_invest,user_referral_bonus: r.user_referral_bonus,user_withdraw: r.user_withdraw,user_roi: r.user_roi,
    user_profit_share: r.user_profit_share,user_send: r.user_send,user_recieve: r.user_recieve,user_reward: r.user_reward,user_reward_title: r.user_reward_title,user_referred_by: r.user_referred_by,
    user_referral: r.user_referral,user_status: r.user_status,created_date: r.created_date,};
    const currency = r.cur_cc ? { cur_cc: r.cur_cc, cur_cur: r.cur_cur, cur_rate: r.cur_rate, } : null;
    return res.json({ success: true, user, currency });
  } catch (err) {console.error("❌ User info error:", err);res.status(500).json({ success: false, message: "Server error" });}
});

module.exports = router;
