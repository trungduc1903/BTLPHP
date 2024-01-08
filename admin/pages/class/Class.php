<?php
$q = "";
if(isset($_GET["q"])){
    $q = trim($_GET["q"]);
}
$year = $_SESSION["schoolYear"];
$classQueryStmt = "CALL proc_class_getByYearv2($year,'$q')";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}
echo $conn->error;
$error = "";
if (isset($_GET['error'])) {
    $error = "Không thể xoá lớp đang có học sinh";
}
?>


<div class="page-title">
    <h2>Quản lý lớp học</h2>
</div>

<div class="page-content page-class">
    <div class="main-content">
        <div class="toolbar">
            <div class="toolbar--left">

                <a href="./index.php?page=class_add">
                    <button class="btn pri">Thêm lớp học</button>
                </a>
            </div>
            <div class="toolbar--right">
                <div class="search">
                    <form action="" method="get">
                        <div class="container">
                            <input hidden type="text" name="page" value="class">
                            <input class="search-inp" placeholder="Tìm kiếm" value="<?php echo $q ?>" type="text" name="q">
                            <input id="search-submit" type="submit" hidden>
                        </div>

                        <label for="search-submit">
                            <span class="icon search-icon">
                                <i class="fal fa-search"></i>
                            </span>
                        </label>

                    </form>
                </div>
                <div class="refresh">
                    <form action="" method="get">
                        <div class="container">
                            <input hidden type="text" name="page" value="class">
                            <label>
                                <input hidden type="submit">
                                <div class="icon-wrapper success">
                                    <span class="icon">
                                        <i class="far fa-redo-alt"></i>
                                    </span>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="message-container">
            <div class="toast <?php if ($error != "") echo "error" ?>">
                <p>
                    <?php if ($error != "") echo $error ?>
                </p>
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên lớp</th>
                        <th>Khối</th>
                        <th>Sĩ số</th>
                        <th>Danh sách học sinh</th>
                        <th style="max-width: 100px;">Phân công giảng dạy</th>
                        <th>Xoá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($classes) {
                        $index = 0;
                        while ($class = mysqli_fetch_array($classes)) {
                            $index++;
                    ?>
                            <tr>
                                <td><?php echo $index ?></td>
                                <td><?php echo $class['grade'] . $class['name'] ?></td>
                                <td><?php echo $class['grade'] ?></td>
                                <td><?php echo $class['qlt'] ?></td>

                                <td>
                                    <a href="./index.php?page=class_students&id=<?php echo $class['classId'] ?>">
                                        <div class="icon-wrapper success">
                                            <span class="icon">
                                                <i class="far fa-eye"></i>
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td>

                                    <a href="./index.php?page=class_teaching&id=<?php echo $class['classId'] ?>">
                                        <div class="icon-wrapper success">
                                            <span class="icon">
                                                <i class="far fa-eye"></i>
                                            </span>
                                        </div>
                                    </a>

                                </td>
                                <td>
                                    <a onclick="return confirm('Xác nhận xoá lớp học')" href="./index.php?page=class_del&id=<?php echo $class['classId'] ?>">
                                        <div class="icon-wrapper warning">
                                            <span class="icon">
                                                <i class="far fa-trash"></i>
                                            </span>
                                        </div>

                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </div>


</div>