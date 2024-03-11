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
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Profile</h5>
                                    </div>

                                    <div class="card-block">

                                        <div class="col-sm-12" style="text-align: -webkit-center; display:none;">
                                            <img src="<?php echo ($row['image']==null)?'https://img.icons8.com/office/100/null/user.png':$row['image'];?>"
                                                id="uploaded_image" class="img-responsive img-circle" width="100px"
                                                height="100px" />
                                            <button type="button"
                                                class=" btn btn-basic change_profile_img"><span>Change</span><i
                                                    class="fa fa-pencil" aria-hidden="true"
                                                    style="margin-left:5px;"></i></button>
                                            <input type="file" name="image" class="image" id="upload_image"
                                                style="display:none;" />
                                        </div>
                                        <form class="form-material" action="admin_handler.php" method="POST"
                                                    enctype="multipart/form-data">
                                            <div class="form-group row" style="display:none;">
                                                <label class="col-sm-2 col-form-label">Role</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="user_role" required="">
                                                        <option value="">Select Role</option>
                                                        <?php 
                                                             foreach( $user_role as $role)
                                                             { 
                                                                $selected="";
                                                                if($role['role_id']==$row['role'])
                                                                {
                                                                  $selected="selected";
                                                                }

                                                               echo "<option value='".$role['role_id']."' $selected>".$role['role']."</option>";
                                                             }
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Enter your Name"
                                                        value="<?php echo $row['name'];?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                                        value="<?php echo $row['email'];?>" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Mobile</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="mobile"
                                                        placeholder="Enter mobile no."
                                                        value="<?php echo $row['mobile'];?>" maxlength="10">
                                                </div>
                                            </div>
                                            <input type="hidden" name="profile_imagebase64" class="profile_imagebase64" >
                                            <input type="hidden" name="current_profile" value="<?php echo $row['image']?>" >
                                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>" >
                                     
                                            <input type="submit" class="site_btn" value="Submit"
                                                        name="update_profile">
                                        
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
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
</div>
</div>
</div>
<!--crop Model-->
<div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--End crop Model-->
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<style>
.image_area {
    position: relative;
}


.preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid red;
}

.modal-lg {
    max-width: 1000px !important;
}

.overlay {
    position: absolute;
    bottom: 10px;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.5);
    overflow: hidden;
    height: 0;
    transition: .5s ease;
    width: 100%;
}

.image_area:hover .overlay {
    height: 50%;
    cursor: pointer;
}

.text {
    color: #333;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
}
</style>
<script>
$(document).ready(function() {
    var $modal = $('#cropImage');
    var image = document.getElementById('sample_image');
    var cropper;
    $('.change_profile_img').click(function() {
        $('#upload_image').trigger('click');
    });
    $('#upload_image').change(function(event) {
        var files = event.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };

        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function(event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                console.log(base64data);
                $('#uploaded_image').attr('src', base64data);
                $('.profile_imagebase64').val(base64data);
                $modal.modal('hide');
                // $.ajax({
                //     url: 'upload.php',
                //     method: 'POST',
                //     data: {
                //         image: base64data
                //     },
                //     success: function(data) {
                //         $modal.modal('hide');
                //         $('#uploaded_image').attr('src', data);
                //     }
                // });
            };
        });
    });

});
</script>

<?php
include 'includes/footer.php';
?>