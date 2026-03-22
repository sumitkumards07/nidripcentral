<?php
// Live Counts for Product Boxes
$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT product_id FROM aalierp_product"));
$active = mysqli_num_rows(mysqli_query($conn, "SELECT product_id FROM aalierp_product WHERE status='Active'"));
$inactive = mysqli_num_rows(mysqli_query($conn, "SELECT product_id FROM aalierp_product WHERE status='Inactive'"));
?>

<div class="product-stats" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:25px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:14px; font-weight:500;">Total Products</div>
        <div style="font-size:32px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_products); ?></div>
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
