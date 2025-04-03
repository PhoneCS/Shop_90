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

    // ดึงข้อมูลจาก pending_members2
    $stmt = $conn->prepare("SELECT * FROM pending_members2 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // คัดลอกข้อมูลไปยัง members2
        $stmt = $conn->prepare("INSERT INTO members2 (username, email, company_name, business_type, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $row['username'], $row['email'], $row['company_name'], $row['business_type'], $row['password']);
        $stmt->execute();

        // ลบข้อมูลจาก pending_members2
        $stmt = $conn->prepare("DELETE FROM pending_members2 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $_SESSION['message'] = "อนุมัติการสมัครสมาชิกเรียบร้อยแล้ว";
    } else {
        $_SESSION['message'] = "ไม่พบข้อมูลการสมัครสมาชิก";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "ไม่มีการระบุ ID";
}

$conn->close();
header('Location: admin.php');
exit();
?>
