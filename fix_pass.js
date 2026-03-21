const pool = require('./config/db');
const bcrypt = require('bcryptjs');

async function fix() {
  try {
    const hashedPassword = await bcrypt.hash('password123', 10);
    await pool.query('UPDATE aalierp_user SET user_password = ? WHERE user_username = ?', [hashedPassword, 'testuser']);
    console.log('✅ Updated testuser password with bcrypt');
    process.exit(0);
  } catch (err) {
    console.error('Error:', err);
    process.exit(1);
  }
}

fix();
