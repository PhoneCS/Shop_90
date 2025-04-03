<?php
session_start();
include('../includes/connect.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];
    $product_additional_info = $_POST['product_additional_info'];
    $product_stock = $_POST['product_stock'];
    $category_id = $_POST['category_id'];

    // กำหนดโฟลเดอร์อัปโหลดใหม่
    $target_dir = "../assets/image/"; // ✅ ต้องมี "/" ต่อท้าย

    // ตรวจสอบและสร้างโฟลเดอร์หากไม่มี
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
    $product_image = "";
    $product_image_hover = "";

    if (!empty($_FILES["product_image"]["name"])) {
        $product_image = basename($_FILES["product_image"]["name"]);
        $target_file_image = $target_dir . $product_image;
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file_image);
    }

    if (!empty($_FILES["product_image_hover"]["name"])) {
        $product_image_hover = basename($_FILES["product_image_hover"]["name"]);
        $target_file_hover = $target_dir . $product_image_hover;
        move_uploaded_file($_FILES["product_image_hover"]["tmp_name"], $target_file_hover);
    }

    // เพิ่มข้อมูลลงในตาราง `product`
    $sql = "INSERT INTO products (product_name, product_price, product_stock, category_id, product_image, product_image_hover) 
            VALUES ('$product_name', '$product_price', '$product_stock', '$category_id', '$product_image', '$product_image_hover')";
    
    if ($conn->query($sql) === TRUE) {
        // ดึง `product_id` ล่าสุด
        $last_id = $conn->insert_id;

        // เพิ่มข้อมูลลงในตาราง `product_detail`
        $sql_detail = "INSERT INTO product_detail (product_id, product_description, product_additional_info) 
                       VALUES ('$last_id', '$product_description', '$product_additional_info')";

        if ($conn->query($sql_detail) === TRUE) {
            echo "<script>alert('เพิ่มสินค้าสำเร็จ'); window.location='../page/addProduct.php';</script>";
        } else {
            echo "Error: " . $sql_detail . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
