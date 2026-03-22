const express = require('express');
const router = express.Router();
const db = require('../config/db');
const bcrypt = require('bcryptjs');

// Helper to standardise responses
const success = (res, data) => res.status(200).json(data);
const error = (res, msg) => res.status(500).json({ status: false, message: msg });

// 1. GET /api/categories
router.get('/categories', async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM aalierp_category WHERE (category_status="Active" OR category_status IS NULL) GROUP BY category_name ORDER BY category_id DESC');
        rows.forEach(r => { if(r.category_image) r.category_image = 'categories/' + r.category_image; });
        success(res, rows);
    } catch(e) { error(res, e.message); }
});

// 2. GET /api/products
router.get('/products', async (req, res) => {
    try {
        let sql = 'SELECT * FROM aalierp_product WHERE product_status="Active"';
        const params = [];
        
        if (req.query.category_id) {
            sql += ' AND category_id=?';
            params.push(req.query.category_id);
        }
        
        sql += ' ORDER BY product_id DESC';
        
        if (req.query.limit) {
            sql += ' LIMIT ?';
            params.push(parseInt(req.query.limit));
        }

        const [rows] = await db.query(sql, params);
        rows.forEach(r => { if(r.product_image) r.product_image = 'products/' + r.product_image; });
        success(res, rows);
    } catch(e) { error(res, e.message); }
});

// 3. POST /api/login (Mobile App Login)
router.post('/login', async (req, res) => {
    try {
        const { identifier, user_password } = req.body;
        const [users] = await db.query('SELECT * FROM aalierp_user WHERE user_email = ? OR user_username = ? LIMIT 1', [identifier, identifier]);
        if (!users.length) return success(res, { status: false, message: 'User not found!' });

        const u = users[0];
        const pwd = u.user_password || '';
        const ok = user_password === pwd || user_password === u.user_passcode || await bcrypt.compare(user_password, pwd).catch(()=>false);
        if (!ok) return success(res, { status: false, message: 'Invalid password' });

        success(res, { status: true, message: 'Login successful', user: u });
    } catch(e) { error(res, e.message); }
});

// 4. POST /api/by-email (Registration)
router.post('/by-email', async (req, res) => {
    try {
        const { email, password, user_referred_by } = req.body;
        const [exists] = await db.query('SELECT user_id FROM aalierp_user WHERE user_email=?', [email]);
        if(exists.length) return success(res, { status: false, message: 'Email already exists' });
        
        const hashed = await bcrypt.hash(password, 10);
        const [result] = await db.query('INSERT INTO aalierp_user (user_email, user_password, user_type, created_on) VALUES (?, ?, "Customer", NOW())', [email, hashed]);
        success(res, { status: true, message: 'Registration successful', user_id: result.insertId });
    } catch(e) { error(res, e.message); }
});

// 5. GET /api/cart_count
router.get('/cart_count', async (req, res) => {
    try {
        const { user_id } = req.query;
        const uid = user_id || 0;
        const [rows] = await db.query('SELECT COUNT(*) as count FROM aalierp_cart WHERE user_id = ? AND status = "Chosen"', [uid]);
        success(res, { count: rows[0].count });
    } catch(e) { error(res, e.message); }
});

// 5b. POST /api/add_to_cart
router.post('/add_to_cart', async (req, res) => {
    try {
        const { p_id, qty, user_id } = req.body;
        // If user_id is missing, we use 0 for guest or handled by session on web (but this is API)
        const uid = user_id || 0; 
        await db.query('INSERT INTO aalierp_cart (p_id, qty, user_id, date, status) VALUES (?, ?, ?, NOW(), "Chosen")', [p_id, qty, uid]);
        success(res, { status: true, message: 'Added to cart' });
    } catch(e) { error(res, e.message); }
});

// 5c. GET /api/cart
router.get('/cart', async (req, res) => {
    try {
        const { user_id } = req.query;
        // If user_id is missing, assume 0 or handle guest
        const uid = user_id || 0;
        const [rows] = await db.query(
            'SELECT c.*, p.product_name, p.product_image, p.product_selling_price FROM aalierp_cart c JOIN aalierp_product p ON c.p_id = p.product_id WHERE c.user_id = ? AND c.status = "Chosen" ORDER BY c.cart_id DESC',
            [uid]
        );
        rows.forEach(r => { if(r.product_image) r.product_image = 'products/' + r.product_image; });
        success(res, rows);
    } catch(e) { error(res, e.message); }
});

// 6. DELETE /api/delete-account/:id
router.delete('/delete-account/:id', async (req, res) => {
    try {
        const { id } = req.params;
        await db.query('DELETE FROM aalierp_user WHERE user_id=?', [id]);
        success(res, { status: true, message: 'Account deleted successfully' });
    } catch(e) { error(res, e.message); }
});

// 7. PUT /api/cart/:id (Update qty)
router.put('/cart/:id', async (req, res) => {
    try {
        const { id } = req.params;
        const { qty } = req.body;
        await db.query('UPDATE aalierp_cart SET qty = ? WHERE cart_id = ?', [qty, id]);
        success(res, { status: true, message: 'Quantity updated' });
    } catch(e) { error(res, e.message); }
});

// 8. DELETE /api/cart/:id (Remove item)
router.delete('/cart/:id', async (req, res) => {
    try {
        const { id } = req.params;
        await db.query('DELETE FROM aalierp_cart WHERE cart_id=?', [id]);
        success(res, { status: true, message: 'Item removed' });
    } catch(e) { error(res, e.message); }
});

module.exports = router;
