<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $order_date = $_POST['order_date'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $delivery_company = $_POST['delivery_company'];
    $product_code = $_POST['product_code'];

    // อัปเดตสถานะเป็น "กำลังจัดส่ง"
    $sql = "UPDATE order_history 
            SET status = 'กำลังจัดส่ง', 
                order_date = ?, 
                shipping_address = ?, 
                phone = ?, 
                delivery_company = ?, 
                tracking_number = ? 
            WHERE order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $order_date, $address, $phone, $delivery_company, $product_code, $order_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('อัปเดตสถานะเรียบร้อยแล้ว'); window.location.href='../page/product_status.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>
