<?php

include("../config/connect.php");
$querySubject= "CALL proc_subject_getAll";

$r = $conn->query($querySubject);
$subjects = mysqli_query($conn, $querySubject);
while(mysqli_next_result($conn)){;}


$firstName = "";
$lastName ="";
$email ="";
$phone = "";
$address = "";
$subject = "";

if (isset($_POST["create"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $subject = $_POST["subject"];
    echo $subject;
    $query = "CALL proc_teacher_add('$firstName', '$lastName', '$phone', '$email', '$subject')";
    $result = $conn->query($query);
    if(!$result == true){
        echo $conn->error;
    }else{
        echo "Success";
       
    }
}


?>

<div class="page user">
    <div class="page-title">
        <h2>Thêm giáo viên</h2>
    </div>

    <div class="page-content">
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <p>Tên</p>
                    <input name="firstName" type="text">
                </div>

                <div class="form-group">
                    <p>Họ</p>
                    <input name="lastName" type="text">
                </div>

                <div class="form-group">
                    <p>Email</p>
                    <input name="email" type="text">
                </div>

                <div class="form-group">
                    <p>Địa chỉ</p>
                    <input name="address" type="text">
                </div>

                <div class="form-group">
                    <p>Số điện thoại</p>
                    <input name="phone" type="text">
                </div>

                <div class="form-group">
                    <p>Môn giảng dạy</p>
                    <select name="subject" id="">
                        <?php 
                            while($row = mysqli_fetch_array($subjects)){
                                echo '<option value = "'.$row['subjectId'].'">'.$row['name']."</option>";
                            }
                            
                        ?>
                    </select>
                </div>
                <div>
                    <input type="submit" value="create" name="create">
                </div>
            </form>
        </div>

    </div>
</div>