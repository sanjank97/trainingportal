<?php
    include 'includes/header_top.php';
    include('../db_connection.php'); 
    if(isset($_SESSION['user_id']))
    {
        

        $user_id=$_SESSION['user_id'];
        $query="select * from users where id=$user_id";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_assoc($result);

        $query="select * from user_role";
        $result=mysqli_query($con,$query);
        $user_role=mysqli_fetch_all ($result, MYSQLI_ASSOC);
      
        $query ="select * from setting";
        $setting_result = mysqli_query($con, $query);
        $setting_row =mysqli_fetch_assoc($setting_result);

       
    }
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
                        <div class="main-body">
                            <div class="page-wrapper">
                        <?php
                            include 'includes/dashboard.php';
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>General Setting</h5>
                                    </div>

                                    <div class="card-block">
                                        <form action ='admin_handler.php' method="post">
                                            <label class="float-label">Marks (Default 1 Mark Per Question)</label>
                                            <input type ="number"  value ="<?php echo $setting_row['per_marks']; ?>" class ="form-control " placeholder ="Enter Marks Per Question" min="1" max="10" name="marks_per_question">
                                            <br>
                                            <label class="float-label">Exam Time (Default 1 Minute Per Question)</label>
                                            <input type ="number" value ="<?php echo $setting_row['per_question_time']; ?>"  class ="form-control " placeholder ="Enter Time In minutes" min="1" max="10"  name="time_per_question">
                                            <br>
                                            <label class="float-label">Grand Test Total Question</label>
                                            <input type ="number" value ="<?php echo $setting_row['grandtest_total']; ?>"  class ="form-control " placeholder ="Enter Total Number"  name="grandtest_total">
                                            <br>
                                            <input type="submit" value="Save" class="btn btn-primary" name="general_setting" />
                                      </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Main-body end -->
                        </div>
                        <div id="styleSelector">

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
</div>

<script>
$(document).ready(function() {


});
</script>

<?php
include 'includes/footer.php';
?>