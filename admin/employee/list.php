<?php
     include '../includes/header_top.php';
     include('../../db_connection.php');
     $query="select * from employee";
     $emp_result=mysqli_query($con,$query);
     $totalRows=mysqli_num_rows($emp_result);   
     $query ="select * from course where course_type=1 order by id desc";
     $exlusive_test_result = mysqli_query($con,$query);
     $exlusive_test_num = mysqli_num_rows($exlusive_test_result); 

   
?>

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?php
            include '../includes/header.php';

            $records_per_page = 50;                       
            $page_number = isset($_GET["page_number"]) ? $_GET["page_number"] : 1;
            $offset = ($page_number - 1) * $records_per_page;
       
            $search = isset($_POST['search']) ?$_POST['search'] : '';
            $query = "SELECT * FROM employee";
            if (!empty($search)) {
                $query .= " WHERE name LIKE '%$search%'";
            }
            $query .= " ORDER BY id DESC LIMIT $offset, $records_per_page";

            // $query="select * from employee order by id desc LIMIT $offset, $records_per_page";
             $result=mysqli_query($con,$query);
             $num=mysqli_num_rows($result); 
             
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
                                    <div class="card" style="display:none">
                                        <div class="card-header text-success emp_status">
                                       
                                        </div>   
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Employee List</h5>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal">
                                                Add
                                            </button>
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
                                                            <th>#</th>
                                                            <th>Employee</th>
                                                            <th>Email Id</th>
                                                            <th>Date Of Birth</th>
                                                            <th>Mobile No.</th>
                                                            <th>Status</th>
                                                            <th>Certificate Status</th>
                                                            <th>Score</th>
                                                            <th>Document</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($num >0)
                                                            {
                                                                $start_increament = $records_per_page *($page_number -1);
                                                                $key=0;
                                                                while($row=mysqli_fetch_assoc($result))
                                                                {
                                                                    $docmsg ="<span class='text-success'>Active </spam>";
                                                                    if( $row['driving_license']!="" && $row['security_license']!="" && $row['cpr_certification']!="" ) {
                                                                       
                                                                        $currentDate = strtotime(date("Y-m-d"));
                                                                        if(strtotime($row['dl_expiredate']) < $currentDate || strtotime($row['sl_expiredate']) < $currentDate || strtotime($row['cc_expiredate']) < $currentDate) {
                                                                            $docmsg ="<span class='text-danger'>Expired!</span>";
                                                                        }
                                                            
                                                                   }else{
                                                                    $docmsg ="<span class='text-danger'>Not Uploaded Yet!</span>";
                                                                   }


                                                                    echo '<tr>
                                                                                <th scope="row">'. $start_increament + (++$key).'</th>
                                                                                <td><a style="color:#007bffc7" href="view.php?employee_id='.$row['id'].'"  style="margin-left:10px;">'.$row['name'].'</a></td>
                                                                                <td>'.$row['email'].'</td>
                                                                                <td>'.$row['dateofbirth'].'</td>
                                                                                <td>'.$row['mobile'].'</td>
                                                                                <td>';
                                                                                if($row['status']==0)
                                                                                {
                                                                                    echo '<a href="javascript:void(0)" class="text-primary emp_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px; font-size:24px;"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<a href="javascript:void(0)" class="text-primary emp_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px;  font-size:24px; color:#007bffc7;"><i class="fa fa-toggle-on" aria-hidden="true" style="color:#007bffc7;"></i></a>';
                                                                                }
                                                                                echo '</td>
                                                                                <td>'.$docmsg.'</td>
                                                                                <td><a href="viewtest.php?employee_id='.$row['id'].'"  style="margin-left:10px;color:green;">View</a></td>
                                                                                <td><a href="view.php?employee_id='.$row['id'].'"  style="margin-left:10px;">View</a></td>
                                                                                <td>
                                                                                <a href="#" class="emp_edit_btn" data-edit-id="'.$row['id'].'" data-toggle="modal" data-target="#myModal2"><i class="ti-pencil-alt edit_icon"  ></i></a>
                                                                                <a href="#" class="emp_delete_btn"  data-delete-id="'.$row['id'].'" style="color:red;margin-left:10px;"><i class="ti-trash delete_icon" ></i></a>
                                                                                ';
                                                                              
                                                                    
                                                                              echo '</td>
                                                                                    
                                                                            </tr>';
                                                                }
                                                                

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
                                                    echo '<li><a href="'.BASE_URL.'employee/list.php?page_number='.($page_number - 1).'">prev</a></li>';
                                                }
                                                for($i=$page_number; $i<= $total_pages; $i++) {
                                                    $active = ($page_number == $i) ? "active": "";
                                                    echo '<li><a href="'.BASE_URL.'employee/list.php?page_number='.$i.'" class="'.$active.'">'.$i.'</a>
                                                    </li>';
                                                }
                                                if( $page_number < $total_pages) {
                                                    echo '<li><a href="'.BASE_URL.'employee/list.php?page_number='.($page_number + 1).'">Next</a></li>';
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
                                                <form class="form-material" action="employee_handler.php" method="POST"
                                                    enctype="multipart/form-data" onsubmit="submitForm(event)">
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Name</label>
                                                        <input type="text" name="name" class="form-control" required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Password</label>
                                                        <input type="text"  name="password" class="form-control password"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Repeat Password</label>
                                                        <input type="text"  name="re_password" class="form-control repassword"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <span class="passerr text-danger"></span>
                       
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Asign To Exclusive Test</label>

                                                        <select class="form-control" id="exclusive_test" name ="exclusive_test[]" multiple="multiple">
                                                        <?php 
                                                            
                                                            if ($exlusive_test_num > 0) {
                                                            while($test_row =mysqli_fetch_assoc($exlusive_test_result)) {
                                                                echo "<option value='".$test_row['course_id']."' >".$test_row['course_title']."</option>";
                                                            }
                                                            
                                                            }
                                                        ?>
                                                        </select>

                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <input type="submit" class="site_btn" value="Submit"
                                                        name="add_employee">
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
                                                <form class="form-material edit-employee-form"
                                                    action="employee_handler.php" method="POST"
                                                    enctype="multipart/form-data" >

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
$(function() {
    $('#exclusive_test').multiselect({
        includeSelectAllOption: true
    });
});


function submitForm(event){
    
     let password = $('.password').val();
     let repassword = $('.repassword').val();
     $('.passerr').text('');
     if(password != repassword) {
        $('.passerr').text('Password mis-matched.!');
        event.preventDefault();
     }
  }


$(document).ready(function() {
   
    $('.repassword, .password').change(function(){
        $('.passerr').text('');
        if($('.repassword').val() != $('.password').val()) {
            $('.passerr').text('Password mis-matched.!');
        }
    })

    $('.emp_edit_btn').click(function() {
        let data_edit_id = $(this).attr('data-edit-id');
        console.log(data_edit_id);
        $.ajax({
            type: 'post',
            url: 'employee_handler.php',
            data: {
                'data_edit_id': data_edit_id
            },
            // contentType: "application/json; charset=utf-8",
            dataType: 'html',
            // traditional: true,
            success: function(data) {
                $('.edit-employee-form').html(data);

                $('#exclusive_test1').multiselect({
                    includeSelectAllOption: true
                });
                
            }
        });
    

    });
    $('.emp_delete_btn').click(function() {
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
                    url: 'employee_handler.php',
                    data: {
                        'data_delete_id': data_delete_id
                    },
                    // contentType: "application/json; charset=utf-8",
                    dataType: 'text',
                    // traditional: true,
                    success: function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Employee has been deleted.',
                            'success'
                        ).then((result) => {
                            window.location.href = "list.php";
                        })
                    }
                });

            }
        })
    });
    $('.emp_status_btn').click(function() {
        let data_status_id = jQuery(this).attr('data-status-id');
        let fatoggleon = jQuery(this).find('i').hasClass("fa-toggle-on");

        if (fatoggleon) {
            jQuery(this).find('i').removeClass("fa-toggle-on");
            jQuery(this).find('i').addClass("fa-toggle-off");
        } else {
            jQuery(this).find('i').removeClass("fa-toggle-off");
            jQuery(this).find('i').addClass("fa-toggle-on");
        }


        console.log(data_status_id);
        $.ajax({
            type: 'post',
            url: 'employee_handler.php',
            data: {
                'data_status_id': data_status_id
            },
            // contentType: "application/json; charset=utf-8",
            // traditional: true,
            dataType: 'text',
            success: function(data) {
                console.log(data);
                $('.emp_status').parent().fadeIn();
                $('.emp_status').text(data);
                setTimeout(() => {
                    $('.emp_status').parent().fadeOut();
                }, 2000);
                //  window.location.href="list.php";           
            }
        });
    });
 
})
</script>
<?php
include '../includes/footer.php';
?>