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
        <title>Add Sub Category | <?php echo $company_name; ?></title>
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
                        <?php include($AaliLINK_IN."/functions/HTML/add-sub-category.php"); ?>
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>




<div class="modal fade" id="update_sub_category" class="update_sub_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
        <div class="modal-content">
            <div class="modal-header text-center"> Update Category </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="update_sub_category_form" onsubmit="return false" autocomplete="off">
                    <input type="hidden" id="update_sub_category_id" name="update_sub_category_id">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="update_sub_category_name" name="update_sub_category_name" autofocus="on">
                        <small class="form-text text-muted update_sub_category_name_error"></small>
                    </div>
                    <input type="hidden" value="<?php echo date("Y-m-d H:i:s"); ?>" id="updated_on" name="updated_on" />
                    <input type="hidden" value="<?php echo $_SESSION["user_name"]; ?>" id="updated_by" name="updated_by" />
                    <div class="row p-3">
                        <div class="col-xs-6 mr-3">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn_update_sub_category" name="btn_update_sub_category"><i class="fa fa-edit"></i> Update Sub Category </button>
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






