<?php
include('../includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $original_price = $_POST['original_price']; // ราคาเดิม
    $discounted_price = $_POST['discounted_price']; // ราคาที่ลดแล้ว

    // คำนวณเปอร์เซ็นต์ส่วนลด
    if ($original_price > 0) {
        $product_discount = (($original_price - $discounted_price) / $original_price) * 100;
        $product_discount = round($product_discount, 2); // ปัดเป็นทศนิยม 2 ตำแหน่ง
    } else {
        $product_discount = 0;
    }

    // อัปเดตฐานข้อมูล
    $query = "UPDATE products SET original_price = ?, product_discount = ? WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ddi", $discounted_price, $product_discount, $product_id);
    
    if ($stmt->execute()) {
        // ใช้ SweetAlert แสดงผลสำเร็จและนำทาง
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'อัปเดตโปรโมชั่นสำเร็จ!',
                text: 'กำลังนำคุณไปยังหน้ารายละเอียดสินค้า...',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '../page/product-details.php?product_id=" . $product_id . "';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการอัปเดต!',
                text: 'โปรดลองอีกครั้ง',
                showConfirmButton: true
            }).then(function() {
                window.history.back();
            });
        </script>";
    }
    
    $stmt->close();
    $conn->close();
} else {
    header('Location: ../page/product-details.php'); // ป้องกันการเข้าถึงโดยตรง
    exit();
}
?>
<?php include('../includes/footer.php'); ?>