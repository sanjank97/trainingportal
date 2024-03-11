<?php


 $query="select * from course where course_type !=1";
 $results=mysqli_query($con,$query);
 $totalcourse=mysqli_num_rows($results);


 $queryusers="select * from users";
 $resultsUsers=mysqli_query($con,$queryusers);
 $totalusers=mysqli_num_rows($resultsUsers);

 

 $query="select * from employee";
 $results=mysqli_query($con,$query);
 $totalemployee=mysqli_num_rows($results);

$query ="select * from test";
$results = mysqli_query($con, $query);
$total_test = mysqli_num_rows($results);
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
<!--             <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                    <p class="m-b-0">Welcome to Portal</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                </ul>
            </div> -->


             <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <a href="#">
                            <div class="card-block">
                                <a href="<?php echo BASE_URL;?>courses/list.php">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class=""><?=$totalcourse;?></h4>
                                            <h6 class="m-b-0">Course</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fa fa-bar-chart f-28"></i>
                                        </div>
                                    </div>
                                 </a>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="#">
                        <div class="card">
                            <div class="card-block">
                            <a href="<?php echo BASE_URL;?>users/list.php">
                                <div class="row align-items-center">
                                   
                                       <div class="col-8">
                                            <h4 class=""><?php echo $totalusers;?></h4>
                                            <h6 class="m-b-0">Users</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fa fa-file-text-o f-28"></i>
                                        </div>
                                    
                                </div>
                                </a>
                            </div>
                        </div>
                     </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="#">
                        <div class="card">
                            <div class="card-block">
                              <a href="<?php echo BASE_URL;?>employee/list.php">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h4 class=""><?php echo  $totalemployee;?></h4>
                                            <h6 class="m-b-0">Employee</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <i class="fa fa-calendar-check-o f-28"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                   
                      <div class="card">
                        <div class="card-block">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h4 class=""><?php echo  $total_test;?></h4>
                                    <h6 class="m-b-0"> Total Test </h6>
                                </div>
                                <div class="col-4 text-right">
                                    <i class="fa fa-hand-o-down f-28"></i>
                                </div>
                            </div>
                        </div>
                    </div>
              
                </div>





        </div>
    </div>
</div>