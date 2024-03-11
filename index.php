
<?php

    session_start();
    if(isset($_SESSION["employee"]))
    {
        header("Location:dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <title>Login </title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <link rel="icon" href="assets/images/android-chrome-192x192.png" type="image/x-icon"> 
        <link rel="icon" href="assets/images/android-chrome-512x512.png" type="image/x-icon"> 
        <link rel="icon" href="assets/images/apple-touch-icon.png" type="image/x-icon"> 
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
        <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <script>
            window.localStorage.clear();
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  </head>
  <style>
    .login{
    text-align: center;
    font-size: 16px;
    color: #000;
    margin: 0;
    }    
    .form-material .form-group{
    margin-bottom: 10px;
    }
    .title{
    font-weight: 500;
    }
    .text-danger{
    color: #ff5252 !important;
    font-size: 13px;
    display: block;
    margin-bottom: 10px;
    }
    #eye {
    position: absolute;
    right: 10px;
    color: #002a3a;
    top: 60%;
    }
  </style>
  <body themebg-pattern="theme1">
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                        <form action="user_login_handler.php" class="md-float-material form-material" method="post" onsubmit="return validateForm()">
                            
                            
                            <div class="text-center">
                               <img src="assets/images/logo/logopng.png" style="width:120px;">
                            </div>
                            
                            
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12 text-center" >
                                            <h3 >Login</h3>
                                            <?php 
                                            if(isset($_SESSION['error']))
                                            {
                                                echo '<p style="color:red; margin:15px 0 0">'.$_SESSION['error'].'</p>';
                                                unset($_SESSION['error']);
                                            }
                                            ?>
                                        </div>
                                      
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">Your Email Address</label>
                                        <input type="text" name="email" class="form-control" required="">
                                        <span class="form-bar"></span>
                                       
                                    </div>
                                    <div class="form-group form-primary">
                                       <label class="float-label">Password</label>
                                        <input type="password" name="password" id="pass" class="form-control" required="">
                                        <span class="form-bar"></span>
                                        <i class="fa fa-eye-slash" id="eye"></i>
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="row m-t-25 text-left" style="display:none;">
                                        <div class="col-12">
                                            <div class="forgot-phone text-right f-right">
                                                <a href="forgetpassword.php" class="text-right f-w-600"> Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <input type="submit" name="user_login"  class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" value="Sign in">
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
        <script>
                function emailValidate()
                  {
                      var email=document.getElementById('email').value;
                      
                      var regex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                      if(email=="")
                      {
                        document.getElementById('email_err').innerHTML="The Email Id field is required.";  
                        return false;
                      }
                      else if(regex.test(email)==false)
                      {
                        document.getElementById('email_err').innerHTML="Please Enter Valid Email Id.";  
                        return false;
                      }
                      else
                      {
                        document.getElementById('email_err').innerHTML="";  
                        return true;
                      }
                  }  
                  function passwordValidate()
                  {
                    var pass=document.getElementById('pass').value;
                      if(pass=="")
                      {
                        document.getElementById('pass_err').innerHTML="The Password field is required";  
                        return false;
                      }
                      else if(pass.length<6)
                      {
                        document.getElementById('pass_err').innerHTML="please enter password of length atleast 6.";
                        return false;
                      }
                      else
                      {
                        document.getElementById('pass_err').innerHTML="";  
                        return true;
                      }
                  }
                  function validateForm()
                   {
                    var email_validation= emailValidate(); 
                    var password_validation= passwordValidate(); 
                    
                    if(email_validation==false ||password_validation==false)
                    {
                        return false;
                    }
                  }
        </script>    
<script type="text/javascript">
$(function(){
  $('#eye').click(function(){
       
        if($(this).hasClass('fa-eye-slash')){
           
          $(this).removeClass('fa-eye-slash');
          
          $(this).addClass('fa-eye');
          
          $('#pass').attr('type','text');
            
        }else{
         
          $(this).removeClass('fa-eye');
          
          $(this).addClass('fa-eye-slash');  
          
          $('#pass').attr('type','password');
        }
    });
});
</script>   
<script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>     
<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>   
<script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>     
<script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
<script src="assets/pages/waves/js/waves.min.js"></script>
<script type="text/javascript" src="assets/js/common-pages.js"></script>
</body>

</html>









