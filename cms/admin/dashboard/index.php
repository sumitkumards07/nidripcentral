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
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
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
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
            
            <div class="main-content">
                <section class="section">
                    <div style="margin-bottom: 40px;">
                        <h1 style="font-size: 32px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px;">Dashboard Overview</h1>
                        <p style="color: #666; font-size: 16px;">Welcome back to your business performance dashboard</p>
                    </div>

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
