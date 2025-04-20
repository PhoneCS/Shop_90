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
    $status = 'y'; // เพิ่ม status

    // เตรียมคำสั่ง SQL โดยเพิ่ม user_id และ status
    $stmt = $conn->prepare("INSERT INTO complaints (title, description, user_id, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $description, $user_id, $status);

    if ($stmt->execute()) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'ส่งข้อความเรียบร้อยแล้ว',
                    text: 'ขอบคุณสำหรับการติดต่อเรา!',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.href = '../page/contact.php';
                });
            });
        </script>";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถส่งข้อความได้: " . $stmt->error . "',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../page/contact.php");
    exit;
}
?>
