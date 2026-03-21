<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-shopping-cart"></i> Add Product</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="product_form" class="product_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_name">
                                        <div class="input-group-text"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                    <input type="text" name="product_name" id="product_name" class="form-control product_name" placeholder="Enter Product Name..">
                                </div>
                                <small class="text-danger text-small product_name_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_price">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                    </div>
                                    <input type="text" name="product_price" id="product_price" class="form-control product_price" placeholder="Enter Product Price..">
                                </div>
                                <small class="text-danger text-small product_price_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control select2 subcategory_id" name="subcategory_id" id="subcategory_id"></select>
                                </div>
                                <small class="text-danger text-small subcategory_id_error"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control select2 category_id" name="category_id" id="category_id"></select>
                                </div>
                                <small class="text-danger text-small category_id_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_old_price">
                                        <div class="input-group-text"><i class="fas fa-hand-scissors"></i></div>
                                    </div>
                                    <input type="text" name="product_old_price" id="product_old_price" class="form-control product_old_price" placeholder="Enter product old price..">
                                </div>
                                <small class="text-danger text-small product_old_price_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_discount">
                                        <div class="input-group-text"><i class="fas fa-hand-holding-usd"></i></div>
                                    </div>
                                    <input type="text" name="product_discount" id="product_discount" class="form-control product_discount" placeholder="Enter discount if any..">
                                </div>
                                <small class="text-danger text-small product_discount_error"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-file product_image">
                                    <input type="file" class="custom-file-input product_image" name="product_image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose image (500 x 500) <span class="text-danger">*</span></label>
                                </div>
                                <small class="text-danger text-small product_image_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control select2 product_unit unit_id" name="unit_id" id="unit_id"></select>
                                </div>
                                <small class="text-danger text-small unit_id_error"></small>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend product_keywords">
                                        <div class="input-group-text"><i class="fas fa-info"></i></div>
                                    </div>
                                    <input type="text" name="product_keywords" id="product_keywords" class="form-control product_keywords" placeholder="Product keywords..">
                                </div>
                                <small class="text-danger text-small product_keywords_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="product_desc" id="product_desc" class="summernote-simple" placeholder="Enter product detail.."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <?php if($_SESSION["user_type"] == "Super"){ ?><input type="submit" id="btn_product" class="btn btn-primary w-100" value="Add Product" /><?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        