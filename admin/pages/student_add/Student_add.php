<?php
include('common/nameValidation.php');
include('common/emailValidation.php');
include('common/dateValidation.php');
include('common/phoneValidation.php');

const success = "success";
const error = "error";
$classQueryStmt = "CALL proc_class_getAll;";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}

$classId = "";
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];
}
$message = "";
if (isset($_POST['create']) || isset($_POST['fakeData'])) {
    $classId = $_POST['classId'];
    $lastName  = trim($_POST['lastName']);
    $lastNameErr = "";
    $firstName = trim($_POST['firstName']);
    $firstNameErr = "";
    $dob = $_POST['dob'];
    $dobErr = "";
    $ethnic = trim($_POST['ethnic']);
    $ethnicErr = "";

    $fatherName = trim($_POST['fatherName']);
    $fatherNameErr = "";
    $fatherPhone = trim($_POST['fatherPhone']);
    $fatherPhoneErr = "";
    $fatherJob = trim($_POST['fatherJob']);
    $fatherJobErr = "";

    $motherName = trim($_POST['motherName']);
    $motherNameErr = "";
    $motherPhone = trim($_POST['motherPhone']);
    $motherPhoneErr = "";
    $motherJob = trim($_POST['motherJob']);
    $motherJobErr = "";

    /**
     * validate
     */
    //firstName
    if (empty($firstName)) {
        $firstNameErr = "Không được để trống";
    } else {
        $firstNameErr = validate_name($firstName);
    }

    //lastname
    if (empty($lastName)) {
        $lastNameErr = "Không được để trống";
    } else {
        $lastNameErr = validate_name($lastName);
    }

    //dob
    $classQueryResult = mysqli_query($conn, "CALL proc_class_getById('$classId')");
    if (mysqli_num_rows($classQueryResult) != 0) {
        $row =  mysqli_fetch_array($classQueryResult);
        $maxDate = "" . ((int)$row['schoolYear'] - 15) . "-12-31";
        if (validate_date($dob, "", $maxDate) != 0) {
            $dobErr = "Ngày sinh không phù hợp";
        }
    }
    while (mysqli_next_result($conn)) {;
    }
    if (!empty($fatherPhone)) {
        $fatherPhoneErr = validate_phone($fatherPhone);
    }

    if (!empty($motherPhone)) {
        $motherPhoneErr = validate_phone($motherPhone);
    }

    if (
        empty($firstNameErr) &&
        empty($lastNameErr) &&
        empty($dobErr) &&
        empty($fatherNameErr) &&
        empty($fatherPhoneErr) &&
        empty($fatherJobErr) &&
        empty($motherNameErr) &&
        empty($motherPhoneErr) &&
        empty($motherJobErr)
    ) {
        $studentAddStmt = "CALL proc_student_add(
            '$firstName', '$lastName', '$ethnic','$classId','$dob','$fatherName','$fatherPhone','$fatherJob',
            '$motherName', '$motherPhone', '$motherJob'
        )";
        if (isset($_POST['fakeData'])) {
            $studentAddStmt = "CALL proc_student_add_fakeScore(
                '$firstName', '$lastName', '$ethnic','$classId','$dob','$fatherName','$fatherPhone','$fatherJob',
                '$motherName', '$motherPhone', '$motherJob'
            )";
        }
        $addResult = mysqli_query($conn, $studentAddStmt);
        if ($addResult) {
            $state = success;
            $message = "Thêm mới thành công";
        } else {
            $state = error;
            $message = $conn->error;
        }
    }
}
?>

<div class="page-title">
    <h2>Thêm học sinh</h2>
</div>
<div class="page-content student-add-page">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>
        </div>
    </div>
    <div>
        <form action="" method="post">
            <div class="form-group">
                <label>
                    Lớp
                    <select name="classId">
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
                            Họ
                            <input value="<?php if (isset($lastName)) echo $lastName ?>" name="lastName" type="text">
                            <p class="message">
                                <?php if (isset($lastNameErr)) echo $lastNameErr ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Tên
                            <input value="<?php if (isset($firstName)) echo $firstName ?>" name="firstName" type="text">
                            <p class="message">
                                <?php if (isset($firstNameErr)) echo $firstNameErr ?>

                            </p>
                        </label>
                    </div>
                    <div class="form-group">

                        <label>
                            Ngày sinh
                            <input value="<?php if (isset($dob)) echo $dob ?>" name="dob" type="date">
                            <p class="message">
                                <?php if (isset($dobErr)) echo $dobErr ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Dân tộc
                            <input value="<?php if (isset($ethnic)) echo $ethnic ?>" name="ethnic" type="text">
                            <p class="message"></p>
                        </label>
                    </div>

                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên cha
                            <input value="<?php if (isset($fatherName)) echo $fatherName ?>" name="fatherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input value="<?php if (isset($fatherPhone)) echo $fatherPhone ?>" name="fatherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input value="<?php if (isset($fatherJob)) echo $fatherJob ?>" name="fatherJob" type="text">
                            <p class="message"></p>
                        </label>

                    </div>
                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên mẹ
                            <input value="<?php if (isset($motherName)) echo $motherName ?>" name="motherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input value="<?php if (isset($motherPhone)) echo $motherPhone ?>" name="motherPhone" type="text">
                            <p class="message">
                                <?php if (isset($motherPhoneErr)) echo $motherPhoneErr ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input value="<?php if (isset($motherJob)) echo $motherJob ?>" name="motherJob" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn pri" name="create">Thêm</button>
                <button type="submit" class="btn" name="clear">Xoá</button>
                <button type="submit" class="btn" name="fakeData">Thêm(fake score)</button>
            </div>
        </form>
    </div>
</div>