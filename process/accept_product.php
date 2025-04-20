<?php
session_start();
include('../includes/connect.inc.php');

// รับข้อมูลจากฟอร์ม
$id = $_POST['id']; // id จากตารางเสนอขาย

// ✅ อัปเดตสถานะรายการเสนอขายให้เป็น 1 (ได้รับการอนุมัติ)
$update_sql = "UPDATE sell_offers SET sell_offers_status = 1 WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error);
}

$update_stmt->bind_param("i", $id);

if ($update_stmt->execute()) {
    // รับข้อมูลที่ต้องการเพิ่ม
    $select_sql = "SELECT * FROM sell_offers WHERE id = ?";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bind_param("i", $id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $offer = $result->fetch_assoc();

    // ข้อมูลที่จะเพิ่มลงในตาราง products
    $product_name = $offer['product_name'];
    $product_image = $offer['product_image'];
    $product_stock = $offer['product_stock'];
    $product_price = $offer['product_price'];
    $category_id = $offer['category_id'];
    $product_description = $offer['product_description'];
    $product_image_hover = $offer['product_image_hover']; // สมมติว่าชื่อคอลัมน์ใน sell_offers เป็นแบบนี้

    // เพิ่มข้อมูลลงในตาราง products
    $insert_product_sql = "INSERT INTO products (product_name, product_image, product_image_hover, product_stock, product_price, category_id, product_description) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
$insert_product_stmt = $conn->prepare($insert_product_sql);
$insert_product_stmt->bind_param("sssissd", $product_name, $product_image, $product_image_hover, $product_stock, $product_price, $category_id, $product_description);


    if ($insert_product_stmt->execute()) {
        // รับ product_id ที่เพิ่งเพิ่ม
        $product_id = $conn->insert_id;

        // เพิ่มข้อมูลลงในตาราง product_detail
        $insert_detail_sql = "INSERT INTO product_detail (product_id, product_description) VALUES (?, ?)";
        $insert_detail_stmt = $conn->prepare($insert_detail_sql);
        $insert_detail_stmt->bind_param("is", $product_id, $product_description);

        if ($insert_detail_stmt->execute()) {
            // แสดง SweetAlert สำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ยืนยันสินค้าสำเร็จ',
                        text: 'สถานะรายการเสนอขายได้รับการอนุมัติแล้ว และข้อมูลสินค้าได้รับการบันทึกเรียบร้อย',
                        confirmButtonText: 'ตกลง'
                    }).then(() => {
                        window.location.href = '../page/offering_information.php';
                    });
                });
            </script>";
        } else {
            // แสดง SweetAlert ถ้าล้มเหลวในการเพิ่มข้อมูลใน product_detail
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล',
                        text: 'ไม่สามารถบันทึกข้อมูลในตาราง product_detail ได้',
                        confirmButtonText: 'ตกลง'
                    });
                });
            </script>";
        }
    } else {
        // แสดง SweetAlert ถ้าล้มเหลวในการเพิ่มข้อมูลใน products
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการเพิ่มสินค้า',
                    text: 'ไม่สามารถบันทึกข้อมูลในตาราง products ได้',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>";
    }
} else {
    // แสดง SweetAlert ถ้าล้มเหลว
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถอัปเดตสถานะได้: " . $update_stmt->error . "',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>";
}

$update_stmt->close();
$insert_product_stmt->close();
$insert_detail_stmt->close();
$conn->close();
?>