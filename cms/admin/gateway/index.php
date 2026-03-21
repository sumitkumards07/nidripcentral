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
        <title>Payment Gateway | <?php echo $company_name; ?></title>
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
                                <div class="col-md-12">
    <?php 
        if(isset($_POST["btn_update_gateway"])){
            $updatequ = mysqli_query($conn,"UPDATE aalierp_gateway SET gate_title='".$_POST["utitle"]."', gate_name='".$_POST["uname"]."', gate_url='".$_POST["uurl"]."', gate_acc='".$_POST["uacc"]."', gate_iban='".$_POST["uiban"]."', gate_type='".$_POST["utype"]."' WHERE gate_id='".$_POST["uid"]."'");
            if($updatequ){echo "<script>window.location.href = '../gateway/?gateway';</script>";}
        }
        if(isset($_GET["u"])){
            $slectq = mysqli_query($conn,"SELECT * FROM aalierp_gateway WHERE gate_id='".$_GET["u"]."'"); $rec = mysqli_fetch_assoc($slectq); ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Update Payment Gateway</h4>
                                        </div>
                                        <div class="card-body py-2">
                                            <form method="POST">
                                                <input type="hidden" class="form-control mb-2" name="uid" value="<?php echo $rec["gate_id"]; ?>" />
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Update Business:</label>
                                                        <input type="text" class="form-control mb-2" name="utitle" value="<?php echo $rec["gate_title"]; ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Update Bank / eWallet:</label>
                                                        <input type="text" class="form-control mb-2" name="uname" value="<?php echo $rec["gate_name"]; ?>" />
                                                    </div>
                                                  <div class="col-md-3">
                                                        <label>Update URL:</label>
                                                        <input type="text" class="form-control mb-2" name="uurl" value="<?php echo $rec["gate_url"]; ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Update Account:</label>
                                                        <input type="text" class="form-control mb-2" name="uacc" value="<?php echo $rec["gate_acc"]; ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Update IBAN:</label>
                                                        <input type="text" class="form-control mb-2" name="uiban" value="<?php echo $rec["gate_iban"]; ?>" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Update Account Type:</label>
                                                        <select class="form-control mb-2" name="utype">
                                                            <option value="<?php echo $rec["gate_type"]; ?>"><?php echo $rec["gate_type"]; ?> Gateway </option>
                            							    <option value="Deposit">Deposit Gateway </option>
                            							    <option value="Withdraw">Withdraw Gateway </option>
                            							</select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <input type="submit" name="btn_update_gateway" class="btn btn-info btn-block text-white" value="Update Gateway" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                        	    <div class="card">
                        		    <div class="card-header"><h5>Add Gateway</h5></div>
                        			    <div class="card-body">
<?php 
    if(isset($_POST["btn_gateway"])){
        if($_POST["title"] == "" || $_POST["name"] == "" || $_POST["acc"] == "" || $_POST["iban"] == ""){
            echo "<div class='alert alert-info alert-block'>Fill in all the fields..!</div>";
        }else{
            $query = mysqli_query($conn,"INSERT INTO aalierp_gateway (gate_title,gate_name,gate_url,gate_acc,gate_iban,gate_type) VALUES 
            ('".$_POST["title"]."','".$_POST["name"]."','".$_POST["url"]."','".$_POST["acc"]."','".$_POST["iban"]."','".$_POST["type"]."')");
            if($query){echo "<script>window.location.href = '../gateway/?gateway';</script>";}
            
        }
    } 
?>
                        							    
                        							        <form method="POST">
                        							             <input type="text" class="form-control mb-2" name="title" placeholder="Enter Account Title" />
                        							             <input type="text" class="form-control mb-2" name="name" placeholder="Enter Bank Name / eWallet" />
                                                                 <input type="text" class="form-control mb-2" name="url" placeholder="Enter URL" />
                        							             <input type="text" class="form-control mb-2" name="acc" placeholder="Enter Account Number" />
                        							             <input type="text" class="form-control mb-2" name="iban" placeholder="Enter IBAN (if Bank)" />
                        							             <select class="form-control mb-2" name="type">
                        							                 <option value="Deposit">Deposit Gateway </option>
                        							                 <option value="Withdraw">Withdraw Gateway </option>
                        							             </select>
                        							             <input type="submit" class="btn btn-info btn-block mb-2 text-white" name="btn_gateway" value="Add Gateway" />
                        							         </form>
                        							     </div>
                        							 </div>
                        				        </div>
                        					    <div class="col-md-8">
                        							<div class="card">
                        							     <div class="card-header"><h5>Gateway [Deposit & Withdraw]</h5></div>
                        							     <div class="card-body table-responsive p-3">
                        							          <table id="table-1" class="table table-striped table-sm table-head-fixed text-nowrap">
                    							                    <thead>
                    							                        <tr>
                    							                            <th>#</th>  
                    							                            <th>Business</th> 
                    							                            <th>Bank/eWallet</th> 
                                                                            <th>URL</th> 
                    							                            <th>Account Number</th> 
                    							                            <th>IBAN (Bank)</th> 
                    							                            <th>Type</th>
                    							                            <th>Action</th>
                    							                        </tr>
                    							                    </thead>
                    							                    <tbody>
<?php 
    $view = mysqli_query($conn,"SELECT * FROM aalierp_gateway"); $n=1; while($row = mysqli_fetch_array($view)){ ?>
                                                                        <tr>
                                                                            <td><?php echo $n; ?></td>
                                                                            <td><?php echo $row["gate_title"]; ?></td>
                                                                            <td><?php echo $row["gate_name"]; ?></td>
                                                                            <td><?php echo $row["gate_url"]; ?></td>
                                                                            <td><?php echo $row["gate_acc"]; ?></td>
                                                                            <td><?php echo $row["gate_iban"]; ?></td>
                                                                            <td><?php echo $row["gate_type"]; echo " Gateway"; ?></td>
                                                                            <td>
                                                                                <a href="?u=<?php echo $row["gate_id"]; ?>" class="btn btn-info btn-sm btn-block text-white">Update</a>
                                                                            </td>
                                                                        </tr>
<?php $n++; } ?>
                    							                    </tbody>
                							                    </table>
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


