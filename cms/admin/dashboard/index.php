<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
        exit;
    }

    // Live Database Counts
    $r1 = mysqli_query($conn, "SELECT COUNT(*) as c FROM aalierp_cart");
    $total_orders = ($r1 && $row1 = mysqli_fetch_assoc($r1)) ? $row1['c'] : 0;

    $r2 = mysqli_query($conn, "SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Pending'");
    $pending_orders = ($r2 && $row2 = mysqli_fetch_assoc($r2)) ? $row2['c'] : 0;

    $r3 = mysqli_query($conn, "SELECT COUNT(*) as c FROM aalierp_user");
    $total_customers = ($r3 && $row3 = mysqli_fetch_assoc($r3)) ? $row3['c'] : 0;

    $r4 = mysqli_query($conn, "SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Refunded'");
    $refunds = ($r4 && $row4 = mysqli_fetch_assoc($r4)) ? $row4['c'] : 0;

    $recent = mysqli_query($conn, "SELECT c.id, c.date, c.status, p.product_name FROM aalierp_cart c LEFT JOIN aalierp_product p ON c.p_id = p.product_id ORDER BY c.id DESC LIMIT 7");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <style>
:root{--c1:#fd215e;--c2:#fd229b;--c3:#fd23c2;--c6:#59c167;--bg:#fafafa;--card:#fff;--border:rgba(0,0,0,.06);--muted:#8a8a8a;--foreground:#1a1a1a;font-family:'Inter',system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body,html{background:linear-gradient(180deg,#fff,#f4f6f8);min-height:100vh;overflow-x:hidden}
.app{display:flex;min-height:100vh}
.hamburger{display:none;width:36px;height:28px;flex-direction:column;justify-content:space-between;cursor:pointer}
.hamburger span{height:4px;width:100%;background:#111;border-radius:4px;transition:.3s ease}
.overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);opacity:0;visibility:hidden;transition:.3s ease;z-index:98}
.sidebar{width:280px;padding:32px;background:linear-gradient(180deg,#ff2b8a 0%,#ff3aa6 50%,#6ee28e 100%);color:#fff;display:flex;flex-direction:column;min-height:100vh}
.brand{display:flex;justify-content:center;margin-bottom:40px}
.brand-logo{width:200px;max-width:100%}
.nav{display:flex;flex-direction:column;gap:12px;flex:1}
.nav-item{background:rgba(255,255,255,.15);border-radius:12px;padding:12px 16px;border:none;color:#fff;display:flex;align-items:center;gap:16px;cursor:pointer;transition:all .2s ease;font-size:15px;font-family:inherit}
.nav-item:hover{background:rgba(255,255,255,.25)}
.nav-item .ico-box{width:44px;height:44px;border-radius:12px;background:#fff;color:var(--foreground);display:flex;align-items:center;justify-content:center}
.nav-item.active{background:#fff;color:var(--c1);font-weight:600}
.nav-item.active .ico-box{background:linear-gradient(135deg,var(--c1),var(--c3));color:#fff}
.upgrade-wrapper{margin-top:auto;padding-top:32px}
.upgrade{width:100%;background:#fff;border:none;padding:12px 24px;border-radius:12px;font-weight:700;color:var(--c1);cursor:pointer;font-family:inherit;font-size:14px;transition:box-shadow .2s ease}
.upgrade:hover{box-shadow:0 10px 30px rgba(0,0,0,.15)}
.sidebar-foot{text-align:center;font-size:12px;opacity:.7;margin-top:24px}
.main{flex:1;padding:24px;overflow-y:auto;overflow-x:hidden}
.header{margin-bottom:24px}
.breadcrumbs{color:var(--muted);font-size:14px;margin-bottom:8px}
.header-row{display:flex;align-items:center;justify-content:space-between}
.header-row h1{font-size:32px;font-weight:700;color:var(--foreground)}
.header-controls{display:flex;align-items:center;gap:16px}
.search{position:relative}
.search-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--muted)}
.search input{padding:14px 20px 14px 48px;width:320px;border-radius:999px;border:1px solid var(--border);background:#fff;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s ease,box-shadow .2s ease}
.search input:focus{border-color:var(--c1);box-shadow:0 0 0 3px rgba(253,33,94,.1)}
.notif{width:48px;height:48px;background:linear-gradient(135deg,var(--c1),var(--c3));border:none;border-radius:12px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:transform .2s ease}
.notif:hover{transform:scale(1.05)}
.page{display:none}.page.active{display:block}
.dashboard-card{background:#fff;border:2px solid var(--border);border-radius:24px;padding:28px;box-shadow:0 20px 60px rgba(18,22,26,.08)}
.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:28px}
.card{background:#fff;padding:20px;border-radius:16px;border:1.5px solid var(--border);box-shadow:0 8px 20px rgba(18,22,26,.04)}
.stat{display:flex;gap:16px;align-items:center;border:2px solid rgba(253,33,94,.1)}
.stat .icon{width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,var(--c1),var(--c2));display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0}
.stat .meta .label{color:var(--muted);font-size:14px;margin-bottom:4px}
.stat .meta .value{font-size:28px;font-weight:800;color:var(--foreground)}
.stat .meta .small{font-size:12px;color:var(--muted)}
.layout{display:grid;grid-template-columns:1fr 380px;gap:24px}
.left{display:flex;flex-direction:column;gap:20px}
.hero{padding:24px}
.hero-content{display:flex;align-items:center;gap:24px}
.hero-text{flex:1}
.hero-text small{color:var(--muted);font-size:14px}
.hero-text h2{font-size:20px;font-weight:700;color:var(--foreground);margin:8px 0}
.hero-text p{color:var(--muted);font-size:14px;line-height:1.6;margin-bottom:16px}
.hero-text .learn{color:var(--c1);font-weight:600;font-size:14px;text-decoration:none}
.hero-text .learn:hover{text-decoration:underline}
.hero-media{width:200px;height:140px;border-radius:16px;background:linear-gradient(135deg,var(--c1),var(--c3),var(--c6));display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden}
.hero-media img{width:96px;height:96px;object-fit:contain}
.activity-card h3{font-size:16px;font-weight:600;margin-bottom:16px;color:var(--foreground)}
.activity{list-style:none}
.activity li{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);font-size:14px;color:var(--foreground)}
.activity li:last-child{border-bottom:none}
.activity li span{color:var(--muted);font-size:12px}
.orders h3{font-size:16px;font-weight:600;margin-bottom:16px;color:var(--foreground)}
.orders ul{list-style:none}
.orders li{display:flex;justify-content:space-between;align-items:center;padding:14px;margin-bottom:10px;border-radius:12px;border:1px solid var(--border);box-shadow:0 4px 12px rgba(0,0,0,.04)}
.orders li:last-child{margin-bottom:0}
.order-item .order-title{font-size:14px;font-weight:500;color:var(--foreground)}
.order-item small{font-size:12px;color:var(--muted)}
.order-status{padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;color:#fff}
.order-status.processing,.order-status.pending{background:#ff9b70}
.order-status.shipped{background:#5aa8ff}
.order-status.delivered{background:#3fc36a}
.order-status.refunded{background:#c1c1c1;color:#222}
.order-status.paid{background:#b46bff}
@media(max-width:1200px){.cards{grid-template-columns:repeat(2,1fr)}.layout{grid-template-columns:1fr}}
@media(max-width:768px){
  .sidebar{position:fixed;left:-300px;z-index:99;transition:.3s ease}
  #sidebar-toggle:checked~.app .sidebar,#sidebar-toggle:checked~.overlay+.app .sidebar{left:0}
  #sidebar-toggle:checked~.overlay{opacity:1;visibility:visible}
  .hamburger{display:flex}
  .header-controls .search{display:none}
  .cards{grid-template-columns:1fr}
}
    </style>
</head>
<body>
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
                <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-" class="nav-item active" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                    <span class="label">Dashboard</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/view-orders/?vo" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg></span>
                    <span class="label">Orders</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/users/?ud" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                    <span class="label">Customer</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/view-product/?vp" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
                    <span class="label">Products</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/content/?content" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg></span>
                    <span class="label">Marketing</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/accounts-detail/?ad" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></span>
                    <span class="label">Accounts</span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/add-category/?ac" class="nav-item" style="text-decoration:none;">
                    <span class="ico-box"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    <span class="label">Settings</span>
                </a>
            </nav>

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
                        <div class="search">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input type="text" placeholder="Search anything here" aria-label="Search">
                        </div>
                        <button class="notif" aria-label="Notifications"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg></button>
                        <span style="font-size:14px;font-weight:600;color:var(--c1);">Hello, <?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Admin"; ?></span>
                    </div>
                </div>
            </header>

            <section class="page active" id="dashboardPage">
                <div class="dashboard-card">

                    <!-- Stat Cards -->
                    <section class="cards">
                        <div class="card stat">
                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></div>
                            <div class="meta"><div class="label">Total Orders</div><div class="value"><?php echo number_format($total_orders); ?></div><div class="small">Live from database</div></div>
                        </div>
                        <div class="card stat">
                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></div>
                            <div class="meta"><div class="label">Pending Orders</div><div class="value"><?php echo number_format($pending_orders); ?></div><div class="small">Awaiting shipment</div></div>
                        </div>
                        <div class="card stat">
                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                            <div class="meta"><div class="label">Total Customers</div><div class="value"><?php echo number_format($total_customers); ?></div><div class="small">Registered accounts</div></div>
                        </div>
                        <div class="card stat">
                            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                            <div class="meta"><div class="label">Return / Refund</div><div class="value"><?php echo number_format($refunds); ?></div><div class="small">Refund requests</div></div>
                        </div>
                    </section>

                    <!-- Layout Grid -->
                    <section class="layout">
                        <div class="left">
                            <!-- Hero Card -->
                            <div class="card hero">
                                <div class="hero-content">
                                    <div class="hero-text">
                                        <small>Built for store managers</small>
                                        <h2>Order Management</h2>
                                        <p>Track every order from checkout to delivery. Manage statuses, payments, and shipment updates all in one place.</p>
                                        <a href="<?php echo $AaliLINK; ?>/admin/view-orders/?vo#" class="learn">Learn More →</a>
                                    </div>
                                    <div class="hero-media">
                                        <img src="<?php echo $AaliLINK; ?>/assets/img/rocket-hero.png" alt="Rocket">
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="card activity-card">
                                <h3>Recent Activity</h3>
                                <ul class="activity">
                                    <li>Dashboard updated to new UI <span><?php echo date('d M g:i A'); ?></span></li>
                                    <li>Live database connected <span><?php echo date('d M g:i A'); ?></span></li>
                                    <li>Total <?php echo number_format($total_orders); ?> orders tracked <span><?php echo date('d M'); ?></span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Orders Overview -->
                        <aside class="right">
                            <div class="card orders">
                                <h3>Orders Overview</h3>
                                <ul>
                                    <?php 
                                    if($recent && mysqli_num_rows($recent) > 0){
                                        while($o = mysqli_fetch_assoc($recent)){
                                            $dt = date("d M g:i A", strtotime($o['date']));
                                            $pn = $o['product_name'] ? substr($o['product_name'],0,25) : 'Unknown Product';
                                            $st = !empty($o['status']) ? $o['status'] : 'Pending';
                                            $sc = strtolower($st);
                                    ?>
                                    <li>
                                        <div class="order-item">
                                            <div class="order-title">Order #<?php echo $o['id']; ?> - <?php echo $pn; ?></div>
                                            <small><?php echo $dt; ?></small>
                                        </div>
                                        <div class="order-status <?php echo $sc; ?>"><?php echo $st; ?></div>
                                    </li>
                                    <?php } } else { ?>
                                    <li>No recent orders found.</li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </aside>
                    </section>

                </div>
            </section>
        </main>
    <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
    <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
</body>
</html>
