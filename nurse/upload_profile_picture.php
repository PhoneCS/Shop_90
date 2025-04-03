<?php
session_start();
require_once 'config.php';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $upload_dir = 'uploads/';
    $file_path = $upload_dir . basename($file['name']);

    // ตรวจสอบการอัปโหลดไฟล์
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        // อัปเดตที่อยู่ของรูปภาพในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE graduates SET profile_picture = ? WHERE email = ?");
        $stmt->bind_param("ss", $file_path, $email);
        $stmt->execute();
        $stmt->close();
        
        // ส่งกลับไปที่หน้า index.php
        header("Location: index.php?message=" . urlencode("อัปโหลดรูปโปรไฟล์สำเร็จ!"));
        exit();
    } else {
        $message = "เกิดข้อผิดพลาดในการอัปโหลดรูปโปรไฟล์!";
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>อัปโหลดรูปโปรไฟล์</title>
    <link rel="stylesheet" href="styles_upload.css">
</head>
<body>
    <div class="container">
        <h1>อัปโหลดรูปโปรไฟล์</h1>
        <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profile_picture" accept="image/*" required>
            <button type="submit">อัปโหลด</button>
        </form>
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <a href="index.php">กลับไปที่หน้าแรก</a>
    </div>
</body>
</html>
