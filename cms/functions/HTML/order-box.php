<?php
// Live Counts for Order Boxes
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart"));
$completed = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Processed'"));
$cancelled = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Cancelled'"));
$rejected = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aalierp_cart WHERE status='Rejected'"));
?>
<section class="cards" style="margin-bottom: 30px;">
    <div class="card stat">
        <div class="icon" style="background: rgba(255, 43, 138, 0.1); color: #ff2b8a;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
        </div>
        <div class="meta">
            <div class="label">Total Orders</div>
            <div class="value"><?php echo number_format($total_orders); ?></div>
            <div class="small">Lifetime history</div>
        </div>
    </div>
    <div class="card stat">
        <div class="icon" style="background: rgba(110, 226, 142, 0.1); color: #6ee28e;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="meta">
            <div class="label">Completed</div>
            <div class="value"><?php echo number_format($completed); ?></div>
            <div class="small">Successfully delivered</div>
        </div>
    </div>
    <div class="card stat">
        <div class="icon" style="background: rgba(255, 171, 0, 0.1); color: #ffab00;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-1.9"/><path d="m3 3 1.9 1.9"/><path d="M5 12h14"/><path d="m19 21-1.9-1.9"/><path d="m19 3-1.9-1.9"/></svg>
        </div>
        <div class="meta">
            <div class="label">Cancelled</div>
            <div class="value"><?php echo number_format($cancelled); ?></div>
            <div class="small">By user or system</div>
        </div>
    </div>
    <div class="card stat">
        <div class="icon" style="background: rgba(255, 86, 48, 0.1); color: #ff5630;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
        </div>
        <div class="meta">
            <div class="label">Rejected</div>
            <div class="value"><?php echo number_format($rejected); ?></div>
            <div class="small">Payment or stock failure</div>
        </div>
    </div>
</section>