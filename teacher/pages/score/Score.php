<?php
$grade;
if (isset($_GET["grade"])) {
    $grade = $_GET["grade"];
}
$classId = "";
if (isset($_GET["classId"])) $classId = $_GET["classId"];
if (isset($_GET["grade"])) $grade = $_GET["grade"];

$semester = $_SESSION["semester"];
$year = $_SESSION["schoolYear"];
$teacherId = $_SESSION["teacher"]["teacherId"];
$subjectId = $_SESSION["teacher"]["subjectId"];
  
$classQueryStmt = "CALL proc_class_getById('$classId')";
$classQueryResult = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}
$class = mysqli_fetch_array($classQueryResult);

$subjectId = $_SESSION["teacher"]["subjectId"];
$studentScoresQueryStmt = "CALL proc_score_getBySubject('$classId','$subjectId',$semester,$year,'$teacherId')";
$studentScoresQueryResult = mysqli_query($conn, $studentScoresQueryStmt);
while (mysqli_next_result($conn));
$students = [];
while ($student = mysqli_fetch_array($studentScoresQueryResult)) {
    $students[$student["studentId"]] = $student;
}
// echo "<pre>";
//     print_r($students);
// echo "<pre>";
while (mysqli_next_result($conn));

if (isset($_POST["update"])) {
    $year = $year - $class["schoolYear"] + 1;
    foreach ($students as $student) {
        $oral = $_POST["oral-" . $student["studentId"]];
        $fif1 = $_POST["fif1-" . $student["studentId"]];
        $fif2 = $_POST["fif2-" . $student["studentId"]];
        $per1 = $_POST["period1-" . $student["studentId"]];
        $per2 = $_POST["period2-" . $student["studentId"]];
        $final = $_POST["final-" . $student["studentId"]];
        updateScore($conn, $student["studentId"], $classId, $subjectId, $oral, $fif1, $fif2, $per1, $per2, $final, $semester, $year);
        // header("Location: ./index.php?classId=".$classId."&grade=".$grade);
    }
}

$studentScoresQueryResult = mysqli_query($conn, $studentScoresQueryStmt);
while (mysqli_next_result($conn));
$students = [];
while ($student = mysqli_fetch_array($studentScoresQueryResult)) {
    $students[$student["studentId"]] = $student;
}

function updateScore(
    $conn,
    $studentId,
    $classId,
    $subjectId,
    $oralTest,
    $fifTest1,
    $fifTest2,
    $periodTest1,
    $periodTest2,
    $finalTest,
    $semester,
    $year
) {
    $updateScoreStmt = "CALL proc_score_update('$studentId','$classId','$subjectId',$year,$semester,$oralTest,$fifTest1,$fifTest2,$periodTest1,$periodTest2,$finalTest)";
    mysqli_query($conn, $updateScoreStmt);
    while (mysqli_next_result($conn));
    echo $conn->error;
}
?>

<?php
if (isset($class)) {
?>
    <div class="page-content page-score">
        <div class="page-title">
            <h2>Lớp <?php echo $grade . $class["name"] ?></h2>
        </div>

        <div class="page-body">

            <form action="" method="post">
                <div class="toolbar">                    
                    <button class="btn pri" name="update">Lưu</button>  
                    <button class="btn">Làm mới</button>                
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ </th>
                                <th>Tên</th>
                                <th colspan="3">Điểm hệ số 1</th>
                                <th colspan="2">Điểm hệ số 2</th>
                                <th>Điểm thi</th>
                                <th>Trung bình</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($students as $score) {
                                $i+=1;
                            ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $score["lastName"] ?></td>
                                    <td><?php echo $score["firstName"] ?></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["oralTest"] ?>" name="<?php echo "oral-" . $score["studentId"] ?>"></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["fifTest1"] ?>" name="<?php echo "fif1-" . $score["studentId"] ?>"></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["fifTest2"] ?>" name="<?php echo "fif2-" . $score["studentId"] ?>" id=""></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["periodTest1"] ?>" name="<?php echo "period1-" . $score["studentId"] ?>" id=""></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["periodTest2"] ?>" name="<?php echo "period2-" . $score["studentId"] ?>" id=""></td>
                                    <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["finalTest"] ?>" name="<?php echo "final-" . $score["studentId"] ?>" id=""></td>
                                    <td><?php echo $score["average"] ?></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>

                    </table>
                </div>
            </form>
        </div>
    </div>
<?php

} else {
    echo "Chọn lớp để làm việc";
}
?>



<script>
    function scoreValidate(e) {
        const key = e.keyCode;
        const keyValid = [8, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 190];

        if (!keyValid.includes(key)) {
            e.preventDefault();
        }
        if (key !== 8) {
            const nextValue = Number(e.target.value + e.key);
            if (nextValue > 10 || nextValue < 0 || Number.isNaN(nextValue)) {
                e.preventDefault();
            }
            if ((e.target.value + " ").length > 4) {
                e.preventDefault();
            }

            if (Number(e.target.value) === 10) {
                e.preventDefault();
            }
        }
    }
</script>