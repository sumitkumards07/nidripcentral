<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .order-tabs{display:flex;gap:8px;margin-bottom:24px;flex-wrap:wrap}
    .order-tabs .tab{padding:10px 22px;border-radius:30px;font-size:13px;font-weight:600;cursor:pointer;border:1.5px solid #e8e8e8;background:#fff;color:#666;transition:all .2s}
    .order-tabs .tab.active,.order-tabs .tab:hover{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border-color:transparent}
    .order-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
    .ocard{background:#fff;padding:20px;border-radius:16px;border:1.5px solid #f0f0f0;text-align:center}
    .ocard .val{font-size:26px;font-weight:800;color:#fd215e}
    .ocard .lbl{font-size:13px;color:#888;margin-top:4px}
    .data-card{background:#fff;border-radius:20px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .tbl{width:100%;border-collapse:collapse;font-size:14px}
    .tbl th{padding:14px 18px;text-align:left;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid #f0f0f0}
    .tbl td{padding:16px 18px;border-bottom:1px solid #f8f8f8;color:#333;vertical-align:middle}
    .tbl tbody tr:hover{background:#fafafa}
    .badge{display:inline-block;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600}
    .bg-chosen{background:#fff9e6;color:#f59e0b}.bg-processing{background:#fff2ed;color:#ff7a3d}.bg-processed{background:#e8faf0;color:#2dbb6a}
    .bg-cancelled{background:#fff0f0;color:#ff4d4d}.bg-delivered{background:#e8f4ff;color:#5aa8ff}.bg-pending{background:#f5f0ff;color:#7c3aed}
    .btn-action{padding:6px 14px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
    .btn-view{background:#f0f0f0;color:#333}.btn-view:hover{background:#fd215e;color:#fff}
    @media(max-width:900px){.order-cards{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:600px){.order-cards{grid-template-columns:1fr}.tbl{font-size:12px}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Order Management</h1>
                    <p class="page-sub">Track and manage all customer orders</p>
                </div>

                <?php
                    $c1 = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_cart"); $cnt_all = ($c1 && $r=mysqli_fetch_assoc($c1))? $r['c']:0;
                    $c2 = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Chosen'"); $cnt_cart = ($c2 && $r=mysqli_fetch_assoc($c2))? $r['c']:0;
                    $c3 = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Processing'"); $cnt_proc = ($c3 && $r=mysqli_fetch_assoc($c3))? $r['c']:0;
                    $c4 = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_cart WHERE status='Processed'"); $cnt_done = ($c4 && $r=mysqli_fetch_assoc($c4))? $r['c']:0;
                ?>

                <div class="order-cards">
                    <div class="ocard"><div class="val"><?php echo $cnt_all;?></div><div class="lbl">Total Orders</div></div>
                    <div class="ocard"><div class="val"><?php echo $cnt_cart;?></div><div class="lbl">In Cart</div></div>
                    <div class="ocard"><div class="val"><?php echo $cnt_proc;?></div><div class="lbl">Processing</div></div>
                    <div class="ocard"><div class="val"><?php echo $cnt_done;?></div><div class="lbl">Completed</div></div>
                </div>

                <div class="order-tabs">
                    <span class="tab active" onclick="loadOrders('all')">All</span>
                    <span class="tab" onclick="loadOrders('Chosen')">Cart</span>
                    <span class="tab" onclick="loadOrders('Processing')">Processing</span>
                    <span class="tab" onclick="loadOrders('Processed')">Completed</span>
                    <span class="tab" onclick="loadOrders('Cancelled')">Cancelled</span>
                </div>

                <div class="data-card">
                    <div style="overflow-x:auto">
                        <table class="tbl">
                            <thead><tr><th>Order</th><th>Date</th><th>Product</th><th>Price</th><th>Customer</th><th>Status</th><th></th></tr></thead>
                            <tbody id="orderBody">
                            <?php 
                            $orders = mysqli_query($conn, "SELECT p.product_name,p.product_image,p.product_price,c.id,c.date,c.qty,c.status,u.user_name FROM aalierp_product p, aalierp_cart c, aalierp_user u WHERE p.product_id=c.p_id AND c.user_id=u.user_id ORDER BY c.id DESC");
                            if($orders) while($row = mysqli_fetch_array($orders)){
                                $st = $row['status'] ?: 'Pending';
                                $cls = 'bg-'.strtolower($st);
                            ?>
                            <tr>
                                <td><strong>#<?php echo 1832000+$row['id'];?></strong></td>
                                <td style="color:#888"><?php echo date('d M, Y',strtotime($row['date']));?></td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <img src="<?php echo $AaliLINK;?>/uploads/products/<?php echo $row['product_image'];?>" style="width:36px;height:36px;border-radius:8px;object-fit:cover;background:#f5f5f5">
                                        <span style="font-weight:600"><?php echo substr($row['product_name'],0,30);?></span>
                                    </div>
                                </td>
                                <td style="font-weight:700;color:#fd215e"><?php echo $cur."".number_format($row['product_price']);?></td>
                                <td><?php echo $row['user_name'];?></td>
                                <td><span class="badge <?php echo $cls;?>"><?php echo $st;?></span></td>
                                <td><button class="btn-action btn-view" onclick="viewOrder(<?php echo $row['id'];?>)">View</button></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>
<?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
<?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
<script>
function loadOrders(status){
    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    event.target.classList.add('active');
}
</script>
</body>
</html>
