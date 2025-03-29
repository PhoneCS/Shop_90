<?php
session_start();
include('../includes/connect.inc.php');

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session
    if (isset($_POST['product_id']) && isset($_POST['product_name'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];

        // ตรวจสอบว่าสินค้านี้อยู่ในตะกร้าหรือไม่
        $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // ดึงข้อมูลสินค้าในตะกร้า
            $row = mysqli_fetch_assoc($check_result);
            if ($row['status'] == 'n') {
                // ถ้าสถานะเป็น 'n' ให้เปลี่ยนเป็น 'y'
                $update_query = "UPDATE cart SET status = 'y', quantity = quantity + 1 
                                 WHERE user_id = '$user_id' AND product_id = '$product_id'";
            } else {
                // ถ้าสถานะเป็น 'y' ให้เพิ่มปริมาณสินค้า
                $update_query = "UPDATE cart SET quantity = quantity + 1 
                                 WHERE user_id = '$user_id' AND product_id = '$product_id'";
            }
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                echo "สินค้าในตะกร้าอัปเดตจำนวนเพิ่มแล้ว";
            } else {
                echo "ไม่สามารถอัปเดตจำนวนสินค้าได้: " . mysqli_error($conn);
            }
        } else {
            // ถ้ายังไม่มีสินค้าในตะกร้า ให้เพิ่มสินค้าใหม่และตั้งค่า status เป็น 'y'
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity, status) 
                             VALUES ('$user_id', '$product_id', 1, 'y')";
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
