<?php
include('../includes/header.php');
$is_logged_in = isset($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเข้าสู่ระบบ',
            text: 'คุณต้องเข้าสู่ระบบก่อนเข้าถึงหน้านี้',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.href = '../auth/login.php';
        });
    </script>";
    exit();
}

// รับ product_id จาก URL
$product_id = $_GET['product_id'];

// ตรวจสอบว่า product_id มีค่า
if (empty($product_id)) {
    echo "ไม่พบสินค้านี้!";
    exit;
}

// ดึงข้อมูลจากทั้งตาราง products, product_detail และ product_discounts
$query = "
    SELECT p.*, pd.*, d.discounted_price, d.discount_percentage
    FROM products p
    INNER JOIN product_detail pd ON p.product_id = pd.product_id
    LEFT JOIN product_discounts d ON p.product_id = d.product_id
    WHERE p.product_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่าได้ผลลัพธ์หรือไม่
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "ไม่พบสินค้านี้!";
    exit;
}
?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดสินค้า - <?php echo $product['product_name']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- แสดงรายละเอียดสินค้า -->
    <div class="product-details">

        <!-- รูปสินค้า -->
        <div class="product-img">
            <img src="../assets/image/<?php echo $product['product_image']; ?>"
                alt="<?php echo $product['product_name']; ?>">
            <?php if (!empty($product['product_image_hover'])) { ?>
                <img src="../assets/image/<?php echo $product['product_image_hover']; ?>"
                    alt="<?php echo $product['product_name']; ?>" class="hover-image">
            <?php } ?>
        </div>

        <!-- ข้อมูลสินค้า -->
        <div class="product-info">
            <h2 class="product-title"><?php echo $product['product_name']; ?></h2>
            <p class="product-description"><?php echo $product['product_description']; ?></p>

            <!-- แสดงราคา -->
            <div class="product-price">
                <?php
                if (!empty($product['discounted_price']) && $product['discounted_price'] < $product['product_price']) {
                    // ถ้ามีราคาที่ลดแล้วให้แสดงราคาเดิมขีดฆ่า + ราคาที่ลดแล้ว
                ?>
                    <span class="original-price"><s>฿<?php echo number_format($product['product_price'], 2); ?></s></span>
                    <span class="discount-price">฿<?php echo number_format($product['discounted_price'], 2); ?></span>
                <?php } else { ?>
                    <span class="discount-price">฿<?php echo number_format($product['product_price'], 2); ?></span>
                <?php } ?>
            </div>





            <!-- ปุ่มแก้ไข (เฉพาะ Admin) -->
            <?php if ($_SESSION['user_type'] == 'admin') { ?>
                <button class="edit-button" onclick="openModal()">แก้ไขสินค้า</button>
            <?php } ?>
            <!-- ปุ่มเปิด modal จัดโปรโมชั่นเฉพาะผู้ใช้ที่เป็น admin -->
            <?php if ($_SESSION['user_type'] == 'admin'): ?>
                <button class="Promotion-button" onclick="openPromotionModal()">จัดโปรโมชั่น</button>
            <?php endif; ?>
            <!-- Modal แก้ไขสินค้า -->
            <center>
                <!-- Modal แก้ไขสินค้า -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>แก้ไขสินค้า</h2>
                        <form action="../process/update_product.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                            <label>ชื่อสินค้า:</label>
                            <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>

                            <label>รายละเอียด:</label>
                            <textarea name="product_description"><?php echo $product['product_description']; ?></textarea>

                            <label>รายละเอียดเพิ่มเติม:</label>
                            <textarea name="product_additional_info"><?php echo $product['product_additional_info']; ?></textarea>

                            <label>ราคาเดิม:</label>
                            <input type="text" name="product_price" value="<?php echo $product['product_price']; ?>">

                            <!-- รูปภาพปกติ -->
                            <label>อัปโหลดรูปภาพ:</label>
                            <input type="file" name="product_image">
                            <?php if (!empty($product['product_image'])): ?>
                                <div>
                                    <label>รูปภาพปัจจุบัน:</label>
                                    <img src="../assets/image/<?php echo $product['product_image']; ?>" alt="Product Image" width="100" height="100">
                                    <input type="hidden" name="current_image" value="<?php echo $product['product_image']; ?>">
                                </div>
                            <?php endif; ?>

                            <!-- รูปภาพ Hover -->
                            <label>อัปโหลดรูปภาพ hover:</label>
                            <input type="file" name="product_image_hover">
                            <?php if (!empty($product['product_image_hover'])): ?>
                                <div>
                                    <label>รูปภาพ hover ปัจจุบัน:</label>
                                    <img src="../assets/image/<?php echo $product['product_image_hover']; ?>" alt="Product Hover Image" width="100" height="100">
                                    <input type="hidden" name="current_image_hover" value="<?php echo $product['product_image_hover']; ?>">
                                </div>
                            <?php endif; ?>

                            <button type="submit">บันทึก</button>
                        </form>
                    </div>
                </div>


                <!-- Modal จัดโปรโมชั่น -->
                <div id="promotionModal" class="promotion-modal">
                    <div class="promotion-modal-content">
                        <span class="promotion-close" onclick="closePromotionModal()">&times;</span>
                        <h2>จัดโปรโมชั่น</h2>
                        <form action="../process/update_promotion.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                            <label>ราคาเดิม:</label>
                            <input type="number" id="original_price_promotion" name="original_price" required
                                onchange="calculateDiscountAndPercentage()" class="originalpromotion-input"
                                value="<?php echo $product['product_price']; ?>" readonly>

                            <label>ราคาที่ลดแล้ว:</label>
                            <input type="number" id="discounted_price" name="discounted_price" required
                                onchange="calculateDiscountAndPercentage()" class="promotion-input">

                            <label>เปอร์เซ็นต์ส่วนลด:</label>
                            <div id="discount_percentage" class="discount-value">0%</div>

                            <button type="submit" class="button-save-promotion">บันทึกโปรโมชั่น</button>
                        </form>
                    </div>
                </div>
            </center>

            <label for="productSize">เลือกจำนวน:</label>
            <div class="quantityproduct-control">
                <button type="button" id="decreaseQuantity" class="quantity-btn">-</button>
                <input type="number" id="productQuantity" name="quantity" value="1" min="1" step="1" class="quantity-input">
                <button type="button" id="increaseQuantity" class="quantity-btn">+</button>
            </div>

            <!-- แสดงจำนวนสินค้าคงเหลือ -->
            <div class="product-stock <?php echo ($product['product_stock'] <= 5) ? 'low-stock' : ''; ?>"
                id="productStock" data-stock="<?php echo $product['product_stock']; ?>">
                <?php if ($product['product_stock'] > 0): ?>
                    <span>เหลือสินค้า <?php echo $product['product_stock']; ?> ชิ้น</span>
                <?php else: ?>
                    <span class="out-of-stock">สินค้าหมด</span>
                <?php endif; ?>
            </div>


            <!-- ปุ่มเพิ่มลงตะกร้า -->
                
                <button class="btn-add-to-cart-product" data-product-name="<?= $product['product_name']; ?>"
                data-product-id="<?= $product['product_id']; ?>" data-product-stock="<?php echo $product['product_stock']; ?>"
                data-is-logged-in="<?= $is_logged_in ? '1' : '0' ?>">เพิ่มลงตะกร้า</button>


            <!-- ข้อมูลเพิ่มเติม -->
            <div class="product-additional-info">
                <h3>ข้อมูลเพิ่มเติม</h3>
                <p><?php echo $product['product_additional_info']; ?></p>
            </div>

            <!-- รีวิวสินค้า -->

        </div>
    </div>

    <script src="../assets/js/product-Detail.js"></script>
    <?php include('../includes/footer.php'); ?>

</body>

</html>