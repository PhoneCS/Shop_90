<?php
session_start();
include('../includes/header.php');
// ข้อมูลสินค้าเฟก (ชั่วคราว)
$cart_items = [
    1 => ['name' => 'หูฟังไร้สาย', 'price' => 1290, 'quantity' => 1, 'image' => '../assets/image/product5.jpg'],
    2 => ['name' => 'ลำโพงบลูทูธ', 'price' => 2590, 'quantity' => 2, 'image' => 'images/speaker.jpg'],
    3 => ['name' => 'เมาส์เกมมิ่ง', 'price' => 890, 'quantity' => 1, 'image' => 'images/mouse.jpg']
];

// คำนวณราคารวม
$total_price = array_reduce($cart_items, function ($carry, $item) {
    return $carry + ($item['price'] * $item['quantity']);
}, 0);
?>
<body>
<div class="container py-4">
    <h2 class="mb-4 text-center">🛒 ตะกร้าสินค้าของคุณ</h2>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="list-group">
                <?php foreach ($cart_items as $id => $item): ?>
                <div class="list-group-item d-flex align-items-center justify-content-between cart-item" data-id="<?php echo $id; ?>" data-price="<?php echo $item['price']; ?>">
                    <img src="<?php echo $item['image']; ?>" class="cart-img me-3">
                    <div class="flex-grow-1">
                        <h5 class="mb-1"><?php echo $item['name']; ?></h5>
                        <p class="mb-1 text-muted">฿<span class="unit-price"><?php echo number_format($item['price'], 2); ?></span></p>
                        <div class="d-flex align-items-center">
                            <!-- ปุ่มเพิ่มและลดจำนวน -->
                            <button class="btn btn-sm btn-outline-secondary btn-decrease">-</button>
                            <span class="quantity-value"><?php echo $item['quantity']; ?></span>
                            <button class="btn btn-sm btn-outline-secondary btn-increase">+</button>
                        </div>
                    </div>
                    <h5 class="text-success total-price">฿<?php echo number_format($item['price'] * $item['quantity'], 2); ?></h5>
                    <button class="btn btn-danger btn-sm btn-remove"> <i class="fas fa-trash"></i> </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="cart-summary">
                <h4>ยอดรวม</h4>
                <h3 class="text-primary total-price-display">฿<?php echo number_format($total_price, 2); ?></h3>
                <button class="btn btn-success w-100 mt-3 btn-checkout">ดำเนินการชำระเงิน</button>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>


</body>


