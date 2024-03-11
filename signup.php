<!-- 
<?php 
  session_start();
  if(isset($_SESSION["user"]))
  {
	  header("Location:test_subject.php");
  }
?>
<!DOCTYPE html>
<html>
     <head>
		<title>User Login</title>
		<meta charset="UTF-8">
		<meta name="description" content="Free Web tutorials">
		<meta name="keywords" content="HTML, CSS, JavaScript">
		<meta name="author" content="John Doe">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
     	  <style>
			body{
				padding-top:50px;
			}   
            form div{
            	margin-top:20px;
            }
			  .main{
				 
				width:30%;
				margin:0 auto;
				border: 1px solid #FF9800;
				padding-left: 20px;
				padding-bottom: 20px;
				border-radius: 4px;
              }
			  label{
				  color: #EF6C00;
			  }
			  ::placeholder{
               color: #EF6C00;
			  }
		     .email input{
				padding: 8px;
				margin-left: 24px;
				border: 1px solid #FF9800;
				border-radius: 3px;
				width:60%;
				
			  }
			
			  .password input{
				padding: 8px;
				margin-left: 27px;
				border: 1px solid #FF9800;
				border-radius: 3px;
				width:60%
			  }
			  .submit input{
				padding: 8px 35px;
				margin-left: 0px;
				border: 1px solid #FF9800;
				border-radius: 3px;
				background: #f57c00;
				color:#fff;
			  }
			  input:focus{
				
				outline:none;
				border: 2px solid #FF9800;
				border-radius: 3px;
			  }
			  form span{
				  margin-left:94px;
				  color:red;
				  font-size:14px;
			  }
			  .submit input:hover{
				  background:#ef6c00;
			  }
			  #create{
				margin-left:20px; 
				color: #EF6C00; 
				text-decoration:none;
			  }
			  #create:hover{
                color:#e65100;
			  }
			@media only screen and (max-width:576px) {
			.main{
				width:100%;
			}
			}
			@media only screen and (max-width:992px) {
			.main{
				width:70%;
			}
			}
			@media only screen and (max-width:1200px) {
			.main{
				width:50%;
			}
			}
			
			
		
     	  </style>
     </head>	
     <body>
		 <div class="main">
			<div><h2>User Login</h2></div>
			<?php 
				if(isset($_SESSION['error']))
				{
					?>
					 <p style="color:red"> You entered wromg credentials.!</p>
					<?php
					unset($_SESSION['error']);
				}
			?>
			<?php 
				if(isset($_SESSION['status_error']))
				{
					?>
					 <p style="color:red">Sorry Admin site Issue Please Try After Sometimes Thank You.!</p>
					<?php
					unset($_SESSION['status_error']);
				}
			?>
			<?php 
				if(isset($_SESSION['psw']))
				{
					?>
					 <p style="color:green">Password Updated successfully.!</p>
					<?php
					unset($_SESSION['psw']);
				}
			?>
			<form action="user_login_handler.php" method="post" onsubmit="return validateForm()">
			<div class="email">
				<label>Username 222</label>
				<input type="text" name="email" id="email" placeholder="Enter Email" onblur="return emailValidate()" >
			</div>
			<span id="email_err"></span>	
			<div class="password">
				<label>Password</label>
				<input type="password" name="password" id="pass" Placeholder="Enter Password" onblur="return passwordValidate()">
			</div>	
			<span id="pass_err"></span>
			<div class="submit">
				<input type="submit" value="submit">
				<a id="create" href="forget_password.php">Forget Password</a>
				<a id="create" href="registration.php">Create Account?</a>
			</div>

			</form>
		</div>
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
     	 
     </body>	
</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
      <title>Login </title>
      <meta charset="utf-8">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
      <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
      <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
      <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  </head>
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
               <?php 
                 if(isset($_SESSION['status']))
                 {
                     ?>
                     <p style="color:green">You have registered successfully..!</p>
                     <?php
                     unset($_SESSION['status']);
                 }
                 if(isset($_SESSION['error']))
                 {
                    ?>
                     <p style="color:red">Error :: This Email Id already Exist.</p>
                     <?php
                     unset($_SESSION['error']);  
                 }
              ?>
                   <form action="user_registration.php" class="md-float-material form-material" method="post" onsubmit="return validateForm()" >
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Sign up</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <!-- <input type="text" name="user-name" class="form-control" required=""> -->
                                     <input type="text" name="fname" class="form-control" placeholder="First Name" id="fname" onblur="return fnameValidate()" >
                                    <span class="form-bar"></span>
                                    <label class="float-label">First Name</label>
                                </div>
                                <div class="form-group form-primary">
                                    <!-- <input type="text" name="user-name" class="form-control" required=""> -->
                                      <input type="text" name="lname"  class="form-control"  placeholder="Last Name" id="lname" onblur="return lnameValidate()">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Last Name</label>
                                </div>
                                <div class="form-group form-primary">
                                    <!-- <input type="text" name="email" class="form-control" required=""> -->
                                  
                                     <input type="text" name="email"  class="form-control"  placeholder="Email Id" id="email" onblur="return emailValidate()">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Your Email Address</label>
                                </div>

                                <div class="form-group form-primary">
                                    <!-- <input type="text" name="user-name" class="form-control" required=""> -->
                                      <input type="text"  class="form-control"  name="phone" placeholder="Phone No." id="phone" onblur="return phoneValidate()">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Phone No</label>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <!-- <input type="password" name="password" class="form-control" required=""> -->
                                             <input type="password"  class="form-control"  name="password" placeholder="Password" id='pass' onblur="return passwordValidate()">
                                            <span class="form-bar"></span>
                                            <label class="float-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-primary">
                                            <!-- <input type="password" name="confirm-password" class="form-control" required=""> -->
                                            <input type="password"  class="form-control"  name="re_password" placeholder="Re-password" id='repass' onblur="return repassValidate()" >
                                            <span class="form-bar"></span>
                                            <label class="float-label">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row m-t-25 text-left">
                                    <div class="col-md-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" value="">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">I read and accept <a href="#">Terms &amp; Conditions.</a></span>
                                            </label>
                                        </div>
                                    </div>
                  
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left"><a href="index.php"><b>Sign In</b></a></p>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <script>
     function fnameValidate()
                  {
                    var x =document.getElementById('fname');
                    var fname=document.getElementById('fname').value;
                    var regex = /^[A-Za-z]+$/;
                      if(fname=="")
                      {
                        document.getElementById('fname_err').innerHTML="The First Name field is required.";  
                        return false;
                      }
                      else if(fname.length<3)
                      {
                        document.getElementById('fname_err').innerHTML="please enter name of length atleast 3.";
                        return false;
                      }
                      else if(regex.test(fname)==false)
                      {
                        document.getElementById('fname_err').innerHTML="Please Enter Only alphabet space not allowed.";  
                        return false;
                      }
                      else
                      {
                        x.value=fname.replace(/\b\w/g, l => l.toUpperCase());  
                        document.getElementById('fname_err').innerHTML="";  
                        return true;
                      }
                  }
                  function lnameValidate()
                  {
                    var x =document.getElementById('lname');
                    var lname=document.getElementById('lname').value;
                    var regex = /^[A-Za-z]+$/;
                      if(lname=="")
                      {
                        document.getElementById('lname_err').innerHTML="The Last Name field is required.";  
                        return false;
                      }
                      else if(lname.length<3)
                      {
                        document.getElementById('lname_err').innerHTML="please enter name of length atleast 3.";
                        return false;
                      }
                      else if(regex.test(lname)==false)
                      {
                        document.getElementById('lname_err').innerHTML="Please Enter Only alphabet space not allowed.";  
                        return false;
                      }
                      else
                      {
                        x.value=lname.replace(/\b\w/g, l => l.toUpperCase()); 
                        document.getElementById('lname_err').innerHTML="";  
                        return true;
                      }
                  }
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
                  function repassValidate()
                  {
                    var pass=document.getElementById('pass').value;
                    var repass=document.getElementById('repass').value;
                    if(repass=="")
                      {
                        document.getElementById('repass_err').innerHTML="The repassword field is required.";  
                        return false;
                      }
                      else if(repass.length<6)
                      {
                        document.getElementById('repass_err').innerHTML="please enter repassword of length atleast 6.";
                        return false;
                      }
                      else if(repass != pass)
                      {
                        document.getElementById('repass_err').innerHTML="Password mis-matched try again.";
                        return false;
                      }
                      else
                      {
                        document.getElementById('repass_err').innerHTML="";  
                        return true;
                      }

                  }
                  function phoneValidate()
                  {
                    var phone=document.getElementById('phone').value;
                    var regex =/^(1\s|1|)?((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{4})$/;
                      if(phone=="")
                      {
                        document.getElementById('phone_err').innerHTML="The Phone field is required.";  
                        return false;
                      }
                      else if(regex.test(phone)==false)
                      {
                        document.getElementById('phone_err').innerHTML="Please Enter Valid phone number.";  
                        return false;
                      }
                      else
                      {
                        document.getElementById('phone_err').innerHTML="";  
                        return true;
                      }
                  }
                  function postValidate()
                  {
                      var user_post=document.getElementById('user_post').value;
                      if(user_post=="")
                      {
                         document.getElementById('user_post_err').innerHTML="The User Post field is required";
                          return false;
                      }
                      else
                      {
                          document.getElementById('user_post_err').innerHTML="";
                          return true;
                      }
                  }
                 
                  function validateForm()
                  {
                    var fname_validation= fnameValidate(); 
                    var lname_validation= lnameValidate(); 
                    var email_validation= emailValidate(); 
                    var password_validation= passwordValidate(); 
                    var repass_validation= repassValidate(); 
                    var phone_validation= phoneValidate();
                    var post_validation= postValidate();
                    if(fname_validation==false ||lname_validation==false ||email_validation==false ||password_validation==false
                    ||repass_validation==false ||post_validation==false)
                    {
                        return false;
                    }
                  }


            </script>
<script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>     
<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>   
<script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>     
<script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
<script src="assets/pages/waves/js/waves.min.js"></script>


<script type="text/javascript" src="assets/js/common-pages.js"></script>
</body>

</html>









