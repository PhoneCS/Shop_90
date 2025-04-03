<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์ฐานข้อมูล
$username = "root";        // ชื่อผู้ใช้ฐานข้อมูล (ค่าเริ่มต้นใน XAMPP)
$password = "";            // รหัสผ่านฐานข้อมูล (ค่าเริ่มต้นใน XAMPP มักจะเป็นค่าว่าง)
$dbname = "users";         // ชื่อฐานข้อมูลที่คุณใช้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
