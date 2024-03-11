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
if (isset($_POST['add_sub_course'])) {

  $video_file = "";
  $total = count($_FILES['course_video']['name']);
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_video']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_video']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name    = time() . rand(999, 10009);
        $newFilePath    = "../uploads/course/video/" . $unique_name . '_' . $_FILES['course_video']['name'][$i];
        $video_file .= $unique_name . '_' . $_FILES['course_video']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }

  //Multiple PDF UPLOAD BY krishna
  $pdfFile = "";
  $total = count($_FILES['course_pdf']['name']);
  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_pdf']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_pdf']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
        $newFilePath = "../uploads/course/pdf/" . $unique_name . '_' . $_FILES['course_pdf']['name'][$i];
        $pdfFile .= $unique_name . '_' . $_FILES['course_pdf']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }
  //Multiple PDF UPLOAD BY krishna

    $course_thumbnail = $_POST['course_thumbnail'];
    if ($_FILES['course_thumbnail']['size'] != 0) {
        $filetype=$_FILES['course_thumbnail']['type'];
        $filetemp_name=$_FILES['course_thumbnail']['tmp_name'];
        $file_extension=explode("/",$filetype)[1];
        $filename="../uploads/".time().'_thumbnail_'.$_FILES['course_thumbnail']['name'];
        $file_upload_path =$document_path.$filename;
        move_uploaded_file($filetemp_name, $file_upload_path);
        $course_thumbnail = $filename;
    }


  $course_title        = $_POST['course_title'];
  $courseID            = $_POST['courseid'];
  $watch_priority      = $_POST['watch_priority'];
  $course_id           = generate_unique_id();
  $course_video        = rtrim($video_file, ',');
  $course_pdf          = $pdfFile;
  $course_thumbnail    = $course_thumbnail;
  $video_link          = $_POST['course_video_link'];
  date_default_timezone_set('America/Toronto');
  $created_on          = date('Y-m-d H:i:s');
  //Database Insert
  $query = "insert into subcourse (title,priority, video,pdf,course_thumbnail,courseID,created_on) values('$course_title','$watch_priority', '$course_video','$course_pdf','$course_thumbnail','$courseID','$created_on')";
  $result = mysqli_query($con, $query);
  if ($result) {
    $_SESSION['success'] = "<strong>Success.!</strong>Subcourse has been added.";
    header("Location:view.php?course_id=$courseID");
  } else {
    $_SESSION['error'] = "Something went wrong.Please check connection";
  }
}


//Edit course section
if (isset($_POST['data_edit_id'])) {
  $subcourse_id = $_POST['data_edit_id'];
  $query = "select courseID,priority,title,pdf,video_link,video from subcourse where id='" . $subcourse_id . "'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  $course_video_html = $course_pdf_html = "";

  if (isset($row['video']) && $row['video'] != "") {
    $course_video = explode(',', $row['video']);
    foreach ($course_video as $item) {
      $course_video_html .= '<div class="alert alert-success"> <button type="button" data-id="' . $item . '" class="close remove_course_video" data-dismiss="alert"><img src="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/assets/images/deleteIconsline.svg"></button><a href="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/uploads/' . $item . '" target="_blank">' . $item . '</a></div>';
    }
  }
  if (isset($row['pdf']) && $row['pdf'] != "") {
    $course_pdf = explode(',', trim($row['pdf'], ','));

    foreach ($course_pdf as $item) {
      $course_pdf_html .= '<div class="alert alert-success"> <button type="button" data-id="' . $item . '" class="close remove_course_pdf" data-dismiss="alert"><img src="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/assets/images/deleteIconsline.svg"></button><a href="https://' . $_SERVER['SERVER_NAME'] . '/trainingportal/admin/uploads/pdf/' . $item . '" target="_blank">' . $item . '</a></div>';
    }
  }

  echo '<div class="form-group form-default">
          <label class="float-label">Course Title</label>
          <input type="text" name="course_title" class="form-control" value="' . $row['title'] . '">
          <span class="form-bar"></span>
        </div>
        <div class="form-group form-default">
          <label class="float-label">Video </label>
          <input type="file" id="course_video" name="course_video[]" class="form-control" style="padding:0px;">
          <span class="form-bar"></span>
        </div>
        <div class="form-group form-default">
        <label class="float-label">Must be watch</label>
        <input type="radio" name="watch_priority" value="0" '.(($row['priority'] ==0)?"checked":"").' />
        <span class="form-bar"></span>
      </div>
        <div class="form-group form-default">
            <p>' . $course_video_html . '</p>
        </div>
    
        <div class="form-group form-default">
        <label class="float-label">Youtube Embed URL(with Iframe)</label>
        <input type="text" name="course_video_link" value="' . htmlspecialchars($row['video_link']) . '" class="form-control"
          >
        <span class="form-bar"></span>
      </div>
      <div class="form-group form-default">
          <label class="float-label">Pdf</label>
          <input type="file" id="course_pdf" name="course_pdf[]" class="form-control"
             style="padding:0px;">
          <span class="form-bar"></span>
      </div>
      <div class="form-group form-default">
        <label class="float-label">Must be watch</label>
        <input type="radio" name="watch_priority" value="1" '.(($row['priority'] ==1)?"checked":"").' />
        <span class="form-bar"></span>
      </div>
      <div class="form-group form-default pdfpreview">
          <p>' . $course_pdf_html . '</p>
      </div>
      

        
        <input type="hidden" name="current_course_thumbnail" value="'.$row['course_thumbnail'].'">
        <input type="hidden" name="current_course_video" value="' . $row['video'] . '">
        <input type="hidden" name="current_pdf" value="' . $row['pdf'] . '">
        <input type="hidden" name="subcourse_id" value="' . $subcourse_id . '">
        <input type="hidden" name="course_id" value="' . $row['courseID'] . '">
        <input type="hidden" name="removed_course_video" value="">
        <input type="hidden" name="removed_course_pdf" value="">
        <div class="row">
          <div class="col-sm-6">
            <input type="submit" class="site_btn" name="update_course"
                  value="Update">
          </div>
    </div>';
}
//Update course 
if (isset($_POST['update_course'])) {

  //PDF
  $current_course_pdf = trim($_POST['current_pdf'], ',');
  $pdf_file = $current_course_pdf . ',';
  $total = count($_FILES['course_pdf']['name']);

  if ($total > 0) {
    for ($i = 0; $i < $total; $i++) {
      $tmpFilePath = $_FILES['course_pdf']['tmp_name'][$i];
      if ($tmpFilePath != "") {
        $filetype = $_FILES['course_pdf']['type'][$i];
        $file_extension = explode("/", $filetype)[1];
        $unique_name = time() . rand(999, 10009);
        $newFilePath = "../uploads/course/pdf/" . $unique_name . '_' . $_FILES['course_pdf']['name'][$i];
        $pdf_file .= $unique_name . '_' . $_FILES['course_pdf']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }
  //removed course PDF
  $removed_course_pdf = explode(',', trim($_POST['removed_course_pdf'], ','));
  foreach ($removed_course_pdf as $removed_item) {
    unlink("../uploads/course/pdf/" . $removed_item);
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
        $newFilePath = "../uploads/course/video/" . $unique_name . '_' . $_FILES['course_video']['name'][$i];
        $video_file .= $unique_name . '_' . $_FILES['course_video']['name'][$i] . ",";
        move_uploaded_file($tmpFilePath, $newFilePath);
      }
    }
  }
  //removed course video
  $removed_course_video = explode(',', trim($_POST['removed_course_video'], ','));
  foreach ($removed_course_video as $removed_item) {
    unlink("../uploads/course/video/" . $removed_item);
  }

    
    //removed course video
//    $course_thumbnail = $_POST['course_thumbnail'];
//    if ($_FILES['course_thumbnail']['size'] != 0) {
//        $filetype=$_FILES['course_thumbnail']['type'];
//        $filetemp_name=$_FILES['course_thumbnail']['tmp_name'];
//        $file_extension=explode("/",$filetype)[1];
//        $filename="../uploads/".time().'_thumbnail_'.$_FILES['course_thumbnail']['name'];
//        $file_upload_path =$document_path.$filename;
//        move_uploaded_file($filetemp_name, $file_upload_path);
//        $course_thumbnail = $filename;
//    }
    
    
    
  $course_title        = $_POST['course_title'];
  $subcourse_id        = $_POST['subcourse_id'];
  $watch_priority      = $_POST['watch_priority'];
  $course_video        = trim($video_file, ',');
  $video_link          = $_POST['course_video_link'];
  $course_pdf          = trim($pdf_file, ',');
  date_default_timezone_set('America/Toronto');
  $updated_on          = date('Y-m-d H:i:s');
  $query = "update subcourse set title='" . $course_title . "', priority='".$watch_priority."', video='" . $course_video . "',video_link='" . $video_link . "', pdf='" . $course_pdf . "',updated_on='" . $updated_on . "' where id='" . $subcourse_id . "'";
  $result = mysqli_query($con, $query);

  if ($result) {
    $_SESSION['success'] = "<strong>Success.!</strong> Subcourse has been updated.";
    header("Location:view.php?course_id=" . $_POST['course_id']);
  } else {
    $_SESSION['error'] = "Something went wrong.Please check connection";
  }
}
// delete course
if (isset($_POST['data_delete_id'])) {
  $subcourse_id = $_POST['data_delete_id'];
  $query = "select courseID, video ,pdf from subcourse where id='" . $subcourse_id . "'";
  $result = mysqli_query($con, $query);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $course_pdf = $row['pdf'];
    $course_video = $row['video'];
    unlink("../uploads/course/pdf/" . $course_pdf);
    unlink("../uploads/course/pdf/" . $course_video);
  }

  $query = "delete from subcourse where id='" . $subcourse_id . "'";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "okay";
  }
}
