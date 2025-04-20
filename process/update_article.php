<?php
session_start();
include('../includes/connect.inc.php');

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

// ดึงชื่อรูปเดิมจากฐานข้อมูล
$sql_get_image = "SELECT image FROM articles WHERE id = ?";
$stmt_get = $conn->prepare($sql_get_image);
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$stmt_get->bind_result($old_image);
$stmt_get->fetch();
$stmt_get->close();

// อัปโหลดรูปใหม่ถ้ามี
$image = $old_image; // ตั้งค่าเริ่มต้นเป็นรูปเดิม
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../assets/image/";
    $new_image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $new_image;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $new_image; // ใช้ชื่อไฟล์ใหม่ถ้าอัปโหลดสำเร็จ
    }
}

// อัปเดตบทความ
$sql = "UPDATE articles SET title = ?, content = ?, image = ?, updated_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $title, $content, $image, $id);

if ($stmt->execute()) {
    echo "อัปเดตบทความสำเร็จ!";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
