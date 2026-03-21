<div class="row">
    <div class="col-md-4">
        
        <div class="card card-primary">
            <div class="card-header"><h4><i class="fa fa-grid"></i> Add Category</h4></div>
            <div class="card-body">
                <div id="msg"></div>
                <form method="post" id="category_form" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text category_name"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="category_name" id="category_name" class="form-control category_name" placeholder="Enter Category Name..">
                        </div>
                        <span class="category_name_error text-danger text-small"></span>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text category_description"><i class="fas fa-award award"></i></div>
                            </div>
                            <input type="text" name="category_description" id="category_description" class="form-control category_description" placeholder="Enter Category Description..">
                        </div>
                        <span class="category_description_error text-danger text-small"></span>
                    </div>
                    <input type="hidden" name="created_on" id="created_on" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                    <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION["user_name"]; ?>" />
                    <div class="form-group">
                        <?php if($_SESSION["user_type"] == "Super"){ ?><input type="submit" id="btn_category" class="btn btn-primary w-100" value="Add Category" /><?php } ?>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <?php if(isset($_GET["assign"])){ $category_id = intval($_GET["assign"]); ?>
            <div class="card">
                <div class="card-body">
                    <?php 
                        if(isset($_POST["update"])) {
                            if(!empty($_POST["user_id"])) {
                                $selected_users = array_map('intval', $_POST["user_id"]);$selected_users = array_unique($selected_users);$user_string = implode(",", $selected_users);
                            } else {$user_string = "";}
                            $update = mysqli_query($conn, "UPDATE aalierp_category SET user_id = '$user_string', updated_on = NOW() WHERE category_id = '$category_id'");
                            if(!$update){die("Update Failed: " . mysqli_error($conn));}
                            echo "<script>window.location.href='../add-category';</script>";exit;
                        }
                        $category_query = mysqli_query($conn, "SELECT user_id FROM aalierp_category WHERE category_id = '$category_id'");
                        if(mysqli_num_rows($category_query) == 0){die("Category not found!");}
                        $category = $category_query ? mysqli_fetch_assoc($category_query) : []; $assigned_users = [];
                        if(!empty($category["user_id"])) {$assigned_users = array_map('intval', explode(",", $category["user_id"]));}
                    ?>
                    <form method="POST">
                    <?php $users_query = mysqli_query($conn, "SELECT user_id, user_name FROM aalierp_user WHERE user_type = 'Admin' AND user_status = 'Approved'");
                        while($users_query && $user = mysqli_fetch_assoc($users_query)) { $checked = in_array((int)$user["user_id"], $assigned_users) ? "checked" : "";
                    ?>
                    <input type="checkbox"  name="user_id[]"  value="<?php echo $user["user_id"]; ?>" <?php echo $checked; ?> style="width:15px;height:15px;"> <?php echo htmlspecialchars($user["user_name"]); ?>
                    <?php } ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    
                    </form>
                </div>
            </div>
        <?php } ?>
        <div class="card">
            <div class="card-header"><h4>View Categories</h4></div>
            <div class="card-body">
                <div id="umsg"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="category_view"></tbody>
                    </table>
                </div>
            </div>
        </div>
 
    </div>
</div>








