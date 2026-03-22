

<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="<?php echo $AaliLINK; ?>/admin/add-unit/?aut#" type="button" class="btn btn-primary btn-icon icon-left">
                    <i class="fas fa-info"></i> Units <span class="badge badge-transparent count_unit"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/add-catalogue/?act#" type="button" class="btn btn-primary btn-icon icon-left">
                    <i class="fas fa-grid"></i> Categories <span class="badge badge-transparent count_catalogue"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/view-product/?vp#" type="button" class="btn btn-info btn-icon icon-left">
                    <i class="fas fa-shopping-cart"></i> Products <span class="badge badge-transparent count_product"></span>
                </a>
                <!--<a href="<?php echo $AaliLINK; ?>/admin/add-sub-category/?asc#" type="button" class="btn btn-info btn-icon icon-left">
                    <i class="fas fa-gift"></i> Sub Categories <span class="badge badge-transparent count_sub_category"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/add-category/?ac#" type="button" class="btn btn-primary btn-icon icon-left">
                    <i class="fas fa-grid"></i> Categories <span class="badge badge-transparent count_category"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/cart/?cart#" type="button" class="btn btn-info btn-icon icon-left">
                    <i class="fas fa-info"></i> Order Cart <span class="badge badge-transparent order_cart"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/processing/?processing#" type="button" class="btn btn-warning btn-icon icon-left">
                    <i class="fas fa-info"></i> Orders Processing <span class="badge badge-transparent orders_processing"></span>
                </a>
                <a href="<?php echo $AaliLINK; ?>/admin/processed/?processed#" type="button" class="btn btn-success btn-icon icon-left">
                    <i class="fas fa-info"></i> Orders Processed <span class="badge badge-transparent orders_processed"></span>
                </a>-->
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xl-3 col-lg-6">
        <div class="card">
            <div class="card-bg">
                <div class="p-t-20 d-flex justify-content-between">
                    <div class="col">
                        <h6 class="mb-0">Orders Processing</h6>
                        <span class="font-weight-bold mb-0 font-20 orders_processing">0</span>
                    </div>
                    <i class="fas fa-address-card card-icon col-orange font-30 p-r-30"></i>
                </div>
                <canvas id="cardChart1" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card">
            <div class="card-bg">
                <div class="p-t-20 d-flex justify-content-between">
                    <div class="col">
                        <h6 class="mb-0">Revenue</h6>
                        <span class="font-weight-bold mb-0 font-20 total_revenue">0</span>
                    </div>
                    <i class="fas fa-hand-holding-usd card-icon col-cyan font-30 p-r-30"></i>
                </div>
                <canvas id="cardChart4" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card">
            <div class="card-bg">
                <div class="p-t-20 d-flex justify-content-between">
                    <div class="col">
                        <h6 class="mb-0">Growth</h6>
                        <span class="font-weight-bold mb-0 font-20">+00.00%</span>
                    </div>
                    <i class="fas fa-chart-bar card-icon col-indigo font-30 p-r-30"></i>
                </div>
                <canvas id="cardChart3" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card">
            <div class="card-bg">
                <div class="p-t-20 d-flex justify-content-between">
                    <div class="col">
                        <h6 class="mb-0">Total Amounts</h6>
                        <span class="font-weight-bold mb-0 font-20 count_user">0</span>
                    </div>
                    <i class="fas fa-diagnoses card-icon col-green font-30 p-r-30"></i>
                </div>
                <canvas id="cardChart2" height="80"></canvas>
            </div>
        </div>
    </div>
</div>






















<div class="row ">
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-green">
            <div class="card-statistic-3">
                <div class="card-icon card-icon-large"><i class="fa fa-shopping-cart"></i></div>
                <div class="card-content">
                    <h4 class="card-title orders_processed">0</h4>
                    <span>Orders Completed</span>
                    <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-purple" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0 text-sm">
                        <span class="mr-2"><a href="#" style="text-decoration: none; color: white;"><i class="fa fa-thumbs-up"></i> More Info</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-cyan">
            <div class="card-statistic-3">
                <div class="card-icon card-icon-large"><i class="fa fa-credit-card"></i></div>
                <div class="card-content">
                    <h4 class="card-title total_revenue">0</h4>
                    <span>Sales</span>
                    <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0 text-sm">
                        <span class="mr-2"><a href="#" style="text-decoration: none; color: white;"><i class="fa fa-thumbs-up"></i> More Info</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-purple">
            <div class="card-statistic-3">
                <div class="card-icon card-icon-large"><i class="fa fa-shopping-cart"></i></div>
                <div class="card-content">
                    <h4 class="card-title order_cart">0</h4>
                    <span>Orders In Cart</span>
                    <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0 text-sm">
                        <span class="mr-2"><a href="#" style="text-decoration: none; color: white;"><i class="fa fa-thumbs-up"></i> More Info</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-orange">
            <div class="card-statistic-3">
                <div class="card-icon card-icon-large"><i class="fa fa-users"></i></div>
                <div class="card-content">
                    <h4 class="card-title count_users">0</h4>
                    <span>Users</span>
                    <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0 text-sm">
                        <span class="mr-2"><a href="<?php echo $AaliLINK; ?>/admin/users/?ud" style="text-decoration: none; color: white;"><i class="fa fa-thumbs-up"></i> More Info</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>







































