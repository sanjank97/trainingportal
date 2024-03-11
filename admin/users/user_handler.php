<?php 
session_start();
if(!isset($_SESSION['admin']))
{
     header("Location:index.php");
}
include('../../db_connection.php');

if(isset($_POST['add_user']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $mobile=$_POST['mobile'];
    $user_role=$_POST['user_role'];
    $status=1;
    date_default_timezone_set('America/Toronto');
    $created_on=date('Y-m-d H:i:s');
    //Database Insert
    $query ="insert into users (name,email,password,mobile,role,status,created_on) values('$name','$email', '$password','$mobile','$user_role','$status','$created_on')";
    $result = mysqli_query($con,$query);
    if($result)
    {
      $_SESSION['success']="<strong>Success.!</strong> user has been added.";
      header("Location:list.php");
    }
    else
    {
      $_SESSION['error']="Something went wrong.Please check connection";
      header("Location:list.php");
    }

}
//Edit course section
if(isset($_POST['data_edit_id']))
{



  $id=$_POST['data_edit_id'];
  $query="select name,email,role,mobile,password from users where id='". $id."'";
  $result = mysqli_query($con,$query);
  $row = mysqli_fetch_assoc($result);

  $query="select role,role_id from user_role";
  $result=mysqli_query($con,$query);
  $user_role=mysqli_fetch_all ($result, MYSQLI_ASSOC);

  echo '<div class="form-group form-default">
            <label class="float-label">Name</label>
            <input type="text" name="name" class="form-control" value="'.$row['name'].'" required="">
            <span class="form-bar"></span>
        </div>
        <div class="form-group form-default">
            <label class="float-label">Email</label>
            <input type="email" name="email" class="form-control" value="'.$row['email'].'" required="">
            <span class="form-bar"></span>
        </div>
        <div class="form-group form-default pass_eye">
          <label class="float-label">Password</label>
          <input type="password" name="password" class="form-control" id="pass" value="'.$row['password'].'" required="">
          <i class="fa fa-eye-slash" id="eye"></i>
          <span class="form-bar"></span>
        </div>
        <input type="hidden" name="user_role" value="1">
        <div class="form-group form-default">
            <label class="float-label">Mobile No.</label>
            <input type="text" name="mobile" maxlength="10" class="form-control" value="'.$row['mobile'].'" required="">
            <span class="form-bar"></span>
        </div>
        <input type="hidden" name="user_id" value="'.$id.'" />
        <input type="submit" class="site_btn"  value="Submit" name="update_user">';

}
//Update user 
if(isset($_POST['update_user']))
{
   $user_id=$_POST['user_id'];
   $name=$_POST['name'];
   $email=$_POST['email'];
   $mobile=$_POST['mobile'];
   $password=$_POST['password'];
   $role=$_POST['user_role'];
   date_default_timezone_set('America/Toronto');
   $updated_on=date('Y-m-d H:i:s');
   $query="update users set name='".$name."', password='".$password."', email='".$email."',mobile='".$mobile."',role='".$role."',updated_on='".$updated_on."' where id='".$user_id."'";
   $result=mysqli_query($con,$query);
   if($result)
   {
     $_SESSION['success']="<strong>Success.!</strong> User has been updated.";
     header("Location:list.php");
   }
   else
   {
    $_SESSION['error']="Something went wrong.Please check connection";
   }
}
// delete user
if(isset($_POST['data_delete_id']))
{
  $user_id=$_POST['data_delete_id'];
  $query="delete from users where id='".$user_id."' AND id <> 2";
  $result=mysqli_query($con,$query);
  if($result)
  {
    $_SESSION['success']="<strong>Success.!</strong> User has been deleted.";
    echo "okay";
  }
  else{
    $_SESSION['error']="Something went wrong.Please check connection";
    echo "okay";
  }
}
//change user status
if(isset($_POST['data_status_id']))
{
  $user_id=$_POST['data_status_id'];
  $query="select status from users where id='".$user_id."'";
  $result=mysqli_query($con,$query);
  $row=mysqli_fetch_assoc($result);
  if($row['status']==0)
  {
    $query="update users set status='1'  where id='".$user_id."' AND id <> 2";
    $result=mysqli_query($con,$query);
    echo "User has been activated successfully.";
  }
  else
  {
    $query="update users set status='0'  where id='".$user_id."' AND id <> 2";
    $result=mysqli_query($con,$query);
    echo "User has been de-activated successfully.";
 
  }
}
?>