<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
        exit;
    }
    $products = mysqli_query($conn, "SELECT p.*, c.category_name, u.unit_name FROM aalierp_product p LEFT JOIN aalierp_category c ON p.category_id=c.category_id LEFT JOIN aalierp_unit u ON p.unit_id=u.unit_id ORDER BY p.product_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px}
    .btn-add{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border:none;padding:12px 28px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;transition:opacity .2s}
    .btn-add:hover{opacity:.88}
    .search-box{padding:10px 18px;border:1.5px solid #e8e8e8;border-radius:12px;font-size:14px;outline:none;width:280px;background:#fafafa;font-family:inherit}
    .search-box:focus{border-color:#fd215e;background:#fff}
    .data-card{background:#fff;border-radius:20px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .tbl{width:100%;border-collapse:collapse;font-size:14px}
    .tbl th{padding:14px 16px;text-align:left;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid #f0f0f0}
    .tbl td{padding:14px 16px;border-bottom:1px solid #f8f8f8;color:#333;vertical-align:middle}
    .tbl tbody tr:hover{background:#fafafa}
    .badge{display:inline-block;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600}
    .bg-active{background:#e8faf0;color:#2dbb6a}.bg-inactive{background:#fff0f0;color:#ff4d4d}
    .prod-img{width:44px;height:44px;border-radius:10px;object-fit:cover;background:#f5f5f5}
    .actions{display:flex;gap:6px}
    .actions button{padding:7px 12px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s}
    .btn-edit{background:#f0f0f0;color:#333}.btn-edit:hover{background:#fd215e;color:#fff}
    .btn-del{background:#fff0f0;color:#ff4d4d}.btn-del:hover{background:#ff4d4d;color:#fff}
    @media(max-width:768px){.top-bar{flex-direction:column;align-items:stretch}.search-box{width:100%}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Product Management</h1>
                    <p class="page-sub">Manage your product catalog</p>
                </div>

                <div class="top-bar">
                    <input type="text" class="search-box" placeholder="Search products..." id="searchProd" onkeyup="filterTable()">
                    <a href="<?php echo $AaliLINK;?>/admin/add-product/?ap" class="btn-add">+ Add Product</a>
                </div>

                <div class="data-card">
                    <div style="overflow-x:auto">
                        <table class="tbl" id="prodTable">
                            <thead><tr><th>#</th><th>Image</th><th>Product</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php $n=1; if($products) while($row = mysqli_fetch_array($products)){
                                $st = $row['product_status'] ?: 'Active';
                                $cls = strtolower($st)==='active' ? 'bg-active' : 'bg-inactive';
                            ?>
                            <tr>
                                <td><?php echo $n++;?></td>
                                <td><img class="prod-img" src="<?php echo $AaliLINK;?>/uploads/products/<?php echo $row['product_image'];?>" alt=""></td>
                                <td><strong><?php echo $row['product_name'];?></strong></td>
                                <td style="color:#888"><?php echo $row['category_name'] ?: '—';?></td>
                                <td style="font-weight:700;color:#fd215e"><?php echo $cur.number_format($row['product_price']);?></td>
                                <td><span class="badge <?php echo $cls;?>"><?php echo $st;?></span></td>
                                <td>
                                    <div class="actions">
                                        <button class="btn-edit" onclick="editProduct(<?php echo $row['product_id'];?>)">Edit</button>
                                        <button class="btn-del" onclick="deleteProduct(<?php echo $row['product_id'];?>)">Delete</button>
                                    </div>
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
function filterTable(){
    let q = document.getElementById('searchProd').value.toLowerCase();
    document.querySelectorAll('#prodTable tbody tr').forEach(r=>{
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
