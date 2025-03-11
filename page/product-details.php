<?php
include('../includes/header.php');

// รับ product_id จาก URL
$product_id = $_GET['product_id'];

// สมมติว่าเราใช้ฐานข้อมูลเพื่อดึงข้อมูลสินค้า
// ตัวอย่างการดึงข้อมูลสินค้า
// ในที่นี้ใช้ข้อมูลจำลอง
$product_details = [
    1 => [
        'name' => 'เสื้อยืดลายกราฟิก',
        'price' => '฿90',
        'original_price' => '฿120',
        'description' => 'เสื้อยืดลายกราฟิกสีขาว มีลายพิมพ์ด้านหน้า',
        'size' => ['S', 'M', 'L'],
        'reviews' => [
            'ดีมาก!',
            'ใช้ดี สวยมาก!',
            'คุณภาพคุ้มราคา'
        ],
        'additional_info' => 'วัสดุ: ผ้าฝ้าย 100% เนื้อผ้านุ่ม ใส่สบาย',
        'care_instructions' => 'วิธีการดูแล: ซักมือ, ไม่ใช้สารฟอกขาว'
    ],
    // ข้อมูลสินค้าตัวอื่นๆ สามารถใส่เพิ่มได้ที่นี่
    2 => [
        'name' => 'กระเป๋า',
        'price' => '฿90',
        'original_price' => '฿120',
        'description' => 'กระเป๋าสีขาว มีลายพิมพ์ด้านหน้า',
        'size' => ['S', 'M', 'L'],
        'reviews' => [
            'ดีมาก!',
            'ใช้ดี สวยมาก!',
            'คุณภาพคุ้มราคา'
        ],
        'additional_info' => 'วัสดุ: ผ้าฝ้าย 100% เนื้อผ้านุ่ม ใส่สบาย',
        'care_instructions' => 'วิธีการดูแล: ซักมือ, ไม่ใช้สารฟอกขาว'
    ],
    // ข้อมูลสินค้าตัวอื่นๆ สามารถใส่เพิ่มได้ที่นี่
];

// ดึงข้อมูลสินค้าตาม product_id
$product = $product_details[$product_id] ?? null;

// หากไม่พบสินค้า ให้แสดงข้อความ
if (!$product) {
    echo "ไม่พบสินค้านี้!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดสินค้า - <?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- แสดงรายละเอียดสินค้า -->
    <div class="product-details">

        <!-- รูปสินค้า -->
        <div class="product-img">
            <img src="../assets/image/product3.jpg" alt="เสื้อยืดลายกราฟิก">
            <img src="../assets/image/product3_hover.jpg" alt="เสื้อยืดลายกราฟิก" class="hover-image">
        </div>

        <!-- ข้อมูลสินค้า -->
        <div class="product-info">
            <h2 class="product-title"><?php echo $product['name']; ?></h2>
            <p class="product-description"><?php echo $product['description']; ?></p>

            <!-- แสดงราคา -->
            <div class="product-price">
                <span class="original-price">฿<?php echo $product['original_price']; ?></span>
                <span class="discount-price">฿<?php echo $product['price']; ?></span>
            </div>

            <!-- เลือกขนาด -->
            <label for="productSize">เลือกขนาด:</label>
            <select id="productSize">
                <?php foreach ($product['size'] as $size): ?>
                <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
            <!-- ปุ่มเพิ่มลงตะกร้า -->
            <button class="btn-add-to-cart-product" data-product-name="<?php echo $product['name']; ?>"
                data-product-id="<?php echo $product_id; ?>">เพิ่มลงตะกร้า</button>
            <!-- ข้อมูลเพิ่มเติม -->
            <div class="product-additional-info">
                <h3>ข้อมูลเพิ่มเติม</h3>
                <p><?php echo $product['additional_info']; ?></p>
                <p><strong>วิธีการดูแล:</strong> <?php echo $product['care_instructions']; ?></p>
            </div>
            <!-- รีวิวสินค้า -->
            <div class="product-reviews">
                <h3>รีวิวสินค้า</h3>
                <?php foreach ($product['reviews'] as $review): ?>
                <p><?php echo $review; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>

</html>