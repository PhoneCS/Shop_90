<?php
include('../includes/header.php');  // รวมไฟล์เชื่อมต่อฐานข้อมูล

// คำสั่ง SQL สำหรับดึงข้อมูลสินค้า
$sql = "SELECT * FROM products WHERE product_discount>0 "; // เลือกสินค้าทั้งหมด
$result = $conn->query($sql);

// เช็คว่ามีสินค้าที่ดึงมาหรือไม่
if ($result->num_rows > 0) {
    echo '<section class="promotions container">';
    echo '<h2 class="section-title">โปรโมชั่นพิเศษ</h2>';
    echo '<div class="products-grid">'; // เริ่มการจัดสินค้าใน grid

    while($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_discount = $row['product_discount']; // ส่วนลด
        $product_image = $row['product_image']; // รูปภาพสินค้า
        $product_image_hover = isset($row['product_image_hover']) ? $row['product_image_hover'] : 'default-hover-image.jpg'; // ตรวจสอบว่ามี hover image หรือไม่
        $product_rating = $row['product_rating']; // คะแนนรีวิว
        ?>

<div class="product-card">
    <a href="../page/product-details.php?product_id=<?php echo $product_id; ?>" class="product-link">
        <div class="product-img">
            <img src="../assets/image/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>">
            <img src="../assets/image/<?php echo $product_image_hover; ?>" alt="<?php echo $product_name; ?>"
                class="hover-image">
            <div class="discount-tag">ลด <?php echo $product_discount; ?>%</div>
        </div>

        <div class="product-info">
            <h3 class="product-title"><?php echo $product_name; ?></h3>
            <div class="product-price">
                <span class="original-price">฿<?php echo $product_price; ?></span>
                <span
                    class="discount-price">฿<?php echo $product_price - ($product_price * $product_discount / 100); ?></span>
            </div>
            <div class="product-rating">
                <?php
                        // การแสดงดาวรีวิว
                        for ($i = 0; $i < $product_rating; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        for ($i = $product_rating; $i < 5; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
            </div>
        </div>
    </a>
    <button class="btn-add-to-cart-product" data-product-name="<?php echo $product_name; ?>"
        data-product-id="<?php echo $product_id; ?>">เพิ่มลงตะกร้า</button>
</div>

<?php
    }
    echo '</div>'; // จบ grid ของสินค้า
    echo '</section>';
} else {
    echo "ไม่พบสินค้าที่มีในระบบ";
}

$conn->close();
?>
<?php
include('../includes/footer.php');
?>