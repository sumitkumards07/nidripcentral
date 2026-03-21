<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                <span class="badge headerBadge1"> 0 </span> 
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
        </li>
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
                <img alt="image" src="<?php echo $AaliLINK; ?>/assets/img/users/user-1.png" class="user-img-radious-style"> 
                <span class="d-sm-none d-lg-inline-block"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello <?php echo $_SESSION["user_name"]; ?>!</div>
              <a href="#" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile</a> 
              <a href="#" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i> Activities</a> 
              <a href="" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>  Settings </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo $AaliLINK; ?>/config/logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
        </li>
    </ul>
</nav>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="background: linear-gradient(to bottom, #ff2b8a, #6ee28e);">
            <a href="<?php echo $AaliLINK; ?>/admin/dashboard/?-"> 
                <img alt="<?php echo $company_name; ?>" src="<?php echo $AaliLINK; ?>/uploads/logos/<?php echo $company_logo; ?>" class="header-logo img-fluid" style="height:100%;" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown <?php if(isset($_GET["-"])){echo "active";} ?>">
                <a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/dashboard/?-"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown <?php if(isset($_GET["vo"]) || isset($_GET["po"]) || isset($_GET["op"]) || isset($_GET["od"]) || isset($_GET["oc"]) || isset($_GET["or"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="clipboard"></i><span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if(isset($_GET["vo"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/view-orders/?vo#">View Orders</a></li>
                    <li class="<?php if(isset($_GET["po"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/pending-orders/?po#">Pending Orders</a></li>
                    <li class="<?php if(isset($_GET["op"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/orders-in-process/?op#">Orders In Process</a></li>
                    <li class="<?php if(isset($_GET["od"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/orders-delivered/?od#">Orders Delivered</a></li>
                    <li class="<?php if(isset($_GET["oc"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/orders-cancelled/?oc#">Orders Cancelled</a></li>
                    <li class="<?php if(isset($_GET["or"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/orders-rejected/?or#">Orders Rejected</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["ap"]) || isset($_GET["vp"]) || isset($_GET["ai"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-cart"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class=" <?php if(isset($_GET["ap"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-product/?ap#">Add Product</a></li>
                    <li class=" <?php if(isset($_GET["ai"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-image/?ai#">Add Product Images</a></li>
                    <li class=" <?php if(isset($_GET["vp"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/view-product/?vp#">View Products</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["act"]) || isset($_GET["aut"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Settings</span></a>
                <ul class="dropdown-menu">
                    <!--<li class=" <?php if(isset($_GET["ac"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-catalogue/?act#">Add Catalogue</a></li>-->
                    <li class=" <?php if(isset($_GET["ab"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-brand/?ab#">Add Brand</a></li>
                    <li class=" <?php if(isset($_GET["ac"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-category/?ac#">Add Categories</a></li>
                    <li class=" <?php if(isset($_GET["asc"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-sub-category/?asc#">Add Sub Category</a></li>
                    <li class=" <?php if(isset($_GET["aut"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/add-unit/?aut#">Add Unit</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["pg"])){echo "active";} ?>">
                <a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/gateway/?pg"><i data-feather="feather"></i><span>Payment Gateway</span></a>
            </li>
            <li class="dropdown <?php if(isset($_GET["ad"]) || isset($_GET["ed"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Accounts</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if(isset($_GET["ad"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/accounts-detail/?ad#">Accounts Detail</a></li>
                    <li class="<?php if(isset($_GET["ed"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/expenses-detail/?ed#">Expenses Detail</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["deposit"])){echo "active";} ?>">
                <a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/deposit/?deposit"><i data-feather="credit-card"></i><span>Manage Deposits</span></a>
            </li>
            <li class="dropdown <?php if(isset($_GET["pr"]) || isset($_GET["sr"]) || isset($_GET["orp"]) || isset($_GET["rr"]) || isset($_GET["er"]) || isset($_GET["urp"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Reports</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if(isset($_GET["pr"])){echo "active";} ?>"><a class="nav-link " href="#">Products Report</a></li>
                    <li class="<?php if(isset($_GET["sr"])){echo "active";} ?>"><a class="nav-link " href="#">Sales Report</a></li>
                    <li class="<?php if(isset($_GET["orp"])){echo "active";} ?>"><a class="nav-link " href="#">Orders Report</a></li>
                    <li class="<?php if(isset($_GET["rr"])){echo "active";} ?>"><a class="nav-link " href="#">Revenue Report</a></li>
                    <li class="<?php if(isset($_GET["er"])){echo "active";} ?>"><a class="nav-link " href="#">Expenses Report</a></li>
                    <li class="<?php if(isset($_GET["urp"])){echo "active";} ?>"><a class="nav-link " href="#">Customers Report</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["pr"]) || isset($_GET["sr"]) || isset($_GET["orp"]) || isset($_GET["rr"]) || isset($_GET["er"]) || isset($_GET["urp"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Stock Management</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if(isset($_GET["pr"])){echo "active";} ?>"><a class="nav-link " href="#">Add Purchases</a></li>
                    <li class="<?php if(isset($_GET["sr"])){echo "active";} ?>"><a class="nav-link " href="#">Stock Available</a></li>
                    <li class="<?php if(isset($_GET["orp"])){echo "active";} ?>"><a class="nav-link " href="#">Purchases Returns</a></li>
                    <li class="<?php if(isset($_GET["rr"])){echo "active";} ?>"><a class="nav-link " href="#">Sales Returns</a></li>
                    <li class="<?php if(isset($_GET["er"])){echo "active";} ?>"><a class="nav-link " href="#">Stock Damaged</a></li>
                    <li class="<?php if(isset($_GET["urp"])){echo "active";} ?>"><a class="nav-link " href="#">Stock Misplaced</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if(isset($_GET["ud"])){echo "active";} ?>">
                <a class="nav-link" href="#"><i data-feather="truck"></i><span>Shipment </span></a>
            </li>
            <li class="dropdown <?php if(isset($_GET["ud"])){echo "active";} ?>">
                <a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/users/?ud"><i data-feather="users"></i><span>Customers </span></a>
            </li>
            <li class="dropdown <?php if(isset($_GET["lu"])){echo "active";} ?>">
                <a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/logs/?lu#"><i data-feather="grid"></i><span>Users Logs Detail</span></a>
            </li>
            <li class="menu-header">Web Contents</li>
            <li class="dropdown <?php if(isset($_GET["content"]) || isset($_GET["banner"])){echo "active";} ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="globe"></i><span><?php echo $company_name; ?></span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if(isset($_GET["content"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/content/?content">Web Contents</a></li>
                    <li class="<?php if(isset($_GET["banner"])){echo "active";} ?>"><a class="nav-link" href="<?php echo $AaliLINK; ?>/admin/banner/?banner">Main Banner</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>