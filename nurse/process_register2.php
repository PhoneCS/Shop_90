<?php
session_start();

// การเชื่อมต่อฐานข้อมูล
require 'database.php'; // ตรวจสอบให้แน่ใจว่าไฟล์นี้มีอยู่และมีข้อมูลการเชื่อมต่อฐานข้อมูลที่ถูกต้อง

// ตรวจสอบว่าแบบฟอร์มถูกส่งหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากแบบฟอร์ม
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $company_name = trim($_POST['company_name']);
    $business_type = trim($_POST['business_type']);

    // ตรวจสอบการยืนยันรหัสผ่าน
    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'รหัสผ่านไม่ตรงกัน';
        header('Location: register2.php');
        exit();
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO pending_members2 (username, email, password, company_name, business_type) 
            VALUES (?, ?, ?, ?, ?)";

    // เตรียมและดำเนินการคำสั่ง SQL
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $company_name, $business_type);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = 'สมัครสมาชิกสำเร็จ! ข้อมูลของคุณจะถูกตรวจสอบโดยผู้ดูแลระบบ';
        } else {
            $_SESSION['message'] = 'เกิดข้อผิดพลาดในการสมัครสมาชิก กรุณาลองอีกครั้ง';
        }
        
        $stmt->close();
    } else {
        $_SESSION['message'] = 'เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // เปลี่ยนเส้นทางกลับไปยังหน้าแบบฟอร์ม
    header('Location: register2.php');
    exit();
} else {
    // หากเข้าถึงไฟล์โดยตรง
    header('Location: register2.php');
    exit();
}
?>
