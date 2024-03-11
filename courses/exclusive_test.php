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
     $query="select asigned_exlusivetest from employee where id=".$_SESSION['employee_id'];
     $emp_result=mysqli_query($con,$query);
     $emp_num=mysqli_num_rows($emp_result);
     $asigned_exlusivetest ="";
     if($emp_num > 0) {
       $emp_row =mysqli_fetch_assoc($emp_result);
       $asigned_exlusivetest =  $emp_row['asigned_exlusivetest'] ;
     }
?>
<style>
.list {
    display: flex;
    justify-content: end;
    align-items: center;
    gap: 20px;
}

.wrap_image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-title {
    font-size: 24px;
    padding: 15px 0;
}
.col-xs-12{
    margin-bottom:15px;
}
</style>
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
                    <!-- Page-header start -->
        
                    <div class="pcoded-inner-content">
                        <!-- Main-body start -->

                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <!-- Basic table card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Grand Test List</h5>
                                            <!-- <select name="course_or_subcourse" id="course_or_subcourse"
                                                class="form-control form-group">
                                             
                                                <optgroup label="">
                                                   
                                                </optgroup>
                                            </select> -->
                                    
                                            <div class="card-header-right">
                                                <ul class="list-unstyled card-option">
                                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                                    <li><i class="fa fa-trash close-card"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Test Title</th>
                                                            <th>Total Question</th>
                                                            <th>Total Time(in Minute)</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body_content">
                                                     
                                                       <?php 
                                                        $query = "select * from course where course_type=1 ORDER BY id DESC";
                                                        $result = mysqli_query($con, $query);
                                                        $num = mysqli_num_rows($result); 
                                                        $flag =0; 
                                                        if ( $num >0 ) {
                                                            $key=0;
                                                          
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                              
                                                                $course_id =$row['course_id'];
                                                                if (strpos($asigned_exlusivetest, $course_id ) !== false) {
                                                                    $flag =1; 
                                                                    $query ="select * from question where course_id='$course_id'";
                                                                    $question_result = mysqli_query($con, $query);
                                                                    $total_question= mysqli_num_rows($question_result);
                                    
                                                                    $query ="select * from setting";
                                                                    $setting_result = mysqli_query($con, $query);
                                                                    $settingData=mysqli_fetch_assoc($setting_result);
                                                                    $per_question_time = $settingData['per_question_time'];
                                                                    $totalQuestion     = $settingData['grandtest_total'];
                                                            
                                                                    $total_time =   $totalQuestion  * $per_question_time;
                                                                    
                                                                    echo "<tr>
                                                                            <td>".++$key."</td>
                                                                            <td>". $row['course_title']."</td>
                                                                            <td>". $totalQuestion."</td>
                                                                            <td>". $total_time ."</td>";

                                                                    if ( $total_question > 0) {
                                                                        echo '<td><form action="test_handler.php" method="post">
                                                                        <input type="hidden" name="course_id" value="'. $course_id .'" />
                                                                        <input type="hidden" name="question_appearance" value="'. $course_id .'" />
                                                                        <input type="hidden" name="employee_id" value="'.$_SESSION['employee_id'].'" />
                                                                        <input type="Submit" value="START TEST" name="start_test" class="btn btn-primary" style="padding:10px;" />
                                                                        </form></td>';  
                                                                    }else{
                                                                        echo '<td></td>';
                                                                    }         
                                                                
                                                                    
                                                                    echo "</tr>";
                                                                } 

                                                            }
                                                        } 
                                                        
                                                     
                                                       ?>
                                                    </tbody>
                                                </table>
                                                <table style="margin:auto;">
                                                  <thead>
                                                        <tr>
                                                        <?php
                                                        if($flag == 0){
                                                         echo '<th>No results</th>';
                                                        }
                                                        ?>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- Page-body end -->
                            </div>
                        </div>
                        <!-- Main-body end -->

                        <div id="styleSelector">

                        </div>
                    </div>
                    <!-- SHOW MORE -->
<!--
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="#" class="btn btn-primary">SHOW MORE</a>
                        </div>
                    </div>
-->
                    <!-- SHOW MORE -->

                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../includes/footer.php';
?>