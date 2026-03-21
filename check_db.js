const pool = require('./config/db');

async function check() {
  try {
    const [rows] = await pool.query('SHOW TABLES');
    console.log('Tables:', rows.map(r => Object.values(r)[0]));
    process.exit(0);
  } catch (err) {
    console.error('Error:', err);
    process.exit(1);
  }
}

check();
