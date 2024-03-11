<nav class="navbar header-navbar pcoded-header">
<div class="navbar-wrapper">
    <div class="navbar-logo">
        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
            <i class="ti-menu"></i>
        </a>
        <div class="mobile-search waves-effect waves-light">
            <div class="header-search">
                <div class="main-search morphsearch-search">
                    <div class="input-group">
                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                        <input type="text" class="form-control" placeholder="Enter Keyword">
                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" style="color:#fff; ">
            <img src="<?php echo BASE_URL;?>/assets/images/logo/logopng.png" style="width:50px;">
            Training Portal
        </div>
        <a class="mobile-options waves-effect waves-light">
            <i class="ti-more"></i>
        </a>
    </div>

    <div class="navbar-container container-fluid">
        <ul class="nav-left">
            <li>
                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
            </li>
            <li class="header-search">
                <div class="main-search morphsearch-search">
                    <div class="input-group">
                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                    </div>
                </div>
            </li>
            <li>
                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                    <i class="ti-fullscreen"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
            <!-- <li class="header-notification">
                <a href="#!" class="waves-effect waves-light">
                    <i class="ti-bell"></i>
                    <span class="badge bg-c-red"></span>
                </a>
                <ul class="show-notification">
                    <li>
                        <h6>Notifications</h6>
                        <label class="label label-danger">New</label>
                    </li>
                </ul>
            </li> -->
            <li class="user-profile header-notification">
                <a href="#!" class="waves-effect waves-light">
                   
                    <span><?php echo isset($_SESSION['employee'])?$_SESSION['employee']:'You' ?></span>
                    <i class="ti-angle-down"></i>
                </a>
                <ul class="show-notification profile-notification">
                    <li class="waves-effect waves-light">
                        <a href="<?php echo BASE_URL;?>profile.php">
                            <i class="ti-user"></i> Profile
                        </a>
                    </li>
                    <li class="waves-effect waves-light">
                        <a href="<?php echo BASE_URL;?>logout.php">
                            <i class="ti-layout-sidebar-left"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</nav>