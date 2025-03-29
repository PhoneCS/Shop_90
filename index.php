<?php
include('./includes/headerIndex.php');

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// ดึงข้อมูลหมวดหมู่จากฐานข้อมูล
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);

?>

<section class="hero-banner">
    <div class="hero-banner-images">
        <!-- เพิ่มรูปภาพเพื่อให้มีภาพซ้ำ -->
        <div class="hero-banner-slide" style="background-image: url('./assets/image/back1.jpg');"></div>

    </div>

    <div class="hero-content">
        <!-- <h1>Shop 90 มาช้อปกันเลย!</h1>
        <p>พบกับสินค้าคุณภาพดีราคาเพียง 90 บาท พร้อมโปรโมชั่นสุดพิเศษ</p> -->
        <a href="./page/products.php" class="btn">ช้อปเลย</a>
    </div>
</section>



<section class="featured-products container">
    <h2 class="section-title">สินค้าแนะนำ</h2>

    <div class="products-grid">
        <?php while ($row = $result->fetch_assoc()) { 
            // คำนวณส่วนลด (ถ้ามี original_price)
            if (!empty($row['original_price'])) {
                $product_discount = round((($row['product_price'] - $row['original_price']) / $row['product_price']) * 100, 2);
            } else {
                $product_discount = 0;
            }
        ?>
        <div class="product-card">
            <a class="textProduct" href="./page/product-details.php?product_id=<?= $row['product_id']; ?>">
            <div class="product-img">
    <img src="./assets/image/<?= $row['product_image']; ?>" alt="<?= $row['product_name']; ?>">
    
    <?php if (!empty($row['product_image_hover'])) { ?>
        <img src="./assets/image/<?= $row['product_image_hover']; ?>" alt="<?= $row['product_name']; ?>" class="hover-image">
    <?php } ?>

    <?php if (!empty($row['original_price'])) { ?>
        <!-- แสดงแทบส่วนลดบนรูปภาพ -->
        <div class="discount-tag">ลด <?= $product_discount; ?>%</div>
    <?php } ?>
</div>

<div class="product-info">
    <h3 class="product-title"><?= $row['product_name']; ?></h3>
    <div class="product-price">
        <?php if (!empty($row['original_price'])) { ?>
            <!-- แสดงราคาที่ลด -->
            <span class="original-price"><s>฿<?= number_format($row['product_price'], 2); ?></s></span> <!-- ราคาเดิม -->
            <span class="discount-price">฿<?= number_format($row['original_price'], 2); ?></span> <!-- ราคาที่ลด -->
        <?php } else { ?>
            <!-- ถ้าไม่มีราคาที่ลด แสดงราคาเดิม -->
            <span class="discount-price">฿<?= number_format($row['product_price'], 2); ?></span>
        <?php } ?>
    </div>



                    <div class="product-rating">
                        <?php
                            $rating = round($row['product_rating']);
                            for ($i = 0; $i < 5; $i++) {
                                echo $i < $rating ? '<i class="fas fa-star"></i> ' : '<i class="far fa-star"></i> ';
                            }
                            ?>
                    </div>
                </div>
            </a>
            <button class="btn-add-to-cart-product" data-product-name="<?= $row['product_name']; ?>"
                data-product-id="<?= $row['product_id']; ?>">เพิ่มลงตะกร้า</button>

        </div>
        <?php } ?>
    </div>

    <div class="text-center">
        <a href="./page/products.php" class="btn btn-secondary">ดูสินค้าทั้งหมด</a>
    </div>
</section>





<!-- Categories -->
<section class="categories container">
    <h2 class="section-title">หมวดหมู่สินค้า</h2>
    <div class="category-cards">
        <?php while ($category = $result_categories->fetch_assoc()) { ?>
        <div class="category-card">
            <img src="./assets/image/<?= $category['category_image']; ?>" alt="<?= $category['category_name']; ?>">
            <div class="category-card-content">
                <h3><?= $category['category_name']; ?></h3>
            </div>
        </div>
        <?php } ?>
    </div>
</section>


<!-- Promotions -->
<section class="promotions container">
    <h2 class="section-title">โปรโมชั่นพิเศษ</h2>

    <div class="promo-cards">
        <!-- Promo 1 -->
        <div class="promo-card">
            <div class="promo-img">
                <img src="/api/placeholder/300/200" alt="โปรโมชั่น 1">
            </div>
            <div class="promo-content">
                <h3 class="promo-title">ซื้อ 1 แถม 1</h3>
                <p class="promo-description">เมื่อซื้อสินค้าในหมวดเครื่องเขียน รับฟรีทันทีสินค้าชิ้นที่ 2
                    มูลค่าเท่ากันหรือน้อยกว่า</p>
                <a href="./page/promotions.php" class="btn">ดูรายละเอียด</a>
            </div>
        </div>

        <!-- Promo 2 -->
        <div class="promo-card">
            <div class="promo-img">
                <img src="/api/placeholder/300/200" alt="โปรโมชั่น 2">
            </div>
            <div class="promo-content">
                <h3 class="promo-title">ลด 50% สำหรับสมาชิกใหม่</h3>
                <p class="promo-description">สมัครสมาชิกวันนี้ รับส่วนลด 50% สำหรับการสั่งซื้อครั้งแรก (สูงสุด 100 บาท)
                </p>
                <a href="./auth/register.php" class="btn">สมัครสมาชิก</a>
            </div>
        </div>
    </div>
</section>

<?php
include('./includes/footerIndex.php');
?>

</body>

</html>