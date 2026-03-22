<?php
// Live Counts for Customer Boxes
$total_result = mysqli_query($conn, "SELECT user_id FROM aalierp_user");
$active_result = mysqli_query($conn, "SELECT user_id FROM aalierp_user WHERE user_status='Approved'");
$inactive_result = mysqli_query($conn, "SELECT user_id FROM aalierp_user WHERE user_status IS NULL OR user_status!='Approved'");

$total_customers = $total_result ? mysqli_num_rows($total_result) : 0;
$active = $active_result ? mysqli_num_rows($active_result) : 0;
$inactive = $inactive_result ? mysqli_num_rows($inactive_result) : 0;
?>

<div class="user-stats" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Customers</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_customers); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Active</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($active); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Inactive</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($inactive); ?></div>
    </div>
</div>
