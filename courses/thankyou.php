<script src="https://kimmobrunfeldt.github.io/progressbar.js/dist/progressbar.min.js"></script>
<?php
     session_start();

   //  echo '<pre>',var_dump($_SESSION); echo '</pre>';
     unset( $_SESSION['questions'] );
     unset( $_SESSION['course_id'] );
     unset( $_SESSION['question_appearance'] );
     unset( $_SESSION['test_session_id'] );
    // echo '<pre>',var_dump($_SESSION); echo '</pre>';


     if (!isset($_SESSION['employee'])) {
        header("Location :../index.php");
     }
    if (isset($_SESSION['test_session_id'])) {
        header("Location :test.php");
    }
     include '../includes/header_top.php';
     include('../db_connection.php');
     $percentage =0;
     $query="select * from course where course_id='".$_GET['course_id']."'";
     $result=mysqli_query($con,$query);
    
     $subcourse_query = "select * from subcourse where courseID='" . $_GET['course_id'] . "'";
     $result_query    = mysqli_query($con, $subcourse_query);

     $message = "Your information has been submitted successfully.";

     if (isset($_GET['test_id'])) {
        $test_id =$_GET['test_id'];
        $test_query ="select * from test where id=$test_id";
        $test_result   = mysqli_query($con, $test_query);
        $test_row = mysqli_fetch_assoc($test_result );

        $total_ques = $test_row['total_questions'] ;
        $score      = $test_row['correct_question'] ;

      //  echo  $test_row['correct_question'] . '******<br>';
      //  echo  $total_ques . 'Total Question' .'<br>';


        if(isset($test_row['mark']) && !empty($test_row['mark'])){
            $marks    = $test_row['mark'];
            $empscore = $test_row['correct_question'] *  $marks;
        }
        
        $totalQuestions     = $test_row['total_questions'];
        if ($totalQuestions > 0) {
            $percentage = number_format($empscore * 100 / ($totalQuestions * $marks), 2);
        } else {
            $percentage = 0; // or any other value you prefer when total questions are zero
        }
        
        if($percentage >= 50) {
            $message = "Congratulations on meeting the qualifications! Your score is ".$percentage.' %. Well done! ';
        } else {
            $message = "I apologize for not meeting the qualifications. Your score is ".$percentage.' %.'; 
        }
        


     }
 

  
?>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?php
            include '../includes/header.php';
          ?>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <?php
                                include '../includes/nav.php';
                            ?>
                    </div>
                </nav>

                <div class="pcoded-content">
                    <div class="pcoded-inner-content listcourse">
                        <div class="main-body">
                            <div id="progress-bar"></div>
                            <div class ="text-center"><b><?php echo $percentage.'%';?></b></div>
                            <div class="page-wrapper thankyou_msg" style="text-align: center;">
                                <p style="font-size: 18px;margin: 0;"><?php  echo  $message;?></p>
                                <h4> Thank you for participating in the test.</h4>
                            </div>
                            <div class="thank_back_button">
                               <a href="<?php echo BASE_URL;?>" class="site_btn">Go To Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../includes/footer.php';
?>
<script>
    let percentage = <?php echo $percentage; ?> ;
    let color = (percentage >=50)?'#2695d6':'red';
    var progressBar = new ProgressBar.Circle('#progress-bar', {
    color: color, // Color of the progress bar
    strokeWidth: 10, // Width of the progress bar
    trailColor: '#f3f3f3', // Color of the trail (background)
    trailWidth: 10, // Width of the trail
    duration: 2000, // Duration of the animation in milliseconds
    easing: 'easeInOut', // Easing function for the animation
    radius: 5 // Adjust this value to decrease the radius of the progress bar
    });
    progressBar.animate(percentage / 100);
</script>