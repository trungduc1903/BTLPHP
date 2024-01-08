<?php

define('NO_INFOR', 0);
define('EXCELLENT', 1);
define('GOOD', 2);
define('AVERAGE', 3);
define('BELOW_AVERAGE', 4);

$year = $_SESSION["schoolYear"];
$semester = 1;

if (!isset($_COOKIE["reportSemester"])) {
    setcookie("reportSemester", 1, time() + (86400 * 30), "/");
} else {
    $semester = $_COOKIE["reportSemester"];
}

if (isset($_POST["semester"])) {
    $_COOKIE["reportSemester"] = $_POST["semester"];
}
$semester =  $_COOKIE["reportSemester"];

// start get general infor
$numsOfTeacher = 0;
$numsOfStudents = 0;
$numsOfClasses = 0;
$numsOfTeacherQuery = "CALL proc_report_getGeneralInfor($year,@numsOfTeacher,@numsOfStudents,@numsOfClasses)";
mysqli_query($conn, $numsOfTeacherQuery);
$select = mysqli_query($conn, 'SELECT @numsOfTeacher,@numsOfStudents,@numsOfClasses');
$result =  mysqli_fetch_array($select);
$numsOfTeacher = $result['@numsOfTeacher'];
$numsOfStudents = $result['@numsOfStudents'];
$numsOfClasses = $result['@numsOfClasses'];

//end get general infor

//start get scoresConditional
$query = "CALL proc_report_semesterClassificationScoreCondition($year, $semester)";
if ($semester == 0) {
    $query = "CALL proc_report_yearClassificationScoreCondition($year)";
}
$scoresConditionalResult = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($scoresConditionalResult)) {
    $conditions[$row["studentId"]] = $row["average"];
}
while (mysqli_next_result($conn));
//end get scoresConditional

//start get student average score

$query = "CALL proc_report_semesterScoreAverage($year,$semester)";
if ($semester == 0) {
    $query = "CALL proc_report_yearScoreAverage($year)";
}
$studentsAverageScoreResult = mysqli_query($conn, $query);
$numsOfExcellent = 0;
$numsOfGood = 0;
$numsOfAverage = 0;
$numsOfBelowAverage = 0;

while ($row = mysqli_fetch_array($studentsAverageScoreResult)) {
    $scores[$row["grade"]][$row["classId"]]["name"] = $row["name"];
    $scores[$row["grade"]][$row["classId"]]["classId"] = $row["classId"];
    if (!isset($scores[$row["grade"]][$row["classId"]]["excellent"])) {
        $scores[$row["grade"]][$row["classId"]]["excellent"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["good"])) {
        $scores[$row["grade"]][$row["classId"]]["good"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["average"])) {
        $scores[$row["grade"]][$row["classId"]]["average"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["belowAverage"])) {
        $scores[$row["grade"]][$row["classId"]]["belowAverage"] = 0;
    };
    $classification = 0;
    $condition = $conditions[$row["studentId"]];
    $score = $row["semesterAverage"];
    if (!$score == null) {
        $classification = 1;
        if ($condition < 5) $classification += 1;
        if ($score < 8) $classification += 1;
        if ($score < 6.5) $classification += 1;
        if ($score < 5) $classification += 1;
        switch ($classification) {
            case NO_INFOR:
                break;
            case EXCELLENT:
                $numsOfExcellent += 1;
                $scores[$row["grade"]][$row["classId"]]["excellent"] += 1;
                break;
            case GOOD:
                $numsOfGood += 1;
                $scores[$row["grade"]][$row["classId"]]["good"] += 1;
                break;
            case AVERAGE:
                $numsOfAverage += 1;
                $scores[$row["grade"]][$row["classId"]]["average"] += 1;
                break;
            case $classification >= BELOW_AVERAGE:
                $numsOfBelowAverage += 1;
                $scores[$row["grade"]][$row["classId"]]["belowAverage"] += 1;
                break;
            default:

                break;
        }
    }
}
//end get student average score

?>

<div class="page-title">

</div>

<div class="page-content report">

    <div class="report-container">
        <div class="card success">
            <div class="type">Tống số</div>
            <div class="quantity"><?php echo $numsOfStudents ?></div>
            <div class="percent">Học sinh</div>
        </div>
        <div class="card success">
            <div class="type">Giỏi</div>
            <div class="quantity"><?php echo $numsOfExcellent ?></div>
            <div class="percent"><?php echo number_format($numsOfExcellent / $numsOfStudents * 100, 2) ?>%</div>
        </div>
        <div class="card infor">
            <div class="type">Khá</div>
            <div class="quantity"><?php echo $numsOfGood ?></div>
            <div class="percent"><?php echo number_format($numsOfGood / $numsOfStudents * 100, 2) ?>%</div>

        </div>
        <div class="card warning">
            <div class="type">Trung bình</div>
            <div class="quantity"><?php echo $numsOfAverage ?></div>
            <div class="percent"><?php echo number_format($numsOfAverage / $numsOfStudents * 100, 2) ?>%</div>
        </div>
        <div class="card error">
            <div class="type">Yếu</div>
            <div class="quantity"><?php echo $numsOfBelowAverage ?></div>
            <div class="percent"><?php echo number_format($numsOfBelowAverage / $numsOfStudents * 100, 2) ?>%</div>

        </div>

    </div>
    <div class="report-container class-report">

        <div class="toolbar">

            <form id="semesterForm" action="" method="POST">
                Kỳ đánh giá
                <select onchange="handleSemesterChange();" name="semester">
                    <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                    <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
                    <option <?php if ($semester == 0) echo "selected" ?> value="0">Cả năm</option>▬
                </select>
            </form>
            <br>
            <div>
                Khối
                <form action="" method="post">
                    <label class="form-group">
                        <input checked onchange="
                            let isShow = document.getElementById('grade--10');
                            isShow.checked = event.target.checked;                      
                        " value="10" type="checkbox" name="grade[]" id="">
                        <span>Khối lớp 10</span>
                    </label>
                    <label class="form-group">
                        <input checked onchange="
                            let isShow = document.getElementById('grade--11');
                            isShow.checked = event.target.checked;                      
                        " value="11" type="checkbox" name="grade[]" id="">
                        <span>Khối lớp 11</span>
                    </label>
                    <label class="form-group">
                        <input checked onchange="
                            let isShow = document.getElementById('grade--12');
                            isShow.checked = event.target.checked;                      
                        " value="12" type="checkbox" name="grade[]" id="">
                        <span>Khối lớp 12</span>
                    </label>

                </form>
            </div>

        </div>
        <div class="content">
            <div class="classes-report">
                <input hidden checked type="checkbox" id="grade--10">
                <input hidden checked type="checkbox" id="grade--11">
                <input hidden checked type="checkbox" id="grade--12">
                <?php
                if (isset($scores[10]))
                    $classes = $scores[10];
                if (isset($scores[10]))
                    foreach ($classes as $class) {
                ?>
                    <div class="class-card grade--10">
                        <a href="./index.php?page=score_class&id=<?php echo $class['classId'] . "&semester=" . $semester ?>">
                            <div class="card-container">
                                <div class="name">Lớp <?php echo "10" . " " . $class["name"] ?></div>
                                <div class="classification">
                                    <div class="chip success">giỏi: <?php echo $class["excellent"] ?></div>
                                    <div class="chip infor">khá: <?php echo $class["good"] ?></div>
                                    <div class="chip warning">trung bình: <?php echo $class["average"] ?></div>
                                    <div class="chip error">yếu: <?php echo $class["belowAverage"] ?></div>
                                </div>
                                <div class="view">

                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                    }
                ?>

                <?php
                if (isset($scores[11]))
                    $classes = $scores[11];
                if (isset($scores[11]))
                    foreach ($classes as $class) {
                ?>
                    <div class="class-card grade--11">
                        <a href="./index.php?page=score_class&id=<?php echo $class['classId'] . "&semester=" . $semester ?>">

                            <div class="card-container">
                                <div class="name">Lớp <?php echo "11" . " " . $class["name"] ?></div>
                                <div class="classification">
                                    <div class="chip success">giỏi: <?php echo $class["excellent"] ?></div>
                                    <div class="chip infor">khá: <?php echo $class["good"] ?></div>
                                    <div class="chip warning">trung bình: <?php echo $class["average"] ?></div>
                                    <div class="chip error">yếu: <?php echo $class["belowAverage"] ?></div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php
                    }
                ?>

                <?php
                if (isset($scores[12]))
                    $classes = $scores[12];
                if (isset($scores[12]))
                    foreach ($classes as $class) {
                ?>
                    <div class="class-card grade--12">
                        <a href="./index.php?page=score_class&id=<?php echo $class['classId'] . "&semester=" . $semester ?>">

                            <div class="card-container">
                                <div class="name">Lớp <?php echo "12" . " " . $class["name"] ?></div>
                                <div class="classification">
                                    <div class="chip success">giỏi: <?php echo $class["excellent"] ?></div>
                                    <div class="chip infor">khá: <?php echo $class["good"] ?></div>
                                    <div class="chip warning">trung bình: <?php echo $class["average"] ?></div>
                                    <div class="chip error">yếu: <?php echo $class["belowAverage"] ?></div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function handleSemesterChange() {
        let form = document.querySelector("#semesterForm");
        form.submit();
    }
</script>