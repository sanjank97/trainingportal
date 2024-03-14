<?php
date_default_timezone_set('America/Toronto');

class Training {
    private $con;
    public function __construct($con) {
        $this->con = $con;
        if (!$this->con) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
    }
    public function getConnection() {
        return $this->con;
    }
    public function getlatestScorebyEmpId($empID) {
        $empID = mysqli_real_escape_string($this->con, $empID);
        $query = "SELECT * FROM test WHERE employee_id='$empID' ORDER BY id desc LIMIT 1";
        $results = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_assoc($results)) {
           if(isset($row['mark']) && !empty($row['mark'])){
                $marks          = $row['mark'];
                $empTotalScore  = $row['correct_question'] *  $marks;
                if(!empty($empTotalScore)){
                    return $empTotalScore;
                }else{
                    return "N/A";
                }
           }
           else{
            return "N/A";
           }
        }
        return "N/A";
    }
    public function getHighestScorebyEmpId($empID) {
        $empID = mysqli_real_escape_string($this->con, $empID);
        $query = "SELECT * FROM test WHERE employee_id='$empID' ";
        $results = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_assoc($results)) {
           if(isset($row['mark']) && !empty($row['mark'])){
                $marks          = $row['mark'];
                $empTotalScore  = $row['correct_question'] *  $marks;
                if(!empty($empTotalScore)){
                    return $empTotalScore;
                }else{
                    return "N/A";
                }
           }
           else{
            return "N/A";
           }
        }
        return "N/A";
    }

    public function getTotalExamEmpId($empID) {
        $empID = mysqli_real_escape_string($this->con, $empID);
        $query = "SELECT * FROM test WHERE employee_id='$empID' ORDER BY id desc LIMIT 1";
        $results = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_assoc($results)) {
           if(isset($row['mark']) && !empty($row['mark'])){
                $marks          = $row['mark'];
                $empTotalScore  = $row['total_questions'] *  $marks;
                if(!empty($empTotalScore)){
                    return "/".$row['total_questions'] * (int)$marks;
                }else{
                    return "";
                }
           }
           else{
            return "";
           }
        }
        return "";
    }
    public function getstatusdocument($empID){
        $query = "SELECT * FROM employee WHERE id='$empID' ORDER BY id desc LIMIT 1";
        $results = mysqli_query($this->con, $query);
    
        // Check if query execution was successful
        if (!$results) {
            echo "Error: " . mysqli_error($this->con);
            return false;
        }
    
        $docmsg = ""; // Initialize document status message
    
        // Fetch the row
        while($row = mysqli_fetch_assoc($results)) {
            if ($row['driving_license'] != "" && $row['security_license'] != "" && $row['cpr_certification'] != "") {
                // Calculate expiration dates
                $dl_expiredate = strtotime($row['dl_expiredate']);
                $sl_expiredate = strtotime($row['sl_expiredate']);
                $cc_expiredate = strtotime($row['cc_expiredate']);
    
                // Get current date
                $currentDate = strtotime(date("Y-m-d"));
    
                // Check if any document is expired
                if ($dl_expiredate < $currentDate || $sl_expiredate < $currentDate || $cc_expiredate < $currentDate) {
                    $docmsg = "<span class='text-danger'>Expired!</span>";
                } else {
                    // Calculate days until expiry
                    $dl_days_until_expiry = ($dl_expiredate - $currentDate) / (60 * 60 * 24);
                    $sl_days_until_expiry = ($sl_expiredate - $currentDate) / (60 * 60 * 24);
                    $cc_days_until_expiry = ($cc_expiredate - $currentDate) / (60 * 60 * 24);
    
                    // Check if any document expires in 1, 2, or 3 days
                    if ($dl_days_until_expiry <= 3 || $sl_days_until_expiry <= 3 || $cc_days_until_expiry <= 3) {
                        $docmsg = "<span class='text-warning'>Expiring soon!</span>";
                    } else {
                        $docmsg = "<span class='text-success'>Active</span>";
                    }
                }
            } else {
                $docmsg = "<span class='text-danger'>Not Uploaded Yet!</span>";
            }
        }
        
        return $docmsg;
    }

    public function getEmployeeRecordsKeyword(){
        echo "TEST bykk";
        die();
    }
    
}


//FILTER FUNCTION

require_once('db_connection.php'); 
require_once('define.php'); 
$objDB      = new Training($con);
$connection = $objDB->getConnection();

if(isset($_POST['action']) &&  $_POST['action'] == "search_keyword"){
    $keyword    = $_POST['keyword'];
    $html       ='';
    $query      = "SELECT * FROM employee WHERE ";
    $keyword    = $_POST['keyword'];
    $columns    = array("name", "email", "mobile", "status"); // Specify the columns you want to search in
    $whereClause = "";
    foreach ($columns as $column) {
        $whereClause .= "$column LIKE '%$keyword%' OR ";
    }
    $whereClause        = rtrim($whereClause, "OR ");
    $query              .= $whereClause;
    $query              .=" ORDER BY last_login DESC";
    $result             = mysqli_query($connection,$query);
    $num                = mysqli_num_rows($result);  
    $Cquery             = "select * from course order by id desc";
    $Cresult            = mysqli_query($connection,$Cquery);
    $Total_course_count = mysqli_num_rows($Cresult);            
    if($num >0)
    {
        $key=0;
        while($row=mysqli_fetch_assoc($result))
        {
            $emp_id                 = $row['id'];                                                        
            $Equery                 ="select DISTINCT course_id from test where employee_id = $emp_id";
            $Eresult                =mysqli_query($connection,$Equery);
            $Total_emp_count        =mysqli_num_rows($Eresult);      
            if( $row['status'] == 1 ){
                $status = "Active";
            }
            else{
                $status = "Inactive";  
            }
            $datetime = $row['last_login'];
            $currentDateTime = new DateTime();
            $givenDateTime = new DateTime($datetime);
            $difference = $currentDateTime->diff($givenDateTime);
            if ($difference->y > 0) {
                $timeAgo = $difference->y . ' year';
            } elseif ($difference->m > 0) {
                $timeAgo = $difference->m . ' month';
            } elseif ($difference->d > 0) {
                $timeAgo = $difference->d . ' day';
            } elseif ($difference->h > 0) {
                $timeAgo = $difference->h . ' hour';
            } elseif ($difference->i > 0) {
                $timeAgo = $difference->i . ' minute';
            } elseif ($difference->s > 0) {
                $timeAgo = $difference->s . ' second';
            } else {
                $timeAgo = 'just now';
            }
            if ($difference->y > 1 || $difference->m > 1 || $difference->d > 1 || $difference->h > 1 || $difference->i > 1 || $difference->s > 1) {
                $timeAgo .= 's';
            }
            $timeAgo .= ' ago';
            if(empty($datetime) || $datetime =="0000-00-00 00:00:00"){
                $timeAgo = 'N/A';
            }
            $html .= '<tr data-score="'.$objDB->getlatestScorebyEmpId($row['id']).'" data-name="'.$row['name'].'">
                    <td>'.++$key.'</td>
                    <td><a style="color:#007bffc7;" href="'.BASE_URL.'employee/view.php?employee_id='.$row['id'].'">'.$row['name'].'</td>
                    <td>'.$Total_emp_count.'/'.$Total_course_count.'</td>
                    <td>'.$objDB->getlatestScorebyEmpId($row['id']).''.$objDB->getTotalExamEmpId($row['id']).'</td>
                    <td>'.$objDB->getstatusdocument($row['id']).'</td>
                    <td>'.$timeAgo.'</td>
                    <td class="text-right">
                       <span class="'.$status.'">'.$status.'</span>
                    </td>
            </tr>';
        }
    }
    else{
        $html = 'Not found any match';
    }
    echo $html;
    die();
}

if(isset($_POST['action']) &&  $_POST['action'] == "search_keyword_emp_list"){
    $keyword    = $_POST['keyword'];
    $html       ='';
    $query      = "SELECT * FROM employee WHERE ";
    $keyword    = $_POST['keyword'];
    $columns    = array("name", "email", "mobile", "status"); // Specify the columns you want to search in
    $whereClause = "";
    foreach ($columns as $column) {
        $whereClause .= "$column LIKE '%$keyword%' OR ";
    }
    $whereClause        = rtrim($whereClause, "OR ");
    $query              .= $whereClause;
    $query              .=" ORDER BY last_login DESC";
    $result             = mysqli_query($connection,$query);
    $num                = mysqli_num_rows($result);  
    $html   ='';
    if($num >0)
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
           $html .=  '<tr data-score="'.$objDB->getlatestScorebyEmpId($row['id']).'" data-name="'.$row['name'].'">
                        <th scope="row">'. $start_increament + (++$key).'</th>
                        <td><a style="color:#007bffc7" href="view.php?employee_id='.$row['id'].'"  style="margin-left:10px;">'.$row['name'].'</a></td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['dateofbirth'].'</td>
                        <td>'.$row['mobile'].'</td>
                        <td>';
                        if($row['status']==0)
                        {
                            $html .= '<a href="javascript:void(0)" class="text-primary emp_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px; font-size:24px;"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
                        }
                        else
                        {
                            $html .= '<a href="javascript:void(0)" class="text-primary emp_status_btn" data-status-id="'.$row['id'].'" style="margin-left:10px;  font-size:24px; color:#007bffc7;"><i class="fa fa-toggle-on" aria-hidden="true" style="color:#007bffc7;"></i></a>';
                        }
                        $html .= '</td>
                        <td>'.$objDB->getstatusdocument($row['id']).'</td>
                        <td><a href="viewtest.php?employee_id='.$row['id'].'"  style="margin-left:10px;color:green;">View</a></td>
                        <td><a href="view.php?employee_id='.$row['id'].'"  style="margin-left:10px;">View</a></td>
                        <td>
                        <a href="#" class="emp_edit_btn" data-edit-id="'.$row['id'].'" data-toggle="modal" data-target="#myModal2"><i class="ti-pencil-alt edit_icon"  ></i></a>
                        <a href="#" class="emp_delete_btn"  data-delete-id="'.$row['id'].'" style="color:red;margin-left:10px;"><i class="ti-trash delete_icon" ></i></a>
                        ';
                        $html .= '</td>  
            </tr>';
        }
    }
    echo $html;
}