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
     $query="select * from course where course_Type = 0 ";
     $result=mysqli_query($con,$query);
     $num=mysqli_num_rows($result);
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

                <div class="pcoded-content main-body">
                    <!-- Page-header start -->
                    <div class="page-wrapper" style="padding-left: 15px;"> 
                        <div class="card">
                            <div class="card-header">
                                <h5>Courses</h5>
                                <div class="card-header-right">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="pcoded-inner-content alllist_course">
                        <div class="row">
                            <?php 
                                if($num >0)
                                {
                                    while($row=mysqli_fetch_assoc($result))
                                    {
                                        if(strlen($row['course_thumbnail']) > 0){ 
                                           $thumbnail = BASE_URL.'admin/uploads/'.$row['course_thumbnail'];
                                        }else{
                                           $thumbnail =  BASE_URL.'/assets/images/Placeholder_view_vector.svg.png';
                                        }
                                        echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <a href="'.BASE_URL.'courses/list.php?course_id='.$row['course_id'].'">
                                                    <div class="card">
                                                        <div class="wrap_image">
                                                            <img src="'.$thumbnail.'">
                                                        </div>
                                                        <div class="card-body">
                                                            <h2 class="card-title">'.$row['course_title'].'</h2>
                                                           
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>';
                                    }
                                }else{
                                    echo "<h5>Not Found.!</h5>";
                                }
                            ?>
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