<?php
include('../includes/header.php');
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

$user_id = $_SESSION['user_id'];

// สร้างคำสั่ง SQL สำหรับดึงข้อมูลการสั่งซื้อ
$query = "SELECT oh.*, p.product_name, p.product_image
          FROM order_history oh
          JOIN products p ON oh.product_id = p.product_id
          WHERE oh.user_id = '$user_id'
          ORDER BY oh.order_date DESC";

// ตรวจสอบผลลัพธ์ของการ query
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<h2 class="order-history-title">ประวัติการสั่งซื้อ</h2>

<div class="order-history-container">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="order-item">
        <div class="order-details">
            <div class="order-product">
                <img src="../assets/image/<?php echo $row['product_image']; ?>"
                    alt="<?php echo $row['product_name']; ?>" class="order-product-img">
                <div class="order-product-info">
                    <h4><?php echo $row['product_name']; ?></h4>
                    <p>จำนวน: <?php echo $row['quantity']; ?> ชิ้น</p>
                    <p>ราคา: ฿<?php echo number_format($row['total'], 2); ?></p>
                </div>
            </div>

            <div class="order-status">
                <p class="status-label">
                    <span class="status-icon <?php echo strtolower($row['status']); ?>"></span>
                    สถานะ: <span
                        class="status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                </p>
                <p class="order-date">วันที่สั่ง: <?php echo date("d/m/Y", strtotime($row['order_date'])); ?></p>
            </div>

        </div>

        <!-- การให้คะแนนสินค้า -->
        <div class="rating-section">
            <?php
            // เช็คสถานะการจัดส่ง
            if ($row['status'] == 'จัดส่งแล้ว') {
                // ดึงข้อมูลการให้คะแนนจากฐานข้อมูลสำหรับสินค้านี้
                $rating_query = "SELECT rating FROM product_ratings WHERE user_id = '$user_id' AND product_id = '{$row['product_id']}' AND order_id = '{$row['order_id']}' LIMIT 1";
                $rating_result = mysqli_query($conn, $rating_query);
                $rating = mysqli_fetch_assoc($rating_result)['rating'] ?? 0; // กำหนดเป็น 0 หากไม่มีข้อมูลการให้คะแนน
            ?>

            <?php if ($rating > 0): ?>
            <!-- แสดงข้อความว่าให้คะแนนแล้ว -->
            <p>ให้คะแนนแล้ว: <?php echo $rating; ?> ดาว</p>
            <?php else: ?>
            <!-- แสดงปุ่มให้คะแนน -->
            <label for="rating-<?php echo $row['order_id']; ?>">ให้คะแนนสินค้า: </label>
            <div class="rating-stars" data-product-id="<?php echo $row['product_id']; ?>"
                id="rating-<?php echo $row['order_id']; ?>">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <?php endif; ?>

            <?php } else { ?>
            <!-- ถ้ายังไม่ได้จัดส่งสำเร็จ ให้แสดงข้อความ -->
            <p>สถานะการจัดส่งยังไม่สำเร็จ ไม่สามารถให้คะแนนได้</p>
            <?php } ?>

            <script>
            // เพิ่มดาวที่ผู้ใช้เคยให้คะแนน
            const productId = "<?php echo $row['product_id']; ?>";
            const rating = <?php echo $rating; ?>;
            const stars = document.querySelectorAll('#rating-<?php echo $row['order_id']; ?> .star');

            stars.forEach(star => {
                const starValue = parseInt(star.getAttribute('data-value'));
                if (starValue <= rating) {
                    star.classList.add('selected');
                }
            });
            </script>
        </div>

    </div>
    <?php endwhile; ?>
</div>

<script>
document.querySelectorAll('.rating-stars').forEach(function(starsContainer) {
    const stars = starsContainer.querySelectorAll('.star');
    const orderId = starsContainer.getAttribute('id').replace('rating-',
        ''); // ดึง order_id จาก id ของ starsContainer
    const productId = starsContainer.getAttribute('data-product-id'); // ดึง product_id จาก data attribute

    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            // ค่าคะแนนที่เลือก
            const rating = (this.getAttribute('data-value') * 1.0).toFixed(
                1); // ทำให้เป็นทศนิยม 1 ตำแหน่ง
            console.log("ส่งข้อมูล: order_id = " + orderId + ", product_id = " + productId +
                ", rating = " + rating); // เพิ่มการแสดงค่าที่ส่งไป

            // แสดงดาวที่ถูกเลือก
            stars.forEach(function(s) {
                s.classList.toggle('selected', s.getAttribute('data-value') <= rating);
            });

            // ส่งข้อมูลการให้คะแนนไปยังฐานข้อมูล
            fetch('../process/submit_rating.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_id: orderId, // ส่ง order_id
                        product_id: productId, // ส่ง product_id
                        rating: rating // ส่งเป็นทศนิยม
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ขอบคุณสำหรับการให้คะแนน!',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง',
                            timer: 2500
                        }).then(() => {
                            window.location.href =
                            '../index.php'; // หรือ './index.php' ตามตำแหน่งไฟล์ JS
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถบันทึกการให้คะแนนได้: ' + data.error
                        });
                    }
                }).catch(err => {
                    console.error('เกิดข้อผิดพลาดในการส่งข้อมูล:', err);
                    alert('เกิดข้อผิดพลาดในการส่งข้อมูล');
                });
        });
    });
});
</script>

<?php include('../includes/footer.php'); ?>