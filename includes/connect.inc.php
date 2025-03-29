<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop90";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าภาษาให้รองรับ UTF-8
$conn->set_charset("utf8");
?>
