require('dotenv').config();
const mysql = require('mysql2/promise');

let pool;

const dbUrl = process.env.DATABASE_URL
  ? process.env.DATABASE_URL.replace('${DB_PASS}', process.env.DB_PASS || '')
  : null;

if (dbUrl) {
  pool = mysql.createPool({
    uri: dbUrl,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
  });
} else {
  pool = mysql.createPool({
    host: process.env.DB_HOST,
    port: parseInt(process.env.DB_PORT || '3306'),
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME,
    ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : false,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
  });
}

module.exports = pool;

