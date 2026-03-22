<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-award"></i> Add Catalogue</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="catalogue_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text catalogue_name"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="catalogue_name" id="catalogue_name" class="form-control catalogue_name" placeholder="Enter CatalogueName..">
                        </div>
                        <span class="catalogue_name_error text-danger text-small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-file catalogue_image">
                            <input type="file" class="custom-file-input " name="catalogue_image" id="customFile">
                            <label class="custom-file-label catalogue_image" for="customFile">Choose image (100 x 100)</label>
                        </div>
                        <span class="catalogue_image_error text-danger text-small"></span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <input type="submit" id="btn_catalogue" class="btn btn-primary w-100" value="Add Catalogue" />
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>View Catalogues</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>Catalogue Name</th>
                                <th>Catalogue Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="catalogue_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>








