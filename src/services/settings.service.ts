import prisma from '../config/prisma';

export class SettingsService {
  async get() {
    return prisma.contents.findFirst({ orderBy: { company_id: 'desc' } });
  }

  async save(data: Record<string, string>, logo?: string) {
    const existing = await prisma.contents.findFirst({ orderBy: { company_id: 'desc' } });
    const fields: any = {
      company_name: data.company_name,
      company_salogan: data.company_salogan,
      company_mobile: data.company_mobile,
      company_email: data.company_email,
      company_web: data.company_web,
      company_phone: data.company_phone,
      company_address: data.company_address,
      company_city: data.company_city,
      company_country: data.company_country,
      company_currency: data.company_currency,
    };
    if (logo) fields.company_logo = logo;

    if (existing) {
      await prisma.contents.update({ where: { company_id: existing.company_id }, data: fields });
    } else {
      if (!fields.company_logo) fields.company_logo = '';
      await prisma.contents.create({ data: fields });
    }
    return { success: true, message: 'Settings saved!' };
  }
}

export class CustomerService {
  async getAll() {
    const users = await prisma.user.findMany({
      orderBy: { user_id: 'desc' },
      select: {
        user_id: true, user_name: true, user_fname: true, user_lname: true,
        user_email: true, user_mobile: true, user_status: true, user_image: true,
        _count: { select: { cart_items: true } },
      },
    });
    return users.map((u: any) => ({
      ...u,
      order_count: u._count.cart_items,
      _count: undefined,
    }));
  }

  async updateStatus(id: number, status: string) {
    await prisma.user.update({ where: { user_id: id }, data: { user_status: status } });
    return { success: true, message: `User ${status}` };
  }

  async delete(id: number) {
    await prisma.user.delete({ where: { user_id: id } });
    return { success: true, message: 'Customer deleted!' };
  }
}

export class SupportService {
  async getTickets() {
    return prisma.ticket.findMany({
      orderBy: { id: 'desc' },
      include: { user: { select: { user_name: true } } },
    });
  }

  async getCoupons() {
    return prisma.coupon.findMany({ orderBy: { id: 'desc' } });
  }
}

export const settingsService = new SettingsService();
export const customerService = new CustomerService();
export const supportService = new SupportService();
