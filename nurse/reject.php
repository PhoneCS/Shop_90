<?php
session_start();
require_once 'config.php';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ลบข้อมูลจาก pending_members
    $sql_delete = "DELETE FROM pending_members WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        $_SESSION['message'] = "ปฏิเสธสมาชิกเรียบร้อยแล้ว";
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการปฏิเสธสมาชิก: " . $stmt_delete->error;
    }

    $stmt_delete->close();
} else {
    $_SESSION['message'] = "ไม่มี ID ที่ระบุ";
}

$conn->close();
header("Location: admin_approval.php");
exit();
?>
