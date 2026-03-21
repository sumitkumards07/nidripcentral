<?php 

include_once("../../config/defines.php");
include_once("User.php");
include_once("DBFunctions.php");
include_once("manage.php");


//User Login Process..
	if(isset($_POST["user_email"]) AND isset($_POST["user_password"])){
		$user = new User();
		$result = $user->userLogin($_POST["user_email"],$_POST["user_password"]);
		echo $result;
		exit();
	}
	

//Add User..
	if(!empty($_POST['reg_email'])){
		$obj = new User();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$reg_image = '../../uploads/users/'; 
		$img = $_FILES['reg_image']['name'];
		$tmp = $_FILES['reg_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$reg_image = $reg_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$reg_image)){

				$insert = $obj->createUserAccount($_POST["reg_fname"],$_POST["reg_lname"],$_POST["reg_username"],$reg_image,$_POST["reg_mobile"],$_POST["reg_email"],$_POST["reg_password"],$_POST["reg_passcode"],$_POST["reg_type"],$_POST["reg_status"]);
				echo $insert;
				exit();
			}
		}else{
			echo "Invalid Format!";
		}
		
	}

	
//Count Users..
	if (isset($_POST["countUsers"])) {
		$query = mysqli_query($conn,"SELECT COUNT(*) AS count_user FROM aalierp_user WHERE user_type='Admin'");
		$row = mysqli_fetch_array($query);
		echo $row["count_user"];
		exit();
	}
	
//View Users
	if(isset($_POST["viewUsers"])){ $n=1;
		$obj = mysqli_query($conn, "SELECT * FROM aalierp_user");
		while($row = mysqli_fetch_array($obj)){ if($row["user_type"] == "Admin"){ ?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><img src="<?php echo $AaliLINK; ?>/uploads/users/<?php echo $row['user_image']; ?>" width="30" height="30" /></td>
				<td><?php echo $row["user_name"]; ?></td>
				<td><?php echo $row["user_username"]; ?></td>
				<td><?php echo $row["user_email"]; ?></td>
				<td><?php echo $row["user_passcode"]; ?></td>
				<td><?php echo $row["user_status"]; ?></td>
				<td class="">
					<div class="text-center">
						<div class="btn-group dropup text-left">
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
							<ul class="dropdown-menu pull-right p-2" role="menu">
								<li><a href="#" uid="<?php echo $row['user_id']; ?>" data-toggle="modal" data-target="#update_user" class="btn btn-default btn-sm update_user"><i class="fa fa-edit"></i> Update User</a></li>
								<li class="divider"></li>
								<li><a href="#" did="<?php echo $row['user_id']; ?>" class="btn btn-default btn-sm delete_user"><i class="fa fa-trash"></i> Delete User</a></li>				
							</ul>
						</div>
					</div>
				</td>
			</tr>
	    <?php $n++; } }
	}





//Add Brand..
	if(!empty($_POST['brand_name'])){
		$obj = new DBFunctions();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$brand_image = '../../uploads/brands/'; 
		$img = $_FILES['brand_image']['name'];
		$tmp = $_FILES['brand_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$brand_image = $brand_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$brand_image)){
			    
				$insert = $obj->addBrand($_POST['brand_name'],$brand_image,$_POST["created_on"],$_POST["created_by"]);
				echo $insert;
				exit();
			}
		}else{
			echo "Invalid Format!";
		}
		
	}
	
//Fetch Brand In Select..
	if(isset($_POST["fetchBrand"])){
		$obj = new DBFunctions();
		$rows = $obj->getAllRecord("aalierp_brand");
		foreach($rows as $row){
			echo "<option value='".$row["brand_id"]."'>".$row["brand_name"]."</option>";
		}
		exit();
	}
	
//Count Brand..
	if (isset($_POST["count_brand"])) {
		$query = mysqli_query($conn,"SELECT COUNT(*) AS count_brand FROM aalierp_brand");
		$row = mysqli_fetch_array($query);
		echo $row["count_brand"];
		exit();
	}
	
//View Brand
	if(isset($_POST["viewBrand"])){ $n=1;
		$obj = mysqli_query($conn, "SELECT * FROM aalierp_brand");
		while($row = mysqli_fetch_array($obj)){ ?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["brand_name"]; ?></td>
				<td><img src="<?php echo $AaliLINK; ?>/uploads/brands/<?php echo $row['brand_image']; ?>" width="30" height="30" /></td>
				<td><?php echo $row["brand_status"]; ?></td>
				<td class="">
					<div class="text-center">
						<div class="btn-group dropup text-left">
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
							<ul class="dropdown-menu pull-right p-2" role="menu">
								<li><a href="#" uid="<?php echo $row['brand_id']; ?>" data-toggle="modal" data-target="#update_brand" class="btn btn-default btn-sm update_brand"><i class="fa fa-edit"></i> Update Brand</a></li>
								<li class="divider"></li>
								<li><a href="#" did="<?php echo $row['brand_id']; ?>" class="btn btn-default btn-sm delete_brand"><i class="fa fa-trash"></i> Delete Brand</a></li>				
							</ul>
						</div>
					</div>
				</td>
			</tr>
	    <?php $n++; } 
	}
		
//Show Brand Data To Update..
	if(isset($_POST["updateBrand"])){
		$m = new Manage();
		$result = $m->getSingleRecord("aalierp_brand","brand_id",$_POST["id"]);
		echo json_encode($result);
		exit();
	}
	
//Update Brand..
	if(!empty($_POST['update_brand_name'])){
		$obj = new Manage();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$brand_image = '../../uploads/brands/';
		$img = $_FILES['update_brand_image']['name'];
		$tmp = $_FILES['update_brand_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$brand_image = $brand_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$brand_image)){

				$result = $obj->update_record("aalierp_brand",["brand_id"=>$_POST["update_brand_id"]],["brand_name"=>$_POST['update_brand_name'],"brand_image"=>$brand_image,"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
				echo $result;
				exit();
			}
		}else{
			echo "Invalid File Format!";
		}
	}
	if(!empty($_POST['update_brand_name'])){
		$obj = new Manage();
		$result = $obj->update_record("aalierp_brand",["brand_id"=>$_POST["update_brand_id"]],["brand_name"=>$_POST['update_brand_name'],"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
		echo $result;
		exit();
	}
	
//Delete Brand..
	if(isset($_POST["deleteBrand"])){
		$m = new Manage();
		$result = $m->deleteRecord("aalierp_brand","brand_id",$_POST["id"]);
		echo $result;
		exit();
	}
	
	








//Add Banner..
	if(!empty($_POST['banner_size'])){
		$obj = new DBFunctions();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$banner_image = '../../uploads/banners/'; 
		$img = $_FILES['banner_image']['name'];
		$tmp = $_FILES['banner_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$banner_image = $banner_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$banner_image)){
			    
				$insert = $obj->addBanner($_POST['banner_size'],$banner_image,$_POST["created_on"],$_POST["created_by"]);
				echo $insert;
				exit();
			}
		}else{
			echo "Invalid Format!";
		}
		
	}
	
//View Banner
	if(isset($_POST["viewBanner"])){ $n=1;
		$obj = mysqli_query($conn, "SELECT * FROM aalierp_banner");
		while($row = mysqli_fetch_array($obj)){ ?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["banner_size"]; ?></td>
				<td><img src="<?php echo $AaliLINK; ?>/uploads/banners/<?php echo $row['banner_image']; ?>" width="30" height="30" /></td>
				<td><?php echo $row["banner_status"]; ?></td>
				<td class="">
					<div class="text-center">
						<div class="btn-group dropup text-left">
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
							<ul class="dropdown-menu pull-right p-2" role="menu">
								<li><a href="?ma=<?php echo $row['banner_id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Make Active</a></li>
								<li><a href="?mda=<?php echo $row['banner_id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Make Deactive</a></li>
								<li class="divider"></li>
								<li><a href="#" did="<?php echo $row['banner_id']; ?>" class="btn btn-default btn-sm delete_banner"><i class="fa fa-trash"></i> Delete Banner</a></li>				
							</ul>
						</div>
					</div>
				</td>
			</tr>
	    <?php $n++; } 
	}
	
	
	
	
	
	
	
	
	
	
	
	
//Add Catalogue..
	if(!empty($_POST['catalogue_name'])){
		$obj = new DBFunctions();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$catalogue_image = '../../uploads/catalogues/'; 
		$img = $_FILES['catalogue_image']['name'];
		$tmp = $_FILES['catalogue_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$catalogue_image = $catalogue_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$catalogue_image)){
			    
				$insert = $obj->addCatalogue($_POST['catalogue_name'],$catalogue_image,$_POST["created_on"],$_POST["created_by"]);
				echo $insert;
				exit();
			}
		}else{
			echo "Invalid Format!";
		}
		
	}
	
//Fetch Catalogue In Select..
	if(isset($_POST["fetchCatalogue"])){
		$obj = new DBFunctions();
		$rows = $obj->getAllRecord("aalierp_catalogue");
		foreach($rows as $row){
			echo "<option value='".$row["catalogue_id"]."'>".$row["catalogue_name"]."</option>";
		}
		exit();
	}
	
//Count Catalogue..
	if (isset($_POST["count_catalogue"])) {
		$query = mysqli_query($conn,"SELECT COUNT(*) AS count_catalogue FROM aalierp_catalogue");
		$row = mysqli_fetch_array($query);
		echo $row["count_catalogue"];
		exit();
	}
	
//View Catalogue
	if(isset($_POST["viewCatalogue"])){ $n=1;
		$obj = mysqli_query($conn, "SELECT * FROM aalierp_catalogue");
		while($row = mysqli_fetch_array($obj)){ ?>
			<tr>
			    <td><input type="checkbox" class="form-control" style="width:15px;height:15px;" /></td>
				<td><?php echo $n; ?></td>
				<td><?php echo $row["catalogue_name"]; ?></td>
				<td><img src="<?php echo $AaliLINK; ?>/uploads/catalogues/<?php echo $row['catalogue_image']; ?>" width="30" height="30" /></td>
				<td><?php echo $row["catalogue_status"]; ?></td>
				<td class="">
					<div class="text-center">
						<div class="btn-group dropup text-left">
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
							<ul class="dropdown-menu pull-right p-2" role="menu">
								<li><a href="#" uid="<?php echo $row['catalogue_id']; ?>" data-toggle="modal" data-target="#update_catalogue" class="btn btn-default btn-sm update_catalogue"><i class="fa fa-edit"></i> Update Catalogue</a></li>
								<li class="divider"></li>
								<li><a href="#" did="<?php echo $row['catalogue_id']; ?>" class="btn btn-default btn-sm delete_catalogue"><i class="fa fa-trash"></i> Delete Catalogue</a></li>				
							</ul>
						</div>
					</div>
				</td>
			</tr>
	    <?php $n++; } 
	}
		
//Show Catalogue Data To Update..
	if(isset($_POST["updateCatalogue"])){
		$m = new Manage();
		$result = $m->getSingleRecord("aalierp_catalogue","catalogue_id",$_POST["id"]);
		echo json_encode($result);
		exit();
	}
	
//Update Catalogue..
	if(!empty($_POST['update_catalogue_name'])){
		$obj = new Manage();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$catalogue_image = '../../uploads/catalogues/';
		$img = $_FILES['update_catalogue_image']['name'];
		$tmp = $_FILES['update_catalogue_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$catalogue_image = $catalogue_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$catalogue_image)){

				$result = $obj->update_record("aalierp_catalogue",["catalogue_id"=>$_POST["update_catalogue_id"]],["catalogue_name"=>$_POST['update_catalogue_name'],"catalogue_image"=>$catalogue_image,"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
				echo $result;
				exit();
			}
		}else{
			echo "Invalid File Format!";
		}
	}
	if(!empty($_POST['update_catalogue_name'])){
		$obj = new Manage();
		$result = $obj->update_record("aalierp_catalogue",["catalogue_id"=>$_POST["update_catalogue_id"]],["catalogue_name"=>$_POST['update_catalogue_name'],"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
		echo $result;
		exit();
	}
	
//Delete Catalogue..
	if(isset($_POST["deleteCatalogue"])){
		$m = new Manage();
		$result = $m->deleteRecord("aalierp_catalogue","catalogue_id",$_POST["id"]);
		echo $result;
		exit();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//Add Category..
    if(!empty($_POST['category_name'])){
        $obj = new DBFunctions();
        $insert = $obj->addCategory($_POST['category_name'],$_POST['category_description'],$_POST["created_on"],$_POST["created_by"]);
        echo $insert;
        exit();
    }
    
//Fetch Category In Select..
    if(isset($_POST["fetchCategory"])){
        $obj = new DBFunctions();
        $rows = $obj->getAllRecord("aalierp_category");
        foreach($rows as $row){
            echo "<option value='".$row["category_id"]."'>".$row["category_name"]."</option>";
        }
        exit();
    }
    
//Count Category..
    if (isset($_POST["count_category"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_category FROM aalierp_category");
        $row = mysqli_fetch_array($query);
        echo $row["count_category"];
        exit();
    }
    
//View Category
    if(isset($_POST["viewCategory"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT * FROM aalierp_category");
        while($row = mysqli_fetch_array($obj)){ if($row["user_id"] == $_SESSION["user_id"] || $_SESSION["user_type"] == "Super"){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["category_name"]; ?></td>
                <td><?php echo $row["category_status"]; ?></td>
                <td class="">
                    <div class="text-center">
                        <div class="btn-group dropup text-left">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right p-2" role="menu">
                                <li><a href="?assign=<?php echo $row['category_id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Assign Admin User</a></li>
                                <li><a href="#" uid="<?php echo $row['category_id']; ?>" data-toggle="modal" data-target="#update_category" class="btn btn-default btn-sm update_category"><i class="fa fa-edit"></i> Update Category</a></li>
                                <li class="divider"></li>
                                <li><a href="#" did="<?php echo $row['category_id']; ?>" class="btn btn-default btn-sm delete_category"><i class="fa fa-trash"></i> Delete Category</a></li>             
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } $n++; } 
    }
        
//Show Category Data To Update..
    if(isset($_POST["updateCategory"])){
        $m = new Manage();
        $result = $m->getSingleRecord("aalierp_category","category_id",$_POST["id"]);
        echo json_encode($result);
        exit();
    }
    
//Update Category..
    if(!empty($_POST['update_category_name'])){
        $obj = new Manage();
        $result = $obj->update_record("aalierp_category",["category_id"=>$_POST["update_category_id"]],["category_name"=>$_POST['update_category_name'],"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
        echo $result;
        exit();
    }
    
//Delete Category..
    if(isset($_POST["deleteCategory"])){
        $m = new Manage();
        $result = $m->deleteRecord("aalierp_category","category_id",$_POST["id"]);
        echo $result;
        exit();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//Add Sub Category..
    if(!empty($_POST['sub_category_name'])){
        $obj = new DBFunctions();
        $insert = $obj->addSubCategory($_POST['sub_category_name'],$_POST['category_id'],$_POST["created_on"],$_POST["created_by"]);
        echo $insert;
        exit();
    }
    
//Fetch Sub Category In Select..
    if(isset($_POST["fetchSubCategory"])){
        $obj = new DBFunctions();
        $rows = $obj->getAllRecord("aalierp_subcategory");
        foreach($rows as $row){
            echo "<option value='".$row["subcategory_id"]."'>".$row["subcategory_name"]."</option>";
        }
        exit();
    }
    
//Count Sub Category..
    if (isset($_POST["count_subcategory"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_subcategory FROM aalierp_subcategory");
        $row = mysqli_fetch_array($query);
        echo $row["count_subcategory"];
        exit();
    }
    
//View Sub Category
    if(isset($_POST["viewSubCategory"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT s.subcategory_id,s.subcategory_name,s.catalogue_id,s.subcategory_status,c.catalogue_name FROM aalierp_subcategory s, aalierp_catalogue c WHERE s.catalogue_id=c.catalogue_id");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["subcategory_name"]; ?></td>
                <td><?php echo $row["catalogue_name"]; ?></td>
                <td><?php echo $row["subcategory_status"]; ?></td>
                <td class="">
                    <div class="text-center">
                        <div class="btn-group dropup text-left">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right p-2" role="menu">
                                <li><a href="#" uid="<?php echo $row['subcategory_id']; ?>" data-toggle="modal" data-target="#update_subcategory" class="btn btn-default btn-sm update_subcategory"><i class="fa fa-edit"></i> Update Sub Category</a></li>
                                <li class="divider"></li>
                                <li><a href="#" did="<?php echo $row['subcategory_id']; ?>" class="btn btn-default btn-sm delete_subcategory"><i class="fa fa-trash"></i> Delete Sub Category</a></li>             
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $n++; } 
    }
        
//Show Category Data To Update..
    if(isset($_POST["updateSubCategory"])){
        $m = new Manage();
        $result = $m->getSingleRecord("aalierp_sub_category","sub_category_id",$_POST["id"]);
        echo json_encode($result);
        exit();
    }
    
//Update Sub Category..
    if(!empty($_POST['update_sub_category_name'])){
        $obj = new Manage();
        $result = $obj->update_record("aalierp_sub_category",["sub_category_id"=>$_POST["update_sub_category_id"]],["sub_category_name"=>$_POST['update_sub_category_name'],"category_id"=>$_POST['update_category_id'],"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
        echo $result;
        exit();
    }
    
//Delete Sub Category..
    if(isset($_POST["deleteSubCategory"])){
        $m = new Manage();
        $result = $m->deleteRecord("aalierp_sub_category","sub_category_id",$_POST["id"]);
        echo $result;
        exit();
    }






























//Add Unit..
    if(!empty($_POST['unit_name'])){
        $obj = new DBFunctions();
        $insert = $obj->addUnit($_POST['unit_name'],$_POST["created_on"],$_POST["created_by"]);
        echo $insert;
        exit();
    }
    
//Fetch Unit In Select..
    if(isset($_POST["fetchUnit"])){
        $obj = new DBFunctions();
        $rows = $obj->getAllRecord("aalierp_unit");
        foreach($rows as $row){
            echo "<option value='".$row["unit_id"]."'>".$row["unit_name"]."</option>";
        }
        exit();
    }
    
//Count Unit..
    if (isset($_POST["count_unit"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_unit FROM aalierp_unit");
        $row = mysqli_fetch_array($query);
        echo $row["count_unit"];
        exit();
    }
    
//View Unit
    if(isset($_POST["viewUnit"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT * FROM aalierp_unit");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["unit_name"]; ?></td>
                <td><?php echo $row["unit_status"]; ?></td>
                <td class="">
                    <div class="text-center">
                        <div class="btn-group dropup text-left">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right p-2" role="menu">
                                <li><a href="#" uid="<?php echo $row['unit_id']; ?>" data-toggle="modal" data-target="#update_unit" class="btn btn-default btn-sm update_unit"><i class="fa fa-edit"></i> Update Unit</a></li>
                                <li class="divider"></li>
                                <li><a href="#" did="<?php echo $row['unit_id']; ?>" class="btn btn-default btn-sm delete_unit"><i class="fa fa-trash"></i> Delete Unit</a></li>             
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $n++; } 
    }
        
//Show Unit Data To Update..
    if(isset($_POST["updateUnit"])){
        $m = new Manage();
        $result = $m->getSingleRecord("aalierp_unit","unit_id",$_POST["id"]);
        echo json_encode($result);
        exit();
    }
    
//Update Unit..
    if(!empty($_POST['update_unit_name'])){
        $obj = new Manage();
        $result = $obj->update_record("aalierp_unit",["unit_id"=>$_POST["update_unit_id"]],["unit_name"=>$_POST['update_unit_name'],"updated_on"=>$_POST["updated_on"],"created_by"=>$_POST["updated_by"]]);
        echo $result;
        exit();
    }
    
//Delete Unit..
    if(isset($_POST["deleteUnit"])){
        $m = new Manage();
        $result = $m->deleteRecord("aalierp_unit","unit_id",$_POST["id"]);
        echo $result;
        exit();
    }


















//Add Product...
    if(!empty($_POST['product_name'])){
        $obj = new DBFunctions();
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
        //$valid_extensions_v = array('mp4', 'avi', 'mov');
        $product_image = '../../uploads/products/';
        //$product_video = '../../uploads/products/';
        $img = $_FILES['product_image']['name'];
        $tmp = $_FILES['product_image']['tmp_name'];
        //$vid = $_FILES['product_video']['name'];
        //$tmpv = $_FILES['product_video']['tmp_name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        //$extv = strtolower(pathinfo($vid, PATHINFO_EXTENSION));
        $final_image = rand(1000,1000000).$img;
        //$final_video = rand(1000,1000000).$vid;
        //if(in_array($ext, $valid_extensions) && in_array($extv, $valid_extensions_v)){ 
        if(in_array($ext, $valid_extensions)){ 
            $product_image = $product_image.strtolower($final_image); 
            //$product_video = $product_video.strtolower($final_video); 
            //if(move_uploaded_file($tmp,$product_image) && move_uploaded_file($tmpv,$product_video)){
            if(move_uploaded_file($tmp,$product_image)){
                $date = date("Y-m-d H:i:s");
                $insert = $obj->addProduct($_POST["product_name"], $product_image, $_POST["category_id"], $_POST["subcategory_id"], $_POST["unit_id"], $_POST["product_price"], $_POST["product_old_price"], $_POST["product_discount"], $_POST["product_keywords"], $_POST["product_desc"], $date, $_SESSION["user_name"]);
                echo $insert;
                exit();
            }
        }else{
            echo "Invalid Format!";
        }
    }
    
//Fetch Product...
    if(isset($_POST["fetchProduct"])){
        $obj = new DBFunctions();
        $rows = $obj->getAllRecord("aalierp_product");
        foreach($rows as $row){
            echo "<option value='".$row["product_id"]."'>".$row["product_name"]."</option>";
        }
        exit();
    }
    
//Count Products..
    if (isset($_POST["count_product"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_product FROM aalierp_product");
        $row = mysqli_fetch_array($query);
        echo $row["count_product"];
        exit();
    }
    
//View Product...
    if(isset($_POST["viewProduct"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT * FROM aalierp_product ORDER BY product_id DESC");
        while($row = mysqli_fetch_array($obj)){ if($row["user_id"] == $_SESSION["user_id"] || $_SESSION["user_type"] == "Super"){ ?>
            <tr>
			    <td><input type="checkbox" class="form-control" style="width:15px;height:15px;" /></td>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["product_name"]; ?></td>
                <td><img src="../../uploads/products/<?php echo $row['product_image']; ?>" width="30" height="30" /></td>
                <td><?php echo $cur."".$row["product_price"]; ?></td>
                <td><?php echo $cur."".$row["product_old_price"]; ?></td>
                <td><?php echo $row["product_discount"]."%"; ?></td>
                <td><?php echo $row["product_keywords"]; ?></td>
                <td><?php echo $row["product_status"]; ?></td>
                <td class="">
                    <div class="text-center">
                        <div class="btn-group dropup text-left">
                            <button type="button" class="btn btn-default btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right p-3" role="menu">
                                <li><a href="?assign=<?php echo $row['product_id']; ?>"><i class="fa fa-edit"></i> Assign Admin User</a></li>
                                <li><a href="#" uid="<?php echo $row['product_id']; ?>" data-toggle="modal" data-target="#update_product" class="update_product"><i class="fa fa-edit"></i> Update Product</a></li>
                                <li class="divider"></li>
                                <li><a href="#" did="<?php echo $row['product_id']; ?>" class="delete_product"><i class="fa fa-trash"></i> Delete Product</a></li>              
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>

        <?php } $n++; }    
    }

//Show Product Data In Form..
    if(isset($_POST["updateProduct"])){
        $m = new Manage();
        $result = $m->getSingleRecord("aalierp_product","product_id",$_POST["id"]);
        echo json_encode($result);
        exit();
    }   

//Update Catalogue..
	if(!empty($_POST['update_product_name'])){
		$obj = new Manage();
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); 
		$product_image = '../../uploads/products/';
		$img = $_FILES['update_product_image']['name'];
		$tmp = $_FILES['update_product_image']['tmp_name'];
		$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
		$final_image = rand(1000,1000000).$img;
		if(in_array($ext, $valid_extensions)){ 
			$product_image = $product_image.strtolower($final_image); 
			if(move_uploaded_file($tmp,$product_image)){

				$result = $obj->update_record("aalierp_product",["product_id"=>$_POST["update_product_id"]],["product_name"=>$_POST['update_product_name'],"product_image"=>$product_image,"product_type"=>$_POST['update_product_type'],"catalogue_id"=>$_POST['update_catalogue_id'],"unit_id"=>$_POST['update_unit_id'],"product_price"=>$_POST['update_product_price'],"product_old_price"=>$_POST['update_product_old_price'],"product_discount"=>$_POST['update_product_discount'],"product_keywords"=>$_POST['update_product_keywords'],"product_download"=>$_POST['update_product_download'],"product_desc"=>$_POST['update_product_desc']]);
				echo $result;
				exit();
			}
		}else{
			echo "Invalid File Format!";
		}
	}
	if(!empty($_POST['update_product_name'])){
		$obj = new Manage();
		$result = $obj->update_record("aalierp_product",["product_id"=>$_POST["update_product_id"]],["product_name"=>$_POST['update_product_name'],"product_type"=>$_POST['update_product_type'],"catalogue_id"=>$_POST['update_catalogue_id'],"unit_id"=>$_POST['update_unit_id'],"product_price"=>$_POST['update_product_price'],"product_old_price"=>$_POST['update_product_old_price'],"product_discount"=>$_POST['update_product_discount'],"product_keywords"=>$_POST['update_product_keywords'],"product_download"=>$_POST['update_product_download'],"product_desc"=>$_POST['update_product_desc']]);
		echo $result;
		exit();
	}

//Delete Product..
    if(isset($_POST["deleteProduct"])){
        $m = new Manage();
        $result = $m->deleteRecord("aalierp_product","product_id",$_POST["id"]);
        echo $result;
        exit();
    }



















//Add Product Image...
    if(!empty($_FILES['product_image'])){
        $obj = new DBFunctions();
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
        $product_image = '../../uploads/products/';
        $img = $_FILES['product_image']['name'];
        $tmp = $_FILES['product_image']['tmp_name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $final_image = rand(1000,1000000).$img;
        if(in_array($ext, $valid_extensions)){ 
            $product_image = $product_image.strtolower($final_image); 
            if(move_uploaded_file($tmp,$product_image)){
                $insert = $obj->addProductImage($_POST["product_id"], $product_image, $_POST["created_on"], $_POST["created_by"]);
                echo $insert;
                exit();
            }
        }else{
            echo "Invalid Format!";
        }
        
    }
    
//View Product Images...
    if(isset($_POST["viewProductImage"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT i.image_id,i.product_id,i.product_image,p.product_name,p.product_status FROM aalierp_image i, aalierp_product p WHERE i.product_id=p.product_id ORDER BY image_id DESC");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["product_name"]; ?></td>
                <td><img src="../../uploads/products/<?php echo $row['product_image']; ?>" width="30" height="30" /></td>
                <td><?php echo $row["product_status"]; ?></td>
                <td class="">
                    <div class="text-center">
                        <div class="btn-group dropup text-left">
                            <button type="button" class="btn btn-default btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right p-3" role="menu">
                                <li><a href="#" uid="<?php echo $row['image_id']; ?>" data-toggle="modal" data-target="#update_product_image" class="update_product_image"><i class="fa fa-edit"></i> Update Product Image</a></li>
                                <li class="divider"></li>
                                <li><a href="#" did="<?php echo $row['image_id']; ?>" class="delete_product_image"><i class="fa fa-trash"></i> Delete Product Image</a></li>              
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>

        <?php $n++; }    
    }
    
    
    
    
    
    
    
    
    
    


















  



//Count Order Cart..
    if (isset($_POST["count_order_cart"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_order_cart FROM aalierp_cart WHERE status='Chosen'");
        $row = mysqli_fetch_array($query);
        echo $row["count_order_cart"];
        exit();
    }
//Count Order Processing..
    if (isset($_POST["count_order_processing"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_order_processing FROM aalierp_cart WHERE status='Processing'");
        $row = mysqli_fetch_array($query);
        echo $row["count_order_processing"];
        exit();
    }
//Count Order Processed..
    if (isset($_POST["count_order_processed"])) {
        $query = mysqli_query($conn,"SELECT COUNT(*) AS count_order_processed FROM aalierp_cart WHERE status='Processed'");
        $row = mysqli_fetch_array($query);
        echo $row["count_order_processed"];
        exit();
    }
    






//View Order Cart
    if(isset($_POST["view_cart"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT p.product_id,p.product_name,p.product_image,p.product_price,c.id,c.p_id,c.date,c.user_id,c.qty,c.ship,c.mail,c.coupon,c.cdiscount,c.status,u.user_name FROM aalierp_product p, aalierp_cart c, aalierp_user u WHERE p.product_id=c.p_id AND c.user_id=u.user_id AND c.status='Chosen'");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["product_name"]; ?></td>
                <td><?php echo $cur."".$row["product_price"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
            </tr>
        <?php $n++; } 
    }
//View Order Processing
    if(isset($_POST["view_order_processing"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT p.product_id,p.product_name,p.product_image,p.product_price,c.id,c.p_id,c.date,c.user_id,c.qty,c.ship,c.mail,c.coupon,c.cdiscount,c.status,u.user_name FROM aalierp_product p, aalierp_cart c, aalierp_user u WHERE p.product_id=c.p_id AND c.user_id=u.user_id AND c.status='Processing'");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["product_name"]; ?></td>
                <td><?php echo $cur."".$row["product_price"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
            </tr>
        <?php $n++; } 
    }
//View Order Processed
    if(isset($_POST["view_order_processed"])){ $n=1;
        $obj = mysqli_query($conn, "SELECT p.product_id,p.product_name,p.product_image,p.product_price,c.id,c.p_id,c.date,c.user_id,c.qty,c.ship,c.mail,c.coupon,c.cdiscount,c.status,u.user_name FROM aalierp_product p, aalierp_cart c, aalierp_user u WHERE p.product_id=c.p_id AND c.user_id=u.user_id AND c.status='Processed'");
        while($row = mysqli_fetch_array($obj)){ ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["product_name"]; ?></td>
                <td><?php echo $cur."".$row["product_price"]; ?></td>
                <td><?php echo $row["user_name"]; ?></td>
            </tr>
        <?php $n++; } 
    }



?>