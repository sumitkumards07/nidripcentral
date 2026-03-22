import prisma from '../config/prisma';

export class BrandService {
  async getAll() {
    return prisma.brand.findMany({ orderBy: { brand_id: 'desc' } });
  }

  async create(name: string, image: string, createdBy: string) {
    const exists = await prisma.brand.findUnique({ where: { brand_name: name } });
    if (exists) return { success: false, message: 'Brand already exists!' };
    await prisma.brand.create({
      data: { brand_name: name, brand_image: image, created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Brand Added!' };
  }

  async update(id: number, data: { name?: string; image?: string }) {
    const updateData: any = { updated_on: new Date() };
    if (data.name) updateData.brand_name = data.name;
    if (data.image) updateData.brand_image = data.image;
    await prisma.brand.update({ where: { brand_id: id }, data: updateData });
    return { success: true, message: 'Brand updated!' };
  }

  async delete(id: number) {
    await prisma.brand.delete({ where: { brand_id: id } });
    return { success: true, message: 'Brand deleted!' };
  }
}

export class BannerService {
  async getAll() {
    return prisma.banner.findMany({ orderBy: { banner_id: 'desc' } });
  }

  async create(size: string, image: string, createdBy: string) {
    await prisma.banner.create({
      data: { banner_size: size, banner_image: image, banner_status: 'Active', created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Banner Added!' };
  }

  async updateStatus(id: number, status: string) {
    await prisma.banner.update({ where: { banner_id: id }, data: { banner_status: status } });
    return { success: true, message: `Banner marked as ${status}` };
  }

  async delete(id: number) {
    await prisma.banner.delete({ where: { banner_id: id } });
    return { success: true, message: 'Banner deleted!' };
  }
}

export const brandService = new BrandService();
export const bannerService = new BannerService();
