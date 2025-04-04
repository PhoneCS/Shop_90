<?php
include('../includes/header.php');

// ดึงข้อมูลสินค้าจากฐานข้อมูล พร้อมเช็คส่วนลด
$sql = "SELECT p.*, d.discounted_price 
        FROM products p
        LEFT JOIN product_discounts d ON p.product_id = d.product_id";

$result = $conn->query($sql);
?>

<section class="product-section">
    <h2>สินค้าทั้งหมด</h2>
    <div class="products-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // ใช้ discounted_price ถ้ามี ถ้าไม่มีใช้ product_price
                $final_price = isset($row['discounted_price']) ? $row['discounted_price'] : $row['product_price'];

                // คำนวณเปอร์เซ็นต์ส่วนลด ถ้ามี
                $product_discount = (isset($row['discounted_price']) && $row['discounted_price'] < $row['product_price']) 
                                    ? (($row['product_price'] - $row['discounted_price']) / $row['product_price']) * 100 
                                    : 0;
        ?>
        <div class="product-card">
            <a href="../page/product-details.php?product_id=<?= $row['product_id']; ?>" class="product-link">
                <div class="product-img">
                    <img src="../assets/image/<?= $row['product_image']; ?>" alt="<?= $row['product_name']; ?>">
                    <?php if (!empty($row['product_image_hover'])) { ?>
                        <img src="../assets/image/<?= $row['product_image_hover']; ?>" alt="<?= $row['product_name']; ?>" class="hover-image">
                    <?php } ?>

                    <?php if ($product_discount > 0) { ?>
                        <div class="discount-tag">ลด <?= number_format($product_discount, 0); ?>%</div>
                    <?php } ?>
                </div>

                <div class="product-info">
                    <h3 class="product-title"><?= $row['product_name']; ?></h3>
                    <div class="product-price">
                        <?php if ($product_discount > 0) { ?>
                            <span class="original-price"><s>฿<?= number_format($row['product_price'], 2); ?></s></span>
                            <span class="discount-price">฿<?= number_format($final_price, 2); ?></span>
                        <?php } else { ?>
                            <span class="discount-price">฿<?= number_format($final_price, 2); ?></span>
                        <?php } ?>
                    </div>

                    <div class="product-rating">
                        <?php
                        $rating = round($row['product_rating']);
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                </div>
            </a>

            <!-- ปุ่มเพิ่มสินค้าลงตะกร้า -->
            <button class="btn-add-to-cart-product" 
                data-product-name="<?= $row['product_name']; ?>" 
                data-product-id="<?= $row['product_id']; ?>"
                data-product-stock="1">เพิ่มลงตะกร้า</button>
        </div>
        <?php
            }
        } else {
            echo "ไม่พบสินค้าภายในระบบ";
        }
        ?>
    </div>
</section>

<?php
include('../includes/footer.php');
?>
