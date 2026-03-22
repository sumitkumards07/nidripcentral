<?php
// Live Counts for Marketing Boxes (Coupons)
$total_coupons = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_coupon"));
$active = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_coupon WHERE status='Active'"));
$paused = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_coupon WHERE status='Paused'"));
$completed = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_coupon WHERE status='Completed'"));
?>

<div class="marketing-stats" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Campaigns</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_coupons); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Active</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($active); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Paused</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($paused); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Completed</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($completed); ?></div>
    </div>
</div>
