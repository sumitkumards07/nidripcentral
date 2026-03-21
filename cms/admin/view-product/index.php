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
        <title>View Products | <?php echo $company_name; ?></title>
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
                        <?php include($AaliLINK_IN."/functions/HTML/view-products.php"); ?>
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>


<div class="modal fade bd-example-modal-lg" id="update_product" class="update_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        
        <div class="modal-content">
            <div class="modal-header text-center"> Update Product </div>
            <div class="modal-body"> 
                <div id="msg"></div>
                   <form method="post" id="update_product_form" class="update_product_form" enctype="multipart/form-data" onsubmit="return false">
                      <input type="hidden" id="update_product_id" name="update_product_id">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend update_product_name">
                                        <div class="input-group-text"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                    <input type="text" name="update_product_name" id="update_product_name" class="form-control update_product_name" >
                                </div>
                                <small class="text-danger text-small update_product_name_error"></small>
                            </div>
                            <div class="form-group w-100">
                                <div class="input-group">
                                    <select class="form-control select2 update_catalogue_id " name="update_catalogue_id" id="update_catalogue_id"></select>
                                </div>
                                <small class="text-danger text-small update_catalogue_id_error"></small>
                            </div>
                            <div class="form-group w-100">
                                <div class="input-group">
                                    <select class="form-control select2 product_unit update_unit_id" name="update_unit_id" id="update_unit_id"></select>
                                </div>
                                <small class="text-danger text-small unit_id_error"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend update_product_price">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="text" name="update_product_price" id="update_product_price" class="form-control update_product_price" >
                                </div>
                                <small class="text-danger text-small product_price_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend update_product_old_price">
                                        <div class="input-group-text"><i class="fas fa-hand-scissors"></i></div>
                                    </div>
                                    <input type="text" name="update_product_old_price" id="update_product_old_price" class="form-control product_old_price" >
                                </div>
                                <small class="text-danger text-small update_product_old_price_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend update_product_discount">
                                        <div class="input-group-text"><i class="fas fa-hand-holding-usd"></i></div>
                                    </div>
                                    <input type="text" name="update_product_discount" id="update_product_discount" class="form-control product_discount" >
                                </div>
                                <small class="text-danger text-small update_product_discount_error"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file update_product_image">
                                    <input type="file" class="custom-file-input product_image" name="update_product_image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose image (500 x 500) <span class="text-danger">*</span></label>
                                </div>
                                <small class="text-danger text-small product_image_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control select2 update_product_type" name="update_product_type" id="update_product_type">
                                      <option value="0">Select Product Type</option>
                                      <option value="Tangible">Tangible</option>
                                      <option value="Intangible">Intangible</option>
                                    </select>
                                </div>
                                <small class="text-danger text-small update_product_type_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_keywords">
                                        <div class="input-group-text"><i class="fas fa-info"></i></div>
                                    </div>
                                    <input type="text" name="update_product_keywords" id="update_product_keywords" class="form-control product_keywords" >
                                </div>
                                <small class="text-danger text-small update_product_keywords_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend update_product_download">
                                        <div class="input-group-text"><i class="fas fa-download"></i></div>
                                    </div>
                                    <input type="text" name="update_product_download" id="update_product_download" class="form-control product_download" >
                                </div>
                                <small class="text-danger text-small update_product_download_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="update_product_desc" id="update_product_desc" class="summernote-simple"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <input type="submit" id="btn_update_product" class="btn btn-primary w-100" value="Update Product" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

















