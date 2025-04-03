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

    // ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
    if (isset($_POST['status']) && isset($_POST['company_name']) && isset($_POST['candidate_email'])) {
        $status = $_POST['status']; // ค่าจากปุ่มตอบรับหรือไม่สนใจ
        $company_name = $_POST['company_name']; // อีเมลของบริษัท

        // อัปเดตสถานะใน matchcompany โดยใช้ company_email และ user_email เป็นเงื่อนไข
        // เปลี่ยนชื่อคอลัมน์ที่ตรงกับฐานข้อมูลจริง
        $stmt_update = $pdo->prepare("UPDATE matchcompany SET status = ? WHERE email = ? ");
        $stmt_update->execute([$status, $company_name]);

        // แสดงผลข้อความหลังการอัปเดตสถานะ
        if ($status === 'y') {
            echo "คุณได้ตอบรับการสมัครงานนี้แล้ว!";
        } elseif ($status === 'n') {
            echo "คุณได้ปฏิเสธการสมัครงานนี้!";
        }
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;
?>
