<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-award"></i> Add Brand</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="brand_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text brand_name"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="brand_name" id="brand_name" class="form-control brand_name" placeholder="Enter Brand Name..">
                        </div>
                        <span class="brand_name_error text-danger text-small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-file brand_image">
                            <input type="file" class="custom-file-input " name="brand_image" id="customFile">
                            <label class="custom-file-label brand_image" for="customFile">Choose image (100 x 100)</label>
                        </div>
                        <span class="brand_image_error text-danger text-small"></span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <input type="submit" id="btn_brand" class="btn btn-primary w-100" value="Add Brand" />
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>View Brands</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand Name</th>
                                <th>Brand Logo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="brand_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>








