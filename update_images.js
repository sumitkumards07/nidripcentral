const db = require('./config/db');

async function updateImages() {
  try {
    const updates = [
      { id: 1, img: 'washer_mockup.png' },
      { id: 2, img: 'fridge_mockup.png' },
      { id: 3, img: 'oven_mockup.png' },
      { id: 4, img: 'dishwasher_mockup.png' }
    ];

    for (const u of updates) {
      await db.query('UPDATE aalierp_product SET product_image = ? WHERE product_id = ?', [u.img, u.id]);
    }
    console.log('Images updated successfully');
    process.exit(0);
  } catch(e) {
    console.error(e);
    process.exit(1);
  }
}

updateImages();
