<?php
include('../includes/header.php'); 
$user_id = $_SESSION['user_id']; 

$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;

// ดึงข้อมูลสินค้าในตะกร้า พร้อมข้อมูลราคาลดถ้ามี
$query = "
    SELECT c.*, 
           p.product_name, 
           p.product_price, 
           pd.discounted_price 
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    LEFT JOIN product_discounts pd ON p.product_id = pd.product_id
    WHERE c.user_id = '$user_id'";

$result = mysqli_query($conn, $query);
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // บันทึกประวัติการสั่งซื้อ
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = isset($item['discounted_price']) && $item['discounted_price'] !== null 
                    ? $item['discounted_price'] 
                    : $item['product_price'];
        $total = $quantity * $price;

        // บันทึกลงตาราง order_history
        $insert = "INSERT INTO order_history (user_id, product_id, quantity, price, total, shipping_address, phone) 
                   VALUES ('$user_id', '$product_id', '$quantity', '$price', '$total', '$address', '$phone')";
        mysqli_query($conn, $insert);
    }

    // ล้างตะกร้าสินค้า
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

    // แสดง SweetAlert แจ้งเตือนการชำระเงินสำเร็จ
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'ชำระเงินสำเร็จ',
            text: 'ระบบได้บันทึกคำสั่งซื้อของคุณแล้ว',
            confirmButtonText: 'ดูประวัติ',
        }).then(() => {
            window.location.href = '../page/order_history.php'; // ส่งผู้ใช้ไปหน้าประวัติการสั่งซื้อ
        });
    </script>";
}
?>

<section class="checkout-container">
    <div class="shipping-info">
        <h3>ข้อมูลการจัดส่ง</h3>
        <form method="POST" id="shippingForm">
            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>"> <!-- เพิ่ม hidden input -->
            <label>ชื่อ-นามสกุล:</label>
            <input type="text" id="fullName" name="fullName" placeholder="กรอกชื่อ-นามสกุล" required>
            <label>เบอร์โทร:</label>
            <input type="text" id="phone" name="phone" placeholder="กรอกเบอร์โทร" required>
            <label>ที่อยู่:</label>
            <textarea id="address" name="address" placeholder="กรอกที่อยู่" required></textarea>
            <label>เมือง:</label>
            <input type="text" id="city" placeholder="กรอกชื่อเมือง" required>
            <label>รหัสไปรษณีย์:</label>
            <input type="text" id="zipcode" placeholder="กรอกรหัสไปรษณีย์" required>
            <button type="submit" class="btn-payment">ชำระเงิน</button>
        </form>
    </div>

    <div class="order-summary">
        <h2>สรุปคำสั่งซื้อ</h2>
        <table>
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart_items as $item) {
                    // ถ้ามีราคาลด ให้ใช้ discounted_price, ถ้าไม่มี ให้ใช้ product_price
                    $price = isset($item['discounted_price']) && !empty($item['discounted_price']) ? $item['discounted_price'] : $item['product_price'];
                    $item_total = $price * $item['quantity'];
                    $total += $item_total;
                ?>
                <tr>
                    <td><?php echo $item['product_name']; ?></td>
                    <td>฿ <?php echo number_format($price, 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>฿ <?php echo number_format($item_total, 2); ?></td>
                </tr>
                <?php } ?>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">ยอดรวม</td>
                    <td>฿ <?php echo number_format($total, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div style="text-align:center; margin-top: 20px;">
            <h4>สแกน QR Code เพื่อชำระเงิน</h4>
            <div id="qrCode"></div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include('../includes/footer.php'); ?>
