<?php
// Live Counts for Order Boxes - Matching Design Specification
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart"));
$processing = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Processing' OR status='Chosen'"));
$delivered = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Processed'"));
$refunded = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Refunded'"));
?>

<div class="orders-stats" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Orders</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_orders); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0;">
        <div style="color:#666; font-size:14px; font-weight:500;">Processing</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($processing); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0;">
        <div style="color:#666; font-size:14px; font-weight:500;">Delivered</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($delivered); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0;">
        <div style="color:#666; font-size:14px; font-weight:500;">Refunded</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($refunded); ?></div>
    </div>
</div>