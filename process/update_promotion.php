<?php
include('../includes/connect.inc.php');
?>

<!-- เพิ่ม SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// ตรวจสอบว่าได้รับข้อมูลจากฟอร์มหรือไม่
if (isset($_POST['product_id']) && isset($_POST['discounted_price']) && isset($_POST['original_price'])) {
    $product_id = $_POST['product_id'];
    $discounted_price = $_POST['discounted_price'];
    $original_price = $_POST['original_price'];

    // คำนวณเปอร์เซ็นต์ส่วนลด
    $discount_percentage = (($original_price - $discounted_price) / $original_price) * 100;

    // ตรวจสอบว่ามีส่วนลดของสินค้านี้อยู่แล้วหรือไม่
    $check_query = "SELECT * FROM product_discounts WHERE product_id = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("i", $product_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // ถ้ามีอยู่แล้วให้ทำการ UPDATE
        $query = "UPDATE product_discounts SET discount_percentage = ?, discounted_price = ? WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("dii", $discount_percentage, $discounted_price, $product_id);
    } else {
        // ถ้ายังไม่มีให้ INSERT ใหม่
        $query = "INSERT INTO product_discounts (product_id, discount_percentage, discounted_price) 
                  VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idi", $product_id, $discount_percentage, $discounted_price);
    }

    // ตรวจสอบว่าการบันทึกหรืออัปเดตสำเร็จหรือไม่
    if ($stmt->execute()) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกโปรโมชั่นสำเร็จ',
                        text: 'โปรโมชั่นถูกบันทึกลงในระบบแล้ว',
                        confirmButtonText: 'ตกลง'
                    }).then(() => {
                        window.location.href = '../page/product-details.php?product_id=" . $product_id . "';
                    });
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถบันทึกโปรโมชั่นได้',
                        confirmButtonText: 'ตกลง'
                    });
                });
              </script>";
    }
}
?>
