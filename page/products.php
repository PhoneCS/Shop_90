<?php
include('../includes/header.php');

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>
<section class="product-section">
    <h2>สินค้าทั้งหมด</h2>
    <div class="products-grid">
        <?php
        // เช็คว่ามีสินค้าจากฐานข้อมูลหรือไม่
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // ตรวจสอบให้ `product_discount` ไม่เกิน 100 และไม่เป็นค่าติดลบ
                $product_discount = ($row['product_discount'] > 0 && $row['product_discount'] <= 100) ? $row['product_discount'] : 0;
                
                // คำนวณราคาหลังส่วนลด
                $discounted_price = $row['product_price'] - ($row['product_price'] * $product_discount / 100);
        ?>
        <div class="product-card">
            <a href="../page/product-details.php?product_id=<?= $row['product_id']; ?>" class="product-link">
                <div class="product-img">
                    <img src="../assets/image/<?= $row['product_image']; ?>" alt="<?= $row['product_name']; ?>">
                    <?php if (!empty($row['product_image_hover'])) { ?>
                        <img src="../assets/image/<?= $row['product_image_hover']; ?>" alt="<?= $row['product_name']; ?>" class="hover-image">
                    <?php } ?>

                    <?php if ($product_discount > 0) { ?>
                        <!-- แสดงแทบส่วนลด -->
                        <div class="discount-tag">ลด <?= number_format($product_discount, 0); ?>%</div>
                    <?php } ?>
                </div>

                <div class="product-info">
                    <h3 class="product-title"><?= $row['product_name']; ?></h3>
                    <div class="product-price">
                        <?php if ($product_discount > 0) { ?>
                            <!-- แสดงราคาเดิมที่ขีดทิ้ง และราคาหลังส่วนลด -->
                            <span class="original-price"><s>฿<?= number_format($row['product_price'], 2); ?></s></span> <!-- ราคาเดิม -->
                            <span class="discount-price">฿<?= number_format($discounted_price, 2); ?></span> <!-- ราคาหลังส่วนลด -->
                        <?php } else { ?>
                            <!-- ถ้าไม่มีส่วนลด แสดงราคาเดิม -->
                            <span class="discount-price">฿<?= number_format($row['product_price'], 2); ?></span>
                        <?php } ?>
                    </div>

                    <div class="product-rating">
                        <?php
                        // การแสดงดาวรีวิว
                        $rating = round($row['product_rating']);
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                </div>
            </a>

            <button class="btn-add-to-cart-product" data-product-name="<?= $row['product_name']; ?>" data-product-id="<?= $row['product_id']; ?>">เพิ่มลงตะกร้า</button>
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
