import prisma from '../config/prisma';

export class ProductService {
  async getAll() {
    return prisma.product.findMany({
      orderBy: { product_id: 'desc' },
      include: {
        category: { select: { category_name: true } },
        subcategory: { select: { sub_category_name: true } },
        unit: { select: { unit_name: true } },
      },
    });
  }

  async getById(id: number) {
    return prisma.product.findUnique({
      where: { product_id: id },
      include: { category: true, subcategory: true, unit: true, images: true },
    });
  }

  async create(data: {
    name: string; image: string; categoryId?: number; subcategoryId?: number;
    unitId?: number; price: number; oldPrice?: number; discount?: number;
    keywords?: string; desc?: string; createdBy: string;
  }) {
    const exists = await prisma.product.findFirst({ where: { product_name: data.name } });
    if (exists) return { success: false, message: 'Product already exists!' };

    await prisma.product.create({
      data: {
        product_name: data.name,
        product_image: data.image,
        category_id: data.categoryId || null,
        subcategory_id: data.subcategoryId || null,
        unit_id: data.unitId || null,
        product_price: data.price,
        product_old_price: data.oldPrice || 0,
        product_discount: data.discount || 0,
        product_keywords: data.keywords || '',
        product_desc: data.desc || '',
        product_status: 'Active',
        created_on: new Date(),
        created_by: data.createdBy,
      },
    });
    return { success: true, message: 'Product Added!' };
  }

  async update(id: number, data: Record<string, any>) {
    data.updated_on = new Date();
    await prisma.product.update({ where: { product_id: id }, data });
    return { success: true, message: 'Product updated!' };
  }

  async delete(id: number) {
    await prisma.product.delete({ where: { product_id: id } });
    return { success: true, message: 'Product deleted!' };
  }

  // Product gallery images
  async addImage(productId: number, image: string, createdBy: string) {
    await prisma.productImage.create({
      data: { product_id: productId, product_image: image, created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Image Added!' };
  }

  async getImages() {
    return prisma.productImage.findMany({
      orderBy: { image_id: 'desc' },
      include: { product: { select: { product_name: true, product_status: true } } },
    });
  }

  async deleteImage(id: number) {
    await prisma.productImage.delete({ where: { image_id: id } });
    return { success: true, message: 'Image deleted!' };
  }
}

export const productService = new ProductService();
