<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเข้าสู่ระบบ',
            text: 'คุณต้องเข้าสู่ระบบก่อนเข้าถึงหน้านี้',
            confirmButtonText: 'เข้าสู่ระบบ'
        }).then(() => {
            window.location.href = '../auth/login.php';
        });
    </script>";
    exit();
}

// รับค่า user_id จาก session
$user_id = $_SESSION['user_id'];

// รับข้อมูลจากฟอร์ม
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_stock = $_POST['product_stock'];
$product_description = $_POST['details'];
$category_id = $_POST['category'];
$email = $_POST['email'];

// อัปโหลดไฟล์รูปภาพหลัก
$target_dir = "../assets/image/";
$original_name = basename($_FILES["image"]["name"]);
$unique_name = time() . "_" . $original_name;
$target_file = $target_dir . $unique_name;
$product_image = $unique_name;

// อัปโหลดไฟล์รูปภาพ hover
$hover_name = basename($_FILES["image_hover"]["name"]);
$unique_hover = time() . "_hover_" . $hover_name;
$target_hover_file = $target_dir . $unique_hover;
$product_image_hover = $unique_hover;

// ตรวจสอบและย้ายไฟล์ทั้งสอง
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file) &&
    move_uploaded_file($_FILES["image_hover"]["tmp_name"], $target_hover_file)) {

    // เตรียมคำสั่ง SQL พร้อมเพิ่มฟิลด์ product_image_hover
    $sql = "INSERT INTO sell_offers (
                user_id, product_name, product_price, product_stock, 
                product_description, product_image, product_image_hover, 
                category_id, email
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdsssss", 
        $user_id, $product_name, $product_price, $product_stock, 
        $product_description, $product_image, $product_image_hover, 
        $category_id, $email
    );

    if ($stmt->execute()) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'ส่งข้อมูลเสนอขายสำเร็จ',
                    text: 'ข้อมูลของคุณถูกส่งเรียบร้อยแล้ว',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.href = '../page/offer_for_sale.php';
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
                    text: '" . $stmt->error . "',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('อัปโหลดรูปภาพไม่สำเร็จ'); window.history.back();</script>";
}

$conn->close();
?>
