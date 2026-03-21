<?php 
include_once("../../config/defines.php");
class Manage{
	function __construct(){
		include_once("../../config/db.php");
		
		$db = new Database();
		$this->con = $db->connect();
	}



//Delete Record...
	public function deleteRecord($table,$pk,$id){
		if($table =="aalierp_brand"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_items WHERE brand_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Brand is used in product table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Brand Deleted";
				}
			}
		}else if($table =="aalierp_category"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_product WHERE category_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Category is used in product table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Category Deleted";
				}
			}
		}else if($table =="aalierp_category"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_sub_category WHERE category_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Category is used in sub category table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Category Deleted";
				}
			}
		}else if($table =="aalierp_sub_category"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_product WHERE category_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Sub Category is used in product table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Sub Category Deleted";
				}
			}
		}else if($table =="aalierp_unit"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_product WHERE category_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Unit is used in product table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Unit Deleted";
				}
			}
		}else if($table =="aalierp_catalogue"){
			$stmt = $this->con->prepare("SELECT ".$id." FROM aalierp_product WHERE catalogue_id = ?");
			$stmt->bind_param("i",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0){
				return "Catalogue is used in product table";
			}else{
				$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
				$stmt->bind_param("i",$id);
				$result = $stmt->execute();
				if($result){
					return "Catalogue Deleted";
				}
			}
		}else{
			$stmt = $this->con->prepare("DELETE FROM ".$table." WHERE ".$pk." = ?");
			$stmt->bind_param("i",$id);
			$result = $stmt->execute();
			if($result){
				return "Deleted";
			}else{
				return "something went wrong";
			}
		}

	}










//Get Single Record..
	public function getSingleRecord($table,$field,$id){
		$stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE ".$field." = ? LIMIT 1");
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows == 1){
			$row = $result->fetch_assoc();
		}
		return $row;
	}







//Update Record..
	public function update_record($table, $where, $fields){
		$sql = "";
		$condition = "";
		$params = [];
		$types = "";

		// Build SET fields dynamically
		foreach ($fields as $key => $value) {
			$sql .= $key . "=?, ";
			$params[] = $value;
			// Simplistic type mapping wrapper (assuming strings for all arrays to prevent int casting errors)
			$types .= "s"; 
		}
		$sql = substr($sql, 0, -2); // Remove trailing comma and space

		// Build WHERE conditions dynamically
		foreach ($where as $key => $value) {
			$condition .= $key . "=? AND ";
			$params[] = $value;
			$types .= "s";
		}
		$condition = substr($condition, 0, -5); // Remove trailing AND

		$query = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;
		
		$stmt = $this->con->prepare($query);
		if($stmt) {
			$stmt->bind_param($types, ...$params);
			if($stmt->execute()){
				return "Updated";
			}
		}
		return "something went wrong";
	}





































//Quotation..
	public function addQuote($quote_date,$ar_item_id,$ar_item_qty,$ar_item_unit,$ar_item_discount,$ar_item_price,$ar_item_narration,$ar_item_status,$quote_sub_total,$quote_status,$created_on,$created_by){
		$stmt = $this->con->prepare("INSERT INTO `aalierp_quote` (`quote_date`, `quote_sub_total`, `status`, `created_on`, `created_by`) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sdiss",$quote_date,$quote_sub_total,$quote_status,$created_on,$created_by);
		$stmt->execute();
		$quote_no = $stmt->insert_id;

		if($quote_no != null){
			for($i=0; $i < count($ar_item_price) ; $i++){
				$submit_quote = $this->con->prepare("INSERT INTO `aalierp_quote_detail`(`qd_no`, `qd_item`, `qd_qty`, `qd_unit`, `qd_discount`, `qd_price`,`qd_narration`,`status`) VALUES (?,?,?,?,?,?,?,?)");
				$submit_quote->bind_param("iididdsi",$quote_no,$ar_item_id[$i],$ar_item_qty[$i],$ar_item_unit[$i],$ar_item_discount[$i],$ar_item_price[$i],$ar_item_narration[$i],$ar_item_status[$i]);
				$submit_quote->execute();
			}
			return "Quote Added";
		}
	}

//Work Order..
	public function addWorkOrder($wc_date,$wc_project,$wc_vendor,$ar_act_id,$ar_act_qty,$ar_act_price,$ar_act_narration,$ar_act_status,$wc_sub_total,$wc_status,$created_on,$created_by){
		$stmt = $this->con->prepare("INSERT INTO `aalierp_workorder` (wc_date,wc_project,wc_vendor,wc_sub_total,status,created_on,created_by) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("siidiss",$wc_date,$wc_project,$wc_vendor,$wc_sub_total,$wc_status,$created_on,$created_by);
		$stmt->execute();
		$wc_no = $stmt->insert_id;

		if($wc_no != null){
			for($i=0; $i < count($ar_act_qty) ; $i++){
				$submit_wc = $this->con->prepare("INSERT INTO `aalierp_workorder_detail`(`wcd_no`, `wcd_act`, `wcd_qty`, `wcd_price`,`wcd_narration`,`status`) VALUES (?,?,?,?,?,?)");
				$submit_wc->bind_param("iiddsi",$wc_no,$ar_act_id[$i],$ar_act_qty[$i],$ar_act_price[$i],$ar_act_narration[$i],$ar_act_status[$i]);
				$submit_wc->execute();
			}
			return "Work Order Added";
		}
	}

//F Work Order..
	public function addFWorkOrder($wcf_date,$wcf_project,$wcf_vendor,$ar_act_id,$ar_act_length,$ar_act_width,$ar_act_price,$ar_act_narration,$ar_act_status,$wcf_sub_total,$wcf_status,$created_on,$created_by){
		$stmt = $this->con->prepare("INSERT INTO `aalierp_workorderf` (wcf_date,wcf_project,wcf_vendor,wcf_sub_total,status,created_on,created_by) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("siidiss",$wcf_date,$wcf_project,$wcf_vendor,$wcf_sub_total,$wcf_status,$created_on,$created_by);
		$stmt->execute();
		$wcf_no = $stmt->insert_id;

		if($wcf_no != null){
			for($i=0; $i < count($ar_act_length) ; $i++){
				$submit_wcf = $this->con->prepare("INSERT INTO `aalierp_workorderf_detail`(`wcdf_no`, `wcdf_act`, `wcdf_length`, `wcdf_width`, `wcdf_price`,`wcdf_narration`,`status`) VALUES (?,?,?,?,?,?,?)");
				$submit_wcf->bind_param("iidddsi",$wcf_no,$ar_act_id[$i],$ar_act_length[$i],$ar_act_width[$i],$ar_act_price[$i],$ar_act_narration[$i],$ar_act_status[$i]);
				$submit_wcf->execute();
			}
			return "Work Order Added";
		}
	}


//Material Issuance..
	public function addMaterialIssue($mi_date,$mi_project,$mi_act,$mi_store,$ar_item_id,$ar_item_qty,$ar_item_narration,$ar_item_status,$mi_status,$created_on,$created_by){
		$stmt = $this->con->prepare("INSERT INTO `aalierp_material` (mi_date,mi_project,mi_act,mi_store,status,created_on,created_by) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("siiiiss",$mi_date,$mi_project,$mi_act,$mi_store,$mi_status,$created_on,$created_by);
		$stmt->execute();
		$mi_no = $stmt->insert_id;

		if($mi_no != null){
			for($i=0; $i < count($ar_item_qty) ; $i++){
				$submit_mi = $this->con->prepare("INSERT INTO `aalierp_material_detail`(`mid_no`, `mid_item`, `mid_qty`,`mid_narration`,`status`) VALUES (?,?,?,?,?)");
				$submit_mi->bind_param("iidsi",$mi_no,$ar_item_id[$i],$ar_item_qty[$i],$ar_item_narration[$i],$ar_item_status[$i]);
				$submit_mi->execute();
			}
			return "Material Issued";
		}
	}









}







//$obj = new Manage();
//print_r($obj->getSingleRecord("aalierp_brand","brand_id",1));
//echo "<pre>";
//print_r($obj->manageRecordPagination("aalierp_staff",1));
//echo $obj->update_record("aalierp_order",["order_id"=>16],["status"=>"Confirmed"]);

?>