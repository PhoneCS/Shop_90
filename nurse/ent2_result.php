<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

try {
    // เชื่อมต่อฐานข้อมูลด้วย PDO
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // รับค่าที่ส่งมาจากฟอร์ม
    $email = $_POST['email'];  // เปลี่ยนจาก 'username' เป็น 'email'
    $company_name = $_POST['company_name'];

    // บันทึกข้อมูลลงในตาราง matchcompany
    $stmt = $pdo->prepare("INSERT INTO matchcompany (email, company_name) VALUES (?, ?)");
    $stmt->execute([$email, $company_name]);

    // แจ้งผลการบันทึก
    echo "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;
?>
