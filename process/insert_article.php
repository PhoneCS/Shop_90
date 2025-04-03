<?php
session_start();
include('../includes/connect.inc.php');
$title = $_POST['title'];
$content = $_POST['content'];

// อัพโหลดไฟล์รูปภาพ
$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../assets/image/";
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
}

$sql = "INSERT INTO articles (title, content, image) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $image);

if ($stmt->execute()) {
    echo "เพิ่มบทความสำเร็จ!";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
