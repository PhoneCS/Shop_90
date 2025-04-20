<?php
include('../includes/header.php');  // รวมไฟล์เชื่อมต่อฐานข้อมูล
$is_logged_in = isset($_SESSION['user_id']);  // ตรวจสอบว่า user ได้ล็อกอินแล้วหรือยัง
// ดึงข้อมูลสินค้าที่มีโปรโมชั่น
$sql = "SELECT p.*, d.discounted_price 
        FROM products p
        LEFT JOIN product_discounts d ON p.product_id = d.product_id
        WHERE d.discounted_price IS NOT NULL"; // ดึงเฉพาะสินค้าที่มีส่วนลด

$result = $conn->query($sql);

// เช็คว่ามีสินค้าที่ดึงมาหรือไม่
if ($result->num_rows > 0) {
    echo '<section class="promotions container">';
    echo '<h2 class="section-title">โปรโมชั่นพิเศษ</h2>';
    echo '<div class="products-grid">'; // เริ่มการจัดสินค้าใน grid

    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $discounted_price = isset($row['discounted_price']) ? $row['discounted_price'] : $product_price;
        $product_image = $row['product_image'];
        $product_image_hover = isset($row['product_image_hover']) ? $row['product_image_hover'] : 'default-hover-image.jpg';
        $product_rating = $row['product_rating'];

        // คำนวณเปอร์เซ็นต์ส่วนลด
        $discount_percentage = ($product_price > $discounted_price) 
            ? (($product_price - $discounted_price) / $product_price) * 100 
            : 0;
        ?>

        <div class="product-card">
            <a href="../page/product-details.php?product_id=<?= $product_id; ?>" class="product-link">
                <div class="product-img">
                    <img src="../assets/image/<?= $product_image; ?>" alt="<?= $product_name; ?>">
                    <img src="../assets/image/<?= $product_image_hover; ?>" alt="<?= $product_name; ?>" class="hover-image">
                    
                    <?php if ($discount_percentage > 0) { ?>
                        <div class="discount-tag">ลด <?= number_format($discount_percentage, 0); ?>%</div>
                    <?php } ?>
                </div>

                <div class="product-info">
                    <h3 class="product-title"><?= $product_name; ?></h3>
                    <div class="product-price">
                        <?php if ($discount_percentage > 0) { ?>
                            <span class="original-price"><s>฿<?= number_format($product_price, 2); ?></s></span>
                            <span class="discount-price">฿<?= number_format($discounted_price, 2); ?></span>
                        <?php } else { ?>
                            <span class="discount-price">฿<?= number_format($product_price, 2); ?></span>
                        <?php } ?>
                    </div>

                    <div class="product-rating">
                        <?php
                        $rating = $product_rating;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($rating >= $i) {
                                echo '<i class="fas fa-star"></i>'; // เต็มดาว
                            } elseif ($rating >= $i - 0.5) {
                                echo '<i class="fas fa-star-half-alt"></i>'; // ครึ่งดาว
                            } else {
                                echo '<i class="far fa-star"></i>'; // ว่าง
                            }
                        }
                        ?>
                    </div>
                </div>
            </a>
            <button class="btn-add-to-cart-product" 
                data-product-name="<?= $row['product_name']; ?>" 
                data-product-id="<?= $row['product_id']; ?>"
                data-product-stock="1"
                data-is-logged-in="<?= $is_logged_in ? '1' : '0' ?>">เพิ่มลงตะกร้า</button>
        </div>

        <?php
    }
    echo '</div>'; // จบ grid ของสินค้า
    echo '</section>';
} else {
    echo "<p class='no-product'>ไม่พบสินค้าที่มีโปรโมชั่น</p>";
}

$conn->close();
?>

<?php
include('../includes/footer.php');
?>
