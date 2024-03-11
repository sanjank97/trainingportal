<?php
session_start();
include 'includes/header_top.php';
include('../db_connection.php');
include('includes/define.php');
if (isset($_SESSION['test_session_id'])) {

    header("Location :courses/test.php");
 }
if (isset($_SESSION['employee_id'])) {

    $user_id = $_SESSION['employee_id'];
    $query = "select * from employee where id=$user_id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

   // echo '<pre>',var_dump($row); echo '<pre>';
    $currentDate = strtotime(date("Y-m-d"));
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
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Profile</h5>
                                    </div>

                                    <div class="card-block">

                             
                                        <form class="form-material profileform" action="profile_handler.php" method="POST" enctype="multipart/form-data">

                                            <div class="form-group row">
                                                <div class="col-md-6 col-12">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Enter your Name" value="<?php echo $row['name']; ?>">
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label class="col-form-label">Email (Read Only)</label>
                                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12">
                                                    <label class="col-form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" name="dob" value="<?php echo $row['dateofbirth']; ?>">
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label class="col-form-label">Mobile</label>
                                                    <input type="text" class="form-control" name="mobile" placeholder="Enter mobile no." maxlenth="10" value="<?php echo $row['mobile']; ?>">
                                                </div>
                                            </div>
                                    

                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Driving license</label>
                                                   
                                                    <input type="file" name="dl_files" class="form-control formfile">
                                                    <input type="hidden" name="current_dl_files" value="<?php echo $row['driving_license']; ?>">
                                                     <?php if($row['driving_license']):?>
                                                     <a class="pdfpreview" href="<?php echo THEME_ASSET . 'certificate/' . $user_id . '/' . $row['driving_license'] ?>" target="_blank">Preview</a>
                                                     <?php endif;?>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Driving license Number</label>
                                                    <input type="text" name="dl_number" class="form-control" value="<?php echo $row['dl_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                <?php   
                                                 $expired ="";
                                                 if ( isset($row['dl_expiredate'])) {                                                   
                                                      $expired =($currentDate > strtotime($row['dl_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                 }
                                                      echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    <input type="date" name="exp_date_dl" class="form-control" value="<?php echo $row['dl_expiredate']; ?>">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Security license</label>
                                                   
                                                    <input type="file" name="security_files" class="form-control formfile">
                                                    <input type="hidden" name="current_security_files" value="<?php echo $row['security_license']; ?>">
                                                    <?php if($row['security_license']):?>
                                                     <a class="pdfpreview" href="<?php echo THEME_ASSET . 'certificate/' . $user_id . '/' . $row['security_license']; ?>" target="_blank">Preview</a>
                                                     <?php endif;?>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">Security license Number</label>
                                                    <input type="text" name="security_number" class="form-control" value="<?php echo $row['sl_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                <?php   
                                                 $expired ="";
                                                 if ( isset($row['sl_expiredate'])) {                                                   
                                                      $expired =($currentDate > strtotime($row['sl_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                 }
                                                      echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    <input type="date" name="exp_date_security" class="form-control" value="<?php echo $row['sl_expiredate']; ?>">
                                                </div>
                                            </div>


                                            <div class="row" style="margin-bottom:15px;">
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">CPR Certification</label>
                                                    
                                                    <input type="file" name="cpr_files" class="form-control formfile">
                                                    <input type="hidden" name="current_cpr_files" value="<?php echo $row['cpr_certification']; ?>">
                                                    <?php if($row['cpr_certification']):?>
                                                    <a class="pdfpreview" href="<?php echo THEME_ASSET . 'certificate/' . $user_id . '/' . $row['cpr_certification'] ?>" target="_blank">Preview</a>
                                                    <?php endif;?>
                                                    
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                    <label class="col-form-label">CPR Certification Number</label>
                                                    <input type="text" name="cpr_number" class="form-control" value="<?php echo $row['cpr_no']; ?>">
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4">
                                                <?php   
                                                 $expired ="";
                                                 if ( isset($row['cc_expiredate'])) {                                                   
                                                      $expired =($currentDate > strtotime($row['cc_expiredate']))? '<span class="text-danger">Expired!</span>':'';
                                                 }
                                                      echo '<label class="col-form-label">Expiry date '.$expired .'</label>';
                                                     ?>
                                                    <input type="date" name="exp_date_cpr" class="form-control" value="<?php echo $row['cc_expiredate']; ?>">
                                                </div>
                                            </div>




                                            <input type="hidden" name="profile_imagebase64" class="profile_imagebase64">
                                            <input type="hidden" name="current_profile" value="<?php echo $row['profile_img'] ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">


                                            <input type="submit" class="site_btn" value="Submit" name="update_profile_emp" style="margin-top:30px;margin: auto;display: flex;">
                                            
                                        </form>

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

    img {
        display: inline-block;
        max-width: 100%;
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