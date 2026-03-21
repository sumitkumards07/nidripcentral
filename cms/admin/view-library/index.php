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
        <title>View Librarys | <?php echo $company_name; ?></title>
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
                        <?php include($AaliLINK_IN."/functions/HTML/view-library.php"); ?>
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
    </body>
</html>


<div class="modal fade bd-example-modal-lg" id="update_library" class="update_library" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        
        <div class="modal-content">
            <div class="modal-header text-center"> Update Post </div>
            <div class="modal-body">
                <div id="msg"></div>
                <form method="post" id="library_form" class="library_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend library_name">
                                        <div class="input-group-text"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                    <input type="text" name="library_name" id="library_name" class="form-control library_name" placeholder="Enter Library Name.." />
                                </div>
                                <small class="form-text text-muted library_name_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend category_id">
                                        <div class="input-group-text"><i class="fas fa-bars"></i></div>
                                    </div>
                                    <select class="form-control select2 library_category category_id" name="category_id" id="category_id"></select>
                                </div>
                                <small class="form-text text-muted category_id_error"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-file library_image">
                                    <input type="file" class="custom-file-input" name="library_image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose image <span class="text-danger">*</span></label>
                                </div>
                                <small class="form-text text-muted library_image_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend library_keywords">
                                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                                    </div>
                                    <input type="text" name="library_keywords" id="library_keywords" class="form-control library_keywords" placeholder="Library keywords..">
                                </div>
                                <small class="form-text text-muted library_keywords_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="library_desc" id="library_desc" class="summernote-simple" placeholder="Enter Library detail.."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <input type="hidden" name="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                            <input type="hidden" name="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                            <input type="submit" id="btn_library" class="btn btn-primary w-100" value="Add Library" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

















