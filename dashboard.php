
<?php
    session_start();
    if (!isset($_SESSION['employee'])) {
        header("Location:index.php");
    }
    if (isset($_SESSION['test_session_id'])) {

        header("Location :courses/test.php");
     }
    include 'includes/header_top.php';

    $query="select * from course";
    $results=mysqli_query($con,$query);
    $totalcourse=mysqli_num_rows($results);

    
    $records_per_page =10;                       
    $page_number = isset($_GET["page_number"]) ? $_GET["page_number"] : 1;
    $offset = ($page_number - 1) * $records_per_page;

    $query = "select * from test where employee_id=".$_SESSION['employee_id'];
    $score_result = mysqli_query($con, $query);
    $totalRows= mysqli_num_rows($score_result); 


?>
  <div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
          <?php
            include 'includes/header.php';
          ?>
          <div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                  <nav class="pcoded-navbar">
                      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                      <div class="pcoded-inner-navbar main-menu">
                            <?php
                                include 'includes/nav.php';
                            ?>
                      </div>
                  </nav>
                  <div class="pcoded-content">
                      <!-- Page-header start -->
          
                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <!-- <div class="row">
                                            <div class="col-xl-3 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-red"><?php echo $totalcourse; ?></h4>
                                                                <h6 class="text-muted m-b-0">Total Courses</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="fa fa-calendar-check-o f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  -->
                                        <div class="row">
                                            <div class="col-12">
                                            <div class="card">
                                            <div class="card-header">
                                                <h5>Score List</h5>
                                                <div class="card-header-right">
                                                    <!-- <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul> -->
                                                </div>
                                            </div>
                                            <div class="card-block table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sno</th>
                                                                <th>Course</th>
                                                                <th>Subcourse</th>
                                                                <th>N.of Q.</th>
                                                                <th>Score</th>
                                                                <th>Total Marks</th>
                                                                <th>Exma Time(H:M)</th>
                                                                <th>Taken Time(H:M:S)</th>
                                                                <th>Status</th>
                                                                <th>Exam Status</th>
                                                                <th>% Score</th>
                                                                <th>Attempt Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body_content">
                                                        <?php 
                                                            $flag = 0;
                                                            $query = "select * from test where employee_id=".$_SESSION['employee_id']." ORDER BY id DESC LIMIT $offset, $records_per_page";
                                                            $result = mysqli_query($con, $query);
                                                            $num = mysqli_num_rows($result); 
                                                            if ( $num >0 ) {
                                                                $start_increament = $records_per_page *($page_number -1);
                                                                $flag = 1;
                                                                $key=0;
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $course_id = $row['course_id'];
                                                                    $query ="select course_title, course_type from course where course_id='". $course_id ."'";
                                                                    $result1= mysqli_query($con, $query);
                                                                    $cousre_row = mysqli_fetch_assoc($result1);
                                                                    $cousre_type = $cousre_row['course_type'];
                                                                    $course_title =  $cousre_row['course_title'];
                                                                    if ($cousre_type ==1) {
                                                                        $course_title = $course_title .' (Grand Test)'; 
                                                                    }
                                                                   
                                                                    $subcourse_id = $row['subcourse_id'];
                                                                    $query ="select title from subcourse where id='". $subcourse_id ."'";
                                                                    $result2= mysqli_query($con, $query);
                                                                    $num = mysqli_num_rows($result2);
                                                                    $subcourse_title ="";
                                                                    if($num >0){
                                                                        $subcourse_title = mysqli_fetch_assoc($result2)['title'];
                                                                    }
                                                                   // $score = $row['score'];
                                                                    if(isset($row['mark']) && !empty($row['mark'])){
                                                                        $marks          = $row['mark'];
                                                                        $empTotalScore  = $row['correct_question'] *  $marks;
                                                                    }

                                                                    $totalQuestions     = $row['total_questions'];
                                                                    if ($totalQuestions > 0) {
                                                                        $percentage = number_format($empTotalScore * 100 / ($totalQuestions * $marks), 2);
                                                                        $totalMarks = $totalQuestions * $marks;
                                                                    } else {
                                                                        $percentage = 0; // or any other value you prefer when total questions are zero
                                                                    }

                                                                    $exam_status ="<span  class='text-danger'>Fail </span>";
                                                                    if(   $percentage  >= 50) {
                                                                       $exam_status ="<span class='text-success'>Pass </span>";
                                                                    }
                                                                  
                                                                    $status ="<span class='text-danger'>".$row['status']."</span>";
                                                                    if ($row['status'] == "completed") {
                                                                       $status ="<span class='text-success'>".$row['status']."</span>";
                                                                    }else if($row['status'] == "failed") {
                                                                       $status ="<span class='text-danger'>".$row['status']."</span>";
                                                                    }



                                                                    echo "<tr>
                                                                            <td>".$start_increament + (++$key)."</td>
                                                                            <td>" . ($course_title ?? 'N/A') . "</td>
                                                                            <td>" . ($subcourse_title ?? 'N/A') . "</td>
                                                                            <td>" . ($totalQuestions ?? 'N/A') . "</td>
                                                                            <td>" . ($empTotalScore ?? 'N/A') . "</td>
                                                                            <td>" . ($totalMarks ?? 'N/A') . "</td>
                                                                            <td>" . ($row['total_time'] ?? 'N/A') . "</td>
                                                                            <td>" . ($row['taken_time'] ?? 'N/A') . "</td>
                                                                            <td>" . ($status ?? 'N/A') . "</td>
                                                                            <td>" . ($exam_status ?? 'N/A') . "</td>
                                                                            <td>" . ($percentage ?? 'N/A') . "%</td>
                                                                            <td>".$row['created_on']."</td>
                                                                        </tr>";


                                                                        
                                                                }
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                   
                                                </div>
                                                <?php
                                                    if($flag == 0){
                                                        echo '<table><h5 style="text-align:center; margin-top:10px;">No records</h5></table>';
                                                    }
                                                ?>
                                            </div>
                                            <ul class="pagination">
                                           <?php 
                                             if ( $totalRows > $records_per_page) {
                                                $total_pages = ceil($totalRows/$records_per_page); 
                                                if( $page_number > 1) {
                                                    echo '<li><a href="'.BASE_URL.'dashboard.php?page_number='.($page_number - 1).'">prev</a></li>';
                                                }
                                                for($i=$page_number; $i<= $total_pages; $i++) {
                                                    $active = ($page_number == $i) ? "active": "";
                                                    echo '<li><a href="'.BASE_URL.'dashboard.php?page_number='.$i.'" class="'.$active.'">'.$i.'</a>
                                                    </li>';
                                                }
                                                if( $page_number < $total_pages) {
                                                    echo '<li><a href="'.BASE_URL.'dashboard.php?page_number='.($page_number + 1).'">Next</a></li>';
                                                }
                                             }   
                                           ?>
                                            </ul>
                                        </div>
                                        </div>

                                            </div>
                                        </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
<?php
include 'includes/footer.php';
?>