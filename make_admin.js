const db = require('./config/db');

async function makeAdmin(email) {
    try {
        const [result] = await db.query("UPDATE aalierp_user SET user_type = 'Admin' WHERE user_email = ?", [email]);
        if (result.affectedRows > 0) {
            console.log(`✅ Successfully made ${email} an Admin.`);
        } else {
            console.log(`❌ User with email ${email} not found.`);
        }
        process.exit(0);
    } catch (err) {
        console.error("Error:", err);
        process.exit(1);
    }
}

const targetEmail = process.argv[2];
if (!targetEmail) {
    console.log("Usage: node make_admin.js <email>");
    process.exit(1);
}

makeAdmin(targetEmail);
