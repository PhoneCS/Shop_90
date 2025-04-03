<?php
$servername = "localhost";
$username = "root"; // ใช้ root สำหรับ XAMPP โดยทั่วไป
$password = ""; // รหัสผ่านว่างสำหรับ XAMPP โดยทั่วไป
$dbname = "users"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
