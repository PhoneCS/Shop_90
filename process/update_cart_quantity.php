<?php
session_start();
include('../includes/connect.inc.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (isset($_SESSION['user_id']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $now = date('Y-m-d H:i:s'); // เวลาปัจจุบัน

    // อัปเดตจำนวนสินค้าในตะกร้า
    $update_query = "UPDATE cart 
                     SET quantity = '$quantity', updated_at = '$now'
                     WHERE user_id = '$user_id' AND product_id = '$product_id'";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "อัปเดตจำนวนสินค้าเรียบร้อยแล้ว";
    } else {
        echo "ไม่สามารถอัปเดตจำนวนสินค้าได้: " . mysqli_error($conn);
    }
}
?>
