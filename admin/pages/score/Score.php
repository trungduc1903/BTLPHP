<?php
$q ="";
if(isset($_GET["q"])){
    $q = trim($_GET["q"]);
}
$year = $_SESSION["schoolYear"];
$classQueryStmt = "CALL proc_class_getByYearv2($year,'$q')";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>


<div class="page-title">
    <h2>Kết quả học tập</h2>
</div>

<div class="page-content page-score">
    <div class="main-content">
        <div class="toolbar">
            <div class="toolbar--left"></div>
            <div class="toolbar--right">
                <div class="search">
                    <form action="" method="get">
                        <div class="container">
                            <input hidden type="text" name="page" value="score">
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
                            <input hidden type="text" name="page" value="score">
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
                        <th>Tên lớp</th>
                        <th>Khối</th>
                        <th>Sĩ số</th>
                        <th>Xem chi tiết</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($classes) {
                        while ($class = mysqli_fetch_array($classes)) {
                    ?>
                            <tr>
                                <td><?php echo $class['name'] ?></td>
                                <td><?php echo $class['grade'] ?></td>
                                <td><?php echo $class['qlt'] ?></td>
                                <td>
                                    <a href="./index.php?page=score_class&id=<?php echo $class['classId'] ?>">
                                        <div class="icon-wrapper success">
                                            <span class="icon">
                                                <i class="fal fa-eye"></i>
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