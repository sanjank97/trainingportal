<?php
        session_start();
        if (!isset($_SESSION['employee'])) {
        header("Location :../index.php");
        }
        if (!isset($_SESSION['course_id'])) {
            header("Location :all_list.php");
        }
        if (!$_SESSION['test_session_id']) {
            header("Location :list.php?course_id=".$_SESSION['course_id']);
        }

     include('../db_connection.php');
     $querySetting ="select * from setting";
     $setting_result    =   mysqli_query($con,$querySetting);
     $setting_row       =   mysqli_fetch_assoc($setting_result);


     $queryToCourse     = "select course_type from course where course_id='". $_SESSION['course_id']."'";
     $resultCourseType  = mysqli_query($con, $queryToCourse);
     $courseType        = mysqli_fetch_assoc($resultCourseType)['course_type'];
     $limitQ            = -1;
     $course_id         = $_SESSION['course_id'];
     $question_appearance=$_SESSION['question_appearance'];
     $query = "SELECT id, question, ans_a, ans_b, ans_c, ans_d FROM question WHERE course_id ='$course_id' AND question_appearance='$question_appearance'";
     $result = mysqli_query($con, $query);
     $total_questions = mysqli_num_rows($result);
     if($total_questions < 1) {
        header("Location:list.php");
     }
     $questions = [];
     while ($row = mysqli_fetch_assoc($result)) {
        array_push($questions, $row);
     }


     if($courseType == 1){
        $limitQ     =  $setting_row['grandtest_total'];
        if(!isset($_SESSION['questions'])){
            $query  = "SELECT id, question, ans_a, ans_b, ans_c, ans_d FROM question WHERE course_id ='$course_id' AND question_appearance='$question_appearance' ORDER BY RAND() LIMIT $limitQ";
            $result         = mysqli_query($con, $query);
            $total_questions = mysqli_num_rows($result);
            $questions = [];
            while ($row = mysqli_fetch_assoc($result)) {
               array_push($questions, $row);
            }
            $_SESSION['questions'] = $questions;
       }
     }

    if(isset($_SESSION['questions'])){
        $questions = $_SESSION['questions'];
        $total_questions = count( $questions );
    }


     $total_time = $setting_row['per_question_time'] * $total_questions;
     if($courseType == 1){
        $total_time = $setting_row['per_question_time'] * $limitQ;
     }
     include '../includes/header_top.php';
    
?>
<style>
.pcoded-content {
    margin-left: 0!important;
}
.pcoded-navbar{
    opacity: 0;
    display: none!important;
}
.show-notification.profile-notification li:first-child{
    display: none;
}
.search-btn{
    display: none;
}
</style>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?php
            include '../includes/header.php';
          ?>
        <div class="pcoded-main-container custom_test_page">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <?php
                                include '../includes/nav.php';
                            ?>
                    </div>
                </nav>
                <div class="pcoded-content test_parent">
                    <!-- Page-header start -->
                    <div class="pcoded-inner-content">
                        <div class="fluid-container">
                            
                            <div class="exam_time">
                                
                                <span class="high_bold">Total exam duration:</span>
                                <span><?php echo $total_time;?></span><span> Minutes</span>

                                <br>
                                <span class="high_bold">Time start: <span style="color:red" id="ctime"></span></span>
                                <br>
                                <span class="high_bold">Total question: <?=$total_questions;?></span>
                            </div>
                        </div>
                        
                        <div class="fluid-container mt-sm-5 my-1">
                            <div class="question" id="ques">
                            </div>
                            <div class="d-flex align-items-center pt-3 custom_btn">
                                <div class="">
                                    <button id="prev" class="btn btn-primary" onclick="previous()">Previous</button>
                                </div>
                                <div class="">
                                    <button id="nxt" class="btn btn-success" onclick="nxt()">Next</button>
                                    <button id="submit" class="btn btn-success" onclick="final_submit()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

var time_taken = "";
var trigger_var = 0;

const startTime = Math.floor(Date.now() / 1000);
if (localStorage.getItem('stime') == null) {
    localStorage.setItem('stime', startTime);
}
var oldseconds = localStorage.getItem('stime');

function showTime() {
    var curseconds = Math.floor(Date.now() / 1000);
    var timeDifferenceInSeconds = curseconds - oldseconds;
    time_taken = format(timeDifferenceInSeconds); 
    var link = document.getElementById('submit');
    var total_time ='<?php echo $total_time; ?>' 
    var taken_time_minute = timeDifferenceInSeconds / 60;
    // we will compare in second at production.
    if (taken_time_minute > total_time) {
        trigger_var = 1;
        link.click();
        return false;
    }
    document.getElementById('ctime').innerHTML = format(timeDifferenceInSeconds);
    setTimeout(showTime, 1000);
}
showTime();
function format(timeDifferenceInSeconds) {
    const hours = Math.floor(timeDifferenceInSeconds / 3600).toString().padStart(2, '0');;
    const minutes = Math.floor((timeDifferenceInSeconds % 3600) / 60).toString().padStart(2, '0');;
    const seconds = Math.floor(timeDifferenceInSeconds % 60).toString().padStart(2, '0');;
    return formattedTimeDifference = `${hours}:${minutes}:${seconds}`;
}
</script>
<script>
var submit = document.getElementById('submit');
submit.style.display = "none";
var prev = document.getElementById('prev');
prev.style.display = "none";
var questions = <?php echo json_encode($questions)?>;
var old_answers = new Array();
var i = 0;
callQues(i);
function nxt() {
    if (document.querySelector("input[name='ans" + (i + 1) + "']:checked")) {
        var ans = document.querySelector("input[name='ans" + (i + 1) + "']:checked").value;
        old_answers[i] = ans;
        localStorage.setItem("ans" + i, ans);

    } else {
        old_answers[i] = "empty";
        localStorage.setItem("ans" + i, "empty");
    }
    i++;
    callQues(i);
}
function previous() {
    if (document.querySelector("input[name='ans" + (i + 1) + "']:checked")) {
        var ans = document.querySelector("input[name='ans" + (i + 1) + "']:checked").value;
        old_answers[i] = ans;
        localStorage.setItem("ans" + i, ans);
    } else {
        old_answers[i] = "empty";
        localStorage.setItem("ans" + i, "empty");
    }
    i--;
    callQues(i);
}
function final_submit() {
    if (document.querySelector("input[name='ans" + (i + 1) + "']:checked")) {
        var ans = document.querySelector("input[name='ans" + (i + 1) + "']:checked").value;
        old_answers[i] = ans;
        localStorage.setItem("ans" + i, ans);
    } else {
        old_answers[i] = "empty";
        localStorage.setItem("ans" + i, "empty");
    }
    if (trigger_var == 0) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure want to submit test?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                finalAjaxRequest();
            }
        });
    } else {
        finalAjaxRequest();
    }
}

function callQues(i) {

    if (i > 0) {
        prev.style.display = "block";
    } else {
        prev.style.display = "none";
    }
    if (i >= 0 && i < questions.length - 1) {
        var nxt = document.getElementById('nxt');
        nxt.style.display = "block";
    } else {
        var nxt = document.getElementById('nxt');
        nxt.style.display = "none";
    }
    if (i == questions.length - 1) {
        var submit = document.getElementById('submit');
        submit.style.display = "block";
    } else {
        var submit = document.getElementById('submit');
        submit.style.display = "none";
    }

    console.log('questions[i].question: ', questions[i].question);
    document.getElementById('ques').innerHTML =
        `<div class="py-2 h5"><b><span> ${i+1} .</span><span id='Question'></span></b></div>
         <div class="ml-sm-3 pt-sm-0 pt-3" id="options">
         <p><span>a.</span><input type='radio'  value='a' name='ans${i+1}'><span id='opa'></span></p>
         <p><span>b.</span><input type='radio'  value='b'name='ans${i+1}'><span id='opb'></span></p>
         <p><span>c.</span><input type='radio'  value='c' name='ans${i+1}'><span id='opc'></span></p>
         <p><span>d.</span><input type='radio'  value='d' name='ans${i+1}'><span id='opd'></span></p> </div>`;

    document.getElementById('Question').textContent = " " + questions[i].question;
    document.getElementById('opa').textContent = " " + questions[i].ans_a;
    document.getElementById('opb').textContent = " " + questions[i].ans_b;
    document.getElementById('opc').textContent = " " + questions[i].ans_c;
    document.getElementById('opd').textContent = " " + questions[i].ans_d;
    var data = document.querySelector("input[name='ans" + (i + 1) + "'][value='" + localStorage.getItem("ans" + i) +
        "']");
    if (localStorage.hasOwnProperty("ans" + i)) {
        data.checked = true;
    }

}
//Final exam submission via ajax call'
function finalAjaxRequest() {
    $.ajax({
        type: "POST",
        url: "test_handler.php",
        dataType: 'json',
        data: {
            'end_test': 'end_test',
            'course_id': '<?php echo $_SESSION['course_id']; ?>',
            'employee_id': '<?php echo $_SESSION['employee_id'];?>',
            'question_appearance':'<?php echo $_SESSION['question_appearance'];?>',
            'emp_ans': old_answers,
            'total_ques': old_answers.length,
            'time_taken': time_taken
        },
        success: function(response) {
            console.log(response);
            console.log(response['test_id']);
            window.localStorage.clear();
            window.location = "<?php echo BASE_URL.'courses/thankyou.php';?>?test_id="+response['test_id'];

        }
    });
}

</script>

<script>
    // Check if the page is being reloaded
    // $(window).on('beforeunload', function() {
    //     return 'Are you sure you want to leave?';
    // });

    // Detect when the user presses the keyboard shortcut to refresh (F5 or Ctrl+R)
    $(document).keydown(function(event) {
        // F5 key code is 116, and Ctrl key code is 17
        if (event.keyCode == 116 || (event.ctrlKey && event.keyCode == 82)) {
            // Display an alert
           let check =  confirm('Are you sure you want to refresh? The test will be auto-submitted');
           if(check != true){
            return false;
           } 
        }
    });
</script>
<?php
include '../includes/footer.php';
?>