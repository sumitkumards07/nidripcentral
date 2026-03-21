<?php
/**
 * User Class for account creation & login..
 */
class User{
	private $con;
	function __construct()
	{
		include_once("../../config/db.php");
		$db = new Database();
		$this->con = $db->connect();
	}
	


    //User Regitration..
    private function emailExists($reg_email){
		$stmt = $this->con->prepare("SELECT user_id FROM aalierp_user WHERE user_email = ?");
		$stmt->bind_param("s",$reg_email);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function createUserAccount($reg_fname, $reg_lname, $reg_username, $reg_image, $reg_mobile, $reg_email, $reg_password, $reg_passcode,  $reg_type, $reg_status){

		if($this->emailExists($reg_email)){
			return "User already exists!";
		}else{
			$stm = $this->con->prepare("SELECT * FROM aalierp_user ORDER BY user_id DESC");
			$stm->execute();
			$res = $stm->get_result();
			$row = $res->fetch_assoc();

			$hash_password = password_hash($reg_password, PASSWORD_DEFAULT,["cost"=>8]);

			$user_ip = $_SERVER['REMOTE_ADDR'];
			$ipdat = 'http://ip-api.com/php/'.$user_ip;
			$ress = @unserialize(file_get_contents($ipdat));
			$user_country = $ress["country"];
			$user_city = $ress["city"];
			
			

$subject = "Email Verification From Mohsin Online"; 
$message = "

Congratulation!
Your account has been created, you can login with the following credentials.
------------------------
	Username: ".$reg_email."
	Password: ".$reg_password."
------------------------

After you have activated your account by pressing the url below:

https://mohsin.mraalionline.com/?email=".$reg_email."&password=".$hash_password."";
		                          
	$headers = "From:noreply@mraalionline.com"."\r\n"; 
	mail($reg_email, $subject, $message, $headers);

			$stmt = $this->con->prepare("INSERT INTO aalierp_user (user_fname, user_lname, user_username, user_image, user_designation, user_mobile, user_email, user_password, user_passcode, user_type, user_ip, user_city, user_country, user_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->bind_param("ssssssssssssss", $reg_fname, $reg_lname, $reg_username, $reg_image, $reg_type, $reg_mobile, $reg_email, $hash_password, $reg_passcode, $reg_type, $user_ip, $user_city, $user_country, $reg_status);
			$result = $stmt->execute();
			if($result){
				return "Registered Successfully!";
				return $this->con->insert_id;
			}else{
				return "Something went wrong!";
			}
		}
	}


















	// User Login...
	public function userLogin($user_email,$user_password){
		$stmt = $this->con->prepare("SELECT * FROM aalierp_user WHERE user_username = ? OR user_email = ?");
		if(!$stmt){
			return "Login is temporarily unavailable!";
		}

		$stmt->bind_param("ss", $user_email, $user_email);
		$stmt->execute();
		$result = $stmt->get_result();

		if(!$result || $result->num_rows < 1){
			return "User Not Registered!";
		}

		$row = $result->fetch_assoc();
		if(!$row){
			return "Login is temporarily unavailable!";
		}

		if(!(password_verify($user_password, $row["user_password"] ?? "") || $user_password === ($row["user_password"] ?? ""))){
			return "Password doesn't match!";
		}

		$user_type = strtolower(trim((string)($row["user_type"] ?? "")));
		$user_status = strtolower(trim((string)($row["user_status"] ?? "")));

		if($user_type !== "admin" && $user_type !== "super"){
			return "This account is not allowed in admin panel!";
		}

		if($user_status !== "approved"){
			return "Your account is not approved yet!";
		}

		$full_name = trim((string)($row["user_name"] ?? ''));
		if($full_name === ""){
			$full_name = trim((string)($row["user_fname"] ?? '') . ' ' . (string)($row["user_lname"] ?? ''));
		}
		if($full_name === ""){
			$full_name = (string)($row["user_username"] ?? $row["user_email"] ?? '');
		}

		$user_ip = $_SERVER["REMOTE_ADDR"] ?? getenv("REMOTE_ADDR") ?? '127.0.0.1';
		$user_country = "Remote Cloud";
		$user_city = "Docker Container";

		session_regenerate_id(true);
		$_SESSION["user_id"] = $row["user_id"] ?? '';
		$_SESSION["user_name"] = $full_name;
		$_SESSION["user_username"] = $row["user_username"] ?? '';
		$_SESSION["user_email"] = $row["user_email"] ?? '';
		$_SESSION["user_image"] = $row["user_image"] ?? '';
		$_SESSION["user_mobile"] = $row["user_mobile"] ?? '';
		$_SESSION["user_passcode"] = $row["user_passcode"] ?? '';
		$_SESSION["user_designation"] = $row["user_designation"] ?? '';
		$_SESSION["user_type"] = $row["user_type"] ?? '';
		$_SESSION["user_status"] = $row["user_status"] ?? '';
		$_SESSION["user_login"] = date("Y-m-d H:i:s");
		$_SESSION["expire"] = time();
		$_SESSION["user_ip"] = $user_ip;
		$_SESSION["user_country"] = $user_country;
		$_SESSION["user_city"] = $user_city;

		$stmt_log = $this->con->prepare("INSERT INTO `aalierp_login_detail`(`login_id`, `login_name`, `login_email`, `login_date`, `login_ip`, `login_country`, `login_city`, `logout_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		if($stmt_log){
			$logout_placeholder = $_SESSION["user_login"];
			$stmt_log->bind_param("ssssssss", $_SESSION["user_id"], $_SESSION["user_name"], $_SESSION["user_email"], $_SESSION["user_login"], $_SESSION["user_ip"], $_SESSION["user_country"], $_SESSION["user_city"], $logout_placeholder);
			$stmt_log->execute();
		}

		if($user_type === "super"){
			return "Super Admin Logged In Successfully!";
		}

		return "Admin Logged In Successfully!";
	}
	
	
	
	
	
	
	
	

}

?>
