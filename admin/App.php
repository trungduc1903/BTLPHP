<?php
include('../config/connect.php');
if (null == isset($_SESSION["user"]["userId"]))
    header("Location: login.php ");
$page = "";
if (isset($_GET["page"]))
    $page = $_GET["page"];
?>
<div class="App">
    <header>
        <?php include_once('./components/header/header.php') ?>
    </header>
    <div class="app-container">
        <nav class="navbar">
            <?php include_once('./components/navbar/Navbar.php') ?>
        </nav>
        <main class="main">
            <?php
            switch ($page) {

                case 'report':
                    include_once('./pages/report/Report.php');
                    break;
                case 'user':
                    if($_SESSION["user"]["level"] == 0){
                        include_once('./pages/user/User.php');
                    }else{
                        include_once('./pages/forbidden/Forbidden.php');
                    }                    
                    break;
                case 'user_add':
                    include_once('./pages/user_add/User_add.php');
                    break;
                case 'user_update':
                    include_once('./pages/user_update/User_update.php');
                    break;

                case 'subject':
                    include_once('./pages/subject/Subject.php');
                    break;
                
                case 'teacher':
                    include_once('./pages/teacher/Teacher.php');
                    break;
                case 'teacher_add':
                    include_once('./pages/teacher_add/Teacher_add.php');
                    break;
                case 'teacher_del':
                    include_once('./pages/teacher_del/Teacher_del.php');
                    break;
                case 'teacher_update':
                    include_once('./pages/teacher_update/Teacher_update.php');
                    break;
                
                case 'class':
                    include_once('./pages/class/Class.php');
                    break;
                case 'class_add':
                    include_once('./pages/class_add/Class_add.php');
                    break;
                case 'class_del':
                    include_once('./pages/class_del/Class_del.php');
                    break;
                case 'class_students':
                    include_once('./pages/class_students/Class_students.php');
                    break;
                case 'class_teaching':
                    include_once('./pages/class_teaching/Class_teaching.PHP');
                    break;

                case 'student_add':
                    include_once('./pages/student_add/Student_add.php');
                    break;
                case 'student_update':
                    include_once('./pages/student_update/Student_update.php');
                    break;

                case 'student_del':
                    include_once('./pages/student_del/Student_del.php');
                    break;
                
                case 'score':
                    include_once('./pages/score/Score.php');
                    break;
                case 'score_class':
                    include_once('./pages/score_class/Score_class.php');
                    break;
                case 'score_student':
                    include_once('./pages/score_student/Score_student.php');
                    break;      
                    
                case 'account':
                    include_once('./pages/account/Account.php');
                    break;
                case 'security':
                    include_once('./pages/security/Security.php');
                    break;
                default:     
                    include_once('./pages/about/About.php');               
                    break;
            }

            ?>

        </main>
    </div>

</div>