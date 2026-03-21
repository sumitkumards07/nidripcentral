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
        <title>Deposits | <?php echo $company_name; ?></title>
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
                     
                        <div class="section-body">
                            <div class="row">
                                
            	                <div class="col-md-12">
            		                <div class="card">
                                        <div class="card-header">
                                            <h5 class="widget-user-username">Deposit Slip <a href="<?php echo $AaliLINK; ?>/admin/deposit/?deposit" class="btn btn-info btn-sm text-white">Back to deposit</a></h5>
                                        </div>
                                        <div class="card-body p-3">
                                            
<?php if(isset($_GET["slip"])){
	$depquer = mysqli_query($conn,"SELECT dep_slip FROM aalierp_deposit WHERE dep_id='".$_GET["slip"]."'");
	$rec = mysqli_fetch_array($depquer); ?>
		                                    <img src="../../<?php echo $rec["dep_slip"]; ?>" class="img-fluid w-100" />
<?php } ?>
        							            
        							    </div>
        						    </div>
        						</div>
                            </div>
                        </div>
                        
                        
  
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>


    
    
    
    
    
    
    