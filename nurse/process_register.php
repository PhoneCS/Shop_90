<?php
session_start();
require_once 'config.php';

// ฟังก์ชันตรวจสอบการกรอกข้อมูล
function validate_input($data) {
    return htmlspecialchars(trim($data));
}

// ตรวจสอบว่าการร้องขอเป็น POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $fullname = validate_input($_POST['fullname']);
    $student_id = validate_input($_POST['student_id']);
    $field_of_study = validate_input($_POST['field_of_study']);
    $faculty = validate_input($_POST['faculty']);
    $email = validate_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
    if ($password !== $confirm_password) {
        $_SESSION['message'] = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน";
        header("Location: register.php");
        exit();
    }

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่ามีข้อมูลนักศึกษาอยู่แล้วหรือไม่ใน pending_members
    $sql_check_pending = "SELECT * FROM pending_members WHERE student_id = ? OR email = ?";
    $stmt_check_pending = $conn->prepare($sql_check_pending);

    if ($stmt_check_pending === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_check_pending->bind_param("ss", $student_id, $email);
    $stmt_check_pending->execute();
    $result_check_pending = $stmt_check_pending->get_result();

    // ตรวจสอบว่ามีข้อมูลนักศึกษาอยู่ใน pending_members
    if ($result_check_pending->num_rows > 0) {
        $_SESSION['message'] = "รหัสนักศึกษา หรือ อีเมลนี้มีอยู่ในระบบแล้ว (Pending)";
        $stmt_check_pending->close();
        $conn->close();
        header("Location: register.php");
        exit();
    }

    // ตรวจสอบว่ามีข้อมูลนักศึกษาอยู่แล้วหรือไม่ใน members1
    $sql_check_members1 = "SELECT * FROM members1 WHERE student_id = ? OR email = ?";
    $stmt_check_members1 = $conn->prepare($sql_check_members1);

    if ($stmt_check_members1 === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_check_members1->bind_param("ss", $student_id, $email);
    $stmt_check_members1->execute();
    $result_check_members1 = $stmt_check_members1->get_result();

    // ตรวจสอบว่ามีข้อมูลนักศึกษาอยู่ใน members1
    if ($result_check_members1->num_rows > 0) {
        $_SESSION['message'] = "รหัสนักศึกษา หรือ อีเมลนี้มีบัญชีอยู่แล้วในระบบ";
        $stmt_check_members1->close();
        $conn->close();
        header("Location: register.php");
        exit();
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // เพิ่มข้อมูลสมาชิกใหม่ลงใน pending_members
    $sql_insert = "INSERT INTO pending_members (fullname, student_id, field_of_study, faculty, email, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);

    if ($stmt_insert === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_insert->bind_param("ssssss", $fullname, $student_id, $field_of_study, $faculty, $email, $hashed_password);

    if ($stmt_insert->execute()) {
        $_SESSION['message'] = "สมัครสมาชิกสำเร็จ กรุณารอการอนุมัติจากแอดมิน";
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการสมัครสมาชิก: " . $stmt_insert->error;
        header("Location: register.php");
        exit();
    }

    $stmt_insert->close();
    $conn->close();
}
?>
