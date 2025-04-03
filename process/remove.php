<?php
session_start();
include('../includes/connect.inc.php');

// ตรวจสอบว่าได้ส่ง product_id มาหรือไม่
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session

    // คำสั่ง SQL สำหรับการเปลี่ยนสถานะสินค้าในตะกร้า
    $query = "UPDATE cart SET status = 'n' WHERE user_id = '$user_id' AND product_id = '$product_id'";

    if (mysqli_query($conn, $query)) {
        // หากอัพเดตสำเร็จ, รีไดเรกไปที่หน้า cart.php
        header("Location: ../page/cart.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการอัพเดตสถานะสินค้า";
    }
}
?>
