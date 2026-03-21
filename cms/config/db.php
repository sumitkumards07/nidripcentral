<?php
class Database{
	private $con;
	public function connect(){
		include_once("defines.php");
		$this->con = mysqli_init();
		mysqli_real_connect($this->con, HOST, USER, PASS, DB, 13923, NULL, MYSQLI_CLIENT_SSL);
		if($this->con){return $this->con;}
		return "Database Connection Failed";
	}
}


?>