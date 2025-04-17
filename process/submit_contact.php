<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // รับ user_id จาก session (ถ้ามี)
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // ตรวจสอบข้อมูล
    if (empty($name) || empty($email) || empty($message)) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน";
        exit;
    }

    // ตั้งชื่อ title เป็นชื่อผู้ส่ง + หัวเรื่องทั่วไป
    $title = "ข้อความใหม่จาก $name ";
    $description = "$message";

    // เตรียมคำสั่ง SQL โดยเพิ่ม user_id
    $stmt = $conn->prepare("INSERT INTO complaints (title, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $user_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('ส่งข้อความเรียบร้อยแล้ว ขอบคุณสำหรับการติดต่อเรา!');
            window.location.href = '../page/contact.php';
        </script>";
    } else {
        echo "เกิดข้อผิดพลาดในการส่งข้อความ: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../page/contact.php");
    exit;
}
?>