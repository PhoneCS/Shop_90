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

    // ตรวจสอบว่ามีข้อมูลที่รอการอนุมัติอยู่ในฐานข้อมูลหรือไม่
    $sql_check = "SELECT * FROM pending_members WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();

        // เพิ่มข้อมูลไปยัง members1
        $sql_insert = "INSERT INTO members1 (fullname, student_id, field_of_study, faculty, email, password_hash, user_type) VALUES (?, ?, ?, ?, ?, ?, 'user')";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $row['fullname'], $row['student_id'], $row['field_of_study'], $row['faculty'], $row['email'], $row['password_hash']);

        if ($stmt_insert->execute()) {
            // ลบข้อมูลจาก pending_members
            $sql_delete = "DELETE FROM pending_members WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            $stmt_delete->execute();

            $_SESSION['message'] = "อนุมัติสมาชิกเรียบร้อยแล้ว";
        } else {
            $_SESSION['message'] = "เกิดข้อผิดพลาดในการอนุมัติสมาชิก: " . $stmt_insert->error;
        }

        $stmt_insert->close();
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "ไม่พบข้อมูลที่ต้องการอนุมัติ";
    }
} else {
    $_SESSION['message'] = "ไม่มี ID ที่ระบุ";
}

$conn->close();
header("Location: admin_approval.php");
exit();
?>
