<?php
session_start();
unset($_SESSION["teacher"]);
header("Location: login.php");