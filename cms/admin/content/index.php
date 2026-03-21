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
        <title>System Contents | <?php echo $company_name; ?></title>
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
                        
                        <div class="row">

                            <div class="col-lg-8">
                                <div class="card card-default">
                                    <div class="card-header"><i class='fa fa-eye'></i> View Web Contents</div>
                                    <div class="card-body">
                                        <div id="dsucc"></div>
                                        <div id="dinfo"></div>
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Fields</th>
                                                    <th>Data</th>
                                                    <th style="text-align: right;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Title: </td>
                                                    <td><?php echo $company_name; ?></td>
                                                    <td style="text-align: right;"><a href="?name=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Logo: </td>
                                                    <td><img src="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>" width="30" height="30" /></td>
                                                    <td style="text-align: right;"><a href="?logo=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Salogan: </td>
                                                    <td><?php echo $company_salogan; ?></td>
                                                    <td style="text-align: right;"><a href="?salogan=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone: </td>
                                                    <td><?php echo $company_phone; ?></td>
                                                    <td style="text-align: right;"><a href="?phone=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile: </td>
                                                    <td><?php echo $company_mobile; ?></td>
                                                    <td style="text-align: right;"><a href="?mobile=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Email: </td>
                                                    <td><?php echo $company_email; ?></td>
                                                    <td style="text-align: right;"><a href="?email=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Website: </td>
                                                    <td><?php echo $company_web; ?></td>
                                                    <td style="text-align: right;"><a href="?web=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Address: </td>
                                                    <td><?php echo $company_address; ?></td>
                                                    <td style="text-align: right;"><a href="?address=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>City: </td>
                                                    <td><?php echo $company_city; ?></td>
                                                    <td style="text-align: right;"><a href="?city=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Country: </td>
                                                    <td><?php echo $company_country; ?></td>
                                                    <td style="text-align: right;"><a href="?country=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Postal Code: </td>
                                                    <td><?php echo $company_pob; ?></td>
                                                    <td style="text-align: right;"><a href="?pob=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Currency: </td>
                                                    <td><?php echo $cur; ?></td>
                                                    <td style="text-align: right;"><a href="?cur=<?php echo $company_id; ?>" class="btn btn-info btn-sm">Update</a></td>
                                                </tr>
                                            </tbody>   
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <?php if(isset($_GET["name"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Name</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_title"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_name='".$_POST["title"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="title" value="<?php echo $company_name; ?>" />
                                                <input type="submit" name="btn_title" class="btn btn-info btn-sm" value="Update Title" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["logo"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Logo</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_logo"])){ 
                                        if($_FILES["logo"]==""){echo "<div class='alert alert-warning alert-block'>Upload Logo</div>";}else{
                                            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
                                    		$reg_image = '../../uploads/logos/';
                                    		$img = $_FILES['logo']['name'];
                                    		$tmp = $_FILES['logo']['tmp_name'];
                                    		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                                    		$final_image = rand(1000,1000000).$img;
                                    		if(in_array($ext, $valid_extensions)){ 
                                    			$reg_image = $reg_image.strtolower($final_image); 
                                    			if(move_uploaded_file($tmp,$reg_image)){
                                                    mysqli_query($conn, "UPDATE aalierp_contents SET company_logo='".$reg_image."' WHERE company_id='".$_POST["id"]."'"); 
                                                    echo "<script>window.location.href = '../content/?content';</script>"; 
                                    			}
                                    		}
                                        }
                                } ?>
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="file" class="form-control mb-2" name="logo" value="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>" />
                                                <input type="submit" name="btn_logo" class="btn btn-info btn-sm" value="Update Logo" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["salogan"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Salogan</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_salogan"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_salogan='".$_POST["salogan"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="salogan" value="<?php echo $company_salogan; ?>" />
                                                <input type="submit" name="btn_salogan" class="btn btn-info btn-sm" value="Update salogan" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["phone"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Phone</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_phone"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_phone='".$_POST["phone"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="phone" value="<?php echo $company_phone; ?>" />
                                                <input type="submit" name="btn_phone" class="btn btn-info btn-sm" value="Update Phone" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["mobile"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Mobile</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_mobile"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_mobile='".$_POST["mobile"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="mobile" value="<?php echo $company_mobile; ?>" />
                                                <input type="submit" name="btn_mobile" class="btn btn-info btn-sm" value="Update Mobile" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["email"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Email</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_email"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_email='".$_POST["email"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="email" value="<?php echo $company_email; ?>" />
                                                <input type="submit" name="btn_email" class="btn btn-info btn-sm" value="Update Email" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["web"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Website</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_web"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_web='".$_POST["web"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="web" value="<?php echo $company_web; ?>" />
                                                <input type="submit" name="btn_web" class="btn btn-info btn-sm" value="Update Website" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["address"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Address</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_address"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_address='".$_POST["address"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="address" value="<?php echo $company_address; ?>" />
                                                <input type="submit" name="btn_address" class="btn btn-info btn-sm" value="Update Address" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["city"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update City</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_city"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_city='".$_POST["city"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="city" value="<?php echo $company_city; ?>" />
                                                <input type="submit" name="btn_city" class="btn btn-info btn-sm" value="Update City" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["country"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Country</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_country"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_country='".$_POST["country"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="country" value="<?php echo $company_country; ?>" />
                                                <input type="submit" name="btn_country" class="btn btn-info btn-sm" value="Update Country" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["pob"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Postal Code</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_pob"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_pob='".$_POST["pob"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="pob" value="<?php echo $company_pob; ?>" />
                                                <input type="submit" name="btn_pob" class="btn btn-info btn-sm" value="Update Postal Code" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <?php if(isset($_GET["cur"])){ ?>
                                    <div class="card card-default">
                                        <div class="card-header"><i class='fa fa-edit'></i> Update Currency</div>
                                        <div class="card-body">
                                <?php if(isset($_POST["btn_cur"])){ 
                                        mysqli_query($conn, "UPDATE aalierp_contents SET company_currency='".$_POST["cur"]."' WHERE company_id='".$_POST["id"]."'"); 
                                        echo "<script>window.location.href = '../content/?content';</script>"; 
                                } ?>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?php echo $company_id; ?>" />
                                                <input type="text" class="form-control mb-2" name="cur" value="<?php echo $cur; ?>" />
                                                <input type="submit" name="btn_cur" class="btn btn-info btn-sm" value="Update Currency" />
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        
                        </div>
                        
                    </section>
                </div>
                <?php include($AaliLINK_IN."/functions/HTML/footer.php"); ?>
            </div>
        </div>
        <?php include($AaliLINK_IN."/functions/HTML/js.php"); ?>
        
    </body>
</html>

