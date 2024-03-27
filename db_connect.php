<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QL_NHANSU";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
?>