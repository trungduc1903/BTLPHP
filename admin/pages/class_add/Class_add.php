<?php
const success = "success";
const error = "error";
$currentYear = getdate()["year"];
if (!isset($_POST["school"])) {
    $schoolYear = $currentYear;
}
if (isset($_POST["create"])) {
    $name = trim($_POST["name"]);
    $schoolYear = $_POST["schoolYear"];
    if (empty($name)) {
        $classNameErr = "Không để trống tên lớp";
    } elseif (empty($schoolYear)) {
        $schoolYearErr = "Không để trống niên khoá";
        echo $schoolYear;
    } else {
        $schoolYear = $_POST["schoolYear"];
        $classAddStmt = "CALL proc_class_add('$name', '$schoolYear')";
        $addResult = mysqli_query($conn, $classAddStmt);
        if ($addResult) {
            $state = success;
            $message = "Thêm mới thành công lớp " . $name . " niên khoá " . $schoolYear . "-" . ($schoolYear + 3);
            // header("location: ./index.php?page=class");
        } else {
            $state = error;
            $message = "Có lỗi, Lớp " . $name . " niên khoá " . $schoolYear . "-" . ($schoolYear + 3) . " Đã tồn tại";
        }
    }
}
?>


<div class="page-title">
    <h2>Thêm lớp học</h2>
</div>
<div class="page-content class-add-page">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>
        </div>
    </div>
    <div class="form-wrapper">
        <form action="" method="post">
            <div class="form-control">
                <label for="">
                    <span class="label">

                        Tên lớp học
                    </span>
                    <input value="<?php
                                    if (isset($_POST["name"])) echo $_POST["name"];
                                    ?>" type="text" name="name" />
                    <p class="message">
                        <?php if (isset($classNameErr)) echo $classNameErr ?>
                    </p>
                </label>
            </div>

            <div class="form-control">
                <label for="">
                    <span class="label">

                        Niên khoá (Nhập năm bắt đầu)
                    </span>
                    <input value="<?php if (isset($schoolYear)) echo $schoolYear ?>" placeholder="VD: 2020" type="number" min=2020 max=<?php echo $currentYear ?> name="schoolYear" id="">
                    <p class="message">
                        <?php if (isset($schoolYearErr)) echo $schoolYearErr ?>
                    </p>
                </label>
            </div>
            <div class="form-buttons">

                <button class="btn pri" name="create">Tạo</button>
            </div>
        </form>

    </div>
</div>