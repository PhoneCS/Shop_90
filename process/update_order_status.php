<?php
session_start();
include('../includes/connect.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $sql = "UPDATE order_history SET status = 'จัดส่งแล้ว' WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        echo "อัปเดตสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดต";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "คำขอไม่ถูกต้อง";
}
