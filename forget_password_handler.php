<?php 
   session_start();
   include("db_connection.php");
   if(isset($_POST['email']))
   {
    $email=$_POST['email'];
    echo $email;
    $query="select * from user_record where email='".$email."'";
    $result=mysqli_query($con,$query);
    $num=mysqli_num_rows($result);
    
    if($num > 0)
    {
        $rand=mt_rand(999,9999);
        echo $rand;
    
        mail($email,"Your Forget Password Code",$rand);
        $query="update user_record set otp='".$rand."' where email='".$email."'";
        $result=mysqli_query($con,$query);
        if($result)
        {
            $_SESSION['email']=$email;
            header("Location:check_otp.php");
        }
     
       else
       {
           header("Location:forget_password.php");
       }
    }
    else
    {
        $_SESSION['email_error']="Please enter registered email.";

        header("Location:forget_password.php");
    }
   
   }


?>