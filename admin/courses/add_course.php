<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location:index.php");
}
include('../../db_connection.php');

function generate_unique_id()
{
  return rand(10000, 99999);
}
if (isset($_POST['add_course'])) {

  

  //        $filetype=$_FILES['course_pdf']['type'];
  //        $filetemp_name=$_FILES['course_pdf']['tmp_name'];
  //        $file_extension=explode("/",$filetype)[1];
  //        $filename=time().'_'.$_FILES['course_pdf']['name'];
  //        $file_upload_path = "../uploads/".$filename;
  //        move_uploaded_file($filetemp_name, $file_upload_path);

  // PDF file SAnjan


  //Thumbnail Image
$course_thumbnail ="";
if ($_FILES['course_thumbnail']['size'] != 0) {
$filetype = $_FILES['course_thumbnail']['type'];
$filetemp_name = $_FILES['course_thumbnail']['tmp_name'];
$file_extension = explode("/", $filetype)[1];
$course_thumbnail = time() . '_' . $_FILES['course_thumbnail']['name'];
$file_upload_path = "../uploads/" . $course_thumbnail;
move_uploaded_file($filetemp_name, $file_upload_path);
}

  //Multiple FiLe Uploaded
  $video_file = "";
  $total = count($_FILES['course_video']['name']);
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
       $tmpFilePath = $_FILES['course_video']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_video']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
       
         $newFilePath = "../uploads/" . $unique_name . '_' . $_FILES['course_video']['name'][$i];
         $video_file .= $unique_name . '_' . $_FILES['course_video']['name'][$i] . ",";
         $uploaded_status = move_uploaded_file($tmpFilePath, $newFilePath);
         if($uploaded_status) {
          echo "file uploaded";
         }else{
          echo "Not uploaded";
         }
      }
    }
  }


  $pdfFile = "";
  $total = count($_FILES['course_pdf']['name']);
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_pdf']['tmp_name'][$i];
      if ($tmpFilePath != "") {

        $filetype = $_FILES['course_pdf']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
        $newFilePath = "../uploads/pdf/" . $unique_name . '_' . $_FILES['course_pdf']['name'][$i];
        $pdfFile .= $unique_name . '_' . $_FILES['course_pdf']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
        
      }
    }
  }

  $course_title        = $_POST['course_title'];
  $course_type         = $_POST['course_type'];
  $watch_priority      = $_POST['watch_priority'];
  $course_id           = time();
  $course_video        = rtrim($video_file, ',');
  $course_pdf          = $pdfFile;
  $course_thumbnail    = $course_thumbnail;
  $video_link          = $_POST['course_video_link'];
  $created_on          = date('Y-m-d H:i:s');
  //Database Insert
  $query = "insert into course (course_title,course_type,priority,course_id,course_video,course_pdf,video_link,course_thumbnail,created_on) values('$course_title','$course_type','$watch_priority','$course_id', '$course_video','$course_pdf','$video_link','$course_thumbnail','$created_on')";
  $result = mysqli_query($con, $query);
  if ($result) {
    $_SESSION['success'] = "<strong>Success.!</strong> course has been added.";
    $query_parameter =($course_type==1)?'?course_type=1':'';
    header("Location:list.php".$query_parameter );
    
  } else {

    $_SESSION['error'] = "Something went wrong.Please check connection";
    $query_parameter =($course_type==1)?'?course_type=1':'';
    header("Location:list.php".$query_parameter );
  }
}
//Edit course section
if (isset($_POST['data_edit_id'])) {
  $course_id = $_POST['data_edit_id'];
  $query = "select course_id,course_type,priority,course_title,course_pdf,video_link,course_video,course_thumbnail from course where course_id='" . $course_id . "'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  $course_video_html = $course_pdf_html = "";

  if($row['course_thumbnail']){
      $previewThumbnail = '<a href="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/uploads/' . $row['course_thumbnail'] . '" target="_blank">Preview</a>';
  }
    
  if (isset($row['course_video']) && $row['course_video'] != "") {
    $course_video = explode(',', $row['course_video']);
    foreach ($course_video as $item) {
      $course_video_html .= '<div class="alert alert-success"> <button type="button" data-id="' . $item . '" class="close remove_course_video" data-dismiss="alert"><img src="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/assets/images/deleteIconsline.svg"></button><a href="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/uploads/' . $item . '" target="_blank">' . $item . '</a></div>';
    }
  }
  if (isset($row['course_pdf']) && $row['course_pdf'] != "") {
    $course_pdf = explode(',', trim($row['course_pdf'], ','));

    foreach ($course_pdf as $item) {
      $course_pdf_html .= '<div class="alert alert-success"> <button type="button" data-id="' . $item . '" class="close remove_course_pdf" data-dismiss="alert"><img src="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/assets/images/deleteIconsline.svg"></button><a href="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/uploads/pdf/' . $item . '" target="_blank">' . $item . '</a></div>';
    }
  }
  echo '<input type="hidden" value="'.(($row['course_type'] ==0)?0:1).'"  name="course_type" />
        <div class="form-group form-default" >
          <label class="float-label">Course Title</label>
          <input type="text" name="course_title" class="form-control" value="' . $row['course_title'] . '">
        </div>
      <div class ="course_property_wrapper" style ="display :'.(($row['course_type'] ==0)?"block":"none").'">
        <div class="form-group form-default">
          <label class="float-label">Video </label>
          <input type="file" name="course_video[]" id="course_video" class="form-control" style="padding:0px;" >
        </div>
        <div class="form-group form-default">
          <label class="float-label">Must be view</label>
          <input type="radio" name="watch_priority" value="0" '.(($row['priority'] ==0)?"checked":"").' />
       </div>
        <div class="form-group form-default">
            ' . $course_video_html . '
        </div>
        <div class="form-group form-default">
        <label class="float-label">Youtube Embed URL (Optional)</label>
        <input type="text" name="course_video_link" value="' . htmlspecialchars($row['video_link']) . '" class="form-control"
          >
      </div>
      <div class="form-group form-default">
          <label class="float-label">Pdf</label>
          <input type="file" id="coursePdf" name="course_pdf[]" class="form-control"
             style="padding:0px;">
      </div>
      <div class="form-group form-default">
        <label class="float-label">Must be watch</label>
        <input type="radio" name="watch_priority" value="1" '.(($row['priority'] ==1)?"checked":"").' />
      </div>
      
      <div class="form-group form-default pdfpreview">
          ' . $course_pdf_html . '
      </div>';

    
    echo '<div class="form-group form-default">
            <label class="float-label">Thumbnail</label>
            <input type="file" name="course_thumbnail" class="form-control">
       </div>
        <div class="form-group form-default pdfpreview">
            <p>' . $previewThumbnail . '</p>
        </div>
       ';
    
  echo '</div>';  
  echo  '<input type="hidden" name="current_course_thumbnail" value="'.$row['course_thumbnail'].'">';
  echo  '<input type="hidden" name="current_course_video"     value="' . $row['course_video'] . '">
        <input type="hidden" name="current_pdf" value="' . $row['course_pdf'] . '">
        <input type="hidden" name="course_id" value="' . $row['course_id'] . '">
        <input type="hidden" name="removed_course_video" value="">
        <input type="hidden" name="removed_course_pdf" value="">
        <input type="submit" class="site_btn" name="update_course"
        value="Update">';
}
//Update course 
if (isset($_POST['update_course'])) {

  //PDF
  $current_course_pdf = trim($_POST['current_pdf'], ',');
  $total = count($_FILES['course_pdf']['name']);
  $pdf_file = trim($_POST['current_pdf'], ',');
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_pdf']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_pdf']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
        $newFilePath = "../uploads/pdf/" . $unique_name . '_' . $_FILES['course_pdf']['name'][$i];
        $pdf_file = $unique_name . '_' . $_FILES['course_pdf']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }
  //removed course PDF
  $removed_course_pdf = explode(',', trim($_POST['removed_course_pdf'], ','));
  foreach ($removed_course_pdf as $removed_item) {
    unlink("../uploads/pdf/" . $removed_item);
  }


  //FILe Uploaded
  $current_course_video = trim($_POST['current_course_video'], ',');
  $video_file = $current_course_video . ',';
  $total = count($_FILES['course_video']['name']);
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_video']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_video']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
        $newFilePath = "../uploads/" . $unique_name . '_' . $_FILES['course_video']['name'][$i];
        $video_file = $unique_name . '_' . $_FILES['course_video']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }
  //removed course video
  $removed_course_video = explode(',', trim($_POST['removed_course_video'], ','));
  foreach ($removed_course_video as $removed_item) {
    unlink("../uploads/" . $removed_item);
  }

    
    
//Thumbnail 
if ($_FILES['course_thumbnail']['size'] != 0) {
    $filetype=$_FILES['course_thumbnail']['type'];
    $filetemp_name=$_FILES['course_thumbnail']['tmp_name'];
    $file_extension=explode("/",$filetype)[1];
    $filename="../uploads/".time().'_thumbnail_'.$_FILES['course_thumbnail']['name'];
    $file_upload_path =$document_path.$filename;
    move_uploaded_file($filetemp_name, $file_upload_path);
    $course_thumbnail = $filename;
}
else{
     $course_thumbnail = $_POST['current_course_thumbnail'];
}
   
//Thumbnail    
    
    
    
    
    
    
  $course_title = $_POST['course_title'];
  $course_id = $_POST['course_id'];
  $course_type         = $_POST['course_type'];
  $watch_priority      = $_POST['watch_priority'];
  $course_video        = trim($video_file, ',');
  $video_link          = $_POST['course_video_link'];
  $course_pdf          = trim($pdf_file, ',');
  //  $course_thumbnail    =$course_thumbnail;
  $updated_on          = date('Y-m-d H:i:s');
  $query = "update course set course_title='" . $course_title . "', course_type='".$course_type."', priority='".$watch_priority."', course_video='" . $course_video . "',video_link='" . $video_link . "', course_thumbnail='".$course_thumbnail."',course_pdf='" . $course_pdf . "',updated_on='" . $updated_on . "' where course_id='" . $course_id . "'";
  $result = mysqli_query($con, $query);
  if ($result) {
    $_SESSION['success'] = "<strong>Success.!</strong> course has been updated.";
    $query_parameter =($course_type==1)?'?course_type=1':'';
    header("Location:list.php".$query_parameter );
  } else {
    $_SESSION['error'] = "Something went wrong.Please check connection";
  }
}
// delete course
if (isset($_POST['data_delete_id'])) {
  $course_id = $_POST['data_delete_id'];
  $query = "select course_video ,course_pdf from course where course_id='" . $course_id . "'";
  $result = mysqli_query($con, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $course_pdf = $row['course_pdf'];
    unlink("../uploads/" . $course_pdf);
  }

  $query = "delete from course where course_id='" . $course_id . "'";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "okay";
  }
}
