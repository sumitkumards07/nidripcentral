<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){ header("location:".DOMAIN.""); exit; }
    $brands = mysqli_query($conn, "SELECT * FROM aalierp_brand ORDER BY brand_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px}
    .btn-add{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border:none;padding:12px 28px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;transition:opacity .2s;text-decoration:none;display:inline-block}
    .btn-add:hover{opacity:.88}
    .brand-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px}
    .brand-card{background:#fff;border-radius:16px;border:1.5px solid #f0f0f0;overflow:hidden;transition:box-shadow .2s}
    .brand-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.08)}
    .brand-card img{width:100%;height:140px;object-fit:cover;background:#f9f9f9}
    .brand-card .info{padding:14px;display:flex;justify-content:space-between;align-items:center}
    .brand-card .name{font-weight:700;font-size:14px;color:#1a1a1a}
    .brand-card .actions button{padding:6px 10px;border:none;border-radius:8px;font-size:12px;cursor:pointer;transition:all .2s}
    .btn-del{background:#fff0f0;color:#ff4d4d}.btn-del:hover{background:#ff4d4d;color:#fff}
    .add-form{background:#fff;border-radius:20px;padding:28px;margin-bottom:28px;box-shadow:0 4px 20px rgba(0,0,0,.04)}
    .form-row{display:grid;grid-template-columns:1fr 1fr auto;gap:16px;align-items:end}
    .form-group{display:flex;flex-direction:column;gap:6px}
    .form-group label{font-size:13px;font-weight:600;color:#555}
    .form-group input,.form-group select{padding:10px 14px;border:1.5px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:inherit;outline:none;background:#fafafa}
    .form-group input:focus{border-color:#fd215e;background:#fff}
    @media(max-width:768px){.form-row{grid-template-columns:1fr}.brand-grid{grid-template-columns:repeat(2,1fr)}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Brand Management</h1>
                    <p class="page-sub">Add and manage product brands</p>
                </div>

                <div class="add-form">
                    <form method="post" enctype="multipart/form-data" onsubmit="return false" id="brandForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Brand Name</label>
                                <input type="text" name="brand_name" id="brand_name" placeholder="Enter brand name" required>
                            </div>
                            <div class="form-group">
                                <label>Brand Image</label>
                                <input type="file" name="brand_image" id="brand_image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn-add" id="btn_add_brand">Add Brand</button>
                        </div>
                        <div id="msg" style="margin-top:12px"></div>
                    </form>
                </div>

                <div class="brand-grid">
                    <?php if($brands) while($row = mysqli_fetch_array($brands)){ ?>
                    <div class="brand-card">
                        <img src="<?php echo $AaliLINK;?>/uploads/brands/<?php echo $row['brand_image'];?>" alt="<?php echo $row['brand_name'];?>">
                        <div class="info">
                            <span class="name"><?php echo $row['brand_name'];?></span>
                            <div class="actions">
                                <button class="btn-del" onclick="deleteBrand(<?php echo $row['brand_id'];?>)">×</button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

            </section>
        </div>
    </div>
</div>
<?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
<?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
</body>
</html>
