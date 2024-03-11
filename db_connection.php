<?php 
date_default_timezone_set('America/Toronto');
$con = mysqli_connect("p3nlmysql179plsk.secureserver.net:3306","trainingportal","!5Rs7q2g9","ph11096940271_training");



//$mysqli = new mysqli("p3nlmysql179plsk.secureserver.net:3306","aaron_new","!5Rs7q2g9","ph11096940271_training");

// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
else{
   // echo "success";
   // die();
}


?>