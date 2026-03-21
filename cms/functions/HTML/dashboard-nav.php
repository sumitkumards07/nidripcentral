<aside class="sidebar">
  <div class="brand">
    <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-">
      <img src="<?php echo $AaliLINK; ?>/assets/img/brand-logo.png" alt="NI DRIP Central" class="brand-logo" style="width: 140px; height: auto;">
    </a>
  </div>

  <nav class="nav">
    <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-" class="nav-item <?php if(isset($_GET["-"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg></span>
      <span class="label">Dashboard</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/view-orders/?vo" class="nav-item <?php if(isset($_GET["vo"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="8" cy="21" r="1" />
          <circle cx="19" cy="21" r="1" />
          <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
        </svg></span>
      <span class="label">Orders</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/users/?ud" class="nav-item <?php if(isset($_GET["ud"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
          <circle cx="9" cy="7" r="4" />
          <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
          <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg></span>
      <span class="label">Customer</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/view-product/?vp" class="nav-item <?php if(isset($_GET["vp"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m7.5 4.27 9 5.15" />
          <path
            d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
          <path d="m3.3 7 8.7 5 8.7-5" />
          <path d="M12 22V12" />
        </svg></span>
      <span class="label">Products</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/content/?content" class="nav-item <?php if(isset($_GET["content"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m3 11 18-5v12L3 14v-3z" />
          <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
        </svg></span>
      <span class="label">Marketing</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/accounts-detail/?ad" class="nav-item <?php if(isset($_GET["ad"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path
            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
        </svg></span>
      <span class="label">Accounts</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/sales-report/?sr" class="nav-item <?php if(isset($_GET["sr"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" x2="12" y1="20" y2="10" />
          <line x1="18" x2="18" y1="20" y2="4" />
          <line x1="6" x2="6" y1="20" y2="16" />
        </svg></span>
      <span class="label">Reports</span>
    </a>
    <a href="<?php echo $AaliLINK; ?>/admin/add-category/?ac" class="nav-item <?php if(isset($_GET["ac"])){echo "active";} ?>" style="text-decoration:none;">
      <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path
            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
          <circle cx="12" cy="12" r="3" />
        </svg></span>
      <span class="label">Settings</span>
    </a>
  </nav>

  <div class="upgrade-wrapper">
    <button class="upgrade">Upgrade To Pro</button>
  </div>

  <div class="sidebar-foot">© NI DRIP</div>
</aside>

<header class="header">
  <div class="breadcrumbs">Dashboard / <strong>Admin</strong></div>
  <div class="header-row">
    <label for="sidebar-toggle" class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <h1>Admin Dashboard</h1>
    
    <div class="header-controls">
      <div class="search" style="display:none;"></div>
      
      <!-- User / Logout -->
      <div class="auth-buttons" style="display:flex; gap:12px; align-items:center;">
        <span style="font-size:14px; font-weight:600; color:var(--c1);">Hello, <?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Admin"; ?></span>
        <a href="<?php echo $AaliLINK; ?>/config/logout.php" class="upgrade" style="padding:10px 18px; font-weight:600; color:#fff; background:linear-gradient(135deg, var(--c1), var(--c3)); border-radius:12px; text-decoration:none; display:flex; align-items:center; gap:8px; font-size:14px; box-shadow:0 10px 25px rgba(253,33,94,0.3);">
          Logout
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 24 24">
            <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5a2 2 0 0 0-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</header>
