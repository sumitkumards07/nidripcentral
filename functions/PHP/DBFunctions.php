<?php 

class DBFunctions{
	private $con;
	function __construct()
	{
		include_once("../../config/db.php");
		include_once("../../config/defines.php");

		$db = new Database();
		$this->con = $db->connect();
	}




//Get all Records..
	public function getAllRecord($table){
		$stmt = $this->con->prepare("SELECT * FROM ".$table);
		$stmt->execute();
		$result = $stmt->get_result();
		$rows = array();
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows;
		}
		return "No Data Found";
	}
	
	
	
	
//Brand Already Exists..
	private function brandExists($brand_name){
		$stmt = $this->con->prepare("SELECT brand_id FROM aalierp_brand WHERE brand_name = ?");
		$stmt->bind_param("s",$brand_name);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}
	
//Add Brand..	
	public function addBrand($brand_name, $brand_image, $created_on, $created_by){
		if($this->brandExists($brand_name)){
			return "Brand already exists!";
		}else{
	        $stmt = $this->con->prepare("INSERT INTO aalierp_brand (brand_name, brand_image, created_on, created_by) VALUES (?,?,?,?)");
	        $stmt->bind_param("ssss", $brand_name, $brand_image, $created_on, $created_by);
	        $result = $stmt->execute();
	        if($result){
	        	return "Brand Added!";
	        }else{
	        	return "Something went wrong!";
	        }
		}	
	}


//Add Banner..
	public function addBanner($banner_size, $banner_image, $created_on, $created_by){
		$stmt = $this->con->prepare("INSERT INTO aalierp_banner (banner_size, banner_image, created_on, created_by) VALUES (?,?,?,?)");
	    $stmt->bind_param("ssss", $banner_size, $banner_image, $created_on, $created_by);
	    $result = $stmt->execute();
	    if($result){
	        return "Banner Added!";
	    }else{
	        return "Something went wrong!";
	    }	
	}











//Catalogue Already Exists..
	private function catalogueExists($brand_name){
		$stmt = $this->con->prepare("SELECT catalogue_id FROM aalierp_catalogue WHERE catalogue_name = ?");
		$stmt->bind_param("s",$catalogue_name);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}
	
//Add Catalogue..	
	public function addCatalogue($catalogue_name, $catalogue_image, $created_on, $created_by){
		if($this->catalogueExists($catalogue_name)){
			return "Catalogue already exists!";
		}else{
	        $stmt = $this->con->prepare("INSERT INTO aalierp_catalogue (catalogue_name, catalogue_image, created_on, created_by) VALUES (?,?,?,?)");
	        $stmt->bind_param("ssss", $catalogue_name, $catalogue_image, $created_on, $created_by);
	        $result = $stmt->execute();
	        if($result){
	        	return "Catalogue Added!";
	        }else{
	        	return "Something went wrong!";
	        }
		}	
	}










//Category Already Exists..
    private function categoryExists($category_name){
        $stmt = $this->con->prepare("SELECT category_id FROM aalierp_category WHERE category_name = ?");
        $stmt->bind_param("s",$category_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return 1;
        }else{
            return 0;
        }
    }
//Add Category..   
    public function addCategory($category_name, $category_description, $created_on, $created_by){
        if($this->categoryExists($category_name)){
            return "Category already exists!";
        }else{
            $stmt = $this->con->prepare("INSERT INTO aalierp_category (category_name, category_description, created_on, created_by) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $category_name, $category_description, $created_on, $created_by);
            $result = $stmt->execute();
            if($result){
                return "Category Added!";
            }else{
                return "Something went wrong!";
            }
        }   
    }













//Sub Category Already Exists..
    private function subCategoryExists($sub_category_name){
        $stmt = $this->con->prepare("SELECT sub_category_id FROM aalierp_sub_category WHERE sub_category_name = ?");
        $stmt->bind_param("s",$sub_category_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return 1;
        }else{
            return 0;
        }
    }
//Add Sub Category..   
    public function addSubCategory($sub_category_name, $category_id, $created_on, $created_by){
        if($this->subCategoryExists($sub_category_name)){
            return "Sub Category already exists!";
        }else{
            $stmt = $this->con->prepare("INSERT INTO aalierp_sub_category (sub_category_name, category_id, created_on, created_by) VALUES (?,?,?,?)");
            $stmt->bind_param("siss", $sub_category_name, $category_id, $created_on, $created_by);
            $result = $stmt->execute();
            if($result){
                return "Sub Category Added!";
            }else{
                return "Something went wrong!";
            }
        }   
    }
    
    













//Unit Already Exists..
    private function unitExists($unit_name){
        $stmt = $this->con->prepare("SELECT unit_id FROM aalierp_unit WHERE unit_name = ?");
        $stmt->bind_param("s",$unit_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return 1;
        }else{
            return 0;
        }
    }
//Add Unit..   
    public function addUnit($unit_name, $created_on, $created_by){
        if($this->unitExists($unit_name)){
            return "Unit already exists!";
        }else{
            $stmt = $this->con->prepare("INSERT INTO aalierp_unit (unit_name, created_on, created_by) VALUES (?,?,?)");
            $stmt->bind_param("sss", $unit_name, $created_on, $created_by);
            $result = $stmt->execute();
            if($result){
                return "Unit Added!";
            }else{
                return "Something went wrong!";
            }
        }   
    }
    
    










//Product Already Exists..
	private function productExists($product_name){
		$stmt = $this->con->prepare("SELECT product_id FROM aalierp_product WHERE product_name = ?");
		$stmt->bind_param("s",$product_name);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}
	public function addProduct($product_name,$product_image,$category_id,$subcategory_id,$unit_id,$product_price,$product_old_price,$product_discount,$product_keywords,$product_desc,$created_on,$created_by){
		if($this->productExists($product_name)){
			return "Product already exists!";
		}else{
	        $stmt = $this->con->prepare("INSERT INTO aalierp_product (product_name, product_image, category_id, subcategory_id, unit_id, product_price, product_old_price, product_discount, product_keywords, product_desc, created_on, created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
	        $stmt->bind_param("ssiidddsssss", $product_name,$product_image,$category_id,$subcategory_id,$unit_id,$product_price,$product_old_price,$product_discount,$product_keywords,$product_desc,$created_on,$created_by);
	        $result = $stmt->execute();

	        if($result){
	        	return "Product Added!";
	        }else{
	        	return "Something went wrong!";
	        }
		}	
	}
	
	
	
	
	
	
	
	
	
	
	
//Add Product Image..	
	public function addProductImage($product_id, $product_image, $created_on, $created_by){
	   $stmt = $this->con->prepare("INSERT INTO aalierp_image (product_id, product_image, created_on, created_by) VALUES (?,?,?,?)");
	   $stmt->bind_param("isss", $product_id, $product_image, $created_on, $created_by);
	   $result = $stmt->execute();
	   if($result){return "Image Added!";}else{return "Something went wrong!";}	
	}	
	
	
	
	
	
	
	
	
	
	
	
//Library Already Exists..
	private function libraryExists($library_name){
		$stmt = $this->con->prepare("SELECT library_id FROM aalierp_library WHERE library_name = ?");
		$stmt->bind_param("s",$library_name);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}
	public function addLibrary($library_name,$library_image,$library_keywords,$library_desc,$created_on,$created_by){
		if($this->libraryExists($library_name)){
			return "Library already exists!";
		}else{
	        $stmt = $this->con->prepare("INSERT INTO aalierp_library (library_name, library_image, library_keywords, library_desc, created_on, created_by) VALUES (?,?,?,?,?,?)");
	        $stmt->bind_param("ssssss", $library_name,$library_image,$library_keywords,$library_desc,$created_on,$created_by);
	        $result = $stmt->execute();

	        if($result){
	        	return "Library Added!";
	        }else{
	        	return "Something went wrong!";
	        }
		}	
	}











}

?>