<html>
<head>
    <title>Product Insertion</title>
    <!-- เชื่อมต่อกับ SweetAlert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
session_start();
include 'connect.inc.php';
date_default_timezone_set('Asia/Bangkok');

// รับค่าจากฟอร์ม
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$details = $_POST['details'];
$quantity = $_POST['qty_input'];
$status = $_POST['status'];
$uid = $_SESSION['id'];
$datetime = date("Y-m-d H:i:s");
$status_item = "y";

// ตรวจสอบราคาให้เป็นตัวเลข
if (!is_numeric($price)) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ข้อผิดพลาด',
            text: 'ราคาต้องเป็นตัวเลข'
        }).then((result) => {
            window.history.back();
        });
    </script>";
    exit();
}

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO product_items(product_name, price, details, quantity, status, date_create, uid_create, status_item)
        VALUES ('$product_name', '$price', '$details', '$quantity', '$status', '$datetime', '$uid', '$status_item');";
$result = mysqli_query($link, $sql);

// แสดง SweetAlert ตามผลลัพธ์ของการบันทึกข้อมูล
if ($result) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: 'เพิ่มข้อมูลสำเร็จ!'
        }).then((result) => {
            window.location = 'overview.php';
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ข้อผิดพลาด',
            text: 'ไม่สามารถเพิ่มข้อมูลได้!'
        }).then((result) => {
            window.location = 'overview.php';
        });
    </script>";
}
?>
</body>
</html>
