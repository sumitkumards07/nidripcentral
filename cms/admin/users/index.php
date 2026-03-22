<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
        exit;
    }
    $users = mysqli_query($conn, "SELECT u.*, (SELECT COUNT(*) FROM aalierp_cart c WHERE c.user_id=u.user_id) as order_count FROM aalierp_user u ORDER BY u.user_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px}
    .search-box{padding:10px 18px;border:1.5px solid #e8e8e8;border-radius:12px;font-size:14px;outline:none;width:280px;background:#fafafa;font-family:inherit}
    .search-box:focus{border-color:#fd215e;background:#fff}
    .stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px}
    .scard{background:#fff;padding:20px;border-radius:16px;border:1.5px solid #f0f0f0;text-align:center}
    .scard .val{font-size:26px;font-weight:800;color:#fd215e}
    .scard .lbl{font-size:13px;color:#888;margin-top:4px}
    .data-card{background:#fff;border-radius:20px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .tbl{width:100%;border-collapse:collapse;font-size:14px}
    .tbl th{padding:14px 16px;text-align:left;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid #f0f0f0}
    .tbl td{padding:14px 16px;border-bottom:1px solid #f8f8f8;color:#333;vertical-align:middle}
    .tbl tbody tr:hover{background:#fafafa}
    .badge{display:inline-block;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600}
    .bg-approved{background:#e8faf0;color:#2dbb6a}.bg-pending{background:#fff9e6;color:#f59e0b}.bg-suspended{background:#fff0f0;color:#ff4d4d}
    .usr-avatar{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px}
    .actions button{padding:7px 12px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;margin-right:4px}
    .btn-approve{background:#e8faf0;color:#2dbb6a}.btn-approve:hover{background:#2dbb6a;color:#fff}
    .btn-del{background:#fff0f0;color:#ff4d4d}.btn-del:hover{background:#ff4d4d;color:#fff}
    @media(max-width:768px){.stat-row{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Customer Management</h1>
                    <p class="page-sub">View and manage registered customers</p>
                </div>

                <?php
                    $ct = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_user"); $total = ($ct && $r=mysqli_fetch_assoc($ct))? $r['c']:0;
                    $ca = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_user WHERE user_status='Approved'"); $approved = ($ca && $r=mysqli_fetch_assoc($ca))? $r['c']:0;
                    $cp = mysqli_query($conn,"SELECT COUNT(*) as c FROM aalierp_user WHERE user_status='Pending'"); $pending = ($cp && $r=mysqli_fetch_assoc($cp))? $r['c']:0;
                ?>
                <div class="stat-row">
                    <div class="scard"><div class="val"><?php echo $total;?></div><div class="lbl">Total Users</div></div>
                    <div class="scard"><div class="val"><?php echo $approved;?></div><div class="lbl">Approved</div></div>
                    <div class="scard"><div class="val"><?php echo $pending;?></div><div class="lbl">Pending</div></div>
                </div>

                <div class="top-bar">
                    <input type="text" class="search-box" placeholder="Search customers..." id="searchCust" onkeyup="filterCust()">
                </div>

                <div class="data-card">
                    <div style="overflow-x:auto">
                        <table class="tbl" id="custTable">
                            <thead><tr><th>#</th><th></th><th>Name</th><th>Email</th><th>Mobile</th><th>Orders</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php $n=1; if($users) while($row = mysqli_fetch_array($users)){
                                $name = $row['user_name'] ?: trim($row['user_fname'].' '.$row['user_lname']) ?: $row['user_email'];
                                $st = $row['user_status'] ?: 'Pending';
                                $cls = 'bg-'.strtolower($st);
                                $init = strtoupper(substr($name,0,1));
                            ?>
                            <tr>
                                <td><?php echo $n++;?></td>
                                <td><div class="usr-avatar"><?php echo $init;?></div></td>
                                <td><strong><?php echo $name;?></strong></td>
                                <td style="color:#888"><?php echo $row['user_email'];?></td>
                                <td><?php echo $row['user_mobile'] ?: '—';?></td>
                                <td style="font-weight:700"><?php echo $row['order_count'];?></td>
                                <td><span class="badge <?php echo $cls;?>"><?php echo $st;?></span></td>
                                <td class="actions">
                                    <button class="btn-approve">Approve</button>
                                    <button class="btn-del">Delete</button>
                                </td>
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
function filterCust(){
    let q = document.getElementById('searchCust').value.toLowerCase();
    document.querySelectorAll('#custTable tbody tr').forEach(r=>{
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
