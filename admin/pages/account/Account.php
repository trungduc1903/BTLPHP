<?php
include('common/emailValidation.php');

$id = $_SESSION["user"]["userId"];
$userQueryStmt = "CALL proc_user_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$user = mysqli_fetch_array($userQueryResult);
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
    $name = $user["name"];
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['avata'] = $user['avata'];
    $avata = $user['avata'];
    $username = $user["username"];
    $email = $user["email"];
}

if (isset($_POST["updateInfor"])) {
    $name = trim($_POST["name"], " ");
    $nameErr = "";
    $username = trim($_POST["username"], " ");
    $usernameErr = "";
    $email = trim($_POST["email"], " ");
    $emailErr = "";
    $avataErr = "";
    if (isset($_FILES["avata"])) {
        $maxSizeFileUpload = 5;
        $file = $_FILES["avata"];
        $fileName = $file["name"];
        $explodeResult = explode(".", $fileName);
        $ext = end($explodeResult);
        $size = $file["size"] / 1024 / 1024;
        $allowedFile = ["jpg", "jpeg", "png"];

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
    //
    if (
        empty($avataErr) &&
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr)
    ) {
        $addUserStmt = "CALL proc_user_update('$id','$name','$username','$email',NULL,'$level');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
            $state = success;
            $message ="Thay đổi thông tin thành công";
            $avataUpdateQuery = "CALL proc_user_avata('$id','$avata')";
            move_uploaded_file($file["tmp_name"], "avatas/$avata");
            mysqli_query($conn, $avataUpdateQuery);
            $_SESSION['user']['avata'] = $avata;
            $_SESSION['user']['name'] = $name;           
            
        } else {
            echo $conn->error;
        }
    }
}

?>

<div class="page-title page-account__title">
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

    <div class="content">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="wrapper">

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
                <div class="user-infor item">
                    <div class="form group">
                        <label>
                            <span class="label">Họ và tên</span>
                            <input name="name" value="<?php if (isset($name)) echo $name ?>" type="text">
                        </label>
                        <p class="message">
                            <?php if (isset($nameErr)) echo $nameErr ?>
                        </p>
                    </div>

                    <div class="form group">
                        <label>
                            <span class="label">Username</span>
                            <input name="username" value="<?php if (isset($username)) echo $username ?>" type="text">
                        </label>
                        <p class="message">
                            <?php if (isset($usernameErr)) echo $usernameErr ?>
                        </p>
                    </div>

                    <div class="form group">
                        <label>
                            <span class="label">Email</span>

                            <input name="email" value="<?php if (isset($email)) echo $email ?>" type="text">
                        </label>
                        <p class="message">
                            <?php if (isset($emailErr)) echo $emailErr ?>
                        </p>
                    </div>
                </div>


            </div>
            <div class="group-button">

                <button type="submit" name="updateInfor" class="btn pri">Lưu thay đổi</button>
                <button type="submit" name="clear" class="btn">Huỷ</button>
            </div>
        </form>

    </div>
</div>
<img id="img" src="" alt="">

<script>
    function handleAvataChange(e) {
        let file = e.target.files[0];
        tmpImg = URL.createObjectURL(file);
        let imgElement = document.querySelector("#img-ava");
        imgElement.src = tmpImg;
        console.log(imgElement);
    }
</script>