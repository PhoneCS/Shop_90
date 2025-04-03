<?php
// process_payment.php

// รับข้อมูลจากคำขอ
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'];
$cartItems = $input['cartItems'];

session_start();
include('../includes/connect.inc.php');

// เริ่มต้นการทำธุรกรรม
try {
    // เริ่มต้นการทำธุรกรรม
    $pdo->beginTransaction();

    // จัดการการชำระเงิน
    // ที่นี่คุณจะต้องเพิ่มการจัดการกับการชำระเงิน เช่น การสร้างออเดอร์
    $order_id = createOrder($user_id, $cartItems, $pdo); // สมมุติว่ามีฟังก์ชัน createOrder() ที่สร้างออเดอร์

    // วนลูปเพื่อลดสต๊อกสินค้าตามจำนวนที่ซื้อ
    foreach ($cartItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // ลดสต๊อกสินค้า
        $sql = "UPDATE products SET product_stock = product_stock - ? WHERE product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$quantity, $product_id]);
    }

    // ยืนยันการทำธุรกรรม
    $pdo->commit();

    // ส่งข้อมูลกลับไปให้ JavaScript
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // ถ้ามีข้อผิดพลาด ยกเลิกธุรกรรม
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการชำระเงินและตัดสต๊อก']);
}

// ฟังก์ชันสมมุติในการสร้างออเดอร์
function createOrder($user_id, $cartItems, $pdo) {
    // สมมุติว่าเรา insert ออเดอร์ใหม่และคืนค่า order_id
    $sql = "INSERT INTO orders (user_id, order_status) VALUES (?, 'pending')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $pdo->lastInsertId(); // คืนค่า order_id ที่เพิ่งสร้าง
}
?>
