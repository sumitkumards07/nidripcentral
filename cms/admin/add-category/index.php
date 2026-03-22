<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){ header("location:".DOMAIN.""); exit; }
    $categories = mysqli_query($conn, "SELECT * FROM aalierp_category ORDER BY category_id DESC");
    $subcats = mysqli_query($conn, "SELECT s.*, c.category_name FROM aalierp_sub_category s LEFT JOIN aalierp_category c ON s.category_id=c.category_id ORDER BY s.sub_category_id DESC");
    $units = mysqli_query($conn, "SELECT * FROM aalierp_unit ORDER BY unit_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .tab-nav{display:flex;gap:8px;margin-bottom:24px}
    .tab-nav .tn{padding:10px 22px;border-radius:30px;font-size:13px;font-weight:600;cursor:pointer;border:1.5px solid #e8e8e8;background:#fff;color:#666;transition:all .2s}
    .tab-nav .tn.active{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border-color:transparent}
    .tab-panel{display:none}.tab-panel.active{display:block}
    .add-form{background:#fff;border-radius:20px;padding:24px;margin-bottom:24px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .form-row{display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:end}
    .form-group{display:flex;flex-direction:column;gap:6px}
    .form-group label{font-size:13px;font-weight:600;color:#555}
    .form-group input,.form-group select{padding:10px 14px;border:1.5px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:inherit;outline:none;background:#fafafa}
    .form-group input:focus,.form-group select:focus{border-color:#fd215e;background:#fff}
    .btn-add{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border:none;padding:12px 28px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer}
    .data-card{background:#fff;border-radius:20px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .tbl{width:100%;border-collapse:collapse;font-size:14px}
    .tbl th{padding:14px 16px;text-align:left;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;border-bottom:2px solid #f0f0f0}
    .tbl td{padding:14px 16px;border-bottom:1px solid #f8f8f8;color:#333}
    .tbl tbody tr:hover{background:#fafafa}
    .btn-del{padding:6px 12px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;background:#fff0f0;color:#ff4d4d}
    .btn-del:hover{background:#ff4d4d;color:#fff}
    @media(max-width:768px){.form-row{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Category Management</h1>
                    <p class="page-sub">Manage categories, sub-categories, and units</p>
                </div>

                <div class="tab-nav">
                    <span class="tn active" onclick="showTab('categories',this)">Categories</span>
                    <span class="tn" onclick="showTab('subcategories',this)">Sub-Categories</span>
                    <span class="tn" onclick="showTab('units',this)">Units</span>
                </div>

                <!-- CATEGORIES -->
                <div id="categories" class="tab-panel active">
                    <div class="add-form">
                        <div class="form-row">
                            <div class="form-group"><label>Category Name</label><input type="text" id="cat_name" placeholder="Enter category name"></div>
                            <div class="form-group"><label>Description</label><input type="text" id="cat_desc" placeholder="Optional description"></div>
                            <button class="btn-add" onclick="addCategory()">Add</button>
                        </div>
                    </div>
                    <div class="data-card">
                        <table class="tbl"><thead><tr><th>#</th><th>Category</th><th>Description</th><th></th></tr></thead><tbody>
                        <?php $n=1; if($categories) while($row=mysqli_fetch_array($categories)){ ?>
                        <tr><td><?php echo $n++;?></td><td><strong><?php echo $row['category_name'];?></strong></td><td style="color:#888"><?php echo $row['category_description'] ?: '—';?></td><td><button class="btn-del">Delete</button></td></tr>
                        <?php } ?>
                        </tbody></table>
                    </div>
                </div>

                <!-- SUB-CATEGORIES -->
                <div id="subcategories" class="tab-panel">
                    <div class="add-form">
                        <div class="form-row">
                            <div class="form-group"><label>Sub-Category Name</label><input type="text" id="subcat_name" placeholder="Enter sub-category"></div>
                            <div class="form-group"><label>Parent Category</label>
                                <select id="subcat_parent">
                                    <?php mysqli_data_seek($categories,0); if($categories) while($c=mysqli_fetch_array($categories)){ ?>
                                    <option value="<?php echo $c['category_id'];?>"><?php echo $c['category_name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn-add" onclick="addSubCategory()">Add</button>
                        </div>
                    </div>
                    <div class="data-card">
                        <table class="tbl"><thead><tr><th>#</th><th>Sub-Category</th><th>Parent Category</th><th></th></tr></thead><tbody>
                        <?php $n=1; if($subcats) while($row=mysqli_fetch_array($subcats)){ ?>
                        <tr><td><?php echo $n++;?></td><td><strong><?php echo $row['sub_category_name'];?></strong></td><td style="color:#888"><?php echo $row['category_name'] ?: '—';?></td><td><button class="btn-del">Delete</button></td></tr>
                        <?php } ?>
                        </tbody></table>
                    </div>
                </div>

                <!-- UNITS -->
                <div id="units" class="tab-panel">
                    <div class="add-form">
                        <div class="form-row">
                            <div class="form-group"><label>Unit Name</label><input type="text" id="unit_name" placeholder="e.g. Kg, Ltr, Pcs"></div>
                            <button class="btn-add" onclick="addUnit()">Add</button>
                        </div>
                    </div>
                    <div class="data-card">
                        <table class="tbl"><thead><tr><th>#</th><th>Unit Name</th><th></th></tr></thead><tbody>
                        <?php $n=1; if($units) while($row=mysqli_fetch_array($units)){ ?>
                        <tr><td><?php echo $n++;?></td><td><strong><?php echo $row['unit_name'];?></strong></td><td><button class="btn-del">Delete</button></td></tr>
                        <?php } ?>
                        </tbody></table>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>
<?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
<?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
<script>
function showTab(id, el){
    document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
    document.querySelectorAll('.tn').forEach(t=>t.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    el.classList.add('active');
}
</script>
</body>
</html>
