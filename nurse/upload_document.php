<?php
session_start();
require_once 'config.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

try {
    // เชื่อมต่อฐานข้อมูลด้วย PDO
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ตรวจสอบการอัปโหลดไฟล์
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ตรวจสอบการอัปโหลดไฟล์
        $files = [
            'id_card' => $_FILES['id_card'],       // บัตรประชาชน
            'house_register' => $_FILES['house_register'],  // ทะเบียนบ้าน
            'transcript' => $_FILES['transcript'],   // ผลการเรียน
            'military_service' => $_FILES['military_service'],   // การเกณฑ์ทหาร
            'work_certificate' => $_FILES['work_certificate']   // หนังสือรับรองการทำงาน
        ];
        
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            $fileName = basename($file['name']);
            $fileTmpPath = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
        
            // ตรวจสอบว่าไฟล์ไม่มีข้อผิดพลาด
            if ($fileError === UPLOAD_ERR_OK) {
                // กำหนดเส้นทางที่จะเก็บไฟล์
                $uploadDir = 'uploads/';
                $uploadFilePath = $uploadDir . $fileName;
        
                // ตรวจสอบขนาดไฟล์ (ตัวอย่างเช่น 5MB)
                if ($fileSize < 5 * 1024 * 1024) {
                    // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
                    if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                        $uploadedFiles[$key] = $uploadFilePath;
                    } else {
                        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์: " . $fileName;
                    }
                } else {
                    echo "ไฟล์ " . $fileName . " มีขนาดใหญ่เกินไป";
                }
            }
        }
        
        // ตรวจสอบว่าไฟล์ทั้งหมดถูกอัปโหลดสำเร็จ
        $updateFields = [];
        $updateValues = [];
        
        if (!empty($uploadedFiles['id_card'])) {
            $updateFields[] = "id_card_file = ?";
            $updateValues[] = $uploadedFiles['id_card'];
        }
        if (!empty($uploadedFiles['house_register'])) {
            $updateFields[] = "house_register_file = ?";
            $updateValues[] = $uploadedFiles['house_register'];
        }
        if (!empty($uploadedFiles['transcript'])) {
            $updateFields[] = "transcript_file = ?";
            $updateValues[] = $uploadedFiles['transcript'];
        }
        if (!empty($uploadedFiles['military_service'])) {
            $updateFields[] = "military_service_file = ?";
            $updateValues[] = $uploadedFiles['military_service'];
        }
        if (!empty($uploadedFiles['work_certificate'])) {
            $updateFields[] = "work_certificate_file = ?";
            $updateValues[] = $uploadedFiles['work_certificate'];
        }
        
        if (!empty($updateFields)) {
            $sql = "UPDATE graduates SET " . implode(', ', $updateFields) . " WHERE email = ?";
            $updateValues[] = $_SESSION['email'];  // เพิ่มอีเมล์สำหรับการระบุผู้ใช้
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateValues);
        
            // หลังจากอัปโหลดไฟล์เสร็จสมบูรณ์ ให้เปลี่ยนเส้นทางไปหน้า index.php
            header("Location: index.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์บางส่วน";
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>อัปโหลดเอกสาร</title>
    <link rel="stylesheet" href="styles_upload.css">
</head>
<body>
    <div class="container">
        <h1>อัปโหลดไฟล์เอกสาร</h1>
        <form action="upload_document.php" method="POST" enctype="multipart/form-data">
            <label for="id_card">เลือกไฟล์บัตรประชาชน (ปปช.):</label>
            <input type="file" name="id_card" id="id_card" required>
            <br><br>
            <label for="house_register">เลือกไฟล์ทะเบียนบ้าน:</label>
            <input type="file" name="house_register" id="house_register" required>
            <br><br>
            <label for="transcript">เลือกไฟล์สำเนาใบรับรองผลการเรียน:</label>
            <input type="file" name="transcript" id="transcript" required>
            <br><br>
            <label for="military_service">เลือกไฟล์ใบผ่านการเกณฑ์ทหารหรือใบผ่านการเรียนรักษาดินแดน(ถ้ามี):</label>
            <input type="file" name="military_service" id="military_service">
            <br><br>
            <label for="work_certificate">เลือกไฟล์หนังสือรับรองการทำงาน(ถ้ามี):</label>
            <input type="file" name="work_certificate" id="work_certificate">
            <br><br>
            <button type="submit">อัปโหลด</button>
        </form>
        <a href="index.php">กลับไปหน้าหลัก</a>
    </div>
</body>
</html>
