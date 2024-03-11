<?php
    include('db_connection.php');
    $stu_id=$_POST['stu_id'];
    $sub_id=$_POST['sub_id'];
    $user_ans=$_POST['user_ans'];
    $total_ques=$_POST['total_ques'];
    $time_taken=$_POST['time'];
    $query="select opcorrect from questions where sub_id=$sub_id";
    $result=mysqli_query($con,$query);
    $num=mysqli_num_rows($result);
  
   $mydata = array();
   $j=0;
    if($num>0)
    {
       while($row=mysqli_fetch_assoc($result))
       {
          $mydata[$j]=$row['opcorrect'];
          $j++;
       }
      
    }
    
    $score=0;
    for($i=0;$i <count($mydata); $i++) 
    {
        if($mydata[$i]== $user_ans[$i])
        {
          $score++;
        }
    }
    $userans=implode(",",$user_ans);
    date_default_timezone_set('Asia/Kolkata');
     $date = date('d-m-Y');
    $query="insert into user_result(stu_id,sub_id,score,total_ques,user_ans,date,time_taken)values('".$stu_id."','".$sub_id."','".$score."','".$total_ques."','".$userans."','".$date."','".$time_taken."')";
    $result=mysqli_query($con,$query);
    $last_id = mysqli_insert_id($con);
    if($result)
    {
        $ansData=array();
        $ansData['ans_msg']= "Congratulation You have Completed Quiz. Your Score : ".$score."/".$total_ques;
        $ansData['last_id']=$last_id;
        echo json_encode($ansData); 
    }

?>