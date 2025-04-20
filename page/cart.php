<?php 
include('../includes/header.php'); // รวมส่วนหัว
if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเข้าสู่ระบบ',
            text: 'คุณต้องเข้าสู่ระบบก่อนเข้าถึงหน้านี้',
            confirmButtonText: 'เข้าสู่ระบบ'
        }).then(() => {
            window.location.href = '../auth/login.php';
        });
    </script>";
    exit();
}

// ตรวจสอบว่า user_id อยู่ใน session หรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // ดึง user_id จาก session

    // ดึงข้อมูลสินค้าจาก cart และ products และ product_discounts (LEFT JOIN)
    $query = "SELECT 
                c.*, 
                p.product_name, 
                p.product_description, 
                p.product_image, 
                p.product_price, 
                d.discounted_price 
              FROM cart c
              JOIN products p ON c.product_id = p.product_id
              LEFT JOIN product_discounts d ON c.product_id = d.product_id
              WHERE c.user_id = '$user_id'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $cart_items = [];
        $total_price = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            // ถ้ามีราคาส่วนลด ใช้ discounted_price แทน product_price
            $final_price = isset($row['discounted_price']) && $row['discounted_price'] !== null
                ? $row['discounted_price']
                : $row['product_price'];

            $row['final_price'] = $final_price;

            $cart_items[] = $row;
            $total_price += $row['quantity'] * $final_price;
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
            $price = $item['final_price'];
            $image = $item['product_image'];
        ?>
        <div class="cart-item" data-product-id="<?php echo $product_id; ?>" data-price="<?php echo $price; ?>">
            <img src="../assets/image/<?php echo $image; ?>" alt="Product Image">
            <div class="cart-item-details">
                <h4><?php echo $product_name; ?></h4>
                <p><?php echo $product_description; ?></p>
                <div class="quantity-control">
                    <button class="quantity-btn decrease"
                        onclick="updateQuantity('decrease', <?php echo $product_id; ?>)">-</button>
                    <input type="number" id="quantity-<?php echo $product_id; ?>" class="quantity-input"
                        value="<?php echo $quantity; ?>" readonly>
                    <button class="quantity-btn increase"
                        onclick="updateQuantity('increase', <?php echo $product_id; ?>)">+</button>
                </div>

                <p class="price" id="price-<?php echo $product_id; ?>">
                    ฿ <?php echo number_format($price, 2); ?>
                    <?php if (isset($item['discounted_price']) && $item['discounted_price'] !== null): ?>
                    <span style="text-decoration: line-through; color: #888; font-size: 0.9em;">
                        ฿ <?php echo number_format($item['product_price'], 2); ?>
                    </span>
                    <?php endif; ?>
                </p>
                <button class="remove-item" onclick="removeItem(<?php echo $product_id; ?>)">ลบ</button>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- สรุปยอด -->
    <div class="cart-summary">
        <h3>สรุปยอด</h3>
        <p>ยอดรวม: <span id="total-price">฿ <?php echo number_format($total_price, 2); ?></span></p>


        <a href="../page/checkout.php?total_price=<?php echo $total_price; ?>"
            class="btn btn-primary">ไปที่การชำระเงิน</a>
    </div>
</section>

<?php 
   } else {
    echo '
    <div style="text-align: center; margin-top: 50px;">
        <img src="../assets/image/cart.png" alt="ไม่มีสินค้าในตะกร้า" style="max-width: 1000px; height: auto;">
        <p style="font-size: 18px; margin-top: 20px; color: red;">ไม่มีสินค้าที่อยู่ในตะกร้า</p>
    </div>';
}

} else {
    echo "<p>กรุณาล็อกอินเพื่อดูตะกร้าสินค้า</p>";
}
include('../includes/footer.php'); // รวมส่วนท้าย
?>