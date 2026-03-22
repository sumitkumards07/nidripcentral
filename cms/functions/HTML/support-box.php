<?php
// Live Counts for Support Boxes
$total_tickets = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_tickets"));
$open = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_tickets WHERE status='Open'"));
$in_progress = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_tickets WHERE status='In Progress'"));
$resolved = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_tickets WHERE status='Resolved'"));
$closed = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_tickets WHERE status='Closed'"));
?>

<div class="support-stats" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 30px;">
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:13px; font-weight:500;">Total Tickets</div>
        <div style="font-size:28px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($total_tickets); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:13px; font-weight:500;">Open</div>
        <div style="font-size:28px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($open); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:13px; font-weight:500;">In Progress</div>
        <div style="font-size:28px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($in_progress); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:13px; font-weight:500;">Resolved</div>
        <div style="font-size:28px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($resolved); ?></div>
    </div>
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,0.03); border:1px solid #f0f0f0; text-align:center;">
        <div style="color:#666; font-size:13px; font-weight:500;">Closed</div>
        <div style="font-size:28px; font-weight:800; color:#1a1a1a; margin-top:8px;"><?php echo number_format($closed); ?></div>
    </div>
</div>
