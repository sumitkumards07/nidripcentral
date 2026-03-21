const pool = require('./config/db');

async function migrate() {
  const dropTables = [
    'DROP TABLE IF EXISTS aalierp_user',
    'DROP TABLE IF EXISTS aalierp_contents',
    'DROP TABLE IF EXISTS aalierp_currency',
    'DROP TABLE IF EXISTS aalierp_product',
    'DROP TABLE IF EXISTS aalierp_category',
    'DROP TABLE IF EXISTS aalierp_subcategory',
    'DROP TABLE IF EXISTS aalierp_unit',
    'DROP TABLE IF EXISTS aalierp_cart',
    'DROP TABLE IF EXISTS aalierp_banner'
  ];

  const tables = [
    `CREATE TABLE IF NOT EXISTS aalierp_user (
      user_id INT AUTO_INCREMENT PRIMARY KEY,
      user_username VARCHAR(255),
      user_name VARCHAR(255),
      user_email VARCHAR(255),
      user_password VARCHAR(255),
      user_passcode VARCHAR(255),
      user_pin VARCHAR(255),
      user_email_otp VARCHAR(255),
      user_mobile VARCHAR(255),
      user_type VARCHAR(50) DEFAULT 'User',
      user_ip VARCHAR(100),
      user_city VARCHAR(100),
      user_country VARCHAR(100),
      user_cc VARCHAR(10),
      user_referred_by VARCHAR(255),
      user_referral VARCHAR(255),
      user_status VARCHAR(50) DEFAULT 'Pending',
      user_image VARCHAR(255),
      user_cash_wallet DECIMAL(15,2) DEFAULT 0,
      user_package_wallet DECIMAL(15,2) DEFAULT 0,
      user_referral_bonus DECIMAL(15,2) DEFAULT 0,
      user_roi DECIMAL(15,2) DEFAULT 0,
      user_profit_share DECIMAL(15,2) DEFAULT 0,
      user_reward_title VARCHAR(255),
      user_reward DECIMAL(15,2) DEFAULT 0,
      user_withdraw DECIMAL(15,2) DEFAULT 0,
      user_send DECIMAL(15,2) DEFAULT 0,
      user_recieve DECIMAL(15,2) DEFAULT 0,
      user_invest DECIMAL(15,2) DEFAULT 0,
      created_on DATETIME
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_contents (
      company_id INT PRIMARY KEY,
      company_name VARCHAR(255),
      company_currency VARCHAR(10)
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_currency (
      cur_id INT AUTO_INCREMENT PRIMARY KEY,
      cur_cc VARCHAR(10),
      cur_cur VARCHAR(10),
      cur_rate DECIMAL(15,4)
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_product (
      product_id INT AUTO_INCREMENT PRIMARY KEY,
      category_id INT,
      subcategory_id INT,
      unit_id INT,
      product_name VARCHAR(255),
      product_image VARCHAR(255),
      product_price DECIMAL(15,2),
      product_old_price DECIMAL(15,2),
      product_discount DECIMAL(5,2),
      product_status VARCHAR(50) DEFAULT 'Active',
      product_video VARCHAR(255),
      product_keywords TEXT,
      product_desc TEXT,
      created_on DATETIME,
      created_by VARCHAR(255)
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_category (
      category_id INT AUTO_INCREMENT PRIMARY KEY,
      category_name VARCHAR(255),
      category_image VARCHAR(255),
      created_on DATETIME,
      created_by VARCHAR(255),
      updated_on DATETIME
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_subcategory (
      subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
      category_id INT,
      subcategory_name VARCHAR(255),
      subcategory_status VARCHAR(50),
      created_on DATETIME,
      created_by VARCHAR(255),
      updated_on DATETIME
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_unit (
      unit_id INT AUTO_INCREMENT PRIMARY KEY,
      unit_name VARCHAR(255),
      created_on DATETIME,
      created_by VARCHAR(255),
      updated_on DATETIME
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_cart (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT,
      p_id INT,
      qty INT,
      date DATETIME,
      ip_add VARCHAR(100),
      status VARCHAR(50) DEFAULT 'Pending',
      ship VARCHAR(255)
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_banner (
      banner_id INT AUTO_INCREMENT PRIMARY KEY,
      banner_size VARCHAR(50),
      banner_image VARCHAR(255)
    )`,
    `CREATE TABLE IF NOT EXISTS aalierp_wishlist (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT,
      product_id INT,
      created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY unique_wish (user_id, product_id)
    )`
  ];

  try {
    for (const sql of dropTables) {
      await pool.query(sql);
      console.log('Dropped:', sql);
    }
    for (const sql of tables) {
      await pool.query(sql);
      console.log('Executed:', sql.substring(0, 50) + '...');
    }
    
    // Insert a default user for testing if none exists
    const [users] = await pool.query('SELECT * FROM aalierp_user LIMIT 1');
    if (users.length === 0) {
      const bcrypt = require('bcryptjs');
      const hashedPassword = await bcrypt.hash('password123', 10);
      const md5 = require('md5');
      const md5Password = md5('password123'); // API uses MD5
      
      await pool.query(
        'INSERT INTO aalierp_user (user_username, user_email, user_password, user_passcode, user_status, user_type) VALUES (?, ?, ?, ?, ?, ?)',
        ['testuser', 'test@example.com', md5Password, 'password123', 'Approved', 'User']
      );
      console.log('✅ Created testuser / password123');
    }
    
    // Insert dummy company content
    const [content] = await pool.query('SELECT * FROM aalierp_contents LIMIT 1');
    if (content.length === 0) {
      await pool.query('INSERT INTO aalierp_contents (company_id, company_name, company_currency) VALUES (1, "Ni Drip", "GBP")');
      console.log('✅ Created dummy company content');
    }

    process.exit(0);
  } catch (err) {
    console.error('Migration Error:', err);
    process.exit(1);
  }
}

migrate();

