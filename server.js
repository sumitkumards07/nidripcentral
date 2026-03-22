require('dotenv').config();
const express = require('express');
const path = require('path');
const session = require('express-session');
const compression = require('compression');
const helmet = require('helmet');
const cors = require('cors');
const bcrypt = require('bcryptjs');
const multer = require('multer');
const fs = require('fs');
const db = require('./config/db');

const app = express();
const PORT = process.env.PORT || 3001;

// ─── MIDDLEWARE ──────────────────────────────────────────────
app.use(helmet({ contentSecurityPolicy: false }));
app.use(compression());
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(session({
  secret: process.env.SESSION_SECRET || 'nidrip_secret',
  resave: false,
  saveUninitialized: false,
  cookie: { maxAge: 24 * 60 * 60 * 1000 }
}));

// ─── MULTER UPLOAD CONFIG ───────────────────────────────────
function makeUpload(folder) {
  const dest = path.join(__dirname, 'public', 'uploads', folder);
  fs.mkdirSync(dest, { recursive: true });
  return multer({
    storage: multer.diskStorage({
      destination: (_, __, cb) => cb(null, dest),
      filename: (_, file, cb) => cb(null, Date.now() + '-' + Math.round(Math.random() * 1e6) + path.extname(file.originalname).toLowerCase()),
    }),
    fileFilter: (_, file, cb) => {
      const ok = ['.jpg', '.jpeg', '.png', '.gif', '.webp'].includes(path.extname(file.originalname).toLowerCase());
      cb(null, ok);
    }
  });
}
const uploadBrands = makeUpload('brands');
const uploadBanners = makeUpload('banners');
const uploadProducts = makeUpload('products');
const uploadLogos = makeUpload('logos');

// ─── HELPERS ────────────────────────────────────────────────
async function getCompany() {
  const [rows] = await db.query('SELECT * FROM aalierp_contents ORDER BY company_id DESC LIMIT 1');
  return rows[0] || {};
}

function guard(req, res, next) {
  if (req.session && req.session.user) return next();
  res.redirect('/login');
}

// Make session user + company available to all views
app.use(async (req, res, next) => {
  res.locals.user = req.session?.user || null;
  try { res.locals.company = await getCompany(); } catch { res.locals.company = {}; }
  next();
});

// ═══════════════════════════════════════════════════════════════
// AUTH ROUTES
// ═══════════════════════════════════════════════════════════════

app.get('/login', (req, res) => {
  if (req.session?.user) return res.redirect('/dashboard');
  res.render('login', { error: null });
});

app.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;
    const [users] = await db.query('SELECT * FROM aalierp_user WHERE user_email = ? OR user_username = ? LIMIT 1', [email, email]);
    if (!users.length) return res.render('login', { error: 'User not found!' });

    const u = users[0];
    const pwd = u.user_password || '';
    const ok = password === pwd || await bcrypt.compare(password, pwd).catch(() => false);
    if (!ok) return res.render('login', { error: "Password doesn't match!" });

    const type = (u.user_type || '').toLowerCase();
    if (!['admin', 'super'].includes(type)) return res.render('login', { error: 'Not authorized for admin panel' });

    req.session.user = {
      id: u.user_id,
      name: u.user_name || `${u.user_fname || ''} ${u.user_lname || ''}`.trim() || u.user_email,
      email: u.user_email,
      type: u.user_type,
      image: u.user_image || ''
    };
    res.redirect('/dashboard');
  } catch (err) {
    res.render('login', { error: 'Server error: ' + err.message });
  }
});

app.get('/logout', (req, res) => {
  req.session.destroy();
  res.redirect('/login');
});

// ═══════════════════════════════════════════════════════════════
// PAGE ROUTES (All use guard middleware)
// ═══════════════════════════════════════════════════════════════

app.get('/', guard, (_, res) => res.redirect('/dashboard'));

app.get('/dashboard', guard, async (req, res) => {
  try {
    const [[{c:totalOrders}]] = await db.query('SELECT COUNT(*) as c FROM aalierp_cart');
    const [[{c:pendingOrders}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Pending' OR status='Chosen'");
    const [[{c:totalCustomers}]] = await db.query('SELECT COUNT(*) as c FROM aalierp_user');
    const [[{c:refunds}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Refunded'");
    const [recentOrders] = await db.query('SELECT c.id, c.date, c.status, p.product_name FROM aalierp_cart c LEFT JOIN aalierp_product p ON c.p_id=p.product_id ORDER BY c.id DESC LIMIT 7');
    res.render('dashboard', { totalOrders, pendingOrders, totalCustomers, refunds, recentOrders, page: 'dashboard' });
  } catch (err) { res.render('dashboard', { totalOrders:0, pendingOrders:0, totalCustomers:0, refunds:0, recentOrders:[], page:'dashboard' }); }
});

app.get('/orders', guard, async (req, res) => {
  try {
    const [[{c:all}]] = await db.query('SELECT COUNT(*) as c FROM aalierp_cart');
    const [[{c:cart}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Chosen'");
    const [[{c:processing}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Processing'");
    const [[{c:done}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Processed'");
    const [orders] = await db.query('SELECT p.product_name,p.product_image,p.product_price,c.id,c.date,c.qty,c.status,u.user_name FROM aalierp_product p, aalierp_cart c, aalierp_user u WHERE p.product_id=c.p_id AND c.user_id=u.user_id ORDER BY c.id DESC');
    res.render('orders', { stats: { all, cart, processing, done }, orders, page: 'orders' });
  } catch (err) { res.render('orders', { stats:{all:0,cart:0,processing:0,done:0}, orders:[], page:'orders' }); }
});

app.get('/products', guard, async (req, res) => {
  try {
    const [products] = await db.query('SELECT p.*, c.category_name, u.unit_name FROM aalierp_product p LEFT JOIN aalierp_category c ON p.category_id=c.category_id LEFT JOIN aalierp_unit u ON p.unit_id=u.unit_id ORDER BY p.product_id DESC');
    const [categories] = await db.query('SELECT * FROM aalierp_category ORDER BY category_name');
    const [units] = await db.query('SELECT * FROM aalierp_unit ORDER BY unit_name');
    res.render('products', { products, categories, units, page: 'products' });
  } catch (err) { res.render('products', { products:[], categories:[], units:[], page:'products' }); }
});

app.get('/customers', guard, async (req, res) => {
  try {
    const [users] = await db.query('SELECT u.*, (SELECT COUNT(*) FROM aalierp_cart c WHERE c.user_id=u.user_id) as order_count FROM aalierp_user u ORDER BY u.user_id DESC');
    const [[{c:total}]] = await db.query('SELECT COUNT(*) as c FROM aalierp_user');
    const [[{c:approved}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_user WHERE user_status='Approved'");
    const [[{c:pending}]] = await db.query("SELECT COUNT(*) as c FROM aalierp_user WHERE user_status='Pending'");
    res.render('customers', { users, stats: { total, approved, pending }, page: 'customers' });
  } catch (err) { res.render('customers', { users:[], stats:{total:0,approved:0,pending:0}, page:'customers' }); }
});

app.get('/brands', guard, async (req, res) => {
  try {
    const [brands] = await db.query('SELECT * FROM aalierp_brand ORDER BY brand_id DESC');
    res.render('brands', { brands, page: 'brands' });
  } catch (err) { res.render('brands', { brands:[], page:'brands' }); }
});

app.get('/categories', guard, async (req, res) => {
  try {
    const [categories] = await db.query('SELECT * FROM aalierp_category ORDER BY category_id DESC');
    const [subcats] = await db.query('SELECT s.*, c.category_name FROM aalierp_sub_category s LEFT JOIN aalierp_category c ON s.category_id=c.category_id ORDER BY s.sub_category_id DESC');
    const [units] = await db.query('SELECT * FROM aalierp_unit ORDER BY unit_id DESC');
    res.render('categories', { categories, subcats, units, page: 'categories' });
  } catch (err) { res.render('categories', { categories:[], subcats:[], units:[], page:'categories' }); }
});

app.get('/banners', guard, async (req, res) => {
  try {
    const [banners] = await db.query('SELECT * FROM aalierp_banner ORDER BY banner_id DESC');
    res.render('banners', { banners, page: 'banners' });
  } catch (err) { res.render('banners', { banners:[], page:'banners' }); }
});

app.get('/settings', guard, async (req, res) => {
  res.render('settings', { page: 'settings' });
});

// ═══════════════════════════════════════════════════════════════
// API ROUTES (JSON responses for CRUD)
// ═══════════════════════════════════════════════════════════════

// -- Orders API --
app.put('/api/orders/:id/status', guard, async (req, res) => {
  await db.query('UPDATE aalierp_cart SET status=? WHERE id=?', [req.body.status, req.params.id]);
  res.json({ success: true, message: `Order updated to ${req.body.status}` });
});
app.delete('/api/orders/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_cart WHERE id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Brands API --
app.post('/api/brands', guard, uploadBrands.single('brand_image'), async (req, res) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  const [exists] = await db.query('SELECT brand_id FROM aalierp_brand WHERE brand_name=?', [req.body.brand_name]);
  if (exists.length) return res.json({ success: false, message: 'Brand already exists!' });
  await db.query('INSERT INTO aalierp_brand (brand_name,brand_image,created_on,created_by) VALUES (?,?,NOW(),?)', [req.body.brand_name, req.file.filename, req.session.user.name]);
  res.json({ success: true, message: 'Brand Added!' });
});
app.delete('/api/brands/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_brand WHERE brand_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Banners API --
app.post('/api/banners', guard, uploadBanners.single('banner_image'), async (req, res) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  await db.query('INSERT INTO aalierp_banner (banner_size,banner_image,banner_status,created_on,created_by) VALUES (?,?,?,NOW(),?)', [req.body.banner_size || 'Full', req.file.filename, 'Active', req.session.user.name]);
  res.json({ success: true, message: 'Banner Added!' });
});
app.delete('/api/banners/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_banner WHERE banner_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Categories API --
app.post('/api/categories', guard, async (req, res) => {
  const [exists] = await db.query('SELECT category_id FROM aalierp_category WHERE category_name=?', [req.body.category_name]);
  if (exists.length) return res.json({ success: false, message: 'Category already exists!' });
  await db.query('INSERT INTO aalierp_category (category_name,category_description,created_on,created_by) VALUES (?,?,NOW(),?)', [req.body.category_name, req.body.category_description || '', req.session.user.name]);
  res.json({ success: true, message: 'Category Added!' });
});
app.delete('/api/categories/:id', guard, async (req, res) => {
  const [used] = await db.query('SELECT product_id FROM aalierp_product WHERE category_id=? LIMIT 1', [req.params.id]);
  if (used.length) return res.json({ success: false, message: 'Category is used in products' });
  await db.query('DELETE FROM aalierp_category WHERE category_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Sub-Categories API --
app.post('/api/subcategories', guard, async (req, res) => {
  await db.query('INSERT INTO aalierp_sub_category (sub_category_name,category_id,created_on,created_by) VALUES (?,?,NOW(),?)', [req.body.sub_category_name, req.body.category_id, req.session.user.name]);
  res.json({ success: true, message: 'Sub-Category Added!' });
});
app.delete('/api/subcategories/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_sub_category WHERE sub_category_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Units API --
app.post('/api/units', guard, async (req, res) => {
  await db.query('INSERT INTO aalierp_unit (unit_name,created_on,created_by) VALUES (?,NOW(),?)', [req.body.unit_name, req.session.user.name]);
  res.json({ success: true, message: 'Unit Added!' });
});
app.delete('/api/units/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_unit WHERE unit_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Products API --
app.post('/api/products', guard, uploadProducts.single('product_image'), async (req, res) => {
  const b = req.body;
  const img = req.file ? req.file.filename : '';
  await db.query(
    'INSERT INTO aalierp_product (product_name,product_image,category_id,unit_id,product_price,product_old_price,product_discount,product_keywords,product_desc,product_status,created_on,created_by) VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),?)',
    [b.product_name, img, b.category_id || null, b.unit_id || null, b.product_price || 0, b.product_old_price || 0, b.product_discount || 0, b.product_keywords || '', b.product_desc || '', 'Active', req.session.user.name]
  );
  res.json({ success: true, message: 'Product Added!' });
});
app.put('/api/products/:id', guard, uploadProducts.single('product_image'), async (req, res) => {
  const b = req.body;
  const updates = [b.product_name, b.category_id || null, b.unit_id || null, b.product_price || 0, b.product_old_price || 0, b.product_discount || 0, b.product_keywords || '', b.product_desc || ''];
  let sql = 'UPDATE aalierp_product SET product_name=?,category_id=?,unit_id=?,product_price=?,product_old_price=?,product_discount=?,product_keywords=?,product_desc=?';
  if (req.file) { sql += ',product_image=?'; updates.push(req.file.filename); }
  sql += ' WHERE product_id=?';
  updates.push(req.params.id);
  await db.query(sql, updates);
  res.json({ success: true, message: 'Product Updated!' });
});
app.delete('/api/products/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_product WHERE product_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Customers API --
app.put('/api/customers/:id/status', guard, async (req, res) => {
  await db.query('UPDATE aalierp_user SET user_status=? WHERE user_id=?', [req.body.status, req.params.id]);
  res.json({ success: true, message: `User ${req.body.status}` });
});
app.delete('/api/customers/:id', guard, async (req, res) => {
  await db.query('DELETE FROM aalierp_user WHERE user_id=?', [req.params.id]);
  res.json({ success: true });
});

// -- Settings API --
app.post('/api/settings', guard, uploadLogos.single('company_logo'), async (req, res) => {
  const b = req.body;
  const [existing] = await db.query('SELECT company_id FROM aalierp_contents ORDER BY company_id DESC LIMIT 1');
  const logo = req.file ? req.file.filename : null;
  
  if (existing.length) {
    let sql = 'UPDATE aalierp_contents SET company_name=?,company_salogan=?,company_email=?,company_mobile=?,company_phone=?,company_web=?,company_address=?,company_city=?,company_country=?,company_currency=?';
    const vals = [b.company_name,b.company_salogan,b.company_email,b.company_mobile,b.company_phone,b.company_web,b.company_address,b.company_city,b.company_country,b.company_currency];
    if (logo) { sql += ',company_logo=?'; vals.push(logo); }
    sql += ' WHERE company_id=?'; vals.push(existing[0].company_id);
    await db.query(sql, vals);
  } else {
    await db.query('INSERT INTO aalierp_contents (company_name,company_salogan,company_email,company_mobile,company_phone,company_web,company_address,company_city,company_country,company_currency,company_logo) VALUES (?,?,?,?,?,?,?,?,?,?,?)',
      [b.company_name,b.company_salogan,b.company_email,b.company_mobile,b.company_phone,b.company_web,b.company_address,b.company_city,b.company_country,b.company_currency,logo||'']);
  }
  res.json({ success: true, message: 'Settings saved!' });
});

// ─── START ──────────────────────────────────────────────────
app.listen(PORT, () => console.log(`✅ NI DRIP Admin running on http://localhost:${PORT}`));
