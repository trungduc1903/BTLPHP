<?php
const success = "success";
const error = "error";
$state;
$message = "";
$classQueryStmt = "CALL proc_class_getAll;";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}

$classId = "";
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];
}



$lastName  = "";
$firstName = "";
$dob = "";
$ethnic = "";


$fatherName = "";
$fatherPhone = "";
$fatherJob = "";

$motherName = "";
$motherPhone = "";
$motherJob = "";

if (isset($_GET["id"])) {

    $studentId = $_GET['id'];
    $studentQueryStmt = "CALL proc_student_getById('$studentId')";
    $studentQueryResult = mysqli_query($conn, $studentQueryStmt);
    echo $conn->error;
    while (mysqli_next_result($conn)) {;
    }

    if ($studentQueryResult) {

        $student = mysqli_fetch_array($studentQueryResult);
        $lastName  = $student['lastName'];
        $firstName = $student['firstName'];
        $dob = $student['dob'];
        $ethnic = $student['ethnic'];

        $fatherName = $student['fatherName'];
        $fatherPhone = $student['fatherPhone'];
        $fatherJob = $student['fatherJob'];

        $motherName = $student['motherName'];
        $motherPhone = $student['motherPhone'];
        $motherJob = $student['motherJob'];
    }
}


if (isset($_POST['save'])) {
    $lastName  = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $dob = $_POST['dob'];
    $ethnic = $_POST['ethnic'];


    $fatherName = $_POST['fatherName'];
    $fatherPhone = $_POST['fatherPhone'];
    $fatherJob = $_POST['fatherJob'];

    $motherName = $_POST['motherName'];
    $motherPhone = $_POST['motherPhone'];
    $motherJob = $_POST['motherJob'];

    /**
     * to do
     * validate
     */

    $studentAddStmt = "CALL proc_student_update('$studentId','$firstName', '$lastName','$dob','$ethnic','$fatherName','$fatherPhone','$fatherJob','$motherName', '$motherPhone', '$motherJob','$classId');";
    $addResult = mysqli_query($conn, $studentAddStmt);
    if ($addResult) {
        $message = "Cập nhật thành công";
        $state = success;
    } else {
        echo $conn->error;
    }
}

?>

<div class="page-title">
    <h2>Cập nhật thông tin học sinh <?php echo $student["lastName"] . " " . $student["firstName"] . " - " . $student["studentCode"] ?></h2>
</div>
<div class="page-content student-update-page">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>

        </div>
    </div>
    <div>
        <form action="" method="post">
            <div hidden class="form-group">
                <label>
                    Lớp
                    <select>
                        <?php
                        if ($classes) {
                            while ($class = mysqli_fetch_array($classes)) {
                        ?>
                                <option <?php if ($classId == $class["classId"]) echo "selected" ?> value="<?php echo $class['classId'] ?>">
                                    <?php echo $class['name'] ?>
                                    Niên khoá
                                    <?php echo $class['schoolYear'] ?> - <?php echo $class['schoolYearEnd'] ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div class="form-container">
                <div class="group">
                    <div class="form-group">
                        <label>
                            <span class="label">Họ</span>
                            <input value="<?php echo $lastName ?>" name="lastName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Tên</span>
                            <input value="<?php echo $firstName ?>" name="firstName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">

                        <label>
                            <span class="label">Ngày sinh</span>
                            <input value="<?php echo $dob ?>" name="dob" type="date">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Dân tộc</span>
                            <input value="<?php echo $ethnic ?>" name="ethnic" type="text">
                            <p class="message"></p>
                        </label>
                    </div>

                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            <span class="label">Họ tên cha</span>
                            <input value="<?php echo $fatherName ?>" name="fatherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Số điện thoại</span>
                            <input value="<?php echo $fatherPhone ?>" name="fatherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Nghề nghiệp</span>
                            <input value="<?php echo $fatherJob ?>" name="fatherJob" type="text">
                            <p class="message"></p>
                        </label>

                    </div>
                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            <span class="label">Họ tên mẹ</span>
                            <input value="<?php echo $motherName ?>" name="motherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Số điện thoại</span>
                            <input value="<?php echo $motherPhone ?>" name="motherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Nghề nghiệp</span>
                            <input value="<?php echo $motherJob ?>" name="motherJob" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn pri" name="save">Cập nhật</button>
                <button type="submit" class="btn" name="clear">Xoá</button>
            </div>
        </form>
    </div>
</div>