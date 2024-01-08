<?php
$page = "";
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
?>

<div class="App">
    <div class="header">
        <?php include_once('./components/header/Header.php') ?>
    </div>
</div>
<div class="app-body">
    <div class="navbar">
        <?php include_once('./components/navbar/Navbar.php') ?>
    </div>
    <main class="main">
        <?php
        switch ($page) {
            case 'score':
                include_once('./pages/score/Score.php');
                break;

            case 'account':
                include_once('./pages/account/Account.php');
                break;

            case 'security':
                include_once('./pages/security/Security.php');
                break;

            default:
                include_once('./pages/score/Score.php');
                break;
        }

        ?>
    </main>
</div>

</div>