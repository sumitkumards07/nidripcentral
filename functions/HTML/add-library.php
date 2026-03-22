<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-shopping-cart"></i> Add Library</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="library_form" class="library_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend library_name">
                                        <div class="input-group-text"><i class="fas fa-shopping-cart"></i></div>
                                    </div>
                                    <input type="text" name="library_name" id="library_name" class="form-control library_name" placeholder="Enter Library Name..">
                                </div>
                                <small class="text-danger text-small library_name_error"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-file library_image">
                                    <input type="file" class="custom-file-input" name="library_image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose image <span class="text-danger">*</span></label>
                                </div>
                                <small class="text-danger text-small library_image_error"></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend library_keywords">
                                        <div class="input-group-text"><i class="fas fa-file-text"></i></div>
                                    </div>
                                    <input type="text" name="library_keywords" id="library_keywords" class="form-control library_keywords" placeholder="Library keywords..">
                                </div>
                                <small class="text-danger text-small library_keywords_error"></small>
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
        