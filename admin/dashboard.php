<?php
    include 'includes/header_top.php';
    include('../db_connection.php'); 
    require_once('../trainingClass.php');
    $training = new Training($con);
?>

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?php
            include 'includes/header.php';
        ?>
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar" navbar-theme="themelight1" active-item-theme="theme1" sub-item-theme="theme2"
                    active-item-style="style0" pcoded-navbar-position="fixed">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <?php  include 'includes/nav.php'; ?>     
                    </div>
                </nav>
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <?php
                                 include 'includes/dashboard.php';
                            ?>
                            <div class="page-wrapper">
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <div class="row">
                                        <div class="col-xl-9 col-md-12">
                                            <div class="card table-card">

                                                <div class="search_wrap">
                                                    <div class="input-search">
                                                        <label>Search</label> <br>
                                                        <input type="text" class="form-control" id="keyword" placeholder="Search By Keyword">
                                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                                    </div>
                                                   
                                                    <div class="sortby" style="margin-bottom:30px;">
                                                        <label>Sort By:</label>
                                                        <select name="sortby" id="sortby" class="form-control">
                                                            <option value="name">Name</option>
                                                            <option value="score">Latest Score</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-header">
                                                    <h5>Top Employes</h5>
                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="scoreTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Course Pending</th>
                                                                    <th>Score</th>
                                                                    <th>Document</th>
                                                                    <th>Last Login</th>
                                                                    <th class="text-right">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $query      ="select * from employee ORDER BY last_login DESC";
                                                                    $result     =mysqli_query($con,$query);
                                                                    $num        =mysqli_num_rows($result);  
                                                                    $Cquery     ="select * from course order by id desc";
                                                                    $Cresult    =mysqli_query($con,$Cquery);
                                                                    $Total_course_count =mysqli_num_rows($Cresult);            
                                                                    if($num >0)
                                                                    {
                                                                        
                                                                        $key=0;
                                                                        while($row=mysqli_fetch_assoc($result))
                                                                        {
                                                                            
                                                                            $emp_id = $row['id'];
                                                                            
                                                                            $Equery                ="select DISTINCT course_id from test where employee_id = $emp_id";
                                                                            $Eresult               =mysqli_query($con,$Equery);
                                                                            $Total_emp_count       =mysqli_num_rows($Eresult);      
                                                                            
                                                                            
                                                                            
                                                                            if( $row['status'] == 1 ){
                                                                                $status = "Active";
                                                                            }
                                                                            else{
                                                                                $status = "Inactive";  
                                                                            }

                                                                            $datetime = $row['last_login'];
                                                                            //echo '<pre>',var_dump( $datetime ); echo '</pre>';
                                                                            $currentDateTime = new DateTime();
                                                                            $givenDateTime = new DateTime($datetime);
                                                                            $difference = $currentDateTime->diff($givenDateTime);

//echo '<pre>',var_dump( $difference ); echo '</pre>';
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

                                                                            ///echo $timeAgo . '====<br>';
                                                                            echo '<tr data-score="'.$training->getlatestScorebyEmpId($row['id']).'" data-name="'.$row['name'].'">
                                                                                    <td>'.++$key.'</td>
                                                                                    <td><a style="color:#007bffc7;" href="'.BASE_URL.'employee/view.php?employee_id='.$row['id'].'">'.$row['name'].'</td>
                                                                                    <td>'.$Total_emp_count.'/'.$Total_course_count.'</td>
                                                                                    <td>'.$training->getlatestScorebyEmpId($row['id']).''.$training->getTotalExamEmpId($row['id']).'</td>
                                                                                    <td>'.$training->getstatusdocument($row['id']).'</td>
                                                                                    <td>'.$timeAgo.'</td>
                                                                                    <td class="text-right">
                                                                                       <span class="'.$status.'">'.$status.'</span>
                                                                                    </td>
                                                                            </tr>';

                                                                        }
                                                                    }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-right m-r-20">
                                                            <a href="<?=BASE_URL?>employee/list.php"
                                                                class=" b-b-primary text-primary">View all
                                                                Employees</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-12">
                                            <div class="card ">
                                                <div class="card-header">
                                                    <h5>Courses</h5>
                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
<!--
                                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                                            <li><i class="fa fa-trash close-card"></i></li>
-->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <?php
                                                    $query  ="select * from course where course_type=0 order by id desc";
                                                    $result =mysqli_query($con,$query);
                                                    $num    =mysqli_num_rows($result);   

                                                    if($num >0)
                                                    {
                                                        $key=0;
                                                        while($row=mysqli_fetch_assoc($result))
                                                        {
                                                            echo '<div class="align-middle m-b-15">
                                                        
                                                            <div class="d-inline-block">
                                                            <h6><a href="'.BASE_URL.'courses/view.php?course_id='.$row['course_id'].'">'.$row['course_title'].'</a></h6>
                                                           
                                                            </div>
                                                            </div>';

                                                        }
                                                    }
                                                 ?>
                                                    <div class="text-center">
                                                        <a href="<?=BASE_URL?>courses/list.php"
                                                            class="b-b-primary text-primary">View all
                                                            Courses</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-body end -->
                            </div>
                            <div id="styleSelector"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#sortby').change(function() {
        var sortBy = $(this).val();
        if (sortBy == 'name') {
            sortByName();
        } else if (sortBy == 'score') {
            sortByScore();
        }
    });
});

function sortByName() {
    var rows = $('#scoreTable tbody').find('tr').get();
    rows.sort(function(a, b) {
        var nameA = $(a).data('name').toUpperCase();
        var nameB = $(b).data('name').toUpperCase();
        return (nameA < nameB) ? -1 : (nameA > nameB) ? 1 : 0;
    });
    $.each(rows, function(index, row) {
        $('#scoreTable').append(row);
    });
}

function sortByScore() {
    var rows = $('#scoreTable tbody').find('tr').get();
    rows.sort(function(a, b) {
        var scoreA = $(a).data('score');
        var scoreB = $(b).data('score');

        // Check if scoreA or scoreB is "N/A"
        if (scoreA === "N/A" && scoreB === "N/A") {
            return 0;
        } else if (scoreA === "N/A") {
            return 1; // Move "N/A" to the bottom
        } else if (scoreB === "N/A") {
            return -1; // Move "N/A" to the bottom
        }

        scoreA = parseFloat(scoreA);
        scoreB = parseFloat(scoreB);
        return scoreB - scoreA;
    });
    $.each(rows, function(index, row) {
        $('#scoreTable').append(row);
    });
}

$(document).ready(function(){
    $(document).on('keyup', "#keyword", function(){
        let keyword = $(this).val();
        $.ajax({
            url: '<?php echo ROOT_URL; ?>trainingClass.php', 
            type: 'POST',
            data: {
                keyword: keyword,
                action:'search_keyword'
            },
            success: function(response) {
                // Handle success response here
                console.log(response);
                if(response){
                    $('#scoreTable tbody').html(response);
                }

            },
            error: function(xhr, status, error) {
                // Handle error here
                console.error(xhr.responseText);
            }
        });

    });
});
</script>
<?php
   
   include 'includes/footer.php';
?>