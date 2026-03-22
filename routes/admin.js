/**
 * Admin API Router — replaces all CMS PHP process.php CRUD logic
 * Modern Node.js/Express with async/await and mysql2 promises
 */

const express = require('express');
const router = express.Router();
const db = require('../config/db');
const multer = require('multer');
const path = require('path');
const fs = require('fs');
const bcrypt = require('bcryptjs');

// ─── FILE UPLOAD CONFIG ───────────────────────────────────────────────────────
const VALID_IMG_EXTS = ['.jpeg', '.jpg', '.png', '.gif', '.bmp', '.webp'];

function makeStorage(subfolder) {
  const dest = path.join(__dirname, '..', 'public', 'uploads', subfolder);
  fs.mkdirSync(dest, { recursive: true });
  return multer.diskStorage({
    destination: (req, file, cb) => cb(null, dest),
    filename: (req, file, cb) => {
      const unique = Date.now() + '-' + Math.round(Math.random() * 1e6);
      cb(null, unique + path.extname(file.originalname).toLowerCase());
    },
  });
}

function imageFilter(req, file, cb) {
  const ext = path.extname(file.originalname).toLowerCase();
  if (VALID_IMG_EXTS.includes(ext)) cb(null, true);
  else cb(new Error('Invalid image format'), false);
}

const uploads = {
  brands: multer({ storage: makeStorage('brands'), fileFilter: imageFilter }),
  banners: multer({ storage: makeStorage('banners'), fileFilter: imageFilter }),
  products: multer({ storage: makeStorage('products'), fileFilter: imageFilter }),
  users: multer({ storage: makeStorage('users'), fileFilter: imageFilter }),
  logos: multer({ storage: makeStorage('logos'), fileFilter: imageFilter }),
};

// ─── ADMIN SESSION GUARD ──────────────────────────────────────────────────────
function adminGuard(req, res, next) {
  if (!req.session || !req.session.user) {
    return res.status(401).json({ success: false, message: 'Unauthorized' });
  }
  next();
}
router.use(adminGuard);

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN AUTH (CMS Login — replaces PHP User::userLogin)
// ═══════════════════════════════════════════════════════════════════════════════
router.post('/cms-login', async (req, res) => {
  const { user_email, user_password } = req.body;
  if (!user_email || !user_password)
    return res.json({ success: false, message: 'Missing credentials' });

  try {
    const [rows] = await db.query(
      'SELECT * FROM aalierp_user WHERE user_username = ? OR user_email = ?',
      [user_email, user_email]
    );
    if (!rows.length) return res.json({ success: false, message: 'User Not Registered!' });

    const user = rows[0];
    const pwd = user.user_password || '';
    const match =
      user_password === pwd ||
      (await bcrypt.compare(user_password, pwd).catch(() => false));

    if (!match) return res.json({ success: false, message: "Password doesn't match!" });

    const type = (user.user_type || '').toLowerCase().trim();
    const status = (user.user_status || '').toLowerCase().trim();

    if (!['admin', 'super'].includes(type))
      return res.json({ success: false, message: 'This account is not allowed in admin panel!' });
    if (status !== 'approved')
      return res.json({ success: false, message: 'Your account is not approved yet!' });

    const fullName =
      (user.user_name || '').trim() ||
      `${user.user_fname || ''} ${user.user_lname || ''}`.trim() ||
      user.user_username ||
      user.user_email;

    req.session.user = {
      id: user.user_id,
      name: fullName,
      username: user.user_username,
      email: user.user_email,
      image: user.user_image,
      type: user.user_type,
      status: user.user_status,
    };

    // Log login
    db.query(
      'INSERT INTO aalierp_login_detail (login_id, login_name, login_email, login_date, login_ip, login_country, login_city, logout_date) VALUES (?,?,?,NOW(),?,?,?,NOW())',
      [user.user_id, fullName, user.user_email, req.ip, 'Remote', 'Cloud']
    ).catch(() => {});

    const msg = type === 'super' ? 'Super Admin Logged In Successfully!' : 'Admin Logged In Successfully!';
    return res.json({ success: true, message: msg, redirect: '/dashboard' });
  } catch (err) {
    console.error('[cms-login]', err);
    return res.json({ success: false, message: 'Login is temporarily unavailable!' });
  }
});

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN USERS (replaces PHP User::createUserAccount + viewUsers + deleteUser)
// ═══════════════════════════════════════════════════════════════════════════════

// Create admin user
router.post('/users/create', uploads.users.single('user_image'), async (req, res) => {
  const { user_fname, user_lname, user_username, user_mobile, user_email, user_password, user_type, user_status } = req.body;
  const imageFile = req.file ? `/uploads/users/${req.file.filename}` : '';
  try {
    const [existing] = await db.query('SELECT user_id FROM aalierp_user WHERE user_email = ?', [user_email]);
    if (existing.length) return res.json({ success: false, message: 'User already exists!' });
    const hash = await bcrypt.hash(user_password, 10);
    await db.query(
      'INSERT INTO aalierp_user (user_fname, user_lname, user_username, user_image, user_mobile, user_email, user_password, user_type, user_status, user_ip, user_city, user_country) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',
      [user_fname, user_lname, user_username, imageFile, user_mobile, user_email, hash, user_type || 'Admin', user_status || 'Approved', req.ip, 'Cloud', 'Remote']
    );
    res.json({ success: true, message: 'Registered Successfully!' });
  } catch (err) {
    console.error('[users/create]', err);
    res.json({ success: false, message: 'Something went wrong!' });
  }
});

// Get all admin users
router.get('/users', async (req, res) => {
  try {
    const [users] = await db.query("SELECT user_id, user_fname, user_lname, user_username, user_email, user_image, user_mobile, user_type, user_status FROM aalierp_user WHERE user_type='Admin' OR user_type='Super'");
    res.json({ success: true, data: users });
  } catch (err) {
    res.json({ success: false, message: 'Error fetching users' });
  }
});

// Update admin user
router.post('/users/update/:id', async (req, res) => {
  const { user_fname, user_lname, user_status } = req.body;
  try {
    await db.query('UPDATE aalierp_user SET user_fname=?, user_lname=?, user_status=? WHERE user_id=?', [user_fname, user_lname, user_status, req.params.id]);
    res.json({ success: true, message: 'User updated!' });
  } catch (err) {
    res.json({ success: false, message: 'Update failed' });
  }
});

// Delete admin user
router.delete('/users/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_user WHERE user_id=?', [req.params.id]);
    res.json({ success: true, message: 'User deleted!' });
  } catch (err) {
    res.json({ success: false, message: 'Delete failed' });
  }
});

// ═══════════════════════════════════════════════════════════════════════════════
// BRANDS (replaces PHP addBrand / viewBrand / updateBrand / deleteBrand)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/brands', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_brand ORDER BY brand_id DESC');
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching brands' }); }
});

router.post('/brands', uploads.brands.single('brand_image'), async (req, res) => {
  if (!req.file) return res.json({ success: false, message: 'Invalid image format' });
  const { brand_name } = req.body;
  const brand_image = `/uploads/brands/${req.file.filename}`;
  try {
    await db.query('INSERT INTO aalierp_brand (brand_name, brand_image, created_on, created_by) VALUES (?,?,NOW(),?)', [brand_name, brand_image, req.session.user.name]);
    res.json({ success: true, message: 'Brand added successfully!' });
  } catch (err) { res.json({ success: false, message: 'Failed to add brand' }); }
});

router.put('/brands/:id', uploads.brands.single('brand_image'), async (req, res) => {
  const { brand_name } = req.body;
  const fields = { brand_name, updated_on: new Date() };
  if (req.file) fields.brand_image = `/uploads/brands/${req.file.filename}`;
  try {
    const sets = Object.keys(fields).map(k => `${k}=?`).join(', ');
    await db.query(`UPDATE aalierp_brand SET ${sets} WHERE brand_id=?`, [...Object.values(fields), req.params.id]);
    res.json({ success: true, message: 'Brand updated!' });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/brands/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_brand WHERE brand_id=?', [req.params.id]);
    res.json({ success: true, message: 'Brand deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// BANNERS (replaces PHP addBanner / viewBanner / deleteBanner)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/banners', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_banner ORDER BY banner_id DESC');
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching banners' }); }
});

router.post('/banners', uploads.banners.single('banner_image'), async (req, res) => {
  if (!req.file) return res.json({ success: false, message: 'Invalid image format' });
  const { banner_size } = req.body;
  const banner_image = `/uploads/banners/${req.file.filename}`;
  try {
    await db.query('INSERT INTO aalierp_banner (banner_size, banner_image, banner_status, created_on, created_by) VALUES (?,?,?,NOW(),?)', [banner_size, banner_image, 'Active', req.session.user.name]);
    res.json({ success: true, message: 'Banner added successfully!' });
  } catch (err) { res.json({ success: false, message: 'Failed to add banner' }); }
});

router.put('/banners/:id/status', async (req, res) => {
  const { status } = req.body; // 'Active' or 'Deactive'
  try {
    await db.query('UPDATE aalierp_banner SET banner_status=? WHERE banner_id=?', [status, req.params.id]);
    res.json({ success: true, message: `Banner marked as ${status}` });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/banners/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_banner WHERE banner_id=?', [req.params.id]);
    res.json({ success: true, message: 'Banner deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// CATEGORIES (replaces PHP addCategory / viewCategory / updateCategory / deleteCategory)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/categories', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_category ORDER BY category_id DESC');
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching categories' }); }
});

router.get('/categories/:id', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_category WHERE category_id=?', [req.params.id]);
    res.json({ success: true, data: rows[0] || null });
  } catch (err) { res.json({ success: false, message: 'Error' }); }
});

router.post('/categories', async (req, res) => {
  const { category_name, category_description } = req.body;
  try {
    await db.query('INSERT INTO aalierp_category (category_name, category_description, created_on, created_by) VALUES (?,?,NOW(),?)', [category_name, category_description || '', req.session.user.name]);
    res.json({ success: true, message: 'Category added!' });
  } catch (err) { res.json({ success: false, message: 'Failed to add category' }); }
});

router.put('/categories/:id', async (req, res) => {
  const { category_name } = req.body;
  try {
    await db.query('UPDATE aalierp_category SET category_name=?, updated_on=NOW() WHERE category_id=?', [category_name, req.params.id]);
    res.json({ success: true, message: 'Category updated!' });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/categories/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_category WHERE category_id=?', [req.params.id]);
    res.json({ success: true, message: 'Category deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// SUB-CATEGORIES
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/subcategories', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT s.*, c.category_name FROM aalierp_subcategory s
       LEFT JOIN aalierp_category c ON s.category_id = c.category_id
       ORDER BY s.subcategory_id DESC`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching sub-categories' }); }
});

router.post('/subcategories', async (req, res) => {
  const { sub_category_name, category_id } = req.body;
  try {
    await db.query('INSERT INTO aalierp_subcategory (subcategory_name, category_id, created_on, created_by) VALUES (?,?,NOW(),?)', [sub_category_name, category_id, req.session.user.name]);
    res.json({ success: true, message: 'Sub-category added!' });
  } catch (err) { res.json({ success: false, message: 'Failed to add sub-category' }); }
});

router.put('/subcategories/:id', async (req, res) => {
  const { sub_category_name, category_id } = req.body;
  try {
    await db.query('UPDATE aalierp_subcategory SET subcategory_name=?, category_id=?, updated_on=NOW() WHERE subcategory_id=?', [sub_category_name, category_id, req.params.id]);
    res.json({ success: true, message: 'Sub-category updated!' });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/subcategories/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_subcategory WHERE subcategory_id=?', [req.params.id]);
    res.json({ success: true, message: 'Sub-category deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// UNITS
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/units', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_unit ORDER BY unit_id DESC');
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching units' }); }
});

router.post('/units', async (req, res) => {
  const { unit_name } = req.body;
  try {
    await db.query('INSERT INTO aalierp_unit (unit_name, created_on, created_by) VALUES (?,NOW(),?)', [unit_name, req.session.user.name]);
    res.json({ success: true, message: 'Unit added!' });
  } catch (err) { res.json({ success: false, message: 'Failed to add unit' }); }
});

router.put('/units/:id', async (req, res) => {
  const { unit_name } = req.body;
  try {
    await db.query('UPDATE aalierp_unit SET unit_name=?, updated_on=NOW() WHERE unit_id=?', [unit_name, req.params.id]);
    res.json({ success: true, message: 'Unit updated!' });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/units/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_unit WHERE unit_id=?', [req.params.id]);
    res.json({ success: true, message: 'Unit deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// PRODUCTS (replaces PHP addProduct / viewProduct / updateProduct / deleteProduct)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/products', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT p.*, c.category_name, s.subcategory_name, u.unit_name
       FROM aalierp_product p
       LEFT JOIN aalierp_category c ON p.category_id = c.category_id
       LEFT JOIN aalierp_subcategory s ON p.subcategory_id = s.subcategory_id
       LEFT JOIN aalierp_unit u ON p.unit_id = u.unit_id
       ORDER BY p.product_id DESC`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching products' }); }
});

router.get('/products/:id', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_product WHERE product_id=?', [req.params.id]);
    res.json({ success: true, data: rows[0] || null });
  } catch (err) { res.json({ success: false, message: 'Error' }); }
});

router.post('/products', uploads.products.single('product_image'), async (req, res) => {
  if (!req.file) return res.json({ success: false, message: 'Invalid image format' });
  const { product_name, category_id, subcategory_id, unit_id, product_price, product_old_price, product_discount, product_keywords, product_desc } = req.body;
  const product_image = `/uploads/products/${req.file.filename}`;
  try {
    await db.query(
      `INSERT INTO aalierp_product (product_name, product_image, category_id, subcategory_id, unit_id, product_price, product_old_price, product_discount, product_keywords, product_desc, created_on, created_by, product_status)
       VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),?,?)`,
      [product_name, product_image, category_id, subcategory_id || null, unit_id || null, product_price, product_old_price || 0, product_discount || 0, product_keywords || '', product_desc || '', req.session.user.name, 'Active']
    );
    res.json({ success: true, message: 'Product added successfully!' });
  } catch (err) {
    console.error('[products/create]', err);
    res.json({ success: false, message: 'Failed to add product' });
  }
});

router.put('/products/:id', uploads.products.single('product_image'), async (req, res) => {
  const { product_name, category_id, subcategory_id, unit_id, product_price, product_old_price, product_discount, product_keywords, product_desc, product_status } = req.body;
  const fields = { product_name, category_id, subcategory_id: subcategory_id || null, unit_id: unit_id || null, product_price, product_old_price: product_old_price || 0, product_discount: product_discount || 0, product_keywords: product_keywords || '', product_desc: product_desc || '', product_status: product_status || 'Active', updated_on: new Date() };
  if (req.file) fields.product_image = `/uploads/products/${req.file.filename}`;
  try {
    const sets = Object.keys(fields).map(k => `${k}=?`).join(', ');
    await db.query(`UPDATE aalierp_product SET ${sets} WHERE product_id=?`, [...Object.values(fields), req.params.id]);
    res.json({ success: true, message: 'Product updated!' });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/products/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_product WHERE product_id=?', [req.params.id]);
    res.json({ success: true, message: 'Product deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// ORDERS / CART (replaces PHP order management)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/orders', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT c.*, p.product_name, p.product_image, u.user_email, u.user_name, u.user_mobile
       FROM aalierp_cart c
       LEFT JOIN aalierp_product p ON c.p_id = p.product_id
       LEFT JOIN aalierp_user u ON c.user_id = u.user_id
       ORDER BY c.id DESC`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching orders' }); }
});

router.put('/orders/:id/status', async (req, res) => {
  const { status } = req.body;
  try {
    await db.query('UPDATE aalierp_cart SET status=? WHERE id=?', [status, req.params.id]);
    res.json({ success: true, message: `Order marked as ${status}` });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/orders/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_cart WHERE id=?', [req.params.id]);
    res.json({ success: true, message: 'Order deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// CONTENT / COMPANY SETTINGS (replaces PHP content management)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/settings', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM aalierp_contents ORDER BY company_id DESC LIMIT 1');
    res.json({ success: true, data: rows[0] || {} });
  } catch (err) { res.json({ success: false, message: 'Error fetching settings' }); }
});

router.post('/settings', uploads.logos.single('company_logo'), async (req, res) => {
  const { company_name, company_salogan, company_mobile, company_email, company_web, company_phone, company_address, company_city, company_country, company_currency } = req.body;
  const logo = req.file ? `/uploads/logos/${req.file.filename}` : null;
  try {
    const [existing] = await db.query('SELECT company_id FROM aalierp_contents ORDER BY company_id DESC LIMIT 1');
    if (existing.length) {
      const fields = { company_name, company_salogan, company_mobile, company_email, company_web, company_phone, company_address, company_city, company_country, company_currency };
      if (logo) fields.company_logo = logo;
      const sets = Object.keys(fields).map(k => `${k}=?`).join(', ');
      await db.query(`UPDATE aalierp_contents SET ${sets} WHERE company_id=?`, [...Object.values(fields), existing[0].company_id]);
    } else {
      await db.query(
        'INSERT INTO aalierp_contents (company_name, company_salogan, company_mobile, company_email, company_web, company_phone, company_address, company_city, company_country, company_currency, company_logo) VALUES (?,?,?,?,?,?,?,?,?,?,?)',
        [company_name, company_salogan, company_mobile, company_email, company_web, company_phone, company_address, company_city, company_country, company_currency, logo || '']
      );
    }
    res.json({ success: true, message: 'Settings saved!' });
  } catch (err) {
    console.error('[settings]', err);
    res.json({ success: false, message: 'Failed to save settings' });
  }
});

// ═══════════════════════════════════════════════════════════════════════════════
// CUSTOMER MANAGEMENT (All regular users)
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/customers', async (req, res) => {
  try {
    const [users] = await db.query(
      `SELECT u.user_id, u.user_name, u.user_email, u.user_mobile, u.user_status, u.user_image,
       (SELECT COUNT(id) FROM aalierp_cart WHERE user_id=u.user_id) as order_count
       FROM aalierp_user u ORDER BY u.user_id DESC`
    );
    res.json({ success: true, data: users });
  } catch (err) { res.json({ success: false, message: 'Error fetching customers' }); }
});

router.put('/customers/:id/status', async (req, res) => {
  const { status } = req.body;
  try {
    await db.query('UPDATE aalierp_user SET user_status=? WHERE user_id=?', [status, req.params.id]);
    res.json({ success: true, message: `User ${status}` });
  } catch (err) { res.json({ success: false, message: 'Update failed' }); }
});

router.delete('/customers/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM aalierp_user WHERE user_id=?', [req.params.id]);
    res.json({ success: true, message: 'Customer deleted!' });
  } catch (err) { res.json({ success: false, message: 'Delete failed' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// REPORTS
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/reports/sales', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT DATE(c.date) as sale_date, COUNT(c.id) as total_orders, SUM(p.product_price * c.qty) as revenue
       FROM aalierp_cart c JOIN aalierp_product p ON c.p_id = p.product_id
       GROUP BY DATE(c.date) ORDER BY sale_date DESC LIMIT 30`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching sales report' }); }
});

router.get('/reports/products', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT p.product_name, COUNT(c.id) as times_ordered, SUM(c.qty) as total_qty
       FROM aalierp_cart c JOIN aalierp_product p ON c.p_id = p.product_id
       GROUP BY c.p_id ORDER BY times_ordered DESC LIMIT 20`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching product report' }); }
});

router.get('/reports/users', async (req, res) => {
  try {
    const [rows] = await db.query(
      `SELECT u.user_name, u.user_email, u.user_status, COUNT(c.id) as order_count
       FROM aalierp_user u LEFT JOIN aalierp_cart c ON c.user_id=u.user_id
       GROUP BY u.user_id ORDER BY order_count DESC`
    );
    res.json({ success: true, data: rows });
  } catch (err) { res.json({ success: false, message: 'Error fetching user report' }); }
});

// ═══════════════════════════════════════════════════════════════════════════════
// DASHBOARD STATS
// ═══════════════════════════════════════════════════════════════════════════════

router.get('/stats', async (req, res) => {
  try {
    const [[{ total_orders }]] = await db.query('SELECT COUNT(*) AS total_orders FROM aalierp_cart');
    const [[{ pending_orders }]] = await db.query("SELECT COUNT(*) AS pending_orders FROM aalierp_cart WHERE status='Pending'");
    const [[{ total_customers }]] = await db.query('SELECT COUNT(*) AS total_customers FROM aalierp_user');
    const [[{ refunds }]] = await db.query("SELECT COUNT(*) AS refunds FROM aalierp_cart WHERE status='Refunded'");
    const [[{ revenue }]] = await db.query("SELECT COALESCE(SUM(p.product_price * c.qty),0) AS revenue FROM aalierp_cart c JOIN aalierp_product p ON c.p_id=p.product_id WHERE c.status='Delivered'");
    res.json({ success: true, data: { total_orders, pending_orders, total_customers, refunds, revenue } });
  } catch (err) { res.json({ success: false, message: 'Error fetching stats' }); }
});

module.exports = router;
