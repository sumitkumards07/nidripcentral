<input type="checkbox" id="sidebar-toggle" hidden>
<label for="sidebar-toggle" class="overlay"></label>

<div class="app">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-">
                <img src="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>" alt="<?php echo $company_name; ?>" class="brand-logo" style="height:60px;width:auto;">
            </a>
        </div>

        <nav class="nav">
            <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-" class="nav-item <?php if(isset($_GET["-"])){echo "active";} ?>" style="text-decoration:none;">
                <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                <span class="label">Dashboard</span>
            </a>
            <a href="<?php echo $AaliLINK; ?>/admin/view-orders/?vo#" class="nav-item <?php if(isset($_GET["vo"]) || isset($_GET["po"]) || isset($_GET["op"]) || isset($_GET["od"]) || isset($_GET["oc"]) || isset($_GET["or"])){echo "active";} ?>" style="text-decoration:none;">
                <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg></span>
                <span class="label">Orders</span>
            </a>
            <a href="<?php echo $AaliLINK; ?>/admin/users/?ud" class="nav-item <?php if(isset($_GET["ud"])){echo "active";} ?>" style="text-decoration:none;">
                <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                <span class="label">Customer</span>
            </a>
            <a href="<?php echo $AaliLINK; ?>/admin/view-product/?vp#" class="nav-item <?php if(isset($_GET["ap"]) || isset($_GET["vp"]) || isset($_GET["ai"])){echo "active";} ?>" style="text-decoration:none;">
                <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
                <span class="label">Products</span>
            </a>
            <a href="<?php echo $AaliLINK; ?>/admin/add-category/?ac" class="nav-item <?php if(isset($_GET["ac"]) || isset($_GET["ab"]) || isset($_GET["asc"]) || isset($_GET["aut"])){echo "active";} ?>" style="text-decoration:none;">
                <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></span>
                <span class="label">Settings</span>
        <div class="sidebar-menu">
            <a href="<?php echo DOMAIN; ?>/cms/admin/dashboard/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/view-orders/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'orders') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span>Orders</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/users/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Customer</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/view-product/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'product') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                <span>Products</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/banner/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'banner') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 15h2"/><path d="M15 15h2"/><path d="M19 15h2"/><path d="M3 15h2"/><path d="M7 15h2"/><path d="m21 10-2 8H5l-2-8h18Z"/><path d="m21 10-2-4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1l-2 4h18Z"/></svg>
                <span>Marketing</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/support/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'support') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.77 3.77Z"/></svg>
                <span>Support</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/sales-report/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'report') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                <span>Reports</span>
            </a>
            <a href="<?php echo DOMAIN; ?>/cms/admin/content/" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'content') !== false) ? 'active' : ''; ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Settings</span>
            </a>
        </div>

        <div class="upgrade-wrapper">
            <a href="<?php echo $AaliLINK; ?>/config/logout.php" class="upgrade" style="display:block;text-align:center;text-decoration:none;">Logout</a>
        </div>
        <div class="sidebar-foot">© <?php echo $company_name; ?></div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <header class="header">
            <div class="breadcrumbs">Dashboard / <strong>Admin</strong></div>
            <div class="header-row">
                <label for="sidebar-toggle" class="hamburger"><span></span><span></span><span></span></label>
                <h1>Admin Dashboard</h1>
                <div class="header-controls">
                    <div class="search" style="margin-right:20px;">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position:relative; left:35px; top:3px; z-index:1;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" placeholder="Search anything here" style="padding:12px 20px 12px 45px; width:350px; border-radius:12px; border:1px solid #eee; background:#f9f9f9; font-size:14px; outline:none;">
                    </div>
                    <button class="notif" style="background:#fd215e; border:none; border-radius:12px; width:45px; height:45px; display:flex; align-items:center; justify-content:center; color:#fff; cursor:pointer; margin-right:15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </button>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div class="avatar" style="width:45px; height:45px; border-radius:12px; background:linear-gradient(135deg, #fd215e, #fd229b); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700;">A</div>
                        <span style="font-size:14px; font-weight:600; color:#1a1a1a;">Hello, <?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Admin"; ?></span>
                    </div>
                </div>
            </div>
        </header>