<?php 
  session_start();
  if(isset($_SESSION['admin']))
  {
	  header("Location:dashboard.php");
  }
  include('define.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin - ExamPortal</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="#" type="image/x-icon">
      <!-- Google font-->     
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
      <!-- waves.css -->
      <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    
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
  <body themebg-pattern="theme1" class="auth">

    <section class="login-block ">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                        <form class="md-float-material form-material" action="#" method="post" onsubmit="return validateForm()">
                            <div class="text-center">
                               <img src="../assets/images/logo/logopng.png" style="width:120px;">
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20 login">
                                        <div class="col-md-12">
                                            <h3 class="text-center title">Reset Password</h3>
                                        </div>
                                    </div>
                                    <?php 
                                    if(isset($_SESSION['error']))
                                    {
                                      echo '<p style="color:red"> You entered wromg credentials.!</p>';
                                      unset($_SESSION['error']);
                                    }
                                    ?>
                                   
                                    <div class="form-group form-primary">
                                        <label class="float-label">Password</label>
                                        <input class="form-control" type="password" name="password" id="pass"  onblur="return passwordValidate()">
                                        <i class="fa fa-eye-slash" id="eye"></i>
                                        <span class="form-bar"></span>
                                    </div>
                                     <div class="form-group form-primary">
                                        <label class="float-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="password" id="pass"  onblur="return passwordValidate()">
                                        <i class="fa fa-eye-slash" id="eye"></i>
                                        <span class="form-bar"></span>
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="forgot-phone text-right f-right">
                                                <a href="<?php echo BASE_URL; ?>" class="text-right f-w-600">Log In</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" name="admin_login" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20 theme-btn">Submit</button>
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
                        document.getElementById('pass_err').innerHTML="The Password field is required.";  
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
      
<!-- Required Jquery -->

<!-- i18next.min.js -->

</body>

</html>
