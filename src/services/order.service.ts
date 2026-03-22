import prisma from '../config/prisma';

export class OrderService {
  async getAll(status?: string) {
    const where = status ? { status } : {};
    return prisma.cart.findMany({
      where,
      orderBy: { id: 'desc' },
      include: {
        product: { select: { product_name: true, product_image: true, product_price: true } },
        user: { select: { user_name: true, user_email: true, user_mobile: true } },
      },
    });
  }

  async getCount(status: string) {
    return prisma.cart.count({ where: { status } });
  }

  async updateStatus(id: number, status: string) {
    await prisma.cart.update({ where: { id }, data: { status } });
    return { success: true, message: `Order marked as ${status}` };
  }

  async delete(id: number) {
    await prisma.cart.delete({ where: { id } });
    return { success: true, message: 'Order deleted!' };
  }

  /** Dashboard stats */
  async getStats() {
    const [totalOrders, pendingOrders, totalCustomers, refunds] = await Promise.all([
      prisma.cart.count(),
      prisma.cart.count({ where: { status: 'Pending' } }),
      prisma.user.count(),
      prisma.cart.count({ where: { status: 'Refunded' } }),
    ]);
    return { total_orders: totalOrders, pending_orders: pendingOrders, total_customers: totalCustomers, refunds };
  }
}

export const orderService = new OrderService();
