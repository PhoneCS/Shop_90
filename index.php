<?php
include('./includes/headerIndex.php');

// ดึงข้อมูลสินค้าทั่วไป
$sql = "SELECT p.*, d.discounted_price, 
               (SELECT AVG(rating) FROM product_ratings r WHERE r.product_id = p.product_id) AS avg_rating
        FROM products p
        LEFT JOIN product_discounts d ON p.product_id = d.product_id";
$result = $conn->query($sql);

// ดึงข้อมูลสินค้าลดราคา
$sql_discounted = "SELECT p.*, d.discounted_price, 
                           (SELECT AVG(rating) FROM product_ratings r WHERE r.product_id = p.product_id) AS avg_rating
                   FROM products p
                   INNER JOIN product_discounts d ON p.product_id = d.product_id";
$result_discounted = $conn->query($sql_discounted);

// ดึงข้อมูลหมวดหมู่
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);
?>

<section class="hero-banner">
    <div class="hero-banner-images">
        <div class="hero-banner-slide" style="background-image: url('./assets/image/back1.jpg');"></div>
    </div>
    <div class="hero-content">
        <a href="./page/products.php" class="btn">ช้อปเลย</a>
    </div>
</section>

<section class="featured-products container">
    <h2 class="section-title">สินค้าแนะนำ</h2>
    <div class="products-grid">
        <?php while ($row = $result->fetch_assoc()) { 
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_price = $row['product_price'];
            $discounted_price = isset($row['discounted_price']) ? $row['discounted_price'] : $product_price;
            $product_image = $row['product_image'];
            $product_image_hover = $row['product_image_hover'] ?? 'default-hover-image.jpg';
            $product_rating = round($row['avg_rating'], 2); // สมมุติว่าใช้ AVG จาก SQL
            $rounded_rating = round($product_rating, 0, PHP_ROUND_HALF_UP);

            $discount_percentage = ($product_price > $discounted_price) 
                ? (($product_price - $discounted_price) / $product_price) * 100 
                : 0;
        ?>
        <div class="product-card">
            <a class="textProduct" href="./page/product-details.php?product_id=<?= $product_id; ?>">
                <div class="product-img">
                    <img src="./assets/image/<?= $product_image; ?>" alt="<?= $product_name; ?>">
                    <img src="./assets/image/<?= $product_image_hover; ?>" alt="<?= $product_name; ?>"
                        class="hover-image">
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
                        $rating = $row['product_rating'];
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
            <button class="btn-add-to-cart-product" data-product-name="<?= $product_name; ?>"
                data-product-id="<?= $product_id; ?>">เพิ่มลงตะกร้า</button>
        </div>
        <?php } ?>
    </div>
    <div class="text-center">
        <a href="./page/products.php" class="btn btn-secondary">ดูสินค้าทั้งหมด</a>
    </div>
</section>

<!-- สินค้าที่ลดราคา -->
<section class="discounted-products container">
    <h2 class="section-title">สินค้าลดราคา</h2>
    <div class="products-grid">
        <?php while ($row = $result_discounted->fetch_assoc()) { 
            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $product_price = $row['product_price'];
            $discounted_price = $row['discounted_price'];
            $product_image = $row['product_image'];
            $product_image_hover = $row['product_image_hover'] ?? 'default-hover-image.jpg';
            $product_rating = $row['product_rating'];

            $discount_percentage = (($product_price - $discounted_price) / $product_price) * 100;
        ?>
        <div class="product-card">
            <a class="textProduct" href="./page/product-details.php?product_id=<?= $product_id; ?>">
                <div class="product-img">
                    <img src="./assets/image/<?= $product_image; ?>" alt="<?= $product_name; ?>">
                    <img src="./assets/image/<?= $product_image_hover; ?>" alt="<?= $product_name; ?>"
                        class="hover-image">
                    <div class="discount-tag">ลด <?= number_format($discount_percentage, 0); ?>%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-title"><?= $product_name; ?></h3>
                    <div class="product-price">
                        <span class="original-price"><s>฿<?= number_format($product_price, 2); ?></s></span>
                        <span class="discount-price">฿<?= number_format($discounted_price, 2); ?></span>
                    </div>
                    <div class="product-rating">
                        <?php
                            $rating = $row['product_rating'];
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
            <button class="btn-add-to-cart-product" data-product-name="<?= $product_name; ?>"
                data-product-id="<?= $product_id; ?>">เพิ่มลงตะกร้า</button>
        </div>
        <?php } ?>
    </div>
</section>

<!-- หมวดหมู่สินค้า -->
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

<?php
include('./includes/footerIndex.php');
?>