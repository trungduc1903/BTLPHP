<?php
include('common/emailValidation.php');

$name = "";
$username = "";
$email = "";
$password = "";
$passwordConfirm = "";
$level = "";
$message = "";
const success = "success";
const error = "error";
$state;
$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
$userQueryStmt = "CALL proc_user_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$user = mysqli_fetch_array($userQueryResult);
while (mysqli_next_result($conn)) {;
}
if (mysqli_num_rows($userQueryResult) != 0) {
    $name = $user["name"];
    $username = $user["username"];
    $email = $user["email"];
    $password = $user["password"];
    $passwordConfirm = $user["password"];
    $level = $user["level"];
}
if (isset($_POST["update"])) {
    $name = trim($_POST["name"], " ");
    $nameErr = "";
    $username = trim($_POST["username"], " ");
    $usernameErr = "";
    $email = trim($_POST["email"], " ");
    $emailErr = "";
    $level = 1;
    $password = trim($_POST["password"], " ");
    $passwordErr = "";
    $passwordConfirm = trim($_POST["passwordConfirm"], " ");
    $passwordConfirmErr = "";

    //to do: validate
    //name
    if (empty($name)) {
        $nameErr = "Không được để trống";
    }
    //username
    if (empty($username)) {
        $usernameErr = "Không được để trống";
    }
    //email
    if (empty($email)) {
        $emailErr = "Không được để trống";
    } else {
        $emailErr = validate_email($email);
    }
    //password
    if (empty($password)) {
        $passwordErr = "Không được để trống";
    }
    //passwordConfirm
    if (strcmp($password, $passwordConfirm) != 0) {
        $passwordConfirmErr = "Mật khẩu không trùng khớp";
    }
    //
    if (
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr) &&
        empty($passwordErr) &&
        empty($passwordConfirmErr)
    ) {
        $addUserStmt = "CALL proc_user_update('$id','$name','$username','$email','$password','$level');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
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
    <h2>Cập nhật thông tin nhân viên</h2>
</div>

<div class="page-content user-update-page">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>
        </div>
    </div>
    <div>
        <form action="" method="post">
            <div class="form-container">
                <div class="group">
                    <div class="form group">
                        <label>
                            <span class="label">Họ và tên</span>
                            <input name="name" value="<?php if (isset($name)) echo $name ?>" type="text">
                            <p class="message">
                                <?php if (isset($nameErr)) echo $nameErr ?>
                            </p>
                        </label>
                    </div>

                    <div class="form group">
                        <label>
                            <span class="label">Username</span>
                            <input name="username" value="<?php if (isset($username)) echo $username ?>" type="text">
                            <p class="message">
                                <?php if (isset($usernameErr)) echo $usernameErr ?>
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
                <div class="group">
                    <div class="form group">
                        <label>
                            <span class="label">Mật khẩu</span>
                            <input id="passInp" value="<?php if (isset($password)) echo $password ?>" name="password" type="text">
                            <p class="message">
                                <?php if (isset($passwordErr)) echo $passwordErr ?>
                            </p>
                        </label>
                    </div>

                    <div class="form group">
                        <label>
                            <span class="label">Nhập lại mật khẩu</span>
                            <input id="confirmPassInp" value="<?php if (isset($passwordConfirm)) echo $passwordConfirm ?>" name="passwordConfirm" type="text">
                            <p class="message">
                                <?php if (isset($passwordConfirmErr)) echo $passwordConfirmErr ?>
                            </p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" name="update" class="btn pri">Cập nhật</button>
                <button type="submit" name="clear" class="btn">Xoá</button>
                <script src="../asset/js/randomPassword.js"></script>
                <span style="user-select: none;" onclick="
                        let pass =  autoGeneratePassword(8);
                        let passInput = document.querySelector('#passInp');
                        let confirmPassInput = document.querySelector('#confirmPassInp');
                        passInput.value = pass;
                        confirmPassInput.value = pass;
                    " class="btn">Tạo mật khẩu ngẫu nhiên</span>
            </div>
        </form>
    </div>

</div>