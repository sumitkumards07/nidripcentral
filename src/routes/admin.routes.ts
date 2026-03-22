import { Router, Request, Response } from 'express';
import multer from 'multer';
import path from 'path';
import fs from 'fs';

import { authService } from '../services/auth.service';
import { brandService, bannerService } from '../services/brand.service';
import { categoryService, subCategoryService, unitService } from '../services/category.service';
import { productService } from '../services/product.service';
import { orderService } from '../services/order.service';
import { settingsService, customerService, supportService } from '../services/settings.service';
import { requireAdmin, attachUser } from '../middleware/auth.middleware';

const router = Router();

// ─── FILE UPLOAD CONFIG ─────────────────────────────────────────────
const VALID_EXTS = ['.jpeg', '.jpg', '.png', '.gif', '.bmp', '.webp'];

function makeStorage(subfolder: string) {
  const dest = path.join(__dirname, '..', '..', 'public', 'uploads', subfolder);
  fs.mkdirSync(dest, { recursive: true });
  return multer.diskStorage({
    destination: (_req, _file, cb) => cb(null, dest),
    filename: (_req, file, cb) => {
      const unique = Date.now() + '-' + Math.round(Math.random() * 1e6);
      cb(null, unique + path.extname(file.originalname).toLowerCase());
    },
  });
}

function imageFilter(_req: any, file: Express.Multer.File, cb: multer.FileFilterCallback) {
  const ext = path.extname(file.originalname).toLowerCase();
  if (VALID_EXTS.includes(ext)) cb(null, true);
  else cb(new Error('Invalid image format'));
}

const upload = {
  brands: multer({ storage: makeStorage('brands'), fileFilter: imageFilter }),
  banners: multer({ storage: makeStorage('banners'), fileFilter: imageFilter }),
  products: multer({ storage: makeStorage('products'), fileFilter: imageFilter }),
  logos: multer({ storage: makeStorage('logos'), fileFilter: imageFilter }),
};

// Apply guards
router.use(requireAdmin);
router.use(attachUser);

function getUser(req: Request) { return (req as any).adminUser || { name: 'Admin' }; }

// ═══════════════════════════════════════════════════════════════
// AUTH
// ═══════════════════════════════════════════════════════════════

router.post('/cms-login', async (req: Request, res: Response) => {
  const { user_email, user_password } = req.body;
  const result = await authService.login(user_email, user_password, req);
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// BRANDS
// ═══════════════════════════════════════════════════════════════

router.get('/brands', async (_req: Request, res: Response) => {
  const data = await brandService.getAll();
  res.json({ success: true, data });
});

router.post('/brands', upload.brands.single('brand_image'), async (req: Request, res: Response) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  const result = await brandService.create(req.body.brand_name, `/uploads/brands/${req.file.filename}`, getUser(req).name);
  res.json(result);
});

router.put('/brands/:id', upload.brands.single('brand_image'), async (req: Request, res: Response) => {
  const data: any = { name: req.body.brand_name };
  if (req.file) data.image = `/uploads/brands/${req.file.filename}`;
  const result = await brandService.update(Number(req.params.id), data);
  res.json(result);
});

router.delete('/brands/:id', async (req: Request, res: Response) => {
  const result = await brandService.delete(Number(req.params.id));
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// BANNERS
// ═══════════════════════════════════════════════════════════════

router.get('/banners', async (_req: Request, res: Response) => {
  const data = await bannerService.getAll();
  res.json({ success: true, data });
});

router.post('/banners', upload.banners.single('banner_image'), async (req: Request, res: Response) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  const result = await bannerService.create(req.body.banner_size, `/uploads/banners/${req.file.filename}`, getUser(req).name);
  res.json(result);
});

router.put('/banners/:id/status', async (req: Request, res: Response) => {
  const result = await bannerService.updateStatus(Number(req.params.id), req.body.status);
  res.json(result);
});

router.delete('/banners/:id', async (req: Request, res: Response) => {
  const result = await bannerService.delete(Number(req.params.id));
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// CATEGORIES
// ═══════════════════════════════════════════════════════════════

router.get('/categories', async (_req: Request, res: Response) => {
  const data = await categoryService.getAll();
  res.json({ success: true, data });
});

router.post('/categories', async (req: Request, res: Response) => {
  const result = await categoryService.create(req.body.category_name, req.body.category_description || '', getUser(req).name);
  res.json(result);
});

router.put('/categories/:id', async (req: Request, res: Response) => {
  const result = await categoryService.update(Number(req.params.id), req.body.category_name);
  res.json(result);
});

router.delete('/categories/:id', async (req: Request, res: Response) => {
  const result = await categoryService.delete(Number(req.params.id));
  res.json(result);
});

// Sub-categories
router.get('/subcategories', async (_req: Request, res: Response) => {
  const data = await subCategoryService.getAll();
  res.json({ success: true, data });
});

router.post('/subcategories', async (req: Request, res: Response) => {
  const result = await subCategoryService.create(req.body.sub_category_name, Number(req.body.category_id), getUser(req).name);
  res.json(result);
});

router.put('/subcategories/:id', async (req: Request, res: Response) => {
  const result = await subCategoryService.update(Number(req.params.id), req.body.sub_category_name, Number(req.body.category_id));
  res.json(result);
});

router.delete('/subcategories/:id', async (req: Request, res: Response) => {
  const result = await subCategoryService.delete(Number(req.params.id));
  res.json(result);
});

// Units
router.get('/units', async (_req: Request, res: Response) => {
  const data = await unitService.getAll();
  res.json({ success: true, data });
});

router.post('/units', async (req: Request, res: Response) => {
  const result = await unitService.create(req.body.unit_name, getUser(req).name);
  res.json(result);
});

router.put('/units/:id', async (req: Request, res: Response) => {
  const result = await unitService.update(Number(req.params.id), req.body.unit_name);
  res.json(result);
});

router.delete('/units/:id', async (req: Request, res: Response) => {
  const result = await unitService.delete(Number(req.params.id));
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// PRODUCTS
// ═══════════════════════════════════════════════════════════════

router.get('/products', async (_req: Request, res: Response) => {
  const data = await productService.getAll();
  res.json({ success: true, data });
});

router.get('/products/:id', async (req: Request, res: Response) => {
  const data = await productService.getById(Number(req.params.id));
  res.json({ success: true, data });
});

router.post('/products', upload.products.single('product_image'), async (req: Request, res: Response) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  const result = await productService.create({
    name: req.body.product_name,
    image: `/uploads/products/${req.file.filename}`,
    categoryId: req.body.category_id ? Number(req.body.category_id) : undefined,
    subcategoryId: req.body.subcategory_id ? Number(req.body.subcategory_id) : undefined,
    unitId: req.body.unit_id ? Number(req.body.unit_id) : undefined,
    price: Number(req.body.product_price),
    oldPrice: Number(req.body.product_old_price || 0),
    discount: Number(req.body.product_discount || 0),
    keywords: req.body.product_keywords,
    desc: req.body.product_desc,
    createdBy: getUser(req).name,
  });
  res.json(result);
});

router.put('/products/:id', upload.products.single('product_image'), async (req: Request, res: Response) => {
  const data: any = { ...req.body };
  if (req.file) data.product_image = `/uploads/products/${req.file.filename}`;
  delete data.product_id; // safety
  const result = await productService.update(Number(req.params.id), data);
  res.json(result);
});

router.delete('/products/:id', async (req: Request, res: Response) => {
  const result = await productService.delete(Number(req.params.id));
  res.json(result);
});

// Product images
router.post('/products/:id/images', upload.products.single('product_image'), async (req: Request, res: Response) => {
  if (!req.file) return res.json({ success: false, message: 'Image required' });
  const result = await productService.addImage(Number(req.params.id), `/uploads/products/${req.file.filename}`, getUser(req).name);
  res.json(result);
});

router.get('/product-images', async (_req: Request, res: Response) => {
  const data = await productService.getImages();
  res.json({ success: true, data });
});

router.delete('/product-images/:id', async (req: Request, res: Response) => {
  const result = await productService.deleteImage(Number(req.params.id));
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// ORDERS
// ═══════════════════════════════════════════════════════════════

router.get('/orders', async (req: Request, res: Response) => {
  const status = req.query.status as string | undefined;
  const data = await orderService.getAll(status);
  res.json({ success: true, data });
});

router.put('/orders/:id/status', async (req: Request, res: Response) => {
  const result = await orderService.updateStatus(Number(req.params.id), req.body.status);
  res.json(result);
});

router.delete('/orders/:id', async (req: Request, res: Response) => {
  const result = await orderService.delete(Number(req.params.id));
  res.json(result);
});

router.get('/stats', async (_req: Request, res: Response) => {
  const data = await orderService.getStats();
  res.json({ success: true, data });
});

// ═══════════════════════════════════════════════════════════════
// SETTINGS
// ═══════════════════════════════════════════════════════════════

router.get('/settings', async (_req: Request, res: Response) => {
  const data = await settingsService.get();
  res.json({ success: true, data });
});

router.post('/settings', upload.logos.single('company_logo'), async (req: Request, res: Response) => {
  const logo = req.file ? `/uploads/logos/${req.file.filename}` : undefined;
  const result = await settingsService.save(req.body, logo);
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// CUSTOMERS
// ═══════════════════════════════════════════════════════════════

router.get('/customers', async (_req: Request, res: Response) => {
  const data = await customerService.getAll();
  res.json({ success: true, data });
});

router.put('/customers/:id/status', async (req: Request, res: Response) => {
  const result = await customerService.updateStatus(Number(req.params.id), req.body.status);
  res.json(result);
});

router.delete('/customers/:id', async (req: Request, res: Response) => {
  const result = await customerService.delete(Number(req.params.id));
  res.json(result);
});

// ═══════════════════════════════════════════════════════════════
// SUPPORT
// ═══════════════════════════════════════════════════════════════

router.get('/tickets', async (_req: Request, res: Response) => {
  const data = await supportService.getTickets();
  res.json({ success: true, data });
});

router.get('/coupons', async (_req: Request, res: Response) => {
  const data = await supportService.getCoupons();
  res.json({ success: true, data });
});

export default router;
