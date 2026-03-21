<?php
    include("defines.php");

    $date = date("Y-m-d H:i:s");
    $query = mysqli_query($conn,"SELECT * FROM aalierp_login_detail WHERE login_name='".$_SESSION["user_name"]."' ORDER BY id DESC");
    $row = mysqli_fetch_assoc($query);
    
    mysqli_query($conn,"UPDATE aalierp_login_detail SET logout_date='$date' WHERE id='".$row["id"]."'");


    if(isset($_SESSION["user_id"])){
    	session_destroy();
    }

    header("location:".DOMAIN."/");

?>