<?php
     include '../includes/header_top.php';
     include('../../db_connection.php');
     $query="select role,role_id from user_role";
     $result=mysqli_query($con,$query);
     $user_role=mysqli_fetch_all ($result, MYSQLI_ASSOC);

     $query="select * from users";
     $result=mysqli_query($con,$query);
     $num=mysqli_num_rows($result);     
?>
<style>
.pass_eye .fa{
    position: absolute;
    left: auto;
    right: 5px;
    top: 33px;
    padding: 10px;
    cursor: pointer;
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
                                        <div class="card-header text-success user_status">
                                       
                                        </div>   
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Users List</h5>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal">
                                                Add
                                            </button>
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
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Mobile.No</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($num >0)
                                                            {
                                                                $key=0;
                                                                while($row=mysqli_fetch_assoc($result))
                                                                {
                                                                    // $exist_role="";
                                                                    // foreach( $user_role as $role)
                                                                    // { 
                                                                    //  if($role['role_id']==$row['role'])
                                                                    //   {
                                                                    //     $exist_role=$role['role'];
                                                                    //   }  
                                                                      
                                                                    // }
                                                                    echo '<tr>
                                                                        <th scope="row">'.++$key.'</th>
                                                                        <td>'.$row['name'].'</td>
                                                                        <td>'.$row['email'].'</td>                                                                     
                                                                        <td>'.$row['mobile'].'</td>
                                                                        <td>';
                                                                        if($row['status']==0)
                                                                        {
                                                                            echo '<a href="#" class="text-primary user_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px; font-size:24px;"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo '<a href="#" class="text-primary user_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px;  font-size:24px; color:#007bffc7;"><i class="fa fa-toggle-on" aria-hidden="true" style="color:#007bffc7;"></i></a>';
                                                                        }
                                                                        echo '</td>
                                                                        <td>
                                                                        <a href="#" class="user_edit_btn " data-edit-id="'.$row['id'].'" data-toggle="modal" data-target="#myModal2"><i class="ti-pencil-alt edit_icon"></i></a>';
                                                                        if($row['id'] !=2){
                                                                            echo  '<a href="#" class="user_delete_btn"  data-delete-id="'.$row['id'].'" style="color:red;margin-left:10px;"><i class="ti-trash delete_icon" ></i></a>';
                                                                        
                                                                        }
                                                                    
                                                                      
                                                
                                                                        echo '</td>
                                                                    </tr>';
                                                                }
                                                                

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
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
 
            <!-- Modal body -->
            <div class="modal-body">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="#">
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                           <div class="card-header">
                                                <h5>Add Users</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="card-block">
                                                <form class="form-material" action="user_handler.php" method="POST"
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
                                                    <div class="form-group form-default pass_eye">
                                                        <label class="float-label">Password</label>
                                                        <input type="password" name="password" id="passadd" class="form-control password"
                                                            required="">
                                                        <i class="fa fa-eye-slash" id="eyeAdd"></i>
                                                        <span class="form-bar"></span>
                                                    </div>

  
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Repeat Password</label>
                                                        <input type="password" name="re_password" class="form-control repassword"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                                    <span class="passerr text-danger"></span>
                                                    <div class="form-group form-default">
                                                        <label class="float-label">Mobile No.</label>
                                                        <input type="text" maxlength="10" name="mobile" class="form-control"
                                                            required="">
                                                        <span class="form-bar"></span>
                                                    </div>
                                              
                                                    <input type="hidden" name="user_role" value="1">
                                                    <input type="submit" class="site_btn" value="Submit"
                                                                name="add_user"> 
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
                                                <h5>Edit Users</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="card-block">
                                                <form class="form-material edit-user-form" action="user_handler.php"
                                                    method="POST" enctype="multipart/form-data">

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
   });

    $('.user_edit_btn').click(function() {
        let data_edit_id = $(this).attr('data-edit-id');
        $.ajax({
            type: 'post',
            url: 'user_handler.php',
            data: {
                'data_edit_id': data_edit_id
            },
            // contentType: "application/json; charset=utf-8",
            dataType: 'html',
            // traditional: true,
            success: function(data) {
                $('.edit-user-form').html(data);
                toggleEye();
            }
        });
    });
    $('.user_delete_btn').click(function() {
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
                    url: 'user_handler.php',
                    data: {
                        'data_delete_id': data_delete_id
                    },
                    // contentType: "application/json; charset=utf-8",
                    dataType: 'text',
                    // traditional: true,
                    success: function(data) {
                        // Swal.fire(
                        //     'Deleted!',
                        //     'Employee has been deleted.',
                        //     'success'
                        // ).then((result) => {
                        //    window.location.href = "list.php";
                        // })
                        //window.location.href = "list.php";
                        window.location.reload();
                    }
                });

            }
        })
    });
    
    $('.user_status_btn').click(function() {
        let data_status_id = $(this).attr('data-status-id');
        let onclass = jQuery(this).find('i').hasClass("fa-toggle-on");
        if(onclass){
            console.log("2222");
            jQuery(this).find('i').removeClass("fa fa-toggle-on");
            jQuery(this).find('i').addClass("fa fa-toggle-off");
        }
        else{
            console.log("3333");
            jQuery(this).find('i').removeClass("fa fa-toggle-off");
            jQuery(this).find('i').addClass("fa fa-toggle-on");
        }

        console.log(data_status_id);
        $.ajax({
            type: 'post',
            url: 'user_handler.php',
            data: {
                'data_status_id': data_status_id
            },
            // contentType: "application/json; charset=utf-8",
            // traditional: true,
            dataType: 'text',
            success: function(data) {
                console.log(data);
                $('.user_status').parent().fadeIn();
                $('.user_status').text(data);
                setTimeout(() => {
                    $('.user_status').parent().fadeOut();
                }, 2000);
             //   window.location.href = "list.php";
            }
        });
    });


});

function toggleEye(){
    $('#eye').click(function(){
       if($(this).hasClass('fa-eye-slash')){
         $(this).removeClass('fa-eye-slash');
         $(this).addClass('fa-eye');
         $('#pass').attr('type','text');
       }else{
         $(this).removeClass('fa-eye');
         $(this).addClass('fa-eye-slash');  
         $('#pass').attr('type','password');
       }
   });
}
$('#eyeAdd').click(function(){
       if($(this).hasClass('fa-eye-slash')){
         $(this).removeClass('fa-eye-slash');
         $(this).addClass('fa-eye');
         $('#passadd').attr('type','text');
       }else{
         $(this).removeClass('fa-eye');
         $(this).addClass('fa-eye-slash');  
         $('#passadd').attr('type','password');
       }
   });
</script>


<?php
include '../includes/footer.php';
?>