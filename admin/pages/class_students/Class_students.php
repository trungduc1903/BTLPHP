<?php
$q = "";
if (isset($_GET["q"])) {
    $q = $_GET["q"];
}
$numsOfStudent = 0;
if (isset($_GET["id"])) {
    $classId = $_GET['id'];

    $studentQueryStmt = "CALL proc_student_class('$classId','$q')";
    $studentsQueryResult = mysqli_query($conn, $studentQueryStmt);
    $students = mysqli_fetch_all($studentsQueryResult, MYSQLI_ASSOC);

    while (mysqli_next_result($conn)) {;
    }

    $classQueryStmt = "CALL proc_class_getById('$classId')";
    $classQueryResult = mysqli_query($conn, $classQueryStmt);
    $class = mysqli_fetch_array($classQueryResult);
    while (mysqli_next_result($conn)) {;
    }
    $numsOfStudent = $class["qlt"];
}
?>

<div class="page-title">
    <h2>Danh sách học sinh lớp <?php echo $class["name"] ?></h2>
    <h2>Niên khoá <?php echo $class["schoolYear"] . " - " . $class["schoolYearEnd"] ?></h2>
</div>

<div class="page-content class-students-page">
    <div class="toolbar">
        <div class="toolbar--left">
            <a href="./index.php?page=student_add&classId=<?php echo $classId ?>">
                <button class="btn pri">Thêm</button>
            </a>
        </div>
        <div class="toolbar--right">
            <div class="search">
                <form action="" method="get">
                    <div class="container">
                        <input hidden type="text" name="page" value="class_students">
                        <input hidden type="text" name="id" value="<?php echo $classId ?>">
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
                        <input hidden type="text" name="page" value="class_students">
                        <input hidden type="text" name="id" value="<?php echo $classId ?>">
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

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã HS</th>
                    <th>Họ và tên</th>
                    <th>Dân tộc</th>
                    <th>Ngày sinh</th>
                    <th>Tên bố</th>
                    <th>Số điện thoại</th>
                    <th>Nghề nghiệp</th>
                    <th>Tên mẹ</th>
                    <th>Số điện thoại</th>
                    <th>Nghề nghiệp</th>
                    <th class="sticky--right">Hành động</th>

                </tr>
            </thead>
            <tbody>
                <?php
                function sortStudentName($a, $b)
                {
                    if ($a['firstName'] > $b['firstName']) {
                        return 1;
                    } elseif ($a['firstName'] < $b['firstName']) {
                        return -1;
                    }
                    return 0;
                }

                usort($students, 'sortStudentName');
                $i = 0;
                if ($students) {
                    foreach ($students as $student) {
                        $i += 1;
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $student["studentCode"] ?></td>
                            <td><?php echo $student["fullname"] ?></td>
                            <td><?php echo $student["ethnic"] ?></td>
                            <td><?php echo $student["dob"] ?></td>
                            <td><?php echo $student["fatherName"] ?></td>
                            <td><?php echo $student["fatherPhone"] ?></td>
                            <td><?php echo $student["fatherJob"] ?></td>
                            <td><?php echo $student["motherName"] ?></td>
                            <td><?php echo $student["motherPhone"] ?></td>
                            <td><?php echo $student["motherJob"] ?></td>
                            <td class="sticky--right">
                                <a onclick="return confirm('Xác nhận xoá học sinh <?php echo $student['fullname'] ?> mã học sinh <?php echo $student['studentCode'] ?>')" href="./index.php?page=student_del&id=<?php echo $student["studentId"] ?>&classId=<?php echo $class['classId'] ?>">
                                    <div class="icon-wrapper warning">
                                        <span class="icon">
                                            <i class="far fa-trash"></i>
                                        </span>
                                    </div>
                                </a>
                                <a href="./index.php?page=student_update&id=<?php echo $student["studentId"] ?>&classId=<?php echo $class['classId'] ?>">
                                    <div class="icon-wrapper infor">
                                        <span class="icon ">
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
    <div class="table-footer">
        Số lượng: <?php echo $i . "/" . $numsOfStudent ?>
    </div>
</div>