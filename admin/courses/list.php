<?php

include '../includes/header_top.php';
include('../../db_connection.php');
$course_type =0;
$grand_test_link_parameter ="";
if (isset($_GET['course_type']) ) {
    $course_type =  $_GET['course_type'];
    $grand_test_link_parameter ='&course_type='.$course_type;
}
$heading = ($course_type  =='1') ?'Exclusive Test' : 'Courses';

$query = "select * from course where course_type='$course_type'";
$course_result = mysqli_query($con, $query);
$totalRows = mysqli_num_rows($course_result);

$records_per_page = 10;                       
$page_number = isset($_GET["page_number"]) ? $_GET["page_number"] : 1;
$offset = ($page_number - 1) * $records_per_page;

$query = "select * from course where course_type='$course_type' ORDER BY id desc LIMIT $offset, $records_per_page";
$result = mysqli_query($con, $query);
$num = mysqli_num_rows($result);



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
                                    <!-- Basic table card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php echo $heading;?></h5>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                Add
                                            </button>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Course Title</th>
                                                            <th>Course Type</th>
                                                            <th>Question</th>
                                                            <?php if ($course_type==0) { echo '<th>Subcourse</th>';} ?>  
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($num > 0) {
                                                            $start_increament = $records_per_page *($page_number -1);
                                                            $key = 0;
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<tr>
                                                                    <th scope="row">' . $start_increament + (++$key). '</th>';
                                                                        if ($course_type==1) {
                                                                            echo '<td>'.$row['course_title'].'</td>';
                                                                        }else{
                                                                            echo '<td> <a href="' . BASE_URL . 'courses/view.php?course_id=' . $row['course_id'] . '"
                                                                            style="color:blue;margin-right:10px;">'.$row['course_title'].'</a></td>';
                                                                        }
                                                                         echo '<td>' . (($row['course_type']==0)?'Default':'Special') . '</td>
                                                                        <td><a href="' . BASE_URL . 'managequestion/list.php?course_id=' . $row['course_id'] . '"
                                                                        style="color:blue;margin-left:10px;">View/Add</a></td>';
                                                                        if( $course_type ==0) {
                                                                            echo '<td><a href="' . BASE_URL . 'courses/view.php?course_id=' . $row['course_id'] . '"
                                                                            style="color:blue;margin-right:10px;">View</a></td>';
                                                                        }
                                                                        echo '<td><a href="#" class=" course_edit_btn" data-toggle="modal"
                                                                        data-target="#myModal2"  data-edit-id="' . $row['course_id'] . '"><i class="ti-pencil-alt edit_icon"  ></i></a>  
                                                                        <a href="#"
                                                                        style="color:red;margin-left:10px;" data-delete-id="' . $row['course_id'] . '" class="cousre-delete-btn"><i class="ti-trash delete_icon" ></i></a>  
                                                                    </td>
                                                                </tr>';
                                                                // print_r($row);
                                                            }
                                                        }else{
                                                            echo "<tr><td colspan='6' class='text-center'><strong>Not Found.!</strong></td></tr>";
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
                                                    echo '<li><a href="'.BASE_URL.'courses/list.php?page_number='.($page_number - 1).$grand_test_link_parameter.'">prev</a></li>';
                                                }
                                                for($i=$page_number; $i<= $total_pages; $i++) {
                                                    $active = ($page_number == $i) ? "active": "";
                                                    echo '<li><a href="'.BASE_URL.'courses/list.php?page_number='.$i.$grand_test_link_parameter.'" class="'.$active.'">'.$i.'</a>
                                                    </li>';
                                                }
                                                if( $page_number < $total_pages) {
                                                    echo '<li><a href="'.BASE_URL.'courses/list.php?page_number='.($page_number + 1).$grand_test_link_parameter.'">Next</a></li>';
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
                                                <h5>Add Courses</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="card-block">
                                                <form class="form-material" action="add_course.php" id="addcourse" enctype="multipart/form-data" method="POST">
                                                    <input type="hidden" value="<?php echo ($course_type ==1)?'1':'0'; ?>"  name="course_type" id='course_type' />
                                                   <div class="form-group form-default">
                                                        <label class="float-label course_level">Course Title</label>
                                                        <input type="text" name="course_title" placeholder="Course Title" class="form-control" required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                
                                                    <div class ='course_property_wrapper' style ='display:<?php echo ($course_type ==1)?"none":"block"; ?>'>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Video</label>
                                                            <input type="file" name="course_video[]" id="course_video" class="form-control" >
                                                            <span class="form-bar"></span>
                                                        </div>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Must be watch</label>
                                                             <input type="radio" name="watch_priority" id="watch_priority_video" value="0" checked />
                                                            <span class="form-bar"></span>
                                                        </div>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Youtube Embed URL (Optional)</label>
                                                            <input type="text" placeholder="Youtube Embed URL" name="course_video_link" class="form-control">
                                                            <span class="form-bar"></span>
                                                        </div>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Pdf (Optional)</label>
                                                            <input type="file" name="course_pdf[]" id="coursePdf" class="form-control">
                                                            <span class="form-bar"></span>
                                                        </div>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Must be view</label>
                                                             <input type="radio" name="watch_priority" id="priority_view" value="1" />
                                                            <span class="form-bar"></span>
                                                        </div>
                                                        <div class="form-group form-default">
                                                            <label class="float-label">Thumbnail (Optional)</label>
                                                            <input type="file" name="course_thumbnail" class="form-control"
                                                            >
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="site_btn" name="add_course" id="addcoursesubmit" value="Submit">
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
                                                <form class="form-material course_edit_form" action="add_course.php" enctype="multipart/form-data" method="POST">


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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).ready(function() {
        $('#addcourse').submit(function(event) {
            var formthis     = $(this);
            var videofiles   = $('#course_video')[0].files;
            var videoPdf     = $('#coursePdf')[0].files;
            let checkedVideo = $("input[name='watch_priority']:checked").val();
            //video = 0
            //Pdf = 1
            if($('#course_type').val() == 0) {
                return toverify(videofiles,videoPdf,checkedVideo);
            }
           
            
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
                url: 'add_course.php',
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
                        url: 'add_course.php',
                        data: {
                            'data_delete_id': data_delete_id
                        },
                        // contentType: "application/json; charset=utf-8",
                        dataType: 'text',
                        // traditional: true,
                        success: function(data) {
                            window.location.reload();
                            // Swal.fire(
                            //     'Deleted!',
                            //     'Your Course has been deleted.',
                            //     'success'
                            // ).then((result) => {
                            //     window.location.reload();
                            // })
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

        $(document).on('click','#course_type',function(){
            $('.course_property_wrapper').css('display','block');
            $('.course_level').text('Course Title');
            if($(this).val() == 1) {
              $('.course_property_wrapper').css('display','none');
              $('.course_level').text('Grand Test Title');
            }

        });

    });
</script>


<?php
include '../includes/footer.php';
?>