<?php 
$con = mysqli_connect("50.62.209.186:3306","u508465154_aaron","Aaron@1996","u508465154_aaron");
// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}


?>