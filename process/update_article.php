<?php
session_start();
include('../includes/connect.inc.php');

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

// อัพโหลดไฟล์รูปภาพถ้ามีการเปลี่ยนแปลง
$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../assets/image/";
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
}

// อัปเดตข้อมูลบทความ
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
