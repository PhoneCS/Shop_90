<?php
session_start();
include 'connect.inc.php';
date_default_timezone_set('Asia/Bangkok');

// รับค่าจากฟอร์ม
$id = $_POST['id'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$details = $_POST['details'];
$quantity = $_POST['qty_input'];
$status = $_POST['status'];
$uid = $_SESSION['id'];
$datetime = date("Y-m-d H:i:s");

// ตรวจสอบราคาให้เป็นตัวเลข
if (!is_numeric($price)) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด',
                text: 'ราคาต้องเป็นตัวเลข'
            }).then(() => {
                window.history.back();
            });
          </script>";
    exit();
}

// เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
$sql = "UPDATE product_items 
        SET product_name='$product_name', 
            price='$price', 
            details='$details', 
            quantity='$quantity', 
            status='$status', 
            date_update='$datetime', 
            uid_update='$uid' 
        WHERE id=$id";
$result = mysqli_query($link, $sql);

// ตรวจสอบผลลัพธ์
$msgType = $result ? "success" : "error";
$msgText = $result ? "แก้ไขสำเร็จ!" : "แก้ไขล้มเหลว: " . mysqli_error($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Status</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script type="text/javascript">
        Swal.fire({
            position: "center",
            icon: "<?php echo $msgType; ?>",
            title: "<?php echo $msgText; ?>",
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location = 'overview.php';
        });
    </script>
</body>
</html>
