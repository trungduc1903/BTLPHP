<?php
ob_start();
$schoolYearMax = getdate()["year"];
$schoolYearMin = 2020;

if (isset($_POST["schoolYear"])) {
   $schoolYear = $_POST["schoolYear"];
   $_SESSION["schoolYear"] = $schoolYear; 
}

$schoolYear = $_SESSION["schoolYear"];

?>
<div class="header">

    <div class="logo">
        <img class="logo__img" src="../asset/logo.png" style="height: 40px; " alt="">
        <h2 class="logo__text">Trường trung học phổ thông PHP</h2>
    </div>
    <div>
        <form id="schoolYearForm" action="" method="POST">
            Năm học
            <select onchange="handleSchoolYearChange();" name="schoolYear">
                <?php
                    for($year = $schoolYearMax; $year >= $schoolYearMin; --$year){
                ?>
                    <option 
                        value="<?php echo $year ?>"
                        <?php if($schoolYear == $year) echo "selected" ?>
                    >
                        <?php echo $year."-".($year + 1)?>
                    </option>
                <?php
                    }
                ?>
            </select>
           
        </form>
    </div>
    <div class="user-infor">
        <p><?php echo $_SESSION["user"]["name"] ?></p>
        <div class="avata">
            <img src="./avatas/<?php echo $_SESSION['user']['avata'] ?>" alt="" onerror="this.onerror = null; this.src = '../asset/defaultAvata.png'">

        </div>
        <?php include('components/dropdownHeader/dropdownHeader.php') ?>

    </div>
</div>
<script>
    function handleSchoolYearChange() {
        let form = document.querySelector("#schoolYearForm");
        form.submit();
    }
</script>