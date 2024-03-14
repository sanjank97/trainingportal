<?php
//     include '../includes/header_top.php';
//     include('../../db_connection.php');
//     $query="select * from course where";
//     $result=mysqli_query($con,$query);
//     $num=mysqli_num_rows($result);     
?>


<?php
session_start();
if (!isset($_SESSION['admin'])) {
header("Location :../index.php");
}
if (isset($_SESSION['test_session_id'])) {
header("Location :test.php");
}
include '../includes/header_top.php';
include('../../db_connection.php');
if (!isset($_GET['course_id'])) {
header("Location:all_list.php");
}
$query = "select * from course where course_id='" . $_GET['course_id'] . "'";
$result = mysqli_query($con, $query);

$row_course = mysqli_fetch_assoc($result);

$course_video_list    = explode(',', $row_course['course_video']);
$course_pdf_list      = explode(',', $row_course['course_pdf']);

$course_video_link   = $row_course['video_link'];


//Fetch subcourse
$subcourse_query = "select * from subcourse where courseID='" . $_GET['course_id'] . "'";
$result_query    = mysqli_query($con, $subcourse_query);




?>
<style>
.list {
    display: flex;
    justify-content: end;
    align-items: center;
    gap: 20px;
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
                <?php
                include '../includes/dashboard.php';
                ?>
                <div class="pcoded-inner-content listcourse">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <?php
                                if (isset($_SESSION['success'])) {
                                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                                    unset($_SESSION['success']);
                                }
                                if (isset($_SESSION['error'])) {
                                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                                    unset($_SESSION['error']);
                                }
                                ?>
                                <div class="card wrap_back_button_header" style="margin-bottom:15px;">
                                    <div class="card-header">
                                        <h5>Courses</h5>
                                        <div class="wrap_back_button">
                                            <button onclick="history.back()">Back</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="card"  style="margin-botton:15px;">
                                    <div class="card-header">
                                        <h5><?php echo $row_course['course_title']; ?></h5>                                         
                                    </div>
                                
                                <!-- Grid row -->
                                <div class="row courseContent">

                                    <?php
                                        

                                            foreach ($course_video_list as $video) {
                                                if (!empty($video)) {
                                                    echo '<div class="col-md-4 mb-4">  
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <video width="320" height="240" controls>
                                                            <source src="' . THEME_ASSET . '/' . $video . '" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <h3 class="text-left font-up font-bold indigo-text mb-0"><strong>' . $row['course_title'] . '</strong></h3>
                                                    </div>';
                                                    }
                                            }
                                            foreach ($course_pdf_list as $pdf_list) {
                                                if (!empty($pdf_list)) {
                                                    echo '<div class="col-md-4 mb-4">
                                                        
                                                        <a href="' . THEME_ASSET . 'pdf/' . $pdf_list . '" target="_blank">
                                                        <div class="wrap-image pdf-image">
                                                        <img src="https://indiabestsite.com/aaron/assets/images/pdf.png">
                                                        </div>                                                         
                                                        </a>
                                                        

                                                </div>';
                                                }
                                            }
                                        
                                    

                                    ?>
                                        <?php
                                                if (!empty($course_video_link)) {
                                                    echo '<div class="col-md-4 mb-4">
                                                                <div class="card">

                                                                <div class="card-block">
                                                                <iframe width="100%" height="284" src="' . $course_video_link . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                                </div>

                                                                </div>
                                                            </div>';
                                                }
                                        ?>
                                </div>
                            </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Sub Courses</h5>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                            Add
                                        </button>
                                    </div>
                                </div>
                                <div class="page-body">

                                    <?php

                                    $num_subcourse = mysqli_num_rows($result_query);

                                    if ($num_subcourse > 0) {

                                        while ($row = mysqli_fetch_assoc($result_query)) {

                                            $subcourse_video_list  = explode(',', $row['video']);
                                            $subcourse_pdf_list    = explode(',', $row['pdf']);
                                            $video_link            = $row['video_link'];

                                    ?>
                                            <div class="card">
                                                <div class="card-block">
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Course Title: </label>
                                                        <strong><?php echo $row['title']; ?></strong>
                                                        <span class="form-bar"></span>
                                                        <span class="action_wrapper" style="float:right;">
                                                            <a href="#" class=" course_edit_btn" data-toggle="modal" data-target="#myModal2" data-edit-id="<?php echo $row['id']; ?>">Edit</a>
                                                            <a href="#" style="color:red;margin-left:10px;" data-delete-id="<?php echo $row['id']; ?>" class="cousre-delete-btn">Delete</a>
                                                        </span>

                                                    </div>

                                                    <div class="row courseContent">
                                                        <?php
                                                        
                                                        foreach ($subcourse_video_list as $video) {
                                                            if (!empty($video)) {
                                                                echo '<div class="col-md-4 mb-4">
                                                                        
                                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                                <video width="320" height="240" controls>
                                                                                    <source src="' . THEME_ASSET . 'course/video/' . $video . '" type="video/mp4">
                                                                                
                                                                                    Your browser does not support the video tag.
                                                                                </video>
                                                                                </div>
                                                                                <h3 class="text-left font-up font-bold indigo-text mb-0"><strong>' . $row['course_title'] . '</strong></h3>
                                                                        
                                                                    </div>';
                                                                }
                                                        }
                                                        ?>
                                                        <!-- Grid column -->
                                                        <!-- you tube empeded link -->
                                                        <!-- PDF -->
                                                        <?php
                                                        if (!empty($video_link)) {
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

                                                            if (!empty($pdf_list)) {
                                                                echo '<div class="col-md-4 mb-4">


                                                                                
                                                                                <a href="' . THEME_ASSET . 'course/pdf/' . $pdf_list . '" target="_blank">
                                                                                <div class="wrap-image pdf-image">
                                                                                <img src="https://indiabestsite.com/aaron/assets/images/pdf.png">
                                                                                </div>
                                                                        
                                                                                </a>
                                                                                

                                                                        </div>';
                                                            }
                                                        }
                                                        ?>



                                                        <!-- PDF -->
                                                    </div>
                                                </div>


                                            </div>
                                    <?php
                                        }
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
                                            <h5>Add Sub Courses</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="card-block">
                                            <form class="form-material" id="addsubcourse"  action="courseshandler.php" enctype="multipart/form-data" method="POST">
                                                <input type="text" value="<?php echo $_GET['course_id']; ?>" name="courseid" hidden>
                                                <div class="form-group form-default">
                                                    <label class="float-label">Course Title</label>
                                                    <input type="text" name="course_title" class="form-control" required="">
                                                    <span class="form-bar"></span>
                                                </div>
                                                <div class="form-group form-default">
                                                    <label class="float-label">Video ( Multiple )</label>
                                                    <input type="file" name="course_video[]" id="course_video" class="form-control" >
                                                    <span class="form-bar"></span>
                                                </div>
                                                <div class="form-group form-default">
                                                        <label class="float-label">Video Must be watch</label>
                                                            <input type="radio" name="watch_priority" value="0" checked />
                                                        <span class="form-bar"></span>
                                                    </div>
                                                <div class="form-group form-default">
                                                    <label class="float-label">Youtube Embed URL (Optional)</label>
                                                    <input type="text" placeholder="Youtube Embed URL" name="course_video_link" class="form-control">
                                                    <span class="form-bar"></span>
                                                </div>
                                                <div class="form-group form-default">
                                                    <label class="float-label">Pdf</label>
                                                    <input type="file" name="course_pdf[]" id="coursePdf" class="form-control">
                                                    <span class="form-bar"></span>
                                                </div>
                                                <div class="form-group form-default">
                                                        <label class="float-label">PDF Must be watch</label>
                                                            <input type="radio" name="watch_priority" value="1" />
                                                        <span class="form-bar"></span>
                                                    </div>
                                      
                                                        <input type="submit" class="site_btn" name="add_sub_course" value="Submit">
                                                 
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
<!--Edit course modal start-->
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
                                            <h5>Edit Courses</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="card-block">
                                            <form class="form-material course_edit_form" action="courseshandler.php" enctype="multipart/form-data" method="POST">


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
<!--edit course model End-->

<!--edit course model End-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function() {
        $('#addsubcourse').submit(function(event) {

            var videofiles   = $('#course_video')[0].files;
            var videoPdf     = $('#coursePdf')[0].files;
            let checkedVideo = $("input[name='watch_priority']:checked").val(); 
            return toverify(videofiles,videoPdf,checkedVideo);
            
           
            
        });

        $('.course_edit_form').submit(function(event) {
        
            var videofiles   = $('.course_edit_form #course_video')[0].files;
            var videoPdf     = $('.course_edit_form #coursePdf')[0].files;
            let checkedVideo = $(".course_edit_form input[name='watch_priority']:checked").val();
            //video = 0
            //Pdf = 1
          // return toverify(videofiles,videoPdf,checkedVideo);
          

        });
    });
    function toverify(videofiles,videoPdf,checkedVideo){
            if(checkedVideo == 0){
                if (videofiles.length === 0) {
                    alert("Video must be upload");
                    return false;
                } else {
                    console.log("File uploaded");
                    return true;
                }
            }
            else{
                if (videoPdf.length === 0) {
                    alert("PDF must be upload");
                    return false;
                } else {
                    console.log("File uploaded");
                    return true;
                }  
            }
        }




$(document).ready(function() {
    $('.course_edit_btn').click(function() {
        let data_edit_id = $(this).attr('data-edit-id');
        $.ajax({
            type: 'post',
            url: 'courseshandler.php',
            data: {
                'data_edit_id': data_edit_id
            },
            // contentType: "application/json; charset=utf-8",
            dataType: 'html',
            // traditional: true,
            success: function(data) {
                $('.course_edit_form').html(data);
            }
        });
    });
    $('.cousre-delete-btn').click(function() {
        let data_delete_id = $(this).attr('data-delete-id');
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
                    url: 'courseshandler.php',
                    data: {
                        'data_delete_id': data_delete_id
                    },
                    // contentType: "application/json; charset=utf-8",
                    dataType: 'text',
                    // traditional: true,
                    success: function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Your Course has been deleted.',
                            'success'
                        ).then((result) => {
                            window.location.reload();
                        })
                    }
                });

            }
        })
    });
    $(document).on('click', '.remove_course_video', function() {
        var course_video_item = $(this).attr('data-id');
        var removed_course_video = $('input[name=removed_course_video]').val();
        $('input[name=removed_course_video]').val(removed_course_video + ',' + course_video_item);

        var current_course_video = $('input[name=current_course_video]').val();
        current_course_video = current_course_video.replace(course_video_item, '');
        $('input[name=current_course_video]').val(current_course_video);
        alert($course_video_item);
    });

    $(document).on('click', '.remove_course_pdf', function() {
        var course_pdf_item = $(this).attr('data-id');
        var removed_course_pdf = $('input[name=removed_course_pdf]').val();
        $('input[name=removed_course_pdf]').val(removed_course_pdf + ',' + course_pdf_item);

        var current_course_pdf = $('input[name=current_pdf]').val();
        current_course_pdf = current_course_pdf.replace(course_pdf_item, '');
        $('input[name=current_pdf]').val(current_course_pdf);
        alert($course_pdf_item);
    });

})
</script>





<?php
include '../includes/footer.php';
?>