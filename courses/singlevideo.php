<?php
     session_start();
     $startTest = true;
     include '../includes/header_top.php';
     include('../db_connection.php');
     if(isset($_GET['course_id'])){
        $courseID = $_GET['course_id']; 
        $query = "SELECT id, question, ans_a, ans_b, ans_c, ans_d FROM question WHERE course_id ='$courseID'";
        $result = mysqli_query($con, $query);
        $total_questions = mysqli_num_rows($result);
        if($total_questions < 1) {
         // echo "Question is not found";
          $startTest =  false;
          //die();
        }
    }

    //echo $total_questions .  "total_questions" .'<br>';
    //echo '<pre>',var_dump( $startTest  ); echo '</pre>';

    if (!isset($_SESSION['employee'])) {
        header("Location :../index.php");
    }
    if (isset($_SESSION['test_session_id']) &&  $startTest) {
        header("Location :test.php");
    }
   
  

 

     $subcourse_query = "select * from subcourse where courseID='" . $_GET['course_id'] . "'";
     $result_query    = mysqli_query($con, $subcourse_query);
    
     $query ="select driving_license, dl_expiredate, security_license, sl_expiredate, cpr_certification, cc_expiredate from employee where id=".$_SESSION['employee_id'];
     $emp_result = mysqli_query($con, $query);
     $num =mysqli_num_rows($emp_result);
     $cls ="documentFeed";
     if($num > 0) {
        $emp_row = mysqli_fetch_assoc( $emp_result );
        if( $emp_row['driving_license']!="" && $emp_row['security_license']!="" && $emp_row['cpr_certification']!="" ) {
            $currentDate = strtotime(date("Y-m-d"));
            if(strtotime($emp_row['dl_expiredate']) < $currentDate || strtotime($emp_row['sl_expiredate']) < $currentDate || strtotime($emp_row['cc_expiredate']) < $currentDate) {
                $cls ="documentExpired";
            }
       }else{
        $cls ="documentNotFeed";
       }
    }

    
?>
<style>
.videoCompl{
    display: inherit;
}
.list {
    display: flex;
    justify-content: end;
    align-items: center;
    gap: 20px;
}
.card .card-block p {
    line-height: 1.4;
    padding: 0 20px;
}
.test_not_found{
    color: green;
    font-size: 16px;
    border: 1px solid green;
    max-width: 300px;
    margin: auto;
    padding: 5px;
}

.documentExpired {
        opacity: 0.3;
        pointer-events: none;
}
.documentNotFeed{
        opacity: 0.3;
        pointer-events: none;
}
.hide{
    display:none;
}
.page-header .page-block {
    padding: 35px 40px 0;
}
.documentFeed .btn-primary{
    margin-top: 30px;
}
.actions .btn{
    height: 44px;
}
</style>
<div id="pcoded" class="pcoded single_video">
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
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h5>Courses and Subcourses</h5>
                                         <p class="text-danger documentMsg"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pcoded-inner-content listcourse <?php echo $cls;?>">
                        <div class="main-body">
                            <div class="page-wrapper" style="padding-top:0px;">
                                <div class="page-body">

<!-- 
                                   <div class="card" style="margin-bottom: 15px;" >
                                        <div class="card-header">
                                            <h5>Courses</h5>
                                            <a href="#" onclick="history.back()">Back<a>
                                        </div>
                                    </div> -->
<div class="card" style="margin-bottom: 15px;" >
    <div class="card-header wrap_back_button_header">
        <h5>Courses</h5>
        <div class="wrap_back_button">
            <button onclick="history.back()">Back</button>
        </div>
    </div>
</div>


                                    <div class="card" style="margin-bottom:15px; padding-bottom:20px;" >    
                          
                                    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
                                       <?php
                                        if(isset($_GET['course_id'])){
                                            $query="select * from course where course_id='".$_GET['course_id']."'";
                                            $result=mysqli_query($con,$query);
                                            $num=mysqli_num_rows($result);
                                            if($num <1)
                                            {
                                                header("Location:all_list.php");
                                            }
                                            $row=mysqli_fetch_assoc($result);
                                            $completed="";
                                            if($row['video_completion'] == 1){
                                                $completed = '<button type="button" class="btn btn_completed"> <i class="fa fa-check" aria-hidden="true"></i> Completed</button>';
                                            
                                            }
                                            $checkPriority = $row['priority'];
                                            $class = "hide";
                                            if($checkPriority == 0){
                                                if($row['video_completion'] == 1){
                                                    $class="show";
                                                }
                                            }
                                            else{
                                                //CheckPDFCOMPLETEDORNOT
                                                if($row['pdf_view'] == 1){
                                                    $class="show";
                                                }
                                            }
                                            echo '<div class="container-fluid _course">
                                                    <video controls crossorigin playsinline poster="" id="player">
                                                        <source src="' . THEME_ASSET . '/' . $row['course_video'] . '" type="video/mp4" size="576">
                                                        <source src="' . THEME_ASSET . '/' . $row['course_video'] . '" type="video/mp4" size="720">
                                                        <source src="' . THEME_ASSET . '/' . $row['course_video'] . '" type="video/mp4" size="1080">
                                                        <source src="' . THEME_ASSET . '/' . $row['course_video'] . '" type="video/mp4" size="1440">
                                                    </video>
                                                <input type="hidden" value="'.$_GET['course_id'].'" id="courseID">
                                                <div class="actions">
                                                    <h2 class="subtitle">'.$row['course_title'].'</h2>

                                                    <button type="button" class="btn js-rewind">Rewind</button>
                                                    <button type="button" class="btn js-forward">Forward</button>
                                                    '.$completed.'
                                                    <span class="videoCompl"></span>
                                                </div>
                                             </div>';
                                             $startTest_T = '';
                                             if($startTest){
                                                $startTest_T = '<input type="Submit" value="START TEST" name="start_test" class="btn btn-primary" />';
                                             }
                                             echo '<div class="col-12 form_test '.$class.'" style="text-align: center;"><form action="test_handler.php" method="post">
                                             <input type="hidden" name="course_id" value="'.$_GET['course_id'].'" />
                                             <input type="hidden" name="question_appearance" value="'.$_GET['course_id'].'" />
                                             <input type="hidden" name="employee_id" value="'.$_SESSION['employee_id'].'" />
                                            '.$startTest_T.'
                                            </form></div>'; 
                                         }
                                        ?>
                                        <?php
                                        if(isset($_GET['subcourse_id'])){
                                            $subcourse_query = "select * from subcourse where id='" . $_GET['subcourse_id'] . "'";
                                            $result_query    = mysqli_query($con, $subcourse_query);
                                            $num=mysqli_num_rows($result_query);
                                            if($num <1)
                                            {
                                                 header("Location:all_list.php");
                                            }
                                            $row=mysqli_fetch_assoc($result_query);
                                            $completed="";
                                            if($row['video_completion'] == 1){
                                                $completed = '<button type="button" class="btn btn_completed"><i class="fa fa-check" aria-hidden="true"></i> 
                                                 Completed</button>';
                                            }
                                            $checkPriority = $row['priority'];
                                            $class = "hide";
                                            if($checkPriority == 0){
                                                if($row['video_completion'] == 1){
                                                    $class="show";
                                                }
                                            }
                                            else{
                                                //CheckPDFCOMPLETEDORNOT
                                                if($row['pdf_view'] == 1){
                                                    $class="show";
                                                }
                                            }
                                            echo '<div class="fluid-container _subcourse">
                                                    <video controls crossorigin playsinline poster="" id="player">
                                                        <source src="' . THEME_ASSET . 'course/video/' . $row['video'] . '" type="video/mp4" size="576">
                                                        <source src="' . THEME_ASSET . 'course/video/' . $row['video'] . '" type="video/mp4" size="720">
                                                        <source src="' . THEME_ASSET . 'course/video/' . $row['video'] . '" type="video/mp4" size="1080">
                                                        <source src="' . THEME_ASSET . 'course/video/' . $row['video'] . '" type="video/mp4" size="1440">
                                                    </video>
                                                    <input type="hidden" value="'.$row['id'].'" id="subcourse_id">
                                                    <div class="actions">
                                                        <h2 class="subtitle">'.$row['title'].'</h2>
                                                        <button type="button" class="btn js-rewind">Rewind</button>
                                                        <button type="button" class="btn js-forward">Forward</button>
                                                        '.$completed.'
                                                        <span class="videoCompl"></span>
                                                    </div>
                                             </div>';
                                             $startTest_T = '';
                                             if($startTest){
                                                $startTest_T = '<input type="Submit" value="START TEST" name="start_test" class="btn btn-primary" />';
                                             }
                                             echo '<div class="col-12 form_test '.$class.'" style="text-align: center;">
                                             <form action="test_handler.php" method="post">
                                             <input type="hidden" name="course_id" value="'.$row['courseID'].'" />
                                             <input type="hidden" name="question_appearance" value="'.$_GET['subcourse_id'].'" />
                                             <input type="hidden" name="employee_id" value="'.$_SESSION['employee_id'].'" />
                                             '.$startTest_T.'
                                            </form></div>'; 
                                         }
                                        ?>
                                 
                                    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => { 
                                                const player = new Plyr('#player');
                                                window.player = player;
                                                function on(selector, type, callback) {
                                                    document.querySelector(selector).addEventListener(type, callback, false);
                                                }
                                                on('.js-rewind', 'click', () => { 
                                                    player.rewind();
                                                });
                                                on('.js-forward', 'click', () => { 
                                                    player.forward();
                                                });
                                                player.on('timeupdate', event => {
                                                const currentTime = event.detail.plyr.currentTime;
                                                const tags = [
                                                    { time: 10, text: 'Tag 1' },
                                                    { time: 20, text: 'Tag 2' },
                                                    { time: 30, text: 'Tag 3' },
                                                ];
                                                const currentTag = tags.find(tag => currentTime >= tag.time);
                                                if (currentTag) {
                                                    console.log(`Current Tag: ${currentTag.text}`);
                                                    // Do something with the current tag, like displaying it on the page
                                                }
                                          });
                                     });
                                    </script>
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(isset($_GET['subcourse_id'])){
        ?>
        <script>
            var video = document.getElementById('player');
                video.addEventListener('ended', function() {
                let courseID = $("#subcourse_id").val();
                $.ajax({
                    url: "test_handler.php",
                    dataType: "json",
                    method:"post",
                    data:{'subcourse_id':courseID},
                    success:function(data){
                        console.log(data);
                        jQuery("._subcourse .videoCompl").html('<button type="button" class="btn btn_completed">Completed</button>');
                        jQuery(".form_test").removeClass('hide');
                    }
                });
            });
        </script>
        <?php
    }
?>
<?php
    if(isset($_GET['course_id'])){
        ?>
        <script>
            var video = document.getElementById('player');
                video.addEventListener('ended', function() {
                let courseID = $("#courseID").val();
                $.ajax({
                    url: "test_handler.php",
                    dataType: "json",
                    method:"post",
                    data:{'courseID':courseID},
                    success:function(data){
                        console.log(data);
                        jQuery("._course .btn_completed").html('<i class="fa fa-check" aria-hidden="true"></i> Completed');
                        jQuery(".form_test").removeClass('hide');
                    }
                });
            });
        </script>
<?php 
    }
?>
<script>window.localStorage.clear()</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
          $(document).ready(function() {
           if($('.listcourse').hasClass('documentExpired')) {
              $('.documentMsg').text("The document has expired. Please submit it again.!");
           }
           if($('.listcourse').hasClass('documentNotFeed')) {
             $('.documentMsg').text("The document has not been uploaded yet.!");
           }
        });
</script>
<?php
include '../includes/footer.php';
?>