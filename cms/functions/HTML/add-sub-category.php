<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-grid"></i> Add Sub Category</h4></div>
            <div class="card-body">
<?php 
    if(isset($_POST["btn_subcategory"])){
        if($_POST["subcategory_name"]==""){
            echo "<div class='alert alert-warning alert-block text-danger'>Add Sub Category Name</div>";
        }else{
            mysqli_query($conn, "INSERT INTO aalierp_subcategory (subcategory_name,catalogue_id,created_on,created_by) VALUES ('".$_POST["subcategory_name"]."','".$_POST["catalogue_id"]."','".$_POST["created_on"]."','".$_POST["created_by"]."')");
            echo "<script>window.location.href='../add-sub-category/?asc';</script>";
        }
    }
?>
                <form method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text subcategory_name"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="subcategory_name" id="subcategory_name" class="form-control subcategory_name" placeholder="Enter Sub Category Name..">
                        </div>
                        <span class="subcategory_name_error text-danger text-small"></span>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-award award"></i></div>
                            </div>
                            <select name="catalogue_id" class="form-control catalogue_id"></select>
                        </div>
                        <span class="catalogue_id_error text-danger text-small"></span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <input type="submit" name="btn_subcategory" class="btn btn-primary w-100" value="Add Sub Category" />
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4>View Sub Categories</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sub Category Name</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="sub_category_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>








