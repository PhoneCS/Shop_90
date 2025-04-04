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

// สร้างลิงก์ QR Code 
// ใส่รูป qr
$payment_link = "https://www.example.com/payment?amount=" . $total_price;
?>

<section class="checkout-container">
    <div class="shipping-info">
        <h3>ข้อมูลการจัดส่ง</h3>
        <form id="shippingForm">
            <input type="hidden" id="user_id" value="<?php echo $user_id; ?>"> <!-- เพิ่ม hidden input -->
            <label>ชื่อ-นามสกุล:</label>
            <input type="text" id="fullName" placeholder="กรอกชื่อ-นามสกุล" required>
            <label>เบอร์โทร:</label>
            <input type="text" id="phone" placeholder="กรอกเบอร์โทร" required>
            <label>ที่อยู่:</label>
            <textarea id="address" placeholder="กรอกที่อยู่" required></textarea>
            <label>เมือง:</label>
            <input type="text" id="city" placeholder="กรอกชื่อเมือง" required>
            <label>รหัสไปรษณีย์:</label>
            <input type="text" id="zipcode" placeholder="กรอกรหัสไปรษณีย์" required>
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

        <button class="btn-payment" onclick="startPayment()">ชำระเงิน</button>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include('../includes/footer.php'); ?>
