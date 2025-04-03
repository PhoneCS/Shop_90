<?php 
include('../includes/header.php'); // รวมส่วนหัว

// ตรวจสอบว่า user_id อยู่ใน session หรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session

    // ดึงข้อมูลสินค้าที่อยู่ในตะกร้าของผู้ใช้ โดยใช้ JOIN กับตาราง product และเลือกสินค้าที่มีสถานะ 'y' ในตาราง cart
    $query = "SELECT c.*, p.product_name, p.product_description, p.product_image, p.product_price 
              FROM cart c
              JOIN products p ON c.product_id = p.product_id
              WHERE c.user_id = '$user_id' AND c.status = 'y'"; 

    $result = mysqli_query($conn, $query);

    // ตรวจสอบข้อผิดพลาดในคำสั่ง SQL
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // ตรวจสอบว่าได้ข้อมูลสินค้าหรือไม่
    if (mysqli_num_rows($result) > 0) {
        // เตรียมข้อมูลสินค้าที่จะส่งไปยังหน้าชำระเงิน
        $cart_items = [];
        $total_price = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row; // เก็บข้อมูลสินค้า
            $total_price += $row['quantity'] * $row['product_price']; // คำนวณยอดรวม
        }
?>

<!-- Cart Section -->
<section class="cart-section container">
    <h2 class="section-title">ตะกร้าสินค้าของคุณ</h2>

    <!-- ตะกร้าสินค้า -->
    <div class="cart-items">
        <?php 
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $product_description = $item['product_description'];
            $quantity = $item['quantity'];
            $price = $item['product_price'];
            $image = $item['product_image']; // ใช้ภาพจากตาราง product
        ?>
            <div class="cart-item" data-product-id="<?php echo $product_id; ?>" data-price="<?php echo $price; ?>">
                <img src="../assets/image/<?php echo $image; ?>" alt="Product Image">
                <div class="cart-item-details">
                    <h4><?php echo $product_name; ?></h4>
                    <p><?php echo $product_description; ?></p>
                    <div class="quantity-control">
                        <button class="quantity-btn decrease" onclick="updateQuantity('decrease', <?php echo $product_id; ?>)">-</button>
                        <input type="number" id="quantity-<?php echo $product_id; ?>" class="quantity-input" value="<?php echo $quantity; ?>" readonly>
                        <button class="quantity-btn increase" onclick="updateQuantity('increase', <?php echo $product_id; ?>)">+</button>
                    </div>
                    <p class="price" id="price-<?php echo $product_id; ?>">฿ <?php echo number_format($price, 2); ?></p>
                    <button class="remove-item" onclick="removeItem(<?php echo $product_id; ?>)">ลบ</button>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- สรุปยอด -->
    <div class="cart-summary">
        <h3>สรุปยอด</h3>
        <p>ยอดรวม: <span id="total-price">฿ <?php echo number_format($total_price, 2); ?></span></p> <!-- ยอดรวม -->
        <a href="../page/checkout.php?total_price=<?php echo $total_price; ?>" class="btn btn-primary">ไปที่การชำระเงิน</a>
    </div>
</section>

<?php 
    } else {
        echo "<p>ไม่มีสินค้าที่อยู่ในตะกร้า</p>";
    }
} else {
    echo "<p>กรุณาล็อกอินเพื่อดูตะกร้าสินค้า</p>";
}
include('../includes/footer.php'); // รวมส่วนท้าย
?>
