<?php
session_start();
include('../includes/connect.inc.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session

    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity']; // จำนวนสินค้าที่เลือก
        $now = date('Y-m-d H:i:s'); // เวลาปัจจุบัน

        // ตรวจสอบราคาส่วนลดจากตาราง product_discounts
        $discount_query = "SELECT discounted_price FROM product_discounts WHERE product_id = '$product_id'";
        $discount_result = mysqli_query($conn, $discount_query);

        if (mysqli_num_rows($discount_result) > 0) {
            // หากมีราคาส่วนลด
            $discount_row = mysqli_fetch_assoc($discount_result);
            $final_price = $discount_row['discounted_price']; // ใช้ราคาโปรโมชั่น
        } else {
            // ถ้าไม่มีโปรโมชั่น ให้ดึงราคาปกติจาก product
            $price_query = "SELECT product_price FROM products WHERE product_id = '$product_id'";
            $price_result = mysqli_query($conn, $price_query);

            if ($price_result && mysqli_num_rows($price_result) > 0) {
                $price_row = mysqli_fetch_assoc($price_result);
                $final_price = $price_row['product_price']; // ใช้ราคาปกติ
            } else {
                echo "ไม่พบข้อมูลสินค้า";
                exit;
            }
        }

        // ตรวจสอบว่าสินค้าอยู่ในตะกร้าหรือไม่
        $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // อัปเดตจำนวนสินค้าในตะกร้า + เวลา
            $update_query = "UPDATE cart 
                             SET quantity = quantity + '$quantity', price = '$final_price', updated_at = '$now'
                             WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                echo "สินค้าในตะกร้าอัปเดตจำนวนเพิ่มแล้ว";
            } else {
                echo "ไม่สามารถอัปเดตจำนวนสินค้าได้: " . mysqli_error($conn);
            }
        } else {
            // เพิ่มสินค้าใหม่ลงตะกร้า
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity, price, created_at, updated_at) 
                             VALUES ('$user_id', '$product_id', '$quantity', '$final_price', '$now', '$now')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                echo "เพิ่มสินค้าลงตะกร้าแล้ว";
            } else {
                echo "ไม่สามารถเพิ่มสินค้าได้: " . mysqli_error($conn);
            }
        }
    }
}
?>
