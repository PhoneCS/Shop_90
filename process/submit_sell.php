<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบหรือยัง (มี user_id ใน session หรือไม่)
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนเสนอขายสินค้า'); window.location.href = '../login.php';</script>";
    exit;
}

// รับค่า user_id จาก session
$user_id = $_SESSION['user_id'];

// รับข้อมูลจากฟอร์ม
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$details = $_POST['details'];

// อัปโหลดไฟล์รูปภาพ
$target_dir = "../upload/";
$original_name = basename($_FILES["image"]["name"]);
$unique_name = time() . "_" . $original_name; // ป้องกันชื่อซ้ำ
$target_file = $target_dir . $unique_name;
$image_filename = $unique_name; // ใช้เฉพาะชื่อไฟล์ในการบันทึกลงฐานข้อมูล

// ตรวจสอบและย้ายไฟล์
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO sell_offers (user_id, first_name, last_name, phone, email, image_path, details)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $first_name, $last_name, $phone, $email, $image_filename, $details);

    if ($stmt->execute()) {
        echo "<script>alert('ส่งข้อมูลเสนอขายสำเร็จแล้ว'); window.location.href = '../page/offer_for_sale.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>alert('อัปโหลดรูปภาพไม่สำเร็จ'); window.history.back();</script>";
}

$conn->close();
?>
