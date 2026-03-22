<?php
// Live Counts for Reports Boxes
$total_sales = mysqli_num_rows(mysqli_query($conn, "SELECT sales_id FROM aalierp_sales"));
$total_revenue = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sales_total) as total FROM aalierp_sales"))['total'];
$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT user_id FROM aalierp_user"));
?>

<div class="reports-stats" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Reports</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_sales); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Revenue</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo $cur."".number_format($total_revenue); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Customers</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_users); ?></div>
    </div>
</div>
