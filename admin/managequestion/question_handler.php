<?php 
   session_start();
   if (!isset($_SESSION['admin'])) {
      header("Location:index.php");
   }

   include('../../db_connection.php');

   if (isset($_POST['add_question'])) {

   $query = "INSERT INTO question(question, ans_a, ans_b, ans_c, ans_d, correct_ans, course_id, question_appearance, created_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

   // Prepare the statement
   if ($stmt = mysqli_prepare($con, $query)) {
      // Bind parameters
      mysqli_stmt_bind_param($stmt, "ssssssiss", $question, $ans_a, $ans_b, $ans_c, $ans_d, $correct_ans, $course_id, $question_appearance, $created_on);

      // Get values from $_POST
      $question = $_POST['question'];
      $ans_a = $_POST['ans_a'];
      $ans_b = $_POST['ans_b'];
      $ans_c = $_POST['ans_c'];
      $ans_d = $_POST['ans_d'];
      $correct_ans = $_POST['correct_ans'];
      $course_id = $_POST['course_id'];
      $question_appearance = $_POST['question_appearance'];
      date_default_timezone_set('America/Toronto');
      $created_on = date('Y-m-d H:i:s');

      // Execute the statement
      mysqli_stmt_execute($stmt);

      // Check if the query was successful
      if (mysqli_stmt_affected_rows($stmt) > 0) {
         $_SESSION['success'] = "<strong>Success.!</strong> Question has been added.";
      } else {
         $_SESSION['error'] = "<strong>Failed.!</strong> Something went wrong. Please check the input.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
   } else {
      $_SESSION['error'] = "<strong>Failed.!</strong> Something went wrong with the query preparation.";
   }

   // Redirect to appropriate page
   header("Location:list.php?course_id=".$course_id."&question_appearance=".$question_appearance);

   // Close connection
   mysqli_close($con);



   }

//Edit Question section
if(isset($_POST['data_edit_id']))
{


    $id = $_POST['data_edit_id'];
    $query = "select * from question where id=$id";
    $result = mysqli_query($con,$query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
      $row=mysqli_fetch_assoc($result);
      echo '
      <input type="text" name="qid" value="'.$row['id'].'" hidden>
      <input type="text" name="course_id" value="'. $row['course_id'].'" hidden>
      <input type="text" name="question_appearance" value="'. $row['question_appearance'].'" hidden>

      <div class="form-group form-default">
	          <input type="hidden" name="csrf" value="'.time().'">
             <label class="float-label">Question Title</label>
              <input type="text" name="question" class="form-control" required=""  value="'.$row['question'].'">
              <span class="form-bar"></span>
          </div>  
          <div class="form-group form-default">
             <label class="float-label">Answer A</label>
              <input type="text" name="ans_a" class="form-control" required="" value="'.$row['ans_a'].'">
              <span class="form-bar"></span>
          </div> 
          <div class="form-group form-default">
             <label class="float-label">Answer B</label>
              <input type="text" name="ans_b" class="form-control" required="" value="'.$row['ans_b'].'">
              <span class="form-bar"></span>
          </div>                                             
          <div class="form-group form-default">
             <label class="float-label">Answer C</label>
              <input type="text" name="ans_c" class="form-control" required="" value="'.$row['ans_c'].'">
              <span class="form-bar"></span>
          </div> 
          <div class="form-group form-default">
             <label class="float-label">Answer D</label>
              <input type="text" name="ans_d" class="form-control" required="" value="'.$row['ans_d'].'">
              <span class="form-bar"></span>
          </div> 
          <div class="form-group form-default">
             <label class="float-label">Correct Answer</label>
              <input type="text" name="correct_ans" id="correct_ans" placeholder="Enter only a,b,c,d in lowercase" class="form-control" required="" value="'.$row['correct_ans'].'">
              <span class="form-bar"></span>
          </div>  <input type="submit" class="site_btn"  value="Submit" name="update_question">';

        }

}

//Update Question 
if(isset($_POST['update_question']))
{



   $qid = $_POST['qid'];
   $course_id = $_POST['course_id'];
   $question_appearance = $_POST['question_appearance'];
   $ques = $_POST['question'].' ';
   $opa = $_POST['ans_a'];
   $opb = $_POST['ans_b'];
   $opc = $_POST['ans_c'];
   $opd = $_POST['ans_d'];
   $opcorrect = $_POST['correct_ans'];
   
   // Prepare the SQL statement with placeholders
   $query = "UPDATE question SET question=?, ans_a=?, ans_b=?, ans_c=?, ans_d=?, correct_ans=? WHERE id=?";
   
   // Prepare the statement
   if ($stmt = mysqli_prepare($con, $query)) {
       // Bind parameters
       mysqli_stmt_bind_param($stmt, "ssssssi", $ques, $opa, $opb, $opc, $opd, $opcorrect, $qid);
   
       // Execute the statement
       mysqli_stmt_execute($stmt);
   
       // Check if the query was successful
       if (mysqli_stmt_affected_rows($stmt) > 0) {
           $_SESSION['success'] = "<strong>Success.!</strong> Question has been updated.";
       } else {
           $_SESSION['error'] = "Failed to update the question.";
       }
   
       // Close statement
       mysqli_stmt_close($stmt);
   } else {
       $_SESSION['error'] = "<strong>Failed.!</strong> Something went wrong with the query preparation.";
   }
   
   // Redirect to appropriate page
   header("Location:list.php?course_id=".$course_id."&question_appearance=".$question_appearance);
   

}

// delete Question
if(isset($_POST['data_delete_id']))
{
  $q_id=$_POST['data_delete_id'];
  $query="delete from question where id='".$q_id."'";
  $result=mysqli_query($con,$query);
  return true;
}
//change Employee status

// if(isset($_POST['course_id'])) {
//    $course_id = $_POST['course_id'];
//    $question_appearance = $_GET['selected_course_id'];

//    $query="select * from question where course_id='".$course_id."' AND question_appearance='".$question_appearance."' ";
//    $result=mysqli_query($con,$query);
//    $num=mysqli_num_rows($result);
//    if($num > 0)
//    {
//        $key=0;
//        while($row=mysqli_fetch_assoc($result))
//        {
           
         
//              echo '<tr>
//                <th scope="row">'.++$key.'</th>
//                <td>'.$row['question'].'</td>
//                <td>[a,b,c,d]</td>
//                <td>'.$row['correct_ans'].'</td>
//                <td>  
//                <a href="#" class="course_edit_btn" data-edit-id="'.$row['id'].'" data-toggle="modal" data-target="#myModal2">Edit</a>
//                <a href="#" class="course_delete_btn"  data-delete-id="'.$row['id'].'" course-id="'.$row['course_id'].'" question-appearance="'.$row['question_appearance'].'" style="color:red;margin-left:10px;">Delete</a>
//                </td>
//               </tr>';
//        }
       
//    }else{
//       echo "<tr>
//                  <td><h3>Not found</h3></td>
//               </tr>";
    
//    }

// }



?>