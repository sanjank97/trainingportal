<?php 
session_start();
if(!isset($_SESSION['admin']))
{
     header("Location:index.php");
}
include('../../db_connection.php');

if(isset($_POST['add_employee']))
{

    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $status=1;
    date_default_timezone_set('America/Toronto');
    $created_on=date('Y-m-d H:i:s');
    $exclusive_test ="";
    if(isset($_POST['exclusive_test']) && $_POST['exclusive_test']!="" ) {
      $exclusive_test =implode(",",$_POST['exclusive_test']);
    }

      $existingEmailCheckQuery = "SELECT COUNT(*) as count FROM employee WHERE email = '$email'";
      $result = mysqli_query($con, $existingEmailCheckQuery);
      if ($result) {
          $row = mysqli_fetch_assoc($result);
          $emailCount = $row['count'];
          if ($emailCount > 0) {
            $_SESSION['error']=" Sorry! Email is already existed!";
            header("Location:list.php");
            exit();
        } 
      }
      
    //Database Insert
    $query ="insert into employee 
    (name,email,password,status,asigned_exlusivetest, created_on) 
    values('$name','$email', '$password','$status','$exclusive_test','$created_on')";


    $result = mysqli_query($con,$query);
    if($result)
    {
      $_SESSION['success']="<strong>Success.!</strong> employee has been added.";
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
  $query="select * from employee where id='". $id."'";
  $result = mysqli_query($con,$query);
  $row = mysqli_fetch_assoc($result);

  $query ="select * from course where course_type=1";
  $exlusive_test_result = mysqli_query($con,$query);
  $exlusive_test_num = mysqli_num_rows($exlusive_test_result); 
 
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
        <div class="form-group form-default">
        <label class="float-label">Password</label>
        <input type="text" name="password" class="form-control" value="'.$row['password'].'" required="">
        <span class="form-bar"></span>
    </div>

       
        <div class="form-group form-default">
        <label class="float-label">Asign To Exclusive Test</label>

        <select class="form-control" id="exclusive_test1" name ="exclusive_test[]" multiple="multiple">';
        
            if ($exlusive_test_num > 0) {
            while($test_row =mysqli_fetch_assoc($exlusive_test_result)) {
                 $selected ="";
                 if (strpos($row['asigned_exlusivetest'], $test_row['course_id']) !== false) {
                  $selected ="selected";
              }

                echo "<option value='".$test_row['course_id']."' $selected>".$test_row['course_title']."</option>";
            }
            
            }
      
       echo '</select>

        <span class="form-bar"></span>
    </div>
      <input type="hidden" name="employee_id" value="'.$id.'" />
      <input type="submit" class="site_btn"  value="Submit" name="update_employee">';

}
//Update course 
if(isset($_POST['update_employee']))
{
 
   $employee_id=$_POST['employee_id'];
   $name=$_POST['name'];
   $email=$_POST['email'];

   $password=$_POST['password'];
   date_default_timezone_set('America/Toronto');
   $updated_on=date('Y-m-d H:i:s');

   $exclusive_test ="";
   if(isset($_POST['exclusive_test']) && $_POST['exclusive_test']!="" ) {
     $exclusive_test =implode(",",$_POST['exclusive_test']);
   }

   $query="update employee set 
   name='".$name."',
   email='".$email."',
   password='".$password."',
   asigned_exlusivetest ='".$exclusive_test."',
   updated_on='".$updated_on."'
   where id='".$employee_id."'";

   $result=mysqli_query($con,$query);
   if($result)
   {
     $_SESSION['success']="<strong>Success.!</strong> Employee has been updated.";
     header("Location:list.php");
   }
   else
   {
    $_SESSION['error']="Something went wrong.Please check connection";
   }
}
// delete Employee
if(isset($_POST['data_delete_id']))
{
  $employee_id=$_POST['data_delete_id'];
  $query="delete from employee where id='".$employee_id."'";
  $result=mysqli_query($con,$query);
  if($result)
  {
    $_SESSION['success']="<strong>Success.!</strong> Employee has been deleted.";
    echo "okay";
  }else{
    $_SESSION['error']="Something went wrong.Please check connection"; 
    echo "okay";
  }
}
//change Employee status
if(isset($_POST['data_status_id']))
{
  $employee_id=$_POST['data_status_id'];
  $query="select status from employee where id='".$employee_id."'";
  $result=mysqli_query($con,$query);
  $row=mysqli_fetch_assoc($result);
  if($row['status']==0)
  {
    $query="update employee set status='1'  where id='".$employee_id."'";
    $result=mysqli_query($con,$query);
    echo "Employee has been activated successfully.";
  
  }
  else
  {
    $query="update employee set status='0'  where id='".$employee_id."'";
    $result=mysqli_query($con,$query);
    echo "Employee has been de-activated successfully.";
 
  }
}

die();

