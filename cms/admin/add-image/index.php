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
        <title>Add Product Images | <?php echo $company_name; ?></title>
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
                        <?php include($AaliLINK_IN."/functions/HTML/add-image.php"); ?>
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>



<div class="modal fade" id="update_image" class="update_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
        <div class="modal-content">
            <div class="modal-header text-center"> Update Product Image</div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="update_product_image_form" onsubmit="return false" autocomplete="off">
                    <input type="hidden" id="update_image_id" name="update_image_id">
                    <div class="form-group has-feedback">
                        <select class="form-control update_product_id" id="update_product_id" name="update_product_id" autofocus="on"></select>
                        <small class="form-text text-muted update_product_id_error"></small>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="file" class="form-control update_product_image" id="update_product_image" name="update_product_image">
                        <small class="form-text text-muted update_product_image_error"></small>
                    </div>
                    <input type="hidden" value="<?php echo date("Y-m-d H:i:s"); ?>" id="updated_on" name="updated_on" />
                    <input type="hidden" value="<?php echo $_SESSION["user_name"]; ?>" id="updated_by" name="updated_by" />
                    <div class="row p-3">
                        <div class="col-xs-6 mr-3">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_update_image" name="btn_update_image"><i class="fa fa-edit"></i> Update Product Image</button>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>














