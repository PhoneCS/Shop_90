<?php
include('./includes/headerIndex.php');
?>
<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-content">
        <h1>Shop 90 มาช้อปกันเลย!</h1>
        <p>พบกับสินค้าคุณภาพดีราคาเพียง 90 บาท พร้อมโปรโมชั่นสุดพิเศษ</p>
        <a href="./page/products.php" class="btn">ช้อปเลย</a>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products container">
    <h2 class="section-title">สินค้าแนะนำ</h2>

    <div class="products-grid">
        <!-- Product 1 -->
        <div class="product-card">
            <a href="./page/product-details.php?product_id=1">
                <div class="product-img">
                    <img src="./assets/image/product3.jpg" alt="เสื้อยืดลายกราฟิก">
                    <img src="./assets/image/product3_hover.jpg" alt="เสื้อยืดลายกราฟิก" class="hover-image">
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
            <a href="./page/product-details.php?product_id=1">
                <div class="product-img">
                    <img src="./assets/image/product4.jpg" alt="กระเป๋า">
                    <img src="./assets/image/product4_hover.jpeg" alt="กระเป๋า" class="hover-image">
                </div>
                <div class="product-info">
                    <h3 class="product-title">กระเป๋า</h3>
                    <div class="product-price">
                        <span class="original-price">฿200</span> <span class="discount-price">฿150</span>
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

        <!-- Product 3 -->
        <div class="product-card">
            <div class="product-img">
                <img src="/api/placeholder/300/300" alt="สินค้า 3">
            </div>
            <div class="product-info">
                <h3 class="product-title">กระเป๋าผ้าลายสัตว์</h3>
                <div class="product-price">
                    <span class="original-price">110 บาท</span>
                    90 บาท
                </div>
                <div class="product-rating">★★★★☆</div>
                <a href="#" class="btn-add-to-cart-product" data-product-id="3"
                    data-product-name="กระเป๋าผ้าลายสัตว์">เพิ่มลงตะกร้า</a>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="product-card">
            <div class="product-img">
                <img src="/api/placeholder/300/300" alt="สินค้า 4">
            </div>
            <div class="product-info">
                <h3 class="product-title">สายชาร์จโทรศัพท์</h3>
                <div class="product-price">90 บาท</div>
                <div class="product-rating">★★★★☆</div>
                <a href="#" class="btn-add-to-cart-product" data-product-id="4"
                    data-product-name="สายชาร์จโทรศัพท์">เพิ่มลงตะกร้า</a>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="./page/products.php" class="btn btn-secondary">ดูสินค้าทั้งหมด</a>
    </div>
</section>

<!-- Categories -->
<section class="categories container">
    <h2 class="section-title">หมวดหมู่สินค้า</h2>

    <div class="category-cards">
        <!-- Category 1 -->
        <div class="category-card">
            <img src="/api/placeholder/300/150" alt="เสื้อผ้า">
            <div class="category-card-content">
                <h3>เสื้อผ้า</h3>
            </div>
        </div>

        <!-- Category 2 -->
        <div class="category-card">
            <img src="./assets/image/product1.jpg" alt="อุปกรณ์ไอที">
            <div class="category-card-content">
                <h3>อุปกรณ์ไอที</h3>
            </div>
        </div>

        <!-- Category 3 -->
        <div class="category-card">
            <img src="./assets/image/product1.jpg" alt="ของใช้ในบ้าน">
            <div class="category-card-content">
                <h3>ของใช้ในบ้าน</h3>
            </div>
        </div>

        <!-- Category 4 -->
        <div class="category-card">
            <img src="/api/placeholder/300/150" alt="เครื่องสำอาง">
            <div class="category-card-content">
                <h3>เครื่องสำอาง</h3>
            </div>
        </div>
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