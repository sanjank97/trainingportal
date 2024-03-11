<?php 
    date_default_timezone_set('America/Toronto');
    session_start();
   
   include('../db_connection.php');
   include('../define.php');

   if (isset($_POST['start_test'])) {
      $course_id = $_POST['course_id'];
      $question_appearance =  $_POST['question_appearance'];
      $query = "SELECT id FROM question WHERE course_id = '$course_id' AND question_appearance ='$question_appearance'";
      $result = mysqli_query($con, $query);
      $total_question =mysqli_num_rows($result);
      
      $total_time = convertToHoursMins($total_question, '%02d:%02d'); 
      $employee_id = $_POST['employee_id'];
      date_default_timezone_set('America/Toronto');
      $start_time = date('H:i:s');
      $created_on = date('Y-m-d H:i:s');    
      $status = "failed";
      $query = "INSERT INTO test (course_id,total_questions, subcourse_id, employee_id, start_time, status, total_time, created_on) VALUES('$course_id','$total_question', '$question_appearance', $employee_id, '$start_time', '$status', '$total_time', '$created_on')";
      $result = mysqli_query($con, $query); 
      if($result) {
         $last_id = mysqli_insert_id($con);
         $_SESSION['course_id']             = $course_id;
         $_SESSION['question_appearance']   = $question_appearance;
         $_SESSION['test_session_id']       = $last_id;
         header("Location :test.php");
      }else{
        header("Location :all_list.php");
      }
   }

   //Final submit 
   if(isset($_POST['end_test'])) {
      
        $course_id           = $_POST['course_id'];
        $question_appearance = $_POST['question_appearance'];
        $employee_id         = $_POST['employee_id'];
        $emp_ans             = $_POST['emp_ans'];
        $total_ques          =  $_POST['total_ques'];
        $time_taken          = $_POST['time_taken'];
        $id                  = $_SESSION['test_session_id'];
        $status = "completed";
        date_default_timezone_set('America/Toronto');
        $end_time =  date('H:i:s');
        $updated_on = date('Y-m-d H:i:s');

        $query="SELECT correct_ans FROM question where course_id = '$course_id' AND question_appearance='$question_appearance'";
  
        
        $result=mysqli_query($con,$query);
        $num=mysqli_num_rows($result);

      
        $mydata = array();
        $j=0;
        if ($num > 0) {
            while ($row=mysqli_fetch_assoc($result)) {
                $mydata[$j]=$row['correct_ans'];
                $j++;
            }

        }


        $score=0;
        for ($i=0; $i < count($mydata); $i++)  {
            if ($mydata[$i]== $emp_ans[$i]) {
             $score++;
            }
        }

        
        $query ="select * from setting";
        $setting_result = mysqli_query($con,$query);
        $setting_row   = mysqli_fetch_assoc($setting_result);
        $mark          = $setting_row['per_marks'];
     


        $query = "UPDATE test SET end_time='$end_time', status='$status', total_questions=$total_ques, mark=$mark, correct_question=$score, taken_time='$time_taken', updated_on ='$updated_on' WHERE id =$id ";
        $result = mysqli_query($con, $query);
        if($result) {
           $data =array(
             'test_id' =>$_SESSION['test_session_id'],
             'status' =>'status'
           );
          unset($_SESSION['test_session_id']);  
          echo json_encode( $data);
        } else {
            echo json_encode("failed");
        }
   }
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

if(isset($_POST['courseID'])){
    $courseID = $_POST['courseID'];
    $query = "update course set video_completion = 1 where course_id = '$courseID'";
    $result = mysqli_query($con,$query);
    if( $result ){
        echo "true";
    }
    else{
        echo "false";
    }
}

if(isset($_POST['subcourse_id'])){
    $courseID = $_POST['subcourse_id'];
    $query = "update subcourse set video_completion = 1 where id = '$courseID'";
    $result = mysqli_query($con,$query);
    if( $result ){
        echo "true";
    }
    else{
        echo "false";
    }
}


if(isset($_POST['courseType'])){
    $courseID = $_POST['courseID'];
    $query    = "update course set pdf_view = 1 where course_id = '$courseID'";
    $result = mysqli_query($con,$query);
    if( $result ){
        echo "true";
    }
    else{
        echo "false";
    }
}
if(isset($_POST['subcourseType'])){
    $courseID = $_POST['courseID'];
    $query = "update subcourse set pdf_view = 1 where id = '$courseID'";
    $result = mysqli_query($con,$query);
    if( $result ){
        echo "true";
    }
    else{
        echo "false";
    }
}

?>