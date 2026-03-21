<?php if(isset($_GET["assign"])) { $product_id = intval($_GET["assign"]); ?>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php 
                                if(isset($_POST["update"])) {  
                                    if(!empty($_POST["user_id"])) {
                                        $selected_users = array_map('intval', $_POST["user_id"]); $selected_users = array_unique($selected_users); $user_string = implode(",", $selected_users);
                                    } else {$user_string = "";}
                                    $update = mysqli_query($conn, "UPDATE aalierp_product SET user_id = '$user_string', updated_on = NOW() WHERE product_id = '$product_id'");
                                    if(!$update){die("Update Failed: " . mysqli_error($conn));}
                                    echo "<script>window.location.href='../view-product';</script>"; exit;
                                }
                                $product_query = mysqli_query($conn, "SELECT user_id FROM aalierp_product WHERE product_id = '$product_id'");
                                if(mysqli_num_rows($product_query) == 0){die("Product not found!");}
                                $product = $product_query ? mysqli_fetch_assoc($product_query) : []; $assigned_users = [];
                                if(!empty($product["user_id"])) {$assigned_users = array_map('intval', explode(",", $product["user_id"]));}
                            ?>
                            <form method="POST">
                                <?php $users_query = mysqli_query($conn, "SELECT user_id, user_name FROM aalierp_user WHERE user_type = 'admin' AND user_status = 'Approved'");
                                    while($users_query && ($user = mysqli_fetch_assoc($users_query))) {$checked = in_array((int)$user["user_id"], $assigned_users) ? "checked" : "";
                                ?>
                                <input type="checkbox" name="user_id[]" value="<?php echo $user["user_id"]; ?>" <?php echo $checked; ?> style="width:15px;height:15px;"> 
                                <?php echo htmlspecialchars($user["user_name"]); ?>
                                <?php } ?>
                                <button type="submit" name="update" class="btn btn-primary">Assign</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
    
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>View Products</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm" id="tableExport" style="width:100%;">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Old Price</th>
                                    <th>Discount (%)</th>
                                    <th>Search Keys</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody id="product_view"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

