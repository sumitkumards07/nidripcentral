<?php 
    include("../../config/defines.php"); 
    if(!isset($_SESSION["user_id"])){
        header("location:".DOMAIN."");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Redirecting.. </title>
        <?php include($AaliLINK_IN."/functions/HTML/login-css.php"); ?>
    </head>
    <body>
        <div class="loader"></div>
        <div id="app">
            <div class="alert alert-primary alert-block text-center"><img src="<?php $AaliLINK; ?>/assets/img/loading.gif" /> Redirecting..</div>
            <?php
				if(isset($_GET["_rdct"])){
					mysqli_query($conn,"INSERT INTO `aalierp_login_detail`(`login_id`, `login_name`, `login_email`, `login_date`, `login_ip`, `login_country`, `login_city`) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["user_name"]."','".$_SESSION["user_email"]."','".$_SESSION["user_login"]."','".$_SESSION["user_ip"]."','".$_SESSION["user_country"]."','".$_SESSION["user_city"]."')");
					echo "<script>window.location.href = '../dashboard/?-';</script>";
				}
			?>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/login-js.php"); ?>
    </body>
</html>

