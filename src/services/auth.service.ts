import prisma from '../config/prisma';
import bcrypt from 'bcryptjs';
import { Request } from 'express';

export interface AdminUser {
  id: number;
  name: string;
  username: string;
  email: string;
  image: string;
  type: string;
  status: string;
}

export class AuthService {
  /** Admin login — replaces PHP User::userLogin() */
  async login(email: string, password: string, req: Request): Promise<{ success: boolean; message: string; redirect?: string }> {
    if (!email || !password) return { success: false, message: 'Missing credentials' };

    const user = await prisma.user.findFirst({
      where: { OR: [{ user_email: email }, { user_username: email }] },
    });

    if (!user) return { success: false, message: 'User Not Registered!' };

    // Support both raw and hashed passwords (legacy compat)
    const pwd = user.user_password || '';
    const isMatch = password === pwd || await bcrypt.compare(password, pwd).catch(() => false);
    if (!isMatch) return { success: false, message: "Password doesn't match!" };

    const userType = (user.user_type || '').toLowerCase().trim();
    const userStatus = (user.user_status || '').toLowerCase().trim();

    if (!['admin', 'super'].includes(userType))
      return { success: false, message: 'This account is not allowed in admin panel!' };
    if (userStatus !== 'approved')
      return { success: false, message: 'Your account is not approved yet!' };

    const fullName = (user.user_name || '').trim()
      || `${user.user_fname || ''} ${user.user_lname || ''}`.trim()
      || user.user_username || user.user_email;

    const sessionUser: AdminUser = {
      id: user.user_id,
      name: fullName,
      username: user.user_username || '',
      email: user.user_email,
      image: user.user_image || '',
      type: user.user_type,
      status: user.user_status,
    };
    (req.session as any).user = sessionUser;

    // Audit log
    await prisma.loginDetail.create({
      data: {
        login_id: String(user.user_id),
        login_name: fullName,
        login_email: user.user_email,
        login_date: new Date(),
        login_ip: req.ip || '127.0.0.1',
        login_country: 'Remote',
        login_city: 'Cloud',
        logout_date: new Date(),
      },
    }).catch(() => {}); // non-critical

    const msg = userType === 'super' ? 'Super Admin Logged In Successfully!' : 'Admin Logged In Successfully!';
    return { success: true, message: msg, redirect: '/dashboard' };
  }

  /** Create admin user — replaces PHP User::createUserAccount() */
  async createUser(data: {
    fname: string; lname: string; username: string; email: string;
    password: string; mobile?: string; image?: string; type?: string; status?: string;
  }, ipAddress: string): Promise<{ success: boolean; message: string }> {
    const exists = await prisma.user.findUnique({ where: { user_email: data.email } });
    if (exists) return { success: false, message: 'User already exists!' };

    const hash = await bcrypt.hash(data.password, 10);
    await prisma.user.create({
      data: {
        user_fname: data.fname,
        user_lname: data.lname,
        user_username: data.username,
        user_email: data.email,
        user_password: hash,
        user_mobile: data.mobile || '',
        user_image: data.image || '',
        user_type: data.type || 'Admin',
        user_status: data.status || 'Approved',
        user_ip: ipAddress,
        user_city: 'Cloud',
        user_country: 'Remote',
      },
    });

    return { success: true, message: 'Registered Successfully!' };
  }
}

export const authService = new AuthService();
