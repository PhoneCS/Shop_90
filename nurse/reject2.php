<?php
session_start();
require 'database.php'; // ไฟล์ที่เชื่อมต่อฐานข้อมูล

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli('localhost', 'root', '', 'users');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการเชื่อมต่อ
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ใช้ intval เพื่อป้องกัน SQL Injection

    // ลบข้อมูลจาก pending_members2
    $stmt = $conn->prepare("DELETE FROM pending_members2 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['message'] = "ปฏิเสธการสมัครสมาชิกเรียบร้อยแล้ว";
    $stmt->close();
} else {
    $_SESSION['message'] = "ไม่มีการระบุ ID";
}

$conn->close();
header('Location: admin.php');
exit();
?>
