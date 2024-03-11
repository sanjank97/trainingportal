<?php
    session_start();
    include('db_connection.php');
    if(isset($_SESSION["user"]))
    {
        header("Location:test_subject.php");
    }
    if(!isset($_POST['fname']))
    {
        header("Location:registration.php");
    }
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $user_post="";
    foreach ($_POST['user_post'] as $ele)
    {
        if($user_post != "")
        {
            $user_post=$user_post.",".$ele;
        }
        else
        {
            $user_post=$user_post.$ele;
        }
      
    }
    $query1="select email from user_record where email='$email'";
    $result1=mysqli_query($con,$query1);
    $num=mysqli_num_rows($result1);
    if($num > 0)
    {
        $_SESSION['error']="error";
        header("Location:registration.php");
    }
    else
    {
        $query="insert into user_record(fname,lname,email,password,phone,user_post,status) values('$fname','$lname','$email','$password','$phone','$user_post',1)";
        echo $query;
        $result=mysqli_query($con,$query);
        if($result)
        {
            mail($email,"My subject","hiii");
            $_SESSION['status']="status";
            header("Location:registration.php");
        }
        else
        {
              echo "failed";
        }

    }



?>