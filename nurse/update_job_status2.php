<?php
session_start();
require_once 'config.php'; // รวมการตั้งค่าการเชื่อมต่อฐานข้อมูล

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูล
if (isset($_POST['toggle_job_status'])) {
    $email = $_POST['email'];
    $new_status = $_POST['toggle_job_status'];

    // อัปเดตสถานะงานในฐานข้อมูล
    $sql = "UPDATE graduates2 SET job_availability = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_status, $email);
    
    if ($stmt->execute()) {
        // หากสำเร็จ, เปลี่ยนเส้นทางกลับไปยังหน้าหลัก
        header("Location: index2.php"); // เปลี่ยนเป็นหน้าที่ต้องการ
        exit();
    } else {
        echo "Error updating job status: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
