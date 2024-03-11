<?php
    include '../includes/header_top.php';
    include('../../db_connection.php');
     $empID =  $_GET['employee_id'];

     $records_per_page = 50;                       
     $page_number = isset($_GET["page_number"]) ? $_GET["page_number"] : 1;
     $offset = ($page_number - 1) * $records_per_page;
     
     $querys      = "SELECT * FROM test WHERE employee_id='$empID'";
     $results     =  mysqli_query($con, $querys);
     $totalRows   =  mysqli_num_rows($results); 

     $query    = "SELECT * FROM test WHERE employee_id='$empID' ORDER BY id DESC LIMIT $offset, $records_per_page";
     $result   =  mysqli_query($con, $query);
     $test_num =  mysqli_num_rows($result); 


    $Equery="select * from employee WHERE id ='$empID'";
    $Eresult=mysqli_query($con,$Equery);
    while($Erow=mysqli_fetch_assoc($Eresult))
    {
        $emplName = $Erow['name'];
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
                      <!-- Page-header start -->
                    <?php
                      include '../includes/dashboard.php';
                    ?>
                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">

                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="wrap_back_button">
                                            <button onclick="history.back()">Back</button>
                                        </div>
                                    <?php 
                                    if(isset($_SESSION['success']))
                                    {
                                        echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>'; 
                                        unset($_SESSION['success']);                                      
                                    }
                                    if(isset($_SESSION['error']))
                                    {
                                        echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>'; 
                                        unset($_SESSION['error']);                                      
                                    }
                                    ?>    
                                        <!-- Basic table card start -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 style="text-transform:uppercase;"><?php echo $emplName;?></h5>
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
                                                            <th>Course</th>
                                                            <th>Subcourse</th>
                                                            <th>N.of Q.</th>
                                                            <th>Score</th>
                                                            <th>Total Score</th>
                                                            <th>Exma Time(H:M)</th>
                                                            <th>Taken Time(H:M:S)</th>
                                                            <th>Status</th>
                                                            <th>Exam Status</th>
                                                            <th>% Score</th>

                                                            <th>Attempt Date</th>
                                                              
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 

                                                            $query          ="select * from setting";
                                                            $setting_result = mysqli_query($con, $query);
                                                            $setting_row    = mysqli_fetch_assoc($setting_result);
                                                 
                                                        if ( $test_num >0 ) {
                                                            $start_increament = $records_per_page *($page_number -1);
                                                            $key=0;
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                 $course_id = $row['course_id'];
                                                                 $query ="select course_title from course where course_id='". $course_id ."'";
                                                                 $result1= mysqli_query($con, $query);
                                                                 $course_title = mysqli_fetch_assoc($result1)['course_title'];
                                                                 $subcourse_id = $row['subcourse_id'];
                                                                 $query  ="select title from subcourse where id='". $subcourse_id ."'";
                                                                 $result2= mysqli_query($con, $query);
                                                                 $num    = mysqli_num_rows($result2);
                                                                 $subcourse_title ="";
                                                                 if($num >0){
                                                                    $subcourse_title = mysqli_fetch_assoc($result2)['title'];
                                                                 }

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
                                                                 
                                                                
                                                                 $exam_status ="<span style='color:red'>Fail </span>";
                                                                 if(   $percentage  >= 50) {
                                                                    $exam_status ="<span style='color:green'>Pass </span>";
                                                                 }
                                                               
                                                                 $status ="<span style='color:red'>".$row['status']."</span>";
                                                                 if ($row['status'] == "completed") {
                                                                    $status ="<span style='color:green'>".$row['status']."</span>";
                                                                 }else if($row['status'] == "inprogress") {
                                                                    $status ="<span style='color:yellow'>".$row['status']."</span>";
                                                                 }


                                                                $date_time  = $row['created_on'];                                                                                               
                                                                $timestamp  = strtotime($date_time);                                       
                                                                $hour       = date("H", $timestamp);
                                                                $minute     = date("i", $timestamp);                                     
                                                                $ampm       = "am";
                                                                if ($hour >= 12) {
                                                                    $ampm = "pm";
                                                                }
                                                                $date = date("d M Y", $timestamp);
                                                                $newtime = sprintf("%02d:%02d %s, %s", $hour, $minute, $ampm, $date);
                                                                echo "<tr data-id=".$row['id'].">
                                                                          <td>".$start_increament + (++$key)."</td>
                                                                          <td>".$course_title."</td>
                                                                          <td>".$subcourse_title."</td>
                                                                          <td>".$totalQuestions."</td>
                                                                          <td>".$empTotalScore."</td>
                                                                          <td>".$totalMarks."</td>
                                                                          <td>".$row['total_time']."</td>
                                                                          <td>".$row['taken_time']."</td>
                                                                          <td>".$status ."</td>
                                                                          <td>".$exam_status."</td>
                                                                          <td>".$percentage.'%'."</td>
                                                                          <td>".$newtime."</td>
                                                                </tr>";
                                                                // print_r($row);
                                                            }
                                                            } else {

                                                              echo "<tr> <th>Not Found </th></tr>";
                                                            }
                                                        

                                                       ?>

                                                           
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <ul class="pagination">
                                           <?php 
                                             if ( $totalRows > $records_per_page) {
                                                $total_pages = ceil($totalRows/$records_per_page); 
                                                if( $page_number > 1) {
                                                    echo '<li><a href="'.BASE_URL.'employee/viewtest.php?page_number='.($page_number - 1).'&employee_id='.$empID.'">prev</a></li>';
                                                }
                                                for($i=$page_number; $i<= $total_pages; $i++) {
                                                    $active = ($page_number == $i) ? "active": "";
                                                    echo '<li><a href="'.BASE_URL.'employee/viewtest.php?page_number='.$i.'&employee_id='.$empID.'" class="'.$active.'">'.$i.'</a>
                                                    </li>';
                                                }
                                                if( $page_number < $total_pages) {
                                                    echo '<li><a href="'.BASE_URL.'employee/viewtest.php?page_number='.($page_number + 1).'&employee_id='.$empID.'">Next</a></li>';
                                                }
                                             }   
                                           ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->

                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
          <div class="pcoded-inner-content">
              <div class="main-body">
                  <div class="#">
                      <div class="page-body">
                     <div class="row">
                              <div class="col-md-12">

                                  <div class="card">  
                                      <div class="card-header">
                                            <h5>Add</h5>
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                     </div>                            
                                      <div class="card-block">
                                          <form class="form-material" action="employee_handler.php" method="POST" enctype="multipart/form-data">
                                              <div class="form-group form-default">
                                                 <label class="float-label">Name</label>
                                                  <input type="text" name="name" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                              <div class="form-group form-default">
                                                 <label class="float-label">Email</label>
                                                  <input type="email" name="email" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                              <div class="form-group form-default">
                                                 <label class="float-label">Password</label>
                                                  <input type="password" name="password" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                              <div class="form-group form-default">
                                                 <label class="float-label">Repeat Password</label>
                                                  <input type="password" name="re_password" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                              <div class="form-group form-default">
                                                 <label class="float-label">Mobile No.</label>
                                                  <input type="text" name="mobile" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                              <div class="form-group form-default">
                                                 <label class="float-label">Date Of Birth</label>
                                                  <input type="date" name="dob" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                              </div>
                                             
                                             <div class="row">
                                                  <div class="col-sm-6">
                                                      <input type="submit" class="site_btn"  value="Submit" name="add_employee">
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div id="styleSelector">
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Employee Edit modal start-->
<div class="modal" id="myModal2">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
          <div class="pcoded-inner-content">
              <div class="main-body">
                  <div class="#">
                      <div class="page-body">
                     <div class="row">
                              <div class="col-md-12">
                                  <div class="card">
                                    <div class="card-header">
                                        <h5>Edit</h5>
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                    </div>
                                      <div class="card-block">
                                          <form class="form-material edit-employee-form" action="employee_handler.php" method="POST" enctype="multipart/form-data">
                               
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div id="styleSelector">
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!--employee Edit modal End-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
      $('.emp_edit_btn').click(function(){
        let data_edit_id=$(this).attr('data-edit-id');
        console.log(data_edit_id);
        $.ajax({
            type: 'post',
            url: 'employee_handler.php',
            data: {'data_edit_id':data_edit_id},
            // contentType: "application/json; charset=utf-8",
            dataType:'html',
            // traditional: true,
            success: function (data) {
               $('.edit-employee-form').html(data);
            }
        });
      });
      $('.emp_delete_btn').click(function(){
        let data_delete_id=$(this).attr('data-delete-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'employee_handler.php',
                    data: {'data_delete_id':data_delete_id},
                    // contentType: "application/json; charset=utf-8",
                    dataType:'text',
                    // traditional: true,
                    success: function (data) {                  
                        Swal.fire(
                        'Deleted!',
                        'Employee has been deleted.',
                        'success'
                        ).then((result) => {
                            window.location.href="list.php";
                        })
                    }
                });

            }
         })
      });
      $('.emp_status_btn').click(function(){
        let data_status_id =jQuery(this).attr('data-status-id');
        let fatoggleon     =jQuery(this).find('i').hasClass("fa-toggle-on");
          
        if(fatoggleon){
           jQuery(this).find('i').removeClass("fa-toggle-on");
           jQuery(this).find('i').addClass("fa-toggle-off");
        }else{
           jQuery(this).find('i').removeClass("fa-toggle-off");
           jQuery(this).find('i').addClass("fa-toggle-on");
        }
          
          
        console.log(data_status_id);
        $.ajax({
            type: 'post',
            url: 'employee_handler.php',
            data: {'data_status_id':data_status_id},
            // contentType: "application/json; charset=utf-8",
            // traditional: true,
            dataType:'text',
            success: function (data) {
              //  window.location.href="list.php";           
            }
        });
      });


    })
</script>
<?php
include '../includes/footer.php';
?>