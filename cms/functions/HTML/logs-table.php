    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0">Today's Logins</h6>
                            <span class="font-weight-bold mb-0">
<?php 
    $count_day = mysqli_query($conn, "SELECT * FROM aalierp_login_detail"); $day=0;
    while($cd = mysqli_fetch_array($count_day)){
        $today = date("d", strtotime(date("Y-m-d")));
        $lday = date("d", strtotime(date($cd["login_date"])));
        if($lday == $today){ $day = $day + 1; }
    }
    echo $day;
?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0">This Month Logins</h6>
                            <span class="font-weight-bold mb-0">
<?php 
    $count_month = mysqli_query($conn, "SELECT * FROM aalierp_login_detail"); $month=0;
    while($cm = mysqli_fetch_array($count_month)){
        $tomonth = date("m", strtotime(date("Y-m-d")));
        $cmonth = date("m", strtotime(date($cm["login_date"])));
        if($cmonth == $tomonth){ $month = $month + 1; }
    }
    echo $month;
?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0">This Years Logins</h6>
                            <span class="font-weight-bold mb-0">
<?php 
    $count_year = mysqli_query($conn, "SELECT * FROM aalierp_login_detail"); $year=0;
    while($cy = mysqli_fetch_array($count_year)){
        $toyear = date("y", strtotime(date("Y-m-d")));
        $cyear = date("y", strtotime(date($cy["login_date"])));
        if($cyear == $toyear){ $year = $year + 1; }
    }
    echo $year;
?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted mb-0">Total Logins</h6>
                            <span class="font-weight-bold mb-0">
<?php 
    $count_total = mysqli_query($conn, "SELECT COUNT(login_date) AS tot FROM aalierp_login_detail"); 
    $tot = mysqli_fetch_assoc($count_total);
    echo $tot["tot"];
?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>View Users Logs </h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                  <tr>
                                    <th class="text-center">#</th>
                                    <th>User Name</th>
                                    <th>User Login</th>
                                    <th>User Logout</th>
                                    <th>User IP</th>
                                    <th>City Login</th>
                                    <th>Country Login</th>
                                  </tr>
                                </thead>
                                <tbody>
<?php $n=1; $view_logs = mysqli_query($conn, "SELECT * FROM aalierp_login_detail ORDER BY id DESC"); while($log = mysqli_fetch_assoc($view_logs)){ ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $log["login_name"]; ?></td>
                                <td><?php echo $log["login_date"]; ?></td>
                                <td><?php echo $log["logout_date"]; ?></td>
                                <td><?php echo $log["login_ip"]; ?></td>
                                <td><?php echo $log["login_city"]; ?></td>
                                <td><?php echo $log["login_country"]; ?></td>
                            </tr>
<?php $n++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
            
            