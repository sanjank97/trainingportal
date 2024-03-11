<?php
session_start();
if (!isset($_SESSION['employee'])) {
  header("Location:index.php");
}
include('db_connection.php');
include('includes/define.php');

//Update course 
if (isset($_POST['update_profile_emp'])) {

  $user_id = $_POST['user_id'];
  $name = $_POST['name'];
  $mobile = $_POST['mobile'];
  //profile image
  $profile_img_path = 'admin/uploads/profile_image/'.$user_id.'/';
  if (!file_exists($profile_img_path)) {
        mkdir($profile_img_path);
  }

  $image_base64 = $_POST['profile_imagebase64'];
  $profile_image = $_POST['current_profile'];
  if ($image_base64) {
    $image_array_1 = explode(";", $image_base64);
    $image_array_2 = explode(",", $image_array_1[1]);
    $image_base64 = base64_decode($image_array_2[1]);
    $profile_image = $profile_img_path . time() . ".png";
    file_put_contents($profile_image, $image_base64);
    //unlink('admin/uploads/'.$_POST['current_profile']);
  }

  $document_path = 'admin/uploads/certificate/'.$user_id.'/';
  if (!file_exists($document_path)) {
        mkdir($document_path);
  }

//dl_files
   $dl = $_POST['current_dl_files'];
  if ($_FILES['dl_files']['size'] != 0) {
    $filetype=$_FILES['dl_files']['type'];
    $filetemp_name=$_FILES['dl_files']['tmp_name'];
    $file_extension=explode("/",$filetype)[1];
    $filename=time().'_dl_'.$_FILES['dl_files']['name'];
    $file_upload_path =$document_path.$filename;
    
    move_uploaded_file($filetemp_name, $file_upload_path);
    unlink($document_path.$dl);
    $dl = $filename;
  }

  $dl_number = $_POST['dl_number'];
  $exp_date_dl =$_POST['exp_date_dl'];

  //sl_files
  $sl = $_POST['current_security_files'];
  if ($_FILES['security_files']['size'] != 0) {

    $filetype=$_FILES['security_files']['type'];
    $filetemp_name=$_FILES['security_files']['tmp_name'];
    $file_extension=explode("/",$filetype)[1];
    $filename = time().'_sl_'.$_FILES['security_files']['name'];
    $file_upload_path =$document_path.$filename;
    move_uploaded_file($filetemp_name, $file_upload_path);
    unlink($document_path.$sl);
    $sl = $filename;
  }

  $sl_number = $_POST['security_number'];
  $exp_date_sl =$_POST['exp_date_security'];

    //cpr_files
    $cpr =  $_POST['current_cpr_files'];
    if ($_FILES['cpr_files']['size'] != 0) {
      $filetype=$_FILES['cpr_files']['type'];
      $filetemp_name=$_FILES['cpr_files']['tmp_name'];
      $file_extension=explode("/",$filetype)[1];
      $filename = time().'_cpr_'.$_FILES['cpr_files']['name'];
      $file_upload_path =$document_path.$filename;
      move_uploaded_file($filetemp_name, $file_upload_path);
      unlink($document_path.$cpr);
      $cpr =  $filename;
    }
  
  $cpr_number = $_POST['cpr_number'];
  $exp_date_cpr =$_POST['exp_date_cpr'];


  $query = "update employee set name='" . $name . "',mobile='" . $mobile . "',profile_img='" . $profile_image . "', driving_license='".$dl."', dl_no='".$dl_number."',dl_expiredate=' $exp_date_dl',security_license ='".$sl."',sl_no='$sl_number',sl_expiredate='$exp_date_sl',cpr_certification='$cpr',cc_expiredate='$exp_date_cpr',cpr_no='$cpr_number', dateofbirth='".$_POST['dob']."' where id='" . $user_id . "'";

  $result = mysqli_query($con, $query);

    if ($result) {
        $_SESSION['success'] = "<strong>Success.!</strong> Profile has been updated.";
        $_SESSION['username'] = $_POST['name'];
        header("Location:profile.php");
    } else {
        $_SESSION['error'] = "Something went wrong.Please check connection";
        header("Location:profile.php");
    }
    } else {
        echo "Sorry wrong input";
    }

