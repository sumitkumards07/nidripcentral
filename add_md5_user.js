const pool = require('./config/db');
const md5 = require('md5');

async function addMd5User() {
  try {
    const md5Password = md5('password123');
    await pool.query(
      'INSERT INTO aalierp_user (user_username, user_email, user_password, user_passcode, user_status, user_type) VALUES (?, ?, ?, ?, ?, ?)',
      ['md5user', 'md5@example.com', md5Password, 'password123', 'Approved', 'User']
    );
    console.log('✅ Created md5user / password123');
    process.exit(0);
  } catch (err) {
    console.error('Error:', err);
    process.exit(1);
  }
}

addMd5User();
