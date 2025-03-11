<?php
include('../includes/header.php');
?>
<section class="product-section">
    <h2>สินค้าทั้งหมด</h2>
    <div class="products-grid">
        <!-- Product 1 -->
        <div class="product-card">
            <a href="product-details.php?product_id=1" class="product-link">
                <div class="product-img">
                    <img src="../assets/image/product3.jpg" alt="เสื้อยืดลายกราฟิก">
                    <img src="../assets/image/product3_hover.jpg" alt="เสื้อยืดลายกราฟิก" class="hover-image">
                </div>
                <div class="product-info">
                    <h3 class="product-title">เสื้อยืดลายกราฟิก</h3>
                    <div class="product-price">
                        <span class="original-price">฿120</span> <span class="discount-price">฿90</span>
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i> <i class="far fa-star"></i>
                    </div>
                </div>
            </a>

            <button class="btn-add-to-cart-product" data-product-name="เสื้อยืดลายกราฟิก"
                data-product-id="1">เพิ่มลงตะกร้า</button>
        </div>





        <!-- Product 2 -->
        <div class="product-card">
            <a href="product-details.php?product_id=2" class="product-link">
                <div class="product-img">
                    <img src="../assets/image/product4.jpg" alt="เสื้อยืดลายกราฟิก">
                    <img src="../assets/image/product4_hover.jpeg" alt="เสื้อยืดลายกราฟิก" class="hover-image">
                </div>
                <div class="product-info">
                    <h3 class="product-title">กระเป๋า</h3>
                    <div class="product-price">
                        <span class="original-price">฿120</span> <span class="discount-price">฿90</span>
                    </div>
                    <div class="product-rating">
                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i> <i class="far fa-star"></i>
                    </div>
                </div>
            </a>

            <button class="btn-add-to-cart-product" data-product-name="เสื้อยืดลายกราฟิก"
                data-product-id="1">เพิ่มลงตะกร้า</button>
        </div>
</section>

<?php
include('../includes/footer.php');
?>