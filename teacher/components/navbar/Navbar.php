<?php
ob_start();
$year = $_SESSION["schoolYear"];
$semester = $_SESSION["semester"];
$classId = "";
if(isset($_GET["classId"])){
    $classId = $_GET["classId"];
}
$teacherId = $_SESSION["teacher"]["teacherId"];

if (isset($_GET["grade"])) {
    $grade = $_GET["grade"];
}

$classesQueryStmt = "CALL proc_class_getByTeacher('$teacherId',$year,$semester)";
$classesQueryResult = mysqli_query($conn, $classesQueryStmt);
while(mysqli_next_result($conn)){;}

$classes = [];
while ($class = mysqli_fetch_array($classesQueryResult)) {
    $classes[$class["grade"]][$class["classId"]] = $class;
};
?>
<div class="navbar-wrapper">
    <div class="nav-item">
        <label for="grade-10" class="grade">
            Khối 10
        </label>
        <input hidden <?php if (isset($grade)) if ($grade == 10) echo "checked" ?> id="grade-10" type="checkbox">
        <div class="class-list">
            <?php
            if (isset($classes[10])) {
                $classList = $classes[10];
                foreach ($classList as $class) {
            ?>
                    <a href="./index.php?classId=<?php echo $class["classId"] . '&grade=10' ?>">
                        <div class="class-item <?php if($classId == $class["classId"])echo "active" ?>">
                            <?php echo $class["grade"] . $class["name"] ?>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "Không có lớp";
            }
            ?>
        </div>
    </div>
    <div class="nav-item">
        <label for="grade-11" class="grade">
            Khối 11
        </label>
        <input hidden <?php if (isset($grade)) if ($grade == 11) echo "checked" ?> id="grade-11" type="checkbox">

        <div class="class-list">
            <?php
            if (isset($classes[11])) {
                $classList = $classes[11];
                foreach ($classList as $class) {
            ?>
                    <a href="./index.php?classId=<?php echo $class["classId"] . '&grade=11' ?>">
                        <div class="class-item <?php if($classId == $class["classId"])echo "active" ?>">
                            <?php echo $class["grade"] . $class["name"] ?>
                        </div>
                    </a>
            <?php
                }
            } else {
                echo "Không có lớp";
            }
            ?>
        </div>
    </div>
    <div class="nav-item">
        <label for="grade-12" class="grade">
            Khối 12
        </label>
        <input hidden <?php if (isset($grade)) if ($grade == 12) echo "checked" ?> id="grade-12" type="checkbox">

        <div class="class-list">
            <?php
            if (isset($classes[12])) {
                $classList = $classes[12];
                foreach ($classList as $class) {
            ?>
                    <a href="./index.php?classId=<?php echo $class["classId"] . '&grade=12' ?>">
                        <div class="class-item <?php if($classId == $class["classId"])echo "active" ?>">
                            <?php echo $class["grade"] . $class["name"] ?>
                        </div>
                    </a>

            <?php
                }
            }else{
                echo "Không có lớp";
            }
            ?>
        </div>
    </div>

</div>

<?php 
    ob_end_flush();
?>