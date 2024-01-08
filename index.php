<?php
include('./config/connect.php');
$semester = 1;
$year = 1;
$schoolYear;
$code = "";
if (isset($_GET["code"])) {
    $code = $_GET["code"];
}
if (isset($_GET["year"])) {
    $year = $_GET["year"];
}
if (isset($_GET["semester"])) {
    $semester = $_GET["semester"];
}

$studentQuery = "CALL proc_student_getByCode('$code')";
$studentResult = mysqli_query($conn, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);
while (mysqli_next_result($conn)) {;
}
$isSuccess = false;
if (mysqli_num_rows($studentResult) != 0) {
    $yearStart = $student["schoolYear"];
    $yearEnd = $yearStart + 2;
    $isSuccess = true;
}
$studentId = "";
echo $conn->error;
if (isset($student["studentId"])) {
    $studentId = $student["studentId"];
}

if (isset($_GET["code"])) {
}

$studentScoreQueryStmt = "CALL proc_score_getByStudent('$studentId',$semester,$year)";
$studentScores = mysqli_query($conn, $studentScoreQueryStmt);
$scores = mysqli_fetch_all($studentScores, MYSQLI_ASSOC);

while (mysqli_next_result($conn)) {;
}
$classId = "";
if(isset($student["classId"]))
$classId = $student["classId"];
$studentSemesterAverageQuery = "CALL proc_score_studentSemesterAverage('$classId','$semester','$year','$studentId')";
$studentSemesterAverageResult = mysqli_query($conn, $studentSemesterAverageQuery);
$avg = mysqli_fetch_assoc($studentSemesterAverageResult);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="header">
        <div class="search">
            <form action="" method="get">
                <input value="<?php echo $code ?>" placeholder="Nhập mã học sinh để tìm kiếm" name="code" type="text">
                <button class="btn pri">Tìm kiếm</button>
            </form>
        </div>
    </div>

    <?php
    if ($isSuccess) {
    ?>
        <div class="toolbar">
            <div class="toolbar--left student-infor">
                <div><b>Họ và tên</b>: <?php echo $student["fullname"] ?></div>
                <div>
                    <b>Lớp</b>: <?php echo ($year + 10 - 1) ?>
                    <?php echo $student["name"] ?>
                </div>
            </div>
            <div class="toolbar--right year-and-semester">
                <form id="semesterAndYear" action="" method="GET">
                    <input type="hidden" name="code" value="<?php echo $code ?>">
                    <select onchange="handleYearAndSemesterChange()" name="semester">
                        <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                        <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
                    </select>
                    <select onchange="handleYearAndSemesterChange()" name="year">
                        <?php
                        ?>
                        <option <?php if ($year == 3) echo "selected" ?> value="<?php echo 3 ?>"><?php echo ($yearStart + 2) . " - " . ($yearStart + 3) ?></option>
                        <option <?php if ($year == 2) echo "selected" ?> value="<?php echo 2 ?>"><?php echo ($yearStart + 1) . " - " . ($yearStart + 2) ?></option>
                        <option <?php if ($year == 1) echo "selected" ?> value="<?php echo 1 ?>"><?php echo $yearStart . " - " . ($yearStart + 1) ?></option>
                        <?php
                        ?>
                    </select>
                </form>

            </div>
        </div>
        <div class="main-content">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên môn</td>
                            <th colspan="3">Điểm hệ số 1</td>
                            <th colspan="2">Điểm hệ số 2</td>
                            <th>Điểm thi </td>
                            <th>Trung bình</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $average = $avg["semesterAverage"];
                        define('NO_INFOR', 0);
                        define('EXCELLENT', 1);
                        define('GOOD', 2);
                        define('AVERAGE', 3);
                        define('BELOW_AVERAGE', 4);
                        $classification = 0;
                        $classification = 1;
                        if ($average < 8) $classification += 1;
                        if ($average < 6.5) $classification += 1;
                        if ($average < 5) $classification += 1;

                        $i = 0;
                        foreach ($scores as $subjectScores) {
                            $i += 1;
                            if ($subjectScores["subjectId"] == "s12")
                                if ($subjectScores["average"] < 5) $classification + 1;
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $subjectScores["subjectName"] ?></td>
                                <td><?php echo $subjectScores["oralTest"] ?></td>
                                <td><?php echo $subjectScores["fifTest1"] ?></td>
                                <td><?php echo $subjectScores["fifTest2"] ?></td>
                                <td><?php echo $subjectScores["periodTest1"] ?></td>
                                <td><?php echo $subjectScores["periodTest2"] ?></td>
                                <td><?php echo $subjectScores["finalTest"] ?></td>
                                <td><?php echo $subjectScores["average"] ?></td>
                            </tr>
                        <?php

                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div>
                    Xếp loại: <?php
                                switch ($classification) {
                                    case NO_INFOR:
                                        echo "<div class='chip'>Chưa xếp loại</div>";
                                        break;
                                    case EXCELLENT:
                                        echo "<div class='chip '>Giỏi</div>";
                                        $excellent += 1;
                                        break;
                                    case GOOD:
                                        echo "<div class='chip infor'>Khá</div>";
                                        $good += 1;
                                        break;
                                    case AVERAGE:
                                        echo "<div class='chip warning'>Trung Bình</div>";
                                        $average += 1;
                                        break;
                                    case $classification >= BELOW_AVERAGE:
                                        echo "<div class='chip error'>Yếu</div>";
                                        $belowAverage += 1;
                                        break;
                                    default:

                                        break;
                                }
                                ?>
                </div>
                <div>
                    <div class="chip">

                        Điểm trung bình: <?php echo $average ?>
                    </div>
                </div>
            </div>
        </div>
    <?php

    }else{
    ?>
    <div class="toolbar" style="">
        <h2 style="text-align: center;">Không tìm thấy kết quả</h2>
    </div>

    <?php
    }

    ?>

</body>

</html>

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#semesterAndYear");
        console.log(form);
        form.submit();
    }
</script>