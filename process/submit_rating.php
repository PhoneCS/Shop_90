<?php
session_start();
include('../includes/connect.inc.php');

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$order_id = intval($data['order_id']); // รับ order_id
$product_id = intval($data['product_id']);
$rating = floatval($data['rating']); // แปลงเป็น float (ทศนิยม)

$response = [];

if ($product_id && $rating >= 1.0 && $rating <= 5.0 && $order_id) {
    // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
    $sql_check = "SELECT * FROM order_history WHERE order_id = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $order_id, $_SESSION['user_id']); // ตรวจสอบว่า order_id และ user_id ตรงกัน
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        // ถ้ามีข้อมูลใน order_history

        // เก็บคะแนนในตาราง product_ratings
        $sql_insert_rating = "INSERT INTO product_ratings (product_id, user_id, rating, order_id) VALUES (?, ?, ?, ?)";
        $stmt_insert_rating = $conn->prepare($sql_insert_rating);
        $stmt_insert_rating->bind_param("iiid", $product_id, $_SESSION['user_id'], $rating, $order_id);

        if ($stmt_insert_rating->execute()) {
            // คำนวณคะแนนเฉลี่ยจากการให้คะแนนทั้งหมดในตาราง product_ratings
            $sql_avg_rating = "SELECT AVG(rating) AS avg_rating FROM product_ratings WHERE product_id = ?";
            $stmt_avg_rating = $conn->prepare($sql_avg_rating);
            $stmt_avg_rating->bind_param("i", $product_id);
            $stmt_avg_rating->execute();
            $result_avg_rating = $stmt_avg_rating->get_result();
            $avg_rating = $result_avg_rating->fetch_assoc()['avg_rating'];

            // อัปเดตคะแนนเฉลี่ยในตาราง products
            $sql_update_rating = "UPDATE products SET product_rating = ? WHERE product_id = ?";
            $stmt_update_rating = $conn->prepare($sql_update_rating);
            $stmt_update_rating->bind_param("di", $avg_rating, $product_id);

            if ($stmt_update_rating->execute()) {
                $response['success'] = true;
                $response['avg_rating'] = round($avg_rating, 2); // ส่งคะแนนเฉลี่ยกลับไป
            } else {
                $response['success'] = false;
                $response['error'] = 'ข้อผิดพลาดในการอัปเดตคะแนนเฉลี่ย';
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'ข้อผิดพลาดในการบันทึกคะแนน';
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'ไม่พบข้อมูลใน order_history หรือข้อมูลไม่ตรงกับผู้ใช้';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'ข้อมูลไม่ครบถ้วนหรือไม่ถูกต้อง';
}

echo json_encode($response);
?>
