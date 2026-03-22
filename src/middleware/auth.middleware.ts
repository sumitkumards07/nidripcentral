import { Request, Response, NextFunction } from 'express';

/** Require admin session for protected routes */
export function requireAdmin(req: Request, res: Response, next: NextFunction): void {
  if (!req.session || !(req.session as any).user) {
    if (req.headers.accept?.includes('application/json')) {
      res.status(401).json({ success: false, message: 'Unauthorized' });
      return;
    }
    res.redirect('/login');
    return;
  }
  const userType = ((req.session as any).user.type || '').toLowerCase().trim();
  if (!['admin', 'super'].includes(userType)) {
    res.status(403).json({ success: false, message: 'Forbidden' });
    return;
  }
  next();
}

/** Attach user object to request for easier access */
export function attachUser(req: Request, _res: Response, next: NextFunction): void {
  if (req.session && (req.session as any).user) {
    (req as any).adminUser = (req.session as any).user;
  }
  next();
}
