<?php
session_start();
include('../config/connect.php');
$message = "";
if (isset($_POST["login"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $loginQueryStmt = "CALL proc_login('$login', '$password')";
    $loginQueryResult = mysqli_query($conn, $loginQueryStmt);
    
    if (mysqli_num_rows($loginQueryResult) != 0) {
        $userInfor = mysqli_fetch_array($loginQueryResult);
        $_SESSION["schoolYear"] = date("Y");
        $_SESSION["user"]["userId"] = $userInfor["userId"];
        $_SESSION["user"]["name"] = $userInfor["name"];
        $_SESSION["user"]["userName"] = $userInfor["username"];
        $_SESSION["user"]["email"] = $userInfor["email"];
        $_SESSION["user"]["level"] = $userInfor["level"];
        $_SESSION["user"]["avata"] = $userInfor["avata"];
        // echo "<pre>";
        // print_r($userInfor);
        // echo "</pre>";


        header("Location: index.php");
    } else {
        $message = "Đăng nhập thất bại! Tên đăng nhập, email hoặc mật khẩu không đúng";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./App.css">
    <link rel="stylesheet" href="./login.css">

</head>

<body>
    <div class="login-container">

        <div class="login">
            <div class="background-left">

            </div>
            <div class="container">
                <form action="" method="post">
                    <div>
                        <p class="title">Đăng nhập để làm việc</p>
                    </div>
                    <?php
                    if ($message != "") {
                    ?>
                        <div class="error-message">
                            <p><?php if ($message != "") echo $message ?></p>
                        </div>
                    <?php
                    }
                    ?>

                    <div>
                        <input placeholder="Nhập tên đăng nhập, Email" value="" type="text" name="login" id="">
                    </div>

                    <div>
                        <input placeholder="Nhập mật khẩu" type="password" name="password" id="">
                    </div>
                    <div>
                        <button class="btn btn-login" type="submit">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>