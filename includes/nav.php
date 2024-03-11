

<div class="main-menu-header" style="display:none;">
  <img class="img-80 img-radius" src="<?php echo BASE_URL;?>assets/images/avatar-4.jpg" alt="User-Profile-Image">
  <div class="user-details">
      <span id="more-details"><?php echo isset($_SESSION['employee'])?$_SESSION['employee']:'You' ?><i class="fa fa-caret-down"></i></span>
  </div>
</div>

<div class="main-menu-content">
  <ul>
      <li class="more-details">
          <a href="<?php echo BASE_URL;?>profile.php"><i class="ti-user"></i>View Profile</a>
          <a href="<?php echo BASE_URL;?>logout.php"><i class="ti-layout-sidebar-left"></i>Logout</a>
      </li>
  </ul>
</div>




<ul class="pcoded-item pcoded-left-item">
    <li class="pcoded active" id="li_dashboard" style="margin-top:15px;">
        <a href="<?php echo BASE_URL;?>" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-home"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
    <li class="pcoded" id="li_courses" style="margin-top:15px;">
        <a href="<?php echo BASE_URL;?>courses/all_list.php" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-book"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Courses</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <!-- <ul class="pcoded-submenu">
            <li class=" ">
                <a href="<?php echo BASE_URL;?>courses/list.php" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">List</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul> -->
    </li>
    <li class="pcoded" id="li_score">
        <a href="<?php echo BASE_URL;?>score/list.php" class="waves-effect waves-dark">
          <span class="pcoded-micon"><i class="ti-medall"></i></span>
            <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Score</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li> 
    <li class="pcoded" id="li_grand_test">
        <a href="<?php echo BASE_URL;?>courses/exclusive_test.php" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Grand Test</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
    <li class="pcoded" id="li_profile">
        <a href="<?php echo BASE_URL;?>profile.php" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="ti-user"></i></span>
            <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Profile</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(document).ready(function() {
    let url = window.location.href;
    if (url.match(/courses/)) {
       $('.pcoded').removeClass('active');
       $('#li_courses').addClass('active');
    }
   
    
    if (url.match(/dashboard/)) {
       $('.pcoded').removeClass('active');
       $('#li_dashboard').addClass('active');
    }
  
    if (url.match(/score/)) {
       $('.pcoded').removeClass('active');
       $('#li_score').addClass('active');
    }
    if (url.match(/exclusive_test/)) {
       $('.pcoded').removeClass('active');
       $('#li_grand_test').addClass('active');
    }
    if (url.match(/profile/)) {
       $('.pcoded').removeClass('active');
       $('#li_profile').addClass('active');
    }

});

</script>