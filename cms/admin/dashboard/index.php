<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
    }

    // Live SQL Telemetry Execution
    $count_orders = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as cc FROM aalierp_cart"));
    $total_orders = $count_orders['cc'];

    $count_pending = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as cc FROM aalierp_cart WHERE status = 'Pending'"));
    $pending_orders = $count_pending['cc'];

    $count_cust = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as cc FROM aalierp_user"));
    $total_customers = $count_cust['cc'];

    $count_ref = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as cc FROM aalierp_cart WHERE status = 'Refunded'"));
    $refunds = $count_ref['cc'];

    $recent_query = mysqli_query($conn, "SELECT c.id, c.date, c.status, p.product_name FROM aalierp_cart c JOIN aalierp_product p ON c.p_id = p.product_id ORDER BY c.id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Dashboard | <?php echo $company_name; ?></title>
        <!-- Isolated Custom Dashboard CSS -->
        <?php include($AaliLINK_IN."/functions/HTML/dashboard-css.php"); ?>
    </head>
    
    <body>
        <input type="checkbox" id="sidebar-toggle" hidden>
        <label for="sidebar-toggle" class="overlay"></label>

        <div class="app">
            <!-- Isolated SVG Sidebar & Header -->
            <?php include($AaliLINK_IN."/functions/HTML/dashboard-nav.php"); ?>
            
            <main class="main">
                <section class="page active" id="dashboardPage">
                    <div class="dashboard-card" style="padding: 24px; background: transparent; box-shadow: none;">
                        
                        <!-- Stat Cards -->
                        <section class="cards">
                          <div class="card stat">
                            <div class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="5" rx="2" />
                                <line x1="2" x2="22" y1="10" y2="10" />
                              </svg>
                            </div>
                            <div class="meta">
                              <div class="label">Total Orders</div>
                              <div class="value"><?php echo number_format($total_orders); ?></div>
                              <div class="small">Live aggregate count</div>
                            </div>
                          </div>

                          <div class="card stat">
                            <div class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m7.5 4.27 9 5.15" />
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                <path d="m3.3 7 8.7 5 8.7-5" />
                                <path d="M12 22V12" />
                              </svg>
                            </div>
                            <div class="meta">
                              <div class="label">Pending Orders</div>
                              <div class="value"><?php echo number_format($pending_orders); ?></div>
                              <div class="small">Awaiting shipment</div>
                            </div>
                          </div>

                          <div class="card stat">
                            <div class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                              </svg>
                            </div>
                            <div class="meta">
                              <div class="label">Total Customers</div>
                              <div class="value"><?php echo number_format($total_customers); ?></div>
                              <div class="small">Registered accounts</div>
                            </div>
                          </div>

                          <div class="card stat">
                            <div class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" x2="12" y1="2" y2="22" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                              </svg>
                            </div>
                            <div class="meta">
                              <div class="label">Return / Refund Requests</div>
                              <div class="value"><?php echo number_format($refunds); ?></div>
                              <div class="small">Awaiting processor</div>
                            </div>
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
                                  <img src="<?php echo $AaliLINK; ?>/assets/img/rocket-hero.png" alt="Rocket illustration">
                                </div>
                              </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="card activity-card">
                              <h3>Recent Notifications</h3>
                              <ul class="activity">
                                <li>System layout successfully updated <span><?php echo date('d M g:i A'); ?></span></li>
                                <li>All internal databases synced to front-end metrics <span><?php echo date('d M g:i A'); ?></span></li>
                              </ul>
                            </div>
                          </div>

                          <!-- Orders Overview -->
                          <aside class="right">
                            <div class="card orders">
                              <h3>Orders Overview</h3>
                              <ul>
                                <?php 
                                if(mysqli_num_rows($recent_query) > 0){
                                    while($row = mysqli_fetch_assoc($recent_query)){
                                        $d_date = date("d M g:i A", strtotime($row['date']));
                                        $p_name = substr($row['product_name'], 0, 25)."...";
                                        $status = empty($row['status']) ? 'Processing' : $row['status'];
                                        $s_class = strtolower($status);
                                        echo "
                                        <li>
                                          <div class='order-item'>
                                            <div class='order-title'>Order #{$row['id']} - {$p_name}</div>
                                            <small>{$d_date}</small>
                                          </div>
                                          <div class='order-status {$s_class}'>{$status}</div>
                                        </li>
                                        ";
                                    }
                                } else {
                                    echo "<li>No recent orders.</li>";
                                }
                                ?>
                              </ul>
                            </div>
                          </aside>
                        </section>

                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
