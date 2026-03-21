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
        <title>Deposits | <?php echo $company_name; ?></title>
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






						<div class="section-body">
                            <div class="row">
                                <!--<div class="col-md-3">
                                    
            		                <div class="card">
                                        <div class="card-header">
                                            <h5 class="widget-user-username">Deposits</h5>
                                        </div>
                                        <div class="card-body">-->

<?php if(isset($_GET["amsg"])){ echo "<div class='alert alert-success alert-block w-100'>Amount deposited Successfully..!</div>"; } ?>

<?php if(isset($_GET["cmsg"])){ echo "<div class='alert alert-success alert-block w-100'>Cancelled Successfully..!</div>"; } ?>

<?php if(isset($_GET["cancel"])){
        if(isset($_POST["btn_cancel"])){ 
            mysqli_query($conn,"UPDATE aalierp_deposit SET dep_reason='".$_POST["dep_reason"]."', dep_status='Cancel' WHERE dep_id='".$_POST["dep_id"]."' AND user_id='".$_POST["user_id"]."'");
        
            echo "<script>window.location.href = '../deposit/?deposit&cmsg';</script>";
        } 
?>
        
        <form method="post">
            <input type="hidden" name="user_id" value="<?php echo $_GET["usr"]; ?>" />
            <input type="hidden" name="dep_id" value="<?php echo $_GET["cancel"]; ?>" />
            <input type="text" name="dep_reason" placeholder="Enter reason" class="form-control mb-2" />
            <input type="submit" name="btn_cancel" value="Cancel Deposit" class="btn btn-info w-100" />
        </form>
<?php }else{ ?>
            							    
<?php if(isset($_POST["btn_deposit"])){ 
        $date=date("Y-m-d"); 
        $ded=0; $ded = $_POST["user_package_wallet"]*$per["deposit_fee"]/100; 
        $amt=0; $amt=$_POST["user_package_wallet"]-$ded;
        $added=0; $added = $ded+$scash;
        $minus=0; $minus=$user_package_wallet-$_POST["user_package_wallet"];
        $usssr = mysqli_query($conn, "SELECT * FROM aalierp_user WHERE user_id='".$_POST["user_name"]."'"); $uss = mysqli_fetch_assoc($usssr);
        $uwth = 0; $uwth = $amt+$uss["user_cash_wallet"];
        
        if($_POST["user_name"]=="0" || $_POST["user_package_wallet"]==""){echo "<div class='alert alert-warning alert-block'>Fill in all fields..!</div>";}else{
            if($_POST["user_package_wallet"] < $user_package_wallet){
                mysqli_query($conn, "INSERT INTO aalierp_deposit (dep_date,user_id,dep_deduct,dep_amount,dep_reason,dep_status,created_by) VALUES ('".$date."','".$_POST["user_name"]."','".$ded."','".$amt."','".$_POST["dep_reason"]."','Approved','".$user_name."')");
                mysqli_query($conn, "UPDATE aalierp_user SET user_cash_wallet='".$uwth."', user_type='Investor' WHERE user_id='".$_POST["user_name"]."'");
                mysqli_query($conn, "UPDATE aalierp_user SET user_cash_wallet='".$added."' WHERE user_type='Super'");
                mysqli_query($conn, "UPDATE aalierp_user SET user_package_wallet='".$minus."' WHERE user_id='".$user_id."'");
                echo "<script>window.location.href = '../deposit/?deposit&amsg';</script>";
            }else{
                echo "<div class='alert alert-warning alert-block'>Your limit to add amount is over..! Request Finance.</div>";
            }
        }
      }
?>
                                            <form method="post">
                                                
                                                <!--<select class="form-control select2" id="user_id" name="user_name">
                                                    <option value="0">Select User</option>
                                                    <?php $vwuser = mysqli_query($conn, "SELECT * FROM aalierp_user WHERE user_type='User' OR user_type='Investor' AND user_status='Approved'");
                                                        while($uvr = mysqli_fetch_array($vwuser)){ ?>
                                                        <option value="<?php echo $uvr["user_id"]; ?>"><?php echo $cin."".$uvr["user_id"]." [".$uvr["user_name"]."]"; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!--<img src="<?php echo $AaliLINK; ?>/assets/img/loading.gif" id="processing">
                                                <input type="text" name="user_name" id="user_name" class="form-control mb-2" placeholder='User Name' value="" disabled>
                                                <input type="text" name="user_package_wallet" class="form-control mt-2 mb-2" placeholder="Enter Amount" />
                                                <input type="text" name="dep_reason" class="form-control mb-2" placeholder="Any note for deposit.." />
                                                <input type="submit" name="btn_deposit" class="btn btn-info w-100" value="Deposit Amount" />-->

                                            </form>
<?php } ?>
                                        <!--</div>
                                    </div>
                                </div>-->

                            
            	                <div class="col-md-12">
            	                    
            	                    
            	                    
            	                    
            	                    <div class="card mb-2">
                                        <div class="card-header">
                                            <h5 class="widget-user-username">Update Deposit <b class="text-warning">(Pending)</b></h5>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="container py-2">
            							        <table id="table-2" class="table table-striped table-sm table-head-fixed text-nowrap">
                    							    <thead>
                    							      <tr>
                    							        <th>#</th>
                    							        <th>Date</th>
                    							        <th>Users</th>
                    							        <th>Amount</th>
                    							        <th>Slip</th>
                    							        <th>Status</th>
                    							        <th>Action</th>
                    							      </tr>
                    							    </thead>
                    							    <tbody>

<?php $n=1;
	$depquer = mysqli_query($conn,"SELECT d.dep_id,d.dep_date,d.user_id,d.dep_deduct,d.dep_amount,d.dep_slip,d.dep_reason,d.dep_status,u.user_name FROM aalierp_deposit d, aalierp_user u WHERE d.user_id=u.user_id AND d.dep_status='Pending' ORDER BY d.dep_id DESC");
	while($rec = mysqli_fetch_array($depquer)){ ?>
        <tr>
            <td><?php echo $n; ?></td>
        	<td><?php echo $rec["dep_date"]; ?></td>
        	<td><?php echo $rec["user_name"]; ?></td>
        	<td><?php echo $rec["dep_amount"]; ?></td>
        	<td><a href="<?php echo $AaliLINK; ?>/admin/slipview/?slip=<?php echo $rec["dep_id"]; ?>"><img src="../../<?php echo $rec["dep_slip"]; ?>" width="50" height="50" /></a></td>
        	<td><?php echo $rec["dep_status"]; ?></td>
        	<td>
        		<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm">Action</button>
                    <button type="button" class="btn btn-info btn-xs dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                    	<a class="dropdown-item" onclick="return confirm('Are you sure to approve deposit?')" href="?p_id=<?php echo $rec["dep_reason"]; ?>&dep=<?php echo $rec["dep_amount"]; ?>&approve=<?php echo $rec["user_id"]; ?>"> Check & Approve</a>
                        <a class="dropdown-item" href="?cancel=<?php echo $rec["dep_id"]; ?>&usr=<?php echo $rec["user_id"]; ?>"> Cancel Deposit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fa fa-trash text-danger"></i> Delete Deposit</a>
                    </div>
                </div>
        	</td>
        </tr>
<?php $n++; } ?>

            							            </tbody>
            							        </table>
            							    </div>
            						    </div>
            						</div>
            					</div>
            				</div>
            				<div class="row">
            	                <div class="col-md-12">
            	                    <div class="card ">
                                        <div class="card-header">
                                            <h5 class="widget-user-username">Update Deposit <b class="text-success">(Approved)</b></h5>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <?php if(isset($_GET["msg"])){ echo "<div class='alert alert-info alert-block w-100'>Amount deposited Approved Successfully..!</div>"; } ?>
            							    <div class="container py-2">
            							        <table id="table-1" class="table table-striped table-sm table-head-fixed text-nowrap">
                    							    <thead>
                    							      <tr>
                    							        <th>#</th>
                    							        <th>Date</th>
                    							        <th>Users</th>
                    							        <th>Amount</th>
                    							        <th>Status</th>
                    							      </tr>
                    							    </thead>
                    							    <tbody>
<?php $n=1;
	$depquery = mysqli_query($conn,"SELECT * FROM aalierp_deposit WHERE dep_status='Approved' ORDER BY dep_id DESC");
	while($rac = mysqli_fetch_array($depquery)){ 
	    $viewus = mysqli_query($conn, "SELECT * FROM aalierp_user WHERE user_id='".$rac["user_id"]."'"); $uss = mysqli_fetch_assoc($viewus); 
   
?>
        <tr>
            <td><?php echo $n; ?></td>
        	<td><?php echo $rac["dep_date"]; ?></td>
        	<td>
        	    <a href="<?php echo $AaliLINK; ?>/admin/uprofile/?uprofile=<?php echo $rac["user_id"]; ?>" class="text-info">
        	        <?php echo $cin."".$rac["user_id"]." [".$uss["user_name"]."]"; ?>
        	    </a>
        	</td>
        	<td><?php echo $rac["dep_amount"]; ?></td>
        	<td><?php if($rac["dep_reason"] == ""){ echo "User deposited him/herself";}else{ echo $rac["dep_reason"]; } ?></td>
        	<td><?php echo $rac["dep_status"]; ?></td>
        	<td><?php echo $rac["created_by"]; ?></td>
        </tr>
<?php $n++; }  ?>
            							            </tbody>
            							        </table>
            							    </div>
            						    </div>
            						</div>
            	                    
            		                
                            </div>
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




<?php 
    if(isset($_GET["approve"]) && isset($_GET["p_id"])){ 
        $viewusr = mysqli_query($conn, "SELECT * FROM aalierp_user WHERE user_id='".$_GET["approve"]."'"); 
        $usr = mysqli_fetch_assoc($viewusr); 
        $viewpro = mysqli_query($conn, "SELECT * FROM aalierp_product WHERE product_name='".$_GET["p_id"]."'"); 
        $prr = mysqli_fetch_assoc($viewpro);
        mysqli_query($conn,"UPDATE aalierp_deposit SET dep_status='Approved' WHERE dep_status='Pending' AND user_id='".$usr["user_id"]."'");
        mysqli_query($conn,"UPDATE aalierp_cart SET status='Processed' WHERE status='Processing' AND p_id='".$prr["product_id"]."' AND user_id='".$usr["user_id"]."'");
        echo "<script>window.location.href = '../deposit/?deposit&msg';</script>";
    }
    
?>


