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
        <title>Manage Banner | <?php echo $company_name; ?></title>
        <?php include($AaliLINK_IN."/functions/HTML/css.php"); ?>
    </head>
    
    <body>
        <div class="loader"></div>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                <?php include($AaliLINK_IN."/functions/HTML/nav.php"); ?>
                <div class="main-content">
                    <section class="section">
                        <?php include($AaliLINK_IN."/functions/HTML/banner.php"); ?>
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>

<?php 
    if(isset($_GET["ma"])){mysqli_query($conn, "UPDATE aalierp_banner SET banner_status='Active' WHERE banner_id='".$_GET["ma"]."'");echo "<script>window.location.href='../banner/?banner';</script>";}
    if(isset($_GET["mda"])){mysqli_query($conn, "UPDATE aalierp_banner SET banner_status='Deactive' WHERE banner_id='".$_GET["mda"]."'");echo "<script>window.location.href='../banner/?banner';</script>";}

?>