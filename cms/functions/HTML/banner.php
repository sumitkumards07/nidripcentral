
<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-image"></i> Add Banner</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="banner_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text banner_size"><i class="fas fa-info info"></i></div>
                            </div>
                            <select class="form-control banner_size" name="banner_size" id="banner_size">
                                <option value="0">Select Banner Size</option>
                                <option value="Small">Small (600x300)</option>
                                <option value="Large">Large (770x400)</option>
                            </select>
                        </div>
                        <span class="banner_size_error text-danger text-small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-file banner_image">
                            <input type="file" class="custom-file-input " name="banner_image" id="customFile">
                            <label class="custom-file-label banner_image" for="customFile">Choose image</label>
                        </div>
                        <span class="banner_image_error text-danger text-small">Small: 600x500 | Large: 770x400</span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <input type="submit" id="btn_banner" class="btn btn-primary w-100" value="Add Banner" />
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>View Banners</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Banner Size</th>
                                <th>Brand Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="banner_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>










