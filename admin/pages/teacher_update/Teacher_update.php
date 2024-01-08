<?php
include('common/phoneValidation.php');
include('common/nameValidation.php');
include('common/emailValidation.php');
const success = "success";
const error = "error";
const subjectQueryStmt = "CALL proc_subject_getAll";
$subjects = mysqli_query($conn, subjectQueryStmt);

while (mysqli_next_result($conn)) {;
}
$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
$teacherQueryStmt = "CALL proc_teacher_getById('$id')";
$teacherQueryResult = mysqli_query($conn, $teacherQueryStmt);
$teacher = mysqli_fetch_array($teacherQueryResult);

while (mysqli_next_result($conn));
if (mysqli_num_rows($teacherQueryResult) != 0) {
    $teacherCode = $teacher["teacherCode"];
    $lastName = $teacher["lastName"];
    $firstName = $teacher["firstName"];
    $phone = $teacher["phone"];
    $email = $teacher["email"];
    $subject = $teacher["subjectId"];
}

if (isset($_POST["update"])) {
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $subject = $_POST["subject"];

    $firstNameErr = "";
    $lastNameErr = "";
    $phoneErr = "";
    $emailErr = "";

    /**
     * Validate
     * nvduong 12/07/2023
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


    //phone
    if (empty($phone)) {
        $phoneErr = "Không được để trống";
    } else {
        $phoneErr = validate_phone($phone);
    }



    //email
    if (empty($email)) {
        $emailErr = "Không được để trống";
    } else {
        $emailErr = validate_email($email);
    }


    if (
        empty($firstNameErr) &&
        empty($lastNameErr) &&
        empty($emailErr) &&
        empty($phoneErr)
    ) {
        $teacherAddStatement = "CALL proc_teacher_update('$id','$lastName','$firstName','$phone', '$email','$subject')";
        $addResult = mysqli_query($conn, $teacherAddStatement);
        if ($addResult) {
            $state = success;
            $message = "Cập nhật thành công";
        } else {
            $state = error;
            $message = $conn->error;
        }
    }
}
?>

<div class="page-title">
    <h2>Cập nhật thông tin giáo viên</h2>
    <h2 class="form-group">
        <?php if(isset($lastName)) echo $lastName ?>
        <?php if(isset($firstName)) echo $firstName ?> - 
        <?php if (isset($teacherCode)) echo $teacherCode ?>
    </h2>
</div>
<div class="teacher-form">
    <div class="message-container ">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>
        </div>
    </div>
    <div class="form-wrapper">
        <form action="" method="post">

            <div class="form-container">

                <div class="group">

                    <div class="form-group">
                        <label>
                            <span class="label">Họ</span>
                            <input value="<?php if (isset($lastName)) echo $lastName ?>" name="lastName" type="text">
                            <p class="message">
                                <?php if (isset($lastNameErr)) echo $lastNameErr  ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Tên</span>
                            <input value="<?php if (isset($firstName)) echo $firstName ?>" name="firstName" type="text">
                            <p class="message">
                                <?php if (isset($firstNameErr)) echo $firstNameErr  ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Môn giảng dạy
                            <select name="subject">
                                <?php
                                if ($subjects) {
                                    while ($subjectItem = mysqli_fetch_array($subjects)) {
                                ?>
                                        <option <?php
                                                if (isset($subject)) {

                                                    if ($subject == $subjectItem["subjectId"]) echo "selected";
                                                }
                                                ?> value="<?php echo $subjectItem["subjectId"] ?>"><?php echo $subjectItem['name'] ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            <span class="label">Số điện thoại</span>
                            <input value="<?php if (isset($phone)) echo $phone ?>" name="phone" type="tel">
                            <p class="message">
                                <?php if (isset($phoneErr)) echo $phoneErr  ?>
                            </p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="label">Email</span>
                            <input value="<?php if (isset($email)) echo $email ?>" name="email" >
                            <p class="message">
                            <?php if (isset($emailErr)) echo $emailErr ?>
                            </p>
                        </label>
                    </div>

                </div>
            </div>



            <div class="form-buttons">
                <button class="btn pri" name="update">Lưu</button>
            </div>
        </form>
    </div>
</div>