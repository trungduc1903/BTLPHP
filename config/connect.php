<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nvduong';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn) {
    mysqli_query($conn, "SET NAMES 'utf8'");
} else {
    die('Lỗi kết nối cơ sở dữ liệu');
}