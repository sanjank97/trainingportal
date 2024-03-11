<?php 
    session_start();
    if(!isset($_SESSION['admin'])) {
      header("Location:index.php");
    }
    include('../db_connection.php'); 
    if(isset($_POST['admin_login'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $query="select * from users where email='$email' AND password='$password'";
      $result=mysqli_query($con,$query);
      $num=mysqli_num_rows($result);
      if($num > 0) {
        $user=mysqli_fetch_assoc($result);
        $_SESSION['admin']="admin";
        $_SESSION['username']=$user['name'];
        $_SESSION['user_id']=$user['id'];
        header("Location:dashboard.php");
      }
      else {
        $_SESSION['error']="error";
        header("Location:index.php");
      }
    }
    if(isset($_POST['update_profile'])) {
      //profile image
      $image_base64 = $_POST['profile_imagebase64'];
      $profile_image=$_POST['current_profile'];
      if ($image_base64) {
          $image_array_1 = explode(";", $image_base64);
          $image_array_2 = explode(",", $image_array_1[1]);
          $image_base64 = base64_decode($image_array_2[1]);
          $profile_image = 'uploads/'.time() . ".png";
          file_put_contents($profile_image, $image_base64);
          unlink($_POST['current_profile']);
       } 
       $user_id=$_POST['user_id'];
       $name=$_POST['name'];
       $mobile=$_POST['mobile'];
       $role=$_POST['user_role'];
       
       $updated_on=date('Y-m-d H:i:s');
       $query="update users set name='".$name."',mobile='".$mobile."',role='".$role."',image='".$profile_image."',updated_on='".$updated_on."' where id='".$user_id."'";
       $result=mysqli_query($con,$query);
       if($result) {
         $_SESSION['success']="<strong>Success.!</strong> User has been updated.";
         $_SESSION['username']=$_POST['name'];
         header("Location:profile.php");
       }
       else {
        $_SESSION['error']="Something went wrong.Please check connection";
        header("Location:profile.php");
       }
    }
  

    if (isset($_POST['general_setting'])) {

        $marks_per_question = (isset($_POST['marks_per_question']) && $_POST['marks_per_question']!="") ? $_POST['marks_per_question'] : 1;
        $time_per_question  = (isset($_POST['time_per_question']) && $_POST['time_per_question']!="") ? $_POST['time_per_question'] : 1;
        $grandtest_total  = (isset($_POST['grandtest_total']) && $_POST['grandtest_total']!="") ? $_POST['grandtest_total'] : '';

        $query ="update setting set per_marks=$marks_per_question, per_question_time=$time_per_question , grandtest_total=$grandtest_total";
        $result = mysqli_query($con, $query);
         if( $result ) {
          $_SESSION['success']="<strong>Success.!</strong> Saved!.";
          
         }else{
          $_SESSION['error']="Something went wrong.Please check connection";
         }
         header("Location:setting.php");
        
      

    }

?>