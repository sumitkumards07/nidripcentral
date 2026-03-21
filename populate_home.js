const pool = require('./config/db');

async function populate() {
  try {
    // Clear existing for a fresh start (optional, but good for demo)
    await pool.query('DELETE FROM aalierp_category');
    await pool.query('DELETE FROM aalierp_product');
    await pool.query('DELETE FROM aalierp_banner');

    // 1. Categories
    const categories = [
      ['Washing Machines', 'washing_machine.png'],
      ['Refrigerators', 'fridge.png'],
      ['Ovens', 'oven.png'],
      ['Dishwashers', 'dishwasher.png']
    ];
    for (const [name, img] of categories) {
      await pool.query('INSERT INTO aalierp_category (category_name, category_image, created_on) VALUES (?, ?, NOW())', [name, img]);
    }
    console.log('✅ Categories populated');

    // 2. Fetch category IDs
    const [catRows] = await pool.query('SELECT category_id, category_name FROM aalierp_category');
    const catMap = {};
    catRows.forEach(row => catMap[row.category_name] = row.category_id);

    // 3. Products
    const products = [
      [catMap['Washing Machines'], 'Samsung EcoBubble', 'samsung_wm.png', 499.99, 599.99, 15, 'Active'],
      [catMap['Refrigerators'], 'LG InstaView', 'lg_fridge.png', 1299.99, 1499.99, 10, 'Active'],
      [catMap['Ovens'], 'Bosch Series 8', 'bosch_oven.png', 799.99, 899.99, 5, 'Active'],
      [catMap['Dishwashers'], 'Miele G7000', 'miele_dw.png', 999.99, 1099.99, 8, 'Active'],
      [catMap['Washing Machines'], 'Hotpoint ActiveCare', 'hotpoint_wm.png', 349.99, 399.99, 12, 'Active'],
      [catMap['Refrigerators'], 'Beko HarvestFresh', 'beko_fridge.png', 449.99, 499.99, 10, 'Active']
    ];

    for (const p of products) {
      await pool.query(
        `INSERT INTO aalierp_product (category_id, product_name, product_image, product_price, product_old_price, product_discount, product_status, created_on) 
         VALUES (?, ?, ?, ?, ?, ?, ?, NOW())`,
        p
      );
    }
    console.log('✅ Products populated');

    // 4. Banners
    await pool.query("INSERT INTO aalierp_banner (banner_size, banner_image) VALUES ('Small', 'banner1.png')");
    console.log('✅ Banners populated');

    process.exit(0);
  } catch (err) {
    console.error('Population Error:', err);
    process.exit(1);
  }
}

populate();
