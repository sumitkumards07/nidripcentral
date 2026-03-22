import prisma from '../config/prisma';

export class CategoryService {
  async getAll() {
    return prisma.category.findMany({ orderBy: { category_id: 'desc' } });
  }

  async getById(id: number) {
    return prisma.category.findUnique({ where: { category_id: id } });
  }

  async create(name: string, description: string, createdBy: string) {
    const exists = await prisma.category.findUnique({ where: { category_name: name } });
    if (exists) return { success: false, message: 'Category already exists!' };
    await prisma.category.create({
      data: { category_name: name, category_description: description, created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Category Added!' };
  }

  async update(id: number, name: string) {
    await prisma.category.update({ where: { category_id: id }, data: { category_name: name, updated_on: new Date() } });
    return { success: true, message: 'Category updated!' };
  }

  async delete(id: number) {
    // FK check: can't delete if products use it
    const used = await prisma.product.count({ where: { category_id: id } });
    if (used > 0) return { success: false, message: 'Category is used in product table' };
    await prisma.category.delete({ where: { category_id: id } });
    return { success: true, message: 'Category Deleted' };
  }
}

export class SubCategoryService {
  async getAll() {
    return prisma.subCategory.findMany({
      orderBy: { sub_category_id: 'desc' },
      include: { category: { select: { category_name: true } } },
    });
  }

  async create(name: string, categoryId: number, createdBy: string) {
    const exists = await prisma.subCategory.findUnique({ where: { sub_category_name: name } });
    if (exists) return { success: false, message: 'Sub Category already exists!' };
    await prisma.subCategory.create({
      data: { sub_category_name: name, category_id: categoryId, created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Sub Category Added!' };
  }

  async update(id: number, name: string, categoryId: number) {
    await prisma.subCategory.update({ where: { sub_category_id: id }, data: { sub_category_name: name, category_id: categoryId, updated_on: new Date() } });
    return { success: true, message: 'Sub Category updated!' };
  }

  async delete(id: number) {
    const used = await prisma.product.count({ where: { subcategory_id: id } });
    if (used > 0) return { success: false, message: 'Sub Category is used in product table' };
    await prisma.subCategory.delete({ where: { sub_category_id: id } });
    return { success: true, message: 'Sub Category Deleted' };
  }
}

export class UnitService {
  async getAll() {
    return prisma.unit.findMany({ orderBy: { unit_id: 'desc' } });
  }

  async create(name: string, createdBy: string) {
    const exists = await prisma.unit.findUnique({ where: { unit_name: name } });
    if (exists) return { success: false, message: 'Unit already exists!' };
    await prisma.unit.create({
      data: { unit_name: name, created_on: new Date(), created_by: createdBy },
    });
    return { success: true, message: 'Unit Added!' };
  }

  async update(id: number, name: string) {
    await prisma.unit.update({ where: { unit_id: id }, data: { unit_name: name, updated_on: new Date() } });
    return { success: true, message: 'Unit updated!' };
  }

  async delete(id: number) {
    await prisma.unit.delete({ where: { unit_id: id } });
    return { success: true, message: 'Unit Deleted' };
  }
}

export const categoryService = new CategoryService();
export const subCategoryService = new SubCategoryService();
export const unitService = new UnitService();
