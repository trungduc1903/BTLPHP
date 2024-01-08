<?php

include('common/emailValidation.php');
include('common/phoneValidation.php');

$id = $_SESSION["teacher"]["teacherId"];

$userQueryStmt = "CALL proc_teacher_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$teacher = mysqli_fetch_array($userQueryResult);
while (mysqli_next_result($conn)) {;
};
$name = "";
$username = "";
$email = "";
$password = "";
$passwordConfirm = "";
$level = "";
$message = "";
const success = "success";
const error = "error";

if (mysqli_num_rows($userQueryResult) != 0) {
    $firstName = $teacher["firstName"];
    $lastName = $teacher["lastName"];
    $_SESSION['teacher']['firstName'] = $teacher['firstName'];
    $_SESSION['teacher']['lastName'] = $teacher['lastName'];
    $_SESSION['teacher']['avata'] = $teacher['avata'];
    $avata = $teacher['avata'];
    $email = $teacher["email"];
    $phone = $teacher["phone"];
}

if (isset($_POST["updateInfor"])) {
    $firstName = trim($_POST["firstName"], " ");
    $lastName = trim($_POST["lastName"], " ");
    $firstNameErr = "";
    $lastNameErr = "";
    $email = trim($_POST["email"], " ");
    $phone = trim($_POST["phone"], " ");
    $emailErr = "";
    $phoneErr = "";
    $avataErr = "";
    if (isset($_FILES["avata"])) {
        $maxSizeFileUpload = 5;
        $file = $_FILES["avata"];
        $fileName = $file["name"];
        $explodeResult = explode(".", $fileName);
        $ext = end($explodeResult);
        $size = $file["size"] / 1024 / 1024;
        $allowedFile = ["jpg", "jpeg", "png"];
        print_r($file);

        if ($file["error"] == 0)
            if ($size > $maxSizeFileUpload) {
                $avataErr = "Vui lòng chọn file dung lượng < 5MB";
            } else
        if (!in_array($ext, $allowedFile)) {
                $avataErr = "Vui lòng chọn định dạng .png hoặc .jpg";
            } else
        if ($file["error"] == 0) {
                $newName = $id . "." . $ext;
                $avata = $newName;
            }
    }

    //to do: validate
    //name
    if (empty($firstName)) {
        $firstNameErr = "Không được để trống";
    }
    //username
    if (empty($lastName)) {
        $lastNameErr = "Không được để trống";
    }
    //email
    if (empty($email)) {
        $emailErr = "Không được để trống";
    } else {
        $emailErr = validate_email($email);
    }
    //phone
    if (empty($phone)) {
        $phoneErr = "Không được để trống";
    } else {
        $phoneErr = validate_phone($phone);
    }
    //
    if (
        empty($avataErr) &&
        empty($firstNameErr) &&
        empty($lastNameErr) &&
        empty($phoneNameErr) &&
        empty($emailErr)
    ) {
        $addUserStmt = "CALL proc_teacher_update('$id','$lastName','$firstName','$phone','$email');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
            $state = success;
            $message = "Cập nhật thành công";

            $avataUpdateQuery = "CALL proc_teacher_avata('$teacherId','$avata')";
            move_uploaded_file($file["tmp_name"], "avatas/$avata");
            mysqli_query($conn, $avataUpdateQuery);

            $_SESSION['teacher']['firstName'] = $firstName;
            $_SESSION['teacher']['lastName'] = $lastName;
            $_SESSION['teacher']['avata'] = $avata;
            header("Location: ./index.php?page=account");
        } else {
            echo $conn->error;
        }
    }
}

if (isset($_POST["updatePassword"])) {
    $oldPassword = trim($_POST["oldPassword"], " ");
    $oldPasswordErr = "";
    $password = trim($_POST["password"], " ");
    $passwordErr = "";
    $passwordConfirm = trim($_POST["passwordConfirm"], " ");
    $passwordConfirmErr = "";

    //to do: validate
    //oldPassword
    if (empty($oldPassword)) {
        $oldPasswordErr = "Không được để trống";
    }

    //password
    if (empty($password)) {
        $passwordErr = "Không được để trống";
    } elseif ($password == $oldPassword) {
        $passwordErr = "Mật khẩu mới phải khác mật khẩu cũ";
    }
    //passwordConfirm
    if (empty($passwordConfirm)) {
        $passwordConfirmErr = "Không được để trống";
    } else
    if (strcmp($password, $passwordConfirm) != 0) {
        $passwordConfirmErr = "Mật khẩu không trùng khớp";
    }

    if (
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr) &&
        empty($passwordErr) &&
        empty($passwordConfirmErr)
    ) {
        echo "update password";
        $updateUserPasswordStmt = "CALL proc_teacher_updatePassword('$id','$password','$oldPassword');";
        $updateUserPasswordResult = mysqli_query($conn, $updateUserPasswordStmt);
        if (mysqli_affected_rows($conn) == 0) {
            echo "Cập nhật thất bại, mật khẩu cũ không đúng";
        } elseif ($updateUserPasswordResult) {
            $state = success;

            header("Location: ./logout.php");
        } else {
            echo $conn->error;
        }
    }
}




?>



<div class="account page-title">
    <a href="./index.php">
        <div class="icon-wrapper success">
            <span class="icon">
                <i class="far fa-long-arrow-left"></i>
            </span>
        </div>
    </a>
    <h2>Tài khoản</h2>
</div>
<div class="page-content page-account">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>

        </div>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-container">
            <div class="group">
                <div class="user-ava item">
                    <input hidden id="ava-input" onchange="handleAvataChange(event);" accept="image/png, image/jpeg" type="file" name="avata">
                    <label for="ava-input">
                        <div class="ava-preview">
                            <img class="" height="100%" id="img-ava" src="" alt="">
                            <div class="add-ava-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="group">
                <div class="form group">
                    <label>
                        <span class="label">Họ</span>
                        <input name="lastName" value="<?php if (isset($lastName)) echo $lastName ?>" type="text">
                        <p class="message">
                            <?php if (isset($lastNameErr)) echo $lastNameErr ?>
                        </p>
                    </label>
                </div>

                <div class="form group">
                    <label>
                        <span class="label">Tên</span>
                        <input name="firstName" value="<?php if (isset($firstName)) echo $firstName ?>" type="text">
                        <p class="message">
                            <?php if (isset($firstNameErr)) echo $firstNameErr ?>
                        </p>
                    </label>
                </div>

            </div>

            <div class="group">
                <div class="form group">
                    <label>
                        <span class="label">Số điện thoại</span>
                        <input name="phone" value="<?php if (isset($phone)) echo $phone ?>" type="text">
                        <p class="message">
                            <?php if (isset($phoneErr)) echo $phoneErr ?>
                        </p>
                    </label>
                </div>

                <div class="form group">
                    <label>
                        <span class="label">Email</span>
                        <input name="email" value="<?php if (isset($email)) echo $email ?>" type="text">
                        <p class="message">
                            <?php if (isset($emailErr)) echo $emailErr ?>
                        </p>
                    </label>
                </div>

            </div>



        </div>
        <div class="form-buttons">
            <button type="submit" name="updateInfor" class="btn pri">Lưu thay đổi</button>
            <button type="submit" name="clear" class="btn">Huỷ</button>
        </div>
    </form>

</div>

<?php ob_end_flush() ?>

<script>
    function handleAvataChange(e) {
        let file = e.target.files[0];
        tmpImg = URL.createObjectURL(file);
        let imgElement = document.querySelector("#img-ava");
        imgElement.src = tmpImg;
        console.log(imgElement);
    }
</script>