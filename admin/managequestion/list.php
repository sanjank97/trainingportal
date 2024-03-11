<?php
     include '../includes/header_top.php';
     include('../../db_connection.php');
     if(!isset($_GET['course_id']))
     {
      header("Location:../courses/list.php");
     }
     $course_id=$_GET['course_id']; 

     $query="select * from subcourse where courseID='".$course_id."'";
     $subcourse=mysqli_query($con,$query);

 
     $query="select * from course where course_id='".$course_id."'";
     $course=mysqli_query($con,$query);
     $course_title ="";

     if(mysqli_num_rows($course) < 1)
     {   
        header("Location:../courses/list.php");
     }
     $course_row =  mysqli_fetch_assoc($course);
     $course_title = $course_row['course_title'];
     $course_type =  $course_row['course_type'];


    

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
            
                    <!-- Page-header end -->
                    <div class="pcoded-inner-content">
                        <!-- Main-body start -->
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
                        <div class="main-body">

                            <div class="page-wrapper">
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <div class="wrap_back_button">
                                        <button onclick="history.back()">Back</button>
                                    </div>
                                    <!-- Basic table card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Question List</h5>
                                            <select name="course_or_subcourse" id="course_or_subcourse"
                                                class="form-control form-group courseType<?php echo $course_type;?>">
                                                <?php 
                                                $selected ="";
                                                if(isset($_GET['question_appearance'])){
                                                    $selected =  ($_GET['question_appearance'] ==$course_id)?'selected':'';
                                                }
                                                echo "<option value='".$course_id."' $selected>". $course_title."</option>"; 
                                                if($course_type ==0) {
                                                ?>

                                                <optgroup label="<?php echo $course_title;?>">
                                                    <?php 
                                                       
                                                         while($row = mysqli_fetch_assoc($subcourse)) {
                                                            $selected ="";
                                                            if(isset($_GET['question_appearance'])){
                                                                $selected =  ($_GET['question_appearance'] == $row['id'])?'selected':'';
                                                            }
                                                          
                                                            echo "<option value='".$row['id']."' $selected>".$row['title']."</option>";
                                                         }
                                                         ?>
                                                </optgroup>
                                                 <?php }?>
                                            </select>
                                            <button type="button" class="btn btn-primary addQuestionButton"
                                                data-toggle="modal" data-target="#myModal">
                                                Add
                                            </button>

                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Question Title</th>
                                                            <th>Question Options</th>
                                                            <th>Correct Options</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body_content">
                                                        <?php
                                                        $question_appearance = isset($_GET['question_appearance'])?$_GET['question_appearance']:$course_id;

                                                        $query="select * from question where course_id='".$course_id."' AND question_appearance='".$question_appearance."' ";
                                                        $result=mysqli_query($con,$query);
                                                        $num=mysqli_num_rows($result);
                                                        if($num > 0)
                                                        {
                                                            $key=0;
                                                            while($row=mysqli_fetch_assoc($result))
                                                            {
                                                                
                                                              
                                                                  echo '<tr>
                                                                    <th scope="row">'.++$key.'</th>
                                                                    <td>'.$row['question'].'</td>
                                                                    <td>[a,b,c,d]</td>
                                                                    <td>'.$row['correct_ans'].'</td>
                                                                    <td>  
                                                                    <a href="#" class="course_edit_btn" data-edit-id="'.$row['id'].'" data-toggle="modal" data-target="#myModal2"><i class="ti-pencil-alt edit_icon"  ></i></a>
                                                                    <a href="#" class="course_delete_btn"  data-delete-id="'.$row['id'].'" course-id="'.$row['course_id'].'" question-appearance="'.$row['question_appearance'].'" style="color:red;margin-left:10px;"><i class="ti-trash delete_icon" ></i></a>
                                                                    </td>
                                                                   </tr>';
                                                            }
                                                            
                                                        }else{
                                                           echo "<tr>
                                                                      <td><h3>Not found</h3></td>
                                                                   </tr>";
                                                         
                                                        }
                                                       
                                                       
                                                       ?>



                                                    </tbody>
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
                                                <h5>Add Question</h5>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="card-block">
                                                <form class="form-material" action="question_handler.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Question Title</label>
                                                        <input type="text" name="question" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Answer A</label>
                                                        <input type="text" name="ans_a" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Answer B</label>
                                                        <input type="text" name="ans_b" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Answer C</label>
                                                        <input type="text" name="ans_c" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Answer D</label>
                                                        <input type="text" name="ans_d" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Correct Answer</label>
                                                        <input type="text" name="correct_ans" id="correct_ans" class="form-control"
                                                           placeholder="Enter only a,b,c,d in lowercase" required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <input type="hidden" name="course_id"
                                                        value="<?php echo $course_id; ?>" />
                                                    <input type="hidden" id="question_appearance"
                                                        name="question_appearance" value="<?php echo $course_id; ?>" />
                                                    <div class="row">
                                                    <input type="submit" class="site_btn" value="Submit"
                                                                name="add_question">
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
                                                <form class="form-material edit-question-form"
                                                    action="question_handler.php" method="POST"
                                                    enctype="multipart/form-data">

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// let course_id ='<?php echo $course_id; ?>';
// let selected_course_id = $('#course_or_subcourse').val();    
// ajaxCallforSelectedCourse(course_id, selected_course_id);

$(document).ready(function() {


    $(document).on('keypress', '#correct_ans', function(e){
    var key = String.fromCharCode(e.which);
    if (key !== 'a' && key !== 'b' && key !== 'c' && key !== 'd') {
        e.preventDefault();
    }
});

    $(document).on('click', '.course_edit_btn', function() {

        let data_edit_id = $(this).attr('data-edit-id');
        console.log("data_edit_id", data_edit_id);
        $.ajax({
            type: 'post',
            url: 'question_handler.php',
            data: {
                'data_edit_id': data_edit_id
            },
            // contentType: "application/json; charset=utf-8",
            dataType: 'html',
            // traditional: true,
            success: function(data) {

                $('.edit-question-form').html(data);
            }
        });
    });


    $(document).on('click', '.course_delete_btn', function() {
        let data_delete_id = $(this).attr('data-delete-id');
        let course_id = $(this).attr('course-id');
        let question_appearance = $(this).attr('question-appearance');
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
                    url: 'question_handler.php',
                    data: {
                        'data_delete_id': data_delete_id
                    },
                    // contentType: "application/json; charset=utf-8",
                    dataType: 'text',
                    // traditional: true,
                    success: function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Question_handler has been deleted.',
                            'success'
                        ).then((result) => {
                            window.location.href =
                                `<?php echo BASE_URL;?>managequestion/list.php?course_id=${course_id}&question_appearance=${question_appearance}`;


                        });
                    }
                });

            }
        })
    });


    $('#course_or_subcourse').change(function() {
        let course_id = '<?php echo $course_id;?>';
        let selected_course_id = $(this).val();
        // ajaxCallforSelectedCourse(course_id, selected_course_id);
        Swal.fire({
            icon: 'success',
            text: 'Course has been changed!'
        }).then((result) => {
            window.location.href =
                `<?php echo BASE_URL;?>managequestion/list.php?course_id=${course_id}&question_appearance=${selected_course_id}`;
        })

    });



});
// function ajaxCallforSelectedCourse(course_id,selected_course_id) {
//     $.ajax({
//             type: 'post',
//             url: 'question_handler.php',
//             data: {
//                 'course_id': course_id,
//                 'selected_course_id': selected_course_id
//             },
//             // contentType: "application/json; charset=utf-8",
//             dataType: 'text',
//             // traditional: true,
//             success: function(data) {
//                 $('#body_content').html(data);

//             }
//         });
// }

$('.addQuestionButton').click(function() {
    let selected_course = $('#course_or_subcourse').val();
    $('#question_appearance').val(selected_course);
});
</script>

<?php
include '../includes/footer.php';
?>