<?php 
    session_start();
    include('db_connection.php');
	if (isset($_POST['user_login'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$query ="select * from employee where email='$email' AND password='$password'"; 
		$result = mysqli_query($con,$query);
		$num = mysqli_num_rows($result);
		if ($num>0)	{
			$row=mysqli_fetch_assoc($result);
			if ($row['status'] == 1) {
				$_SESSION['employee']=$row['name'];
				$_SESSION['employee_id']=$row['id'];
				$query ="update employee set last_login ='".date('Y-m-d H:i:s')."' WHERE id=".$row['id'];
				
				$result = mysqli_query($con,$query);
				header("Location:dashboard.php");
			}else{  
				$_SESSION['error'] ='Please contact with administrator.';
				header("Location:index.php");
			}
			
		}else {
			$_SESSION['error'] ='Invalid email or password. Please try again.';
			header("Location:index.php");
		}
	}
	




?>