
<?php
     include '../includes/header_top.php';
     include('../../db_connection.php');
     include('../includes/define.php');
     if (!isset($_GET['employee_id']) || $_GET['employee_id'] =="") {
        header('Location:list.php');
     }
     $user_id = $_GET['employee_id'];
     $query="select * from employee where id = $user_id";
     $result=mysqli_query($con,$query);
     $row = mysqli_fetch_assoc($result);
     $currentDate = strtotime(date("Y-m-d"));


?>
 <style>
    .pdfpreview{
        list-style:underline;
        color:blue;
        display: block;
    }
 </style>
  <div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
          <?php
            include '../includes/header.php';
          ?>
          <div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                  <nav class="pcoded-navbar">
                      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                      <div class="pcoded-inner-navbar main-menu">
                            <?php
                                include '../includes/nav.php';
                            ?>
                      </div>
                      
                  </nav>
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      
                    <?php
                      include '../includes/dashboard.php';
                    ?>

                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                           
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="card">

                                    <div class="card-header wrap_back_button_header">
                                        <h5>Profile</h5>
                                        <div class="wrap_back_button">
                                            <button onclick="history.back()">Back</button>
                                        </div>
                                    </div>

                                    <div class="card-block">

                                     

                                        <form class="form-material" action="#" method="POST" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" class="form-control" readonly name="name" placeholder="Enter your Name" value="<?php echo $row['name']; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Mobile</label>
                                                    <input type="text" readonly class="form-control" name="mobile" placeholder="Enter mobile no." value="<?php echo $row['mobile']; ?>">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Driving license</label>
                                                    <?php
                                                        if(isset($row['driving_license']) && !empty( $row['driving_license'] )){
                                                            echo '<a class="pdfpreview" href="'.THEME_ASSET . 'certificate/' . $user_id . '/' . $row['driving_license'].'" target="_blank">
                                                                Preview
                                                            </a>';
                                                        }
                                                    ?>
                                                  
                                                    <input type="hidden" name="dl_files" class="form-control">
                                                    <input type="hidden" name="current_dl_files" value="<?php echo $row['driving_license']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Driving license Number</label>
                                                    <input type="text" readonly name="dl_number" class="form-control" value="<?php echo $row['dl_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                <?php   
                                                        $expired ="";
                                                        if ( isset($row['dl_expiredate'])) {                                                   
                                                            $expired =($currentDate > strtotime($row['dl_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                        }
                                                        echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    
                                                    <input type="text" readonly name="exp_date_dl" class="form-control" value="<?php echo $row['dl_expiredate']; ?>">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Security license</label>
                                                    <?php
                                                        if(isset($row['security_license']) && !empty( $row['security_license'] )){
                                                            echo '<a class="pdfpreview" href="'.THEME_ASSET . 'certificate/' . $user_id . '/' . $row['security_license'].'" target="_blank">
                                                                Preview
                                                            </a>';
                                                        }
                                                    ?>

                                                    
                                                    <input type="hidden" name="security_files" class="form-control">
                                                    <input type="hidden" name="current_security_files" value="<?php echo $row['security_license']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Security license Number</label>
                                                    <input type="text" readonly name="security_number" class="form-control" value="<?php echo $row['sl_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <?php  
                                                      $expired ="";
                                                      if ( isset($row['sl_expiredate'])) {                                                  
                                                      $expired =($currentDate > strtotime($row['sl_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                      }
                                                      echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    
                                                    <input type="text" readonly name="exp_date_security" class="form-control" value="<?php echo $row['sl_expiredate']; ?>">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">CPR Certification</label>
                                                    <?php
                                                
                                                    if(isset($row['cpr_certification']) && !empty( $row['cpr_certification'] )){
                                                        echo '<a class="pdfpreview" href="'.THEME_ASSET . 'certificate/' . $user_id . '/' . $row['cpr_certification'].'" target="_blank">
                                                            Preview
                                                        </a>';
                                                    }
                                                    ?>  
                                                    
                                                    <input type="hidden" name="cpr_files" class="form-control">
                                                    <input type="hidden" name="current_cpr_files" value="<?php echo $row['cpr_certification']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">CPR Certification Number</label>
                                                    <input type="text" readonly name="cpr_number" class="form-control" value="<?php echo $row['cpr_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                   <?php  
                                                      $expired ="";
                                                      if ( isset($row['cc_expiredate'])) {
                                                        $expired =($currentDate > strtotime($row['cc_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                      }                                                 
                                                     
                                                      echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    <input type="text" readonly name="exp_date_cpr" class="form-control" value="<?php echo $row['cc_expiredate']; ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" name="profile_imagebase64" class="profile_imagebase64">
                                            <input type="hidden" name="current_profile" value="<?php echo $row['profile_img'] ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">


                                            <!-- <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="submit" class="site_btn" value="Submit" name="update_profile_emp" style="margin-top:30px;">
                                                </div>
                                            </div> -->
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                            
                            <!-- Main-body end -->

                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


<?php
include '../includes/footer.php';
?>