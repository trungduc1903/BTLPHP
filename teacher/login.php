<?php
session_start();
include('../config/connect.php');
$message = "";
if (isset($_POST["login"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $loginQueryStmt = "CALL proc_login_teacher('$login', '$password')";
    $loginQueryResult = mysqli_query($conn, $loginQueryStmt);
    echo mysqli_num_rows($loginQueryResult);
    if (mysqli_num_rows($loginQueryResult) != 0) {
        $teacher = mysqli_fetch_array($loginQueryResult);
        $_SESSION["teacher"]["teacherId"] = $teacher["teacherId"];
        $_SESSION["teacher"]["firstName"] = $teacher["firstName"];
        $_SESSION["teacher"]["lastName"] = $teacher["lastName"];
        $_SESSION["teacher"]["email"] = $teacher["email"];
        $_SESSION["teacher"]["phone"] = $teacher["phone"];
        $_SESSION["teacher"]["subjectId"] = $teacher["subjectId"];
        $_SESSION["teacher"]["avata"] = $teacher["avata"];
       

        header("Location: index.php?page=user");
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