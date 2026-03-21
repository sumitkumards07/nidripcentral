<?php
	session_start();
	
	define("HOST", getenv("DB_HOST") ?: "mysql-3ca597c5-sumitkumards07-3d54.d.aivencloud.com");
	define("USER", getenv("DB_USER") ?: "avnadmin");
	define("PASS", getenv("DB_PASS"));
	define("DB", getenv("DB_NAME") ?: "defaultdb");

	$conn = mysqli_init();
	mysqli_real_connect($conn, HOST, USER, PASS, DB, 13923, NULL, MYSQLI_CLIENT_SSL);
	
	define("DOMAIN","https://nidrip.mraalionline.com/cms");
	$AaliLINK = "https://nidrip.mraalionline.com/cms";
	$AaliLINK_IN = $_SERVER['DOCUMENT_ROOT']."/cms";
	
	$gc_query = mysqli_query($conn, "SELECT * FROM `aalierp_contents` ORDER BY company_id DESC LIMIT 1");
	$row = mysqli_fetch_assoc($gc_query);
	$company_id = $row['company_id'];$company_name = $row['company_name']; $company_salogan = $row['company_salogan']; 
    $company_mobile = $row['company_mobile']; $company_email = $row['company_email'];$company_web = $row['company_web']; 
    $company_phone = $row['company_phone']; $company_address = $row['company_address']; $company_city = $row['company_city']; 
	$company_country = $row['company_country']; $company_pob = $row['company_pob']; $company_logo = $row["company_logo"];
    $cur = $row['company_currency'];

	
	
?>