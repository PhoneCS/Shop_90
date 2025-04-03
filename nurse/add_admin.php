<?php
// เชื่อมต่อฐานข้อมูล
require_once 'config.php';

// ข้อมูลผู้ใช้ Admin ที่จะเพิ่ม
$fullname = 'admin';
$student_id = '00000000001';
$field_of_study = 'admin';
$faculty = 'admin';
$email = 'admin@gmail.com';
$password = '111111'; // รหัสผ่านที่ไม่เข้ารหัส

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าผู้ใช้มีอยู่แล้วหรือไม่ใน members1
$sql_check = "SELECT * FROM members1 WHERE student_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $student_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    // เพิ่มข้อมูลผู้ใช้ใหม่ลงในฐานข้อมูล
    $sql_insert = "INSERT INTO members1 (fullname, student_id, field_of_study, faculty, email, password_hash, user_type) VALUES (?, ?, ?, ?, ?, ?, 'admin')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssss", $fullname, $student_id, $field_of_study, $faculty, $email, $hashed_password);

    if ($stmt_insert->execute()) {
        echo "ผู้ใช้ Admin ถูกเพิ่มลงในฐานข้อมูลเรียบร้อยแล้ว!";
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt_insert->error;
    }

    $stmt_insert->close();
} else {
    echo "ข้อมูลผู้ใช้ที่มีรหัสนักศึกษานี้มีอยู่แล้วในฐานข้อมูล";
}

$stmt_check->close();
$conn->close();
?>
