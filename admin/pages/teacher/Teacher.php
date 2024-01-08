<?php
$q = "";
if (isset($_GET["q"])) {
    $q = trim($_GET["q"]);
}
$teacherQueryStmt = "CALL proc_teacher_get('$q')";
$teachers = mysqli_query($conn, $teacherQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>

<div class="page-title">
    <h2>Quản lý giáo viên</h2>
</div>

<div class="page-content teacher-page">
    <div class="main-content">
        <div class="toolbar">
            <div class="toolbar--left">

                <a href="./index.php?page=teacher_add">
                    <button class="btn pri">Thêm giáo viên</button>
                </a>
            </div>

            <div class="toolbar--right">
                <div class="search">
                    <form action="" method="get">
                        <div class="container">
                            <input hidden type="text" name="page" value="teacher">
                            <input class="search-inp" placeholder="Nhập tên, SĐT, email" value="<?php echo $q ?>" type="text" name="q">
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
                            <input hidden type="text" name="page" value="teacher">
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

        <style>
            .tabler__teacher {
                max-height: calc(100vh - 200px);
                border-top: 1px #e0e0e0 solid;
            }
        </style>
        <div>
            <div class="table-wrapper tabler__teacher">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã giáo viên</th>

                            <th>Tên giáo viên</th>

                            <th>Môn giảng dạy</th>

                            <th>Email</th>

                            <th>Số điện thoại</th>
                            <th>Mật khẩu</th>
                            <th class="sticky--right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if ($teachers) {
                            while ($teacher = mysqli_fetch_array($teachers)) {
                                $i += 1;
                        ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $teacher["teacherCode"] ?></td>
                                    <td><?php echo $teacher["fullname"] ?></td>
                                    <td><?php echo $teacher["subjectName"] ?></td>
                                    <td><?php echo $teacher["email"] ?></td>
                                    <td><?php echo $teacher["phone"] ?></td>
                                    <td><?php echo $teacher["password"] ?></td>
                                    <td class="sticky--right">
                                        <a href="./index.php?page=teacher_del&id=<?php echo $teacher["teacherId"] ?>" onclick="return confirm('Xác nhận xoá giáo viên <?php echo $teacher['fullname'] ?> ')">
                                            <div class="icon-wrapper warning">
                                                <span class="icon">
                                                    <i class="far fa-trash"></i>
                                                </span>
                                            </div>
                                        </a>

                                        <a href="./index.php?page=teacher_update&id=<?php echo $teacher["teacherId"] ?>">
                                            <div class="icon-wrapper infor">
                                                <span class="icon">
                                                    <i class="far fa-edit"></i>
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


</div>