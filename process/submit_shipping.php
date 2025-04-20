<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $delivery_company = $_POST['delivery_company'];
    $product_code = $_POST['product_code'];

    // อัปเดตสถานะเป็น "กำลังจัดส่ง"
    $sql = "UPDATE order_history 
            SET status = 'กำลังจัดส่ง', 
                delivery_company = ?, 
                tracking_number = ? 
            WHERE order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $delivery_company, $product_code, $order_id);
    
    if ($stmt->execute()) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'อัปเดตสถานะเรียบร้อยแล้ว',
                    text: 'สถานะของคำสั่งซื้อได้รับการอัปเดตเป็นกำลังจัดส่ง',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.href = '../page/product_status.php';
                });
            });
        </script>";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถอัปเดตสถานะได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>";
    }
}
?>
