<?php 
    include("../../config/defines.php");
    if(!isset($_SESSION["user_id"])){ header("location:".DOMAIN.""); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | <?php echo $company_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>">
    <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    <style>
    .page-title{font-size:28px;font-weight:800;color:#1a1a1a;margin-bottom:4px}
    .page-sub{color:#666;font-size:15px;margin-bottom:28px}
    .settings-card{background:#fff;border-radius:20px;padding:32px;box-shadow:0 4px 20px rgba(0,0,0,.04);max-width:800px}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .form-group{display:flex;flex-direction:column;gap:6px}
    .form-group label{font-size:13px;font-weight:600;color:#555}
    .form-group input,.form-group textarea{padding:10px 14px;border:1.5px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:inherit;outline:none;background:#fafafa}
    .form-group input:focus,.form-group textarea:focus{border-color:#fd215e;background:#fff}
    .form-group.full{grid-column:1/-1}
    .btn-save{background:linear-gradient(135deg,#fd215e,#fd229b);color:#fff;border:none;padding:14px 40px;border-radius:12px;font-size:15px;font-weight:600;cursor:pointer;margin-top:24px;transition:opacity .2s}
    .btn-save:hover{opacity:.88}
    .logo-preview{width:80px;height:80px;border-radius:16px;object-fit:cover;border:2px solid #f0f0f0;margin-bottom:12px}
    @media(max-width:768px){.form-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
        
        <div class="main-content">
            <section class="section">
                <div style="margin-bottom:8px">
                    <h1 class="page-title">Company Settings</h1>
                    <p class="page-sub">Manage your company information</p>
                </div>

                <div class="settings-card">
                    <img src="<?php echo $AaliLINK;?>/uploads/logos/<?php echo $company_logo;?>" alt="Logo" class="logo-preview">
                    <form method="post" enctype="multipart/form-data" onsubmit="return false" id="settingsForm">
                        <div class="form-grid">
                            <div class="form-group"><label>Company Name</label><input type="text" name="company_name" value="<?php echo $company_name;?>"></div>
                            <div class="form-group"><label>Slogan</label><input type="text" name="company_salogan" value="<?php echo $company_salogan;?>"></div>
                            <div class="form-group"><label>Email</label><input type="email" name="company_email" value="<?php echo $company_email;?>"></div>
                            <div class="form-group"><label>Mobile</label><input type="text" name="company_mobile" value="<?php echo $company_mobile;?>"></div>
                            <div class="form-group"><label>Phone</label><input type="text" name="company_phone" value="<?php echo $company_phone;?>"></div>
                            <div class="form-group"><label>Website</label><input type="text" name="company_web" value="<?php echo $company_web;?>"></div>
                            <div class="form-group"><label>City</label><input type="text" name="company_city" value="<?php echo $company_city;?>"></div>
                            <div class="form-group"><label>Country</label><input type="text" name="company_country" value="<?php echo $company_country;?>"></div>
                            <div class="form-group"><label>Currency Symbol</label><input type="text" name="company_currency" value="<?php echo $cur;?>"></div>
                            <div class="form-group"><label>Company Logo</label><input type="file" name="company_logo" accept="image/*"></div>
                            <div class="form-group full"><label>Address</label><textarea name="company_address" rows="3"><?php echo $company_address;?></textarea></div>
                        </div>
                        <button type="submit" class="btn-save" id="btn_save_settings">Save Settings</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
<?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
</body>
</html>
