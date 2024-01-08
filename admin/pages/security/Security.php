<?php

$id = $_SESSION["user"]["userId"];
$userQueryStmt = "CALL proc_user_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$user = mysqli_fetch_array($userQueryResult);
while (mysqli_next_result($conn)) {;
};

$password = "";
$passwordConfirm = "";
$message = "";
const success = "success";
const error = "error";

if (mysqli_num_rows($userQueryResult) != 0) {
    $name = $user["name"];
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['avata'] = $user['avata'];
    $avata = $user['avata'];
    $username = $user["username"];
    $email = $user["email"];
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
        empty($passwordErr) &&
        empty($passwordConfirmErr)
    ) {
        $updateUserPasswordStmt = "CALL proc_user_updatePassword('$id','$password','$oldPassword');";
        $updateUserPasswordResult = mysqli_query($conn, $updateUserPasswordStmt);
        if (mysqli_affected_rows($conn) == 0) {
            $state = error;
            $message =  "Cập nhật thất bại, mật khẩu cũ không đúng";
        } elseif ($updateUserPasswordResult) {
            $state = success;
            header("Location: ./logout.php");
        } else {
            echo $conn->error;
        }
    }
}

?>

<div class="page-title">
    <h2>Bảo mật</h2>
</div>

<div class="page-content security-page">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php echo $message ?>
            </p>
        </div>
    </div>
    <div>
        <div>
            <form action="" method="post">
                <h2 class="form-title">Thay đổi mật khẩu</h2>
                <div class="form-group">
                    <label>
                        Nhập khẩu cũ
                        <input value="<?php if (isset($oldPassword)) echo $oldPassword ?>" name="oldPassword" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($oldPasswordErr)) echo $oldPasswordErr ?>
                    </p>
                </div>
                <div class="form-group">
                    <label>
                        Nhập khẩu mới
                        <input value="<?php if (isset($password)) echo $password ?>" name="password" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($passwordErr)) echo $passwordErr ?>
                    </p>
                </div>

                <div class="form-group">
                    <label>
                        Nhập lại mật khẩu
                        <input value="<?php if (isset($passwordConfirm)) echo $passwordConfirm ?>" name="passwordConfirm" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($passwordConfirmErr)) echo $passwordConfirmErr ?>
                    </p>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="updatePassword" class="btn pri">Lưu thay đổi</button>
                    <button type="submit" name="clear" class="btn">Huỷ</button>
                </div>
            </form>
        </div>
    </div>

</div>