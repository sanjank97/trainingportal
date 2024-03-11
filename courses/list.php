<?php
     session_start();
     if (!isset($_SESSION['employee'])) {
        header("Location :../index.php");
     }
    if (isset($_SESSION['test_session_id'])) {
        header("Location :test.php");
    }
     include '../includes/header_top.php';
     include('../db_connection.php');
     if(!isset($_GET['course_id']))
     {
        header("Location:all_list.php");
     } 
     $query="select * from course where course_id='".$_GET['course_id']."'";
     $result=mysqli_query($con,$query);
      
    $num=mysqli_num_rows($result);
    if($num <1)
    {
    header("Location:all_list.php");
    }

    $row=mysqli_fetch_assoc($result);
    $course_video_list    =explode(',',$row['course_video']);
    $course_pdf_list      =explode(',', $row['course_pdf']);
    $course_video_link    =$row_course['video_link'];
    
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
.documentMsg{
    color: red;
    font-size: 16px;
    text-align: center;
    font-weight: 300;
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
.listcourse  .cardleft{
    margin-left: 10px;
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
::-webkit-media-controls {
display: none !important;
}
::-webkit-media-controls-enclosure {
display: none !important;
}
::-webkit-media-controls-panel {
display: none !important;
}
</style>
<div id="pcoded" class="pcoded ">
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
                    <div class="pcoded-inner-content listcourse <?php echo $cls;?> main_video">
                        <div class="main-body">
                            <div class="page-wrapper">
                                <div class="page-body">
                                    <div class="documentMsg"></div>
                                <div class="wrap_back_button">
                                        <button onclick="history.back()">Back</button>
                                    </div>
                                    <div class="card" style="margin-bottom: 15px; padding-bottom:20px;" >    
                                        <div class="card-header">
                                            <h5><?php echo  $row['course_title']?></h5>
                                        </div>
                                    
                                    <div class="row" style="margin-top:15px;">
                                       <?php
                                        
                                        foreach($course_video_list as $video)
                                        {
                                            if(!empty($video)):
                                                echo '<div class="col-md-4 mb-4">
                                                <div class="card cardleft">
                                                    <div class="card-block">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                        <a href="' . BASE_URL . 'courses/singlevideo.php?course_id=' . $_GET['course_id'] . '">
                                                            <video width="320"  controls>
                                                            <source src="' . THEME_ASSET . '/' . $video . '" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                            </video>
                                                            <img src="' . BASE_URL . '/assets/images/play-button-svgrepo-com.svg" type="video/mp4">
                                                        </a>
                                                        </div>
                                                    
                                                    </div>
                                                
                                                </div>
                                            </div>';
                                            endif;
                                        }
                                        if ($video_link) {
                                            echo '<div class="col-md-4 mb-4">
                                                        <div class="card">
                                                            <div class="card-block">
                                                                <iframe width="100%" height="284" src="' . $video_link . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                        
                                        foreach ($course_pdf_list as $pdf_list) {
                                            if ($pdf_list) {
                                                echo '<div class="col-md-4 mb-4">
                                                    <div class="card">
                                                    <div class="card-block">
                                                        <a href="' . THEME_ASSET . 'pdf/' . $pdf_list . '" target="_blank" title="'.$_GET['course_id'].'"  data-id="course" onclick="pdfclick(event)">
                                                            <div class="wrap-image pdf-image">
                                                                <img src="' . BASE_URL . '/assets/images/pdf.png">
                                                            </div>
                                                        </a>
                                                   
                                                    </div>
                                                    </div>

                                            </div>';
                                            }
                                        }
                                        ?>
                                        <div class="col-12 notes_To_see">
                                            <?php
                                                $priority = $row['priority'];
                                                if($priority == 0){
                                                    echo '<p class="testnotes">Notes: Video must be watch to take test of this course!!</p>';
                                                }else{
                                                    echo '<p class="testnotes">Notes: Pdf must be read to take test of this course!!</p>';
                                                }
                                                
                                            ?>
                                        </div>
                                        
                                    </div>
                                    <!--START TEST BUTTON -->
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <?php
                                            
                                               //O --- Video
                                               //1 --- PDF
                                                $query_status="select * from course where course_id='".$_GET['course_id']."'";
                                                $result_status=mysqli_query($con,$query_status);
                                                $num_status=mysqli_num_rows($result_status);
                                                if($num_status > 0){
                                                    while ($rowstatus = mysqli_fetch_assoc($result_status)) {
                                                        $checkPriority = $rowstatus['priority'];
                                                        $flag_start_test = false;
                                                        if($checkPriority == 0){
                                                            if($rowstatus['video_completion'] == 1){
                                                                $flag_start_test = true;
                                                            }
                                                        }
                                                        else{
                                                            //CheckPDFCOMPLETEDORNOT
                                                            if($rowstatus['pdf_view'] == 1){
                                                                $flag_start_test = true;
                                                            }
                                                        }
                                                      }
                                                }
                                                
                                                $course_id      = $_GET['course_id'];
                                                $query          = "SELECT id FROM question WHERE course_id = '$course_id' AND question_appearance='$course_id'";
                                                $result         = mysqli_query($con, $query);
                                                $total_questoin = mysqli_num_rows($result);
                                                if($total_questoin > 0){
                                                    if($flag_start_test){
                                                        echo '<form action="test_handler.php" method="post">
                                                                <input type="hidden" name="course_id" value="'.$_GET['course_id'].'" />
                                                                <input type="hidden" name="question_appearance" value="'.$_GET['course_id'].'" />
                                                                <input type="hidden" name="employee_id" value="'.$_SESSION['employee_id'].'" />
                                                                <input type="Submit" value="START TEST" name="start_test" class="btn btn-primary" />
                                                        </form>';
                                                    }
                                                }
                                                else{
                                                    echo "<p class='test_not_found'>Test will appear soon!!</p>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <!--END TEST BUTTON -->
                                 </div>

                                    <div class="page-body">

                                        <?php
                                        $num_subcourse = mysqli_num_rows($result_query);
                                        if ($num_subcourse > 0) {
                                            echo '<div class="card" style="margin-bottom: 15px;">
                                            <div class="card-header">
                                                <h5>Sub Courses</h5>
                                            </div>
                                            </div>';
                                            while ($row = mysqli_fetch_assoc($result_query)) {

                                               // echo '<pre>',var_dump($row); echo '</pre>';
                                                $subcourse_id = $row['id'];
                                                $subcourse_video_list  = explode(',', $row['video']);
                                                $subcourse_pdf_list    = explode(',', $row['pdf']);
                                                $video_link            = $row['video_link'];

                                                $checkPriority = $row['priority'];
                                                $flag_start_test = false;
                                                if($checkPriority == 0){
                                                    //CheckVideoCompletedORNOT
                                                    if($row['video_completion'] == 1){
                                                        $flag_start_test = true;
                                                    }
                                                }
                                                else{
                                                    //CheckPDFCOMPLETEDORNOT
                                                    if($row['pdf_view'] == 1){
                                                        $flag_start_test = true;
                                                    }
                                                }


                                                ?>
                                                <div class="card" style="margin-bottom: 30px; padding-bottom:20px;">
                                                    <div class="card-block">
                                                        <div class="form-default">
                                                            <div class="card-header">
                                                                <h5 style="text-transform: uppercase;"><?php echo $row['title']; ?></h5>
                                                            </div>
                                                        </div>

                                                        <div class="row courseContent" style="margin-top:15px;">
                                                            <?php
                                                            foreach ($subcourse_video_list as $video) {
                                                                if(!empty($video)):
                                                                echo '<div class="col-md-4 mb-4">
                                                                        <div class="card cardleft">
                                                                            <div class="card-block">
                                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                                <a class="viewbutton" href="' . BASE_URL . 'courses/singlevideo.php?subcourse_id=' . $row['id'] . '">
                                                                                    <video width="320" controls>
                                                                                        <source src="' . THEME_ASSET . 'course/video/' . $video . '" type="video/mp4">
                                                                                    
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                    <img src="' . BASE_URL . '/assets/images/play-button-svgrepo-com.svg" type="video/mp4">
                                                                                </a>
                                                                                 
                                                                                </div>
                                                                                <h3 class="text-left font-up font-bold indigo-text mb-0"><strong>' . $row['course_title'] . '</strong></h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                endif;
                                                            }
                                                            ?>
    <!-- subcourse_id=' . $row['courseID'] . '">
    Watch Video -->
                                                            <!-- Grid column -->
                                                            <!-- you tube empeded link -->
                                                            <!-- PDF -->
                                                            <?php
                                                            if ($video_link) {
                                                                echo '<div class="col-md-4 mb-4">
                                                                            <div class="card">

                                                                            <div class="card-block">
                                                                            <iframe width="100%" height="284" src="' . $video_link . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                                            </div>

                                                                            </div>
                                                                        </div>';
                                                            }
                                                            ?>
                                                            <?php
                                                            foreach ($subcourse_pdf_list as $pdf_list) {
                                                                if ($pdf_list) {
                                                                    echo '<div class="col-md-4 mb-4">
                                                                            <div class="card-block">
                                                                                <a href="' . THEME_ASSET . 'course/pdf/' . $pdf_list . '" target="_blank"  title="'.$row['id'].'" data-id="subcourse" onClick="subcoursepdfclick(event)">
                                                                                <div class="wrap-image pdf-image">
                                                                                    <img src="' . BASE_URL . '/assets/images/pdf.png">
                                                                                </div>
                                                                                </a>
                                                                            </div>
                                                                     </div>';
                                                                }
                                                            }
                                                            ?>
                                                            <!-- PDF -->
                                                        </div>

                                                            <?php
                                                            $priority = $row['priority'];
                                                            if($priority == 0){
                                                                echo '<p class="testnotes">Notes: Video must be watch to take test of this course!!</p>';
                                                            }else{
                                                                echo '<p class="testnotes">Notes: Pdf must be read to take test of this course!!</p>';
                                                            }
                                                            ?>
                                                    </div>
                                                    <!--START TEST BUTTON -->
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                        <?php
                                                            $course_id      = $_GET['course_id'];
                                                            $query          = "SELECT id FROM question WHERE course_id = '$course_id' AND question_appearance ='$subcourse_id'";
                                                            $result         = mysqli_query($con, $query);
                                                            $total_questoin = mysqli_num_rows($result);
                                                            if($total_questoin > 0){
                                                                if($flag_start_test){
                                                                    echo '<form action="test_handler.php" method="post">
                                                                            <input type="hidden" name="course_id" value="'.$_GET['course_id'].'" />
                                                                            <input type="hidden" name="question_appearance" value="'.$subcourse_id.'" />
                                                                            <input type="hidden" name="employee_id" value="'.$_SESSION['employee_id'].'" />
                                                                            <input type="Submit" value="START TEST" name="start_test" class="btn btn-primary" />
                                                                        </form>'; 
                                                                }
                                                            }
                                                            else{
                                                                echo "<p class='test_not_found'>Test will appear soon!!</p>";
                                                            }
                                                        ?>  
                                                        </div>
                                                    </div>
                                                    <!--END TEST BUTTON -->
                                                </div>
                                        <?php
                                            }
                                        }else{
                                           // echo 'Empty';
                                        }

                                        

                                        ?>
                                    </div>
                                    <!-- Grid row -->

                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>window.localStorage.clear()</script>

<script>
    function pdfclick(event){
       
        var href       = event.currentTarget.getAttribute('alt');

        let courseType = event.currentTarget.getAttribute('data-id');
        let courseID   = event.currentTarget.getAttribute('title');
        $.ajax({
            url: "test_handler.php",
            dataType: "json",
            method:"post",
            data:{'courseID':courseID,'courseType':courseType},
            success:function(data){
                console.log(data);

            }
        });
    }

    function subcoursepdfclick(event){
  
        var href       = event.currentTarget.getAttribute('href');
        let courseType = event.currentTarget.getAttribute('data-id');
        let courseID   = event.currentTarget.getAttribute('title');
        $.ajax({
            url: "test_handler.php",
            dataType: "json",
            method:"post",
            data:{'courseID':courseID,'subcourseType':courseType},
            success:function(data){
                console.log(data);
                window.open( href,'_blank');
            }
        });
    }


    //   jQuery(document).ready(function(){
    //         $.ajax({
    //             url: "test_handler.php",
    //             dataType: "json",
    //             method:"post",
    //             data:{'courseID':courseID},
    //             success:function(data){
    //                 console.log(data);
    //                 jQuery("._course .videoCompl").html('<button type="button" class="btn btn_completed">Completed</button>');
    //             }
    //         });
    //   });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
          $(document).ready(function() {
           if($('.listcourse').hasClass('documentExpired')) {
              let htmlContent = '<p>The document has expired. Please submit it again. <a href="<?=BASE_URL;?>profile.php">Click here</a></p>';
              $('.documentMsg').html(htmlContent);
           }
           if($('.listcourse').hasClass('documentNotFeed')) {
             $('.documentMsg').text("The document has not been uploaded yet.!");
           }
        });
</script>
<?php
include '../includes/footer.php';
?>