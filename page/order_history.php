<?php
include('../includes/header.php');
$user_id = $_SESSION['user_id'];

// สร้างคำสั่ง SQL
$query = "SELECT oh.*, p.product_name, p.product_image
          FROM order_history oh
          JOIN products p ON oh.product_id = p.product_id
          WHERE oh.user_id = '$user_id'
          ORDER BY oh.order_date DESC";

// ตรวจสอบผลลัพธ์ของการ query
$result = mysqli_query($conn, $query);

if (!$result) {
    // ถ้าคำสั่ง SQL ล้มเหลว ให้แสดงข้อความแสดงข้อผิดพลาด
    die('Query failed: ' . mysqli_error($conn));
}
?>

<h2 class="order-history-title">ประวัติการสั่งซื้อ</h2>

<div class="order-history-container">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="order-item">
        <div class="order-details">
            <div class="order-product">
                <img src="../assets/image/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="order-product-img">
                <div class="order-product-info">
                    <h4><?php echo $row['product_name']; ?></h4>
                    <p>จำนวน: <?php echo $row['quantity']; ?> ชิ้น</p>
                    <p>ราคา: ฿<?php echo number_format($row['total'], 2); ?></p>
                </div>
            </div>

            <div class="order-status">
                <p>สถานะ: <span class="status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></p>
                <p>วันที่สั่ง: <?php echo date("d/m/Y", strtotime($row['order_date'])); ?></p>
            </div>
        </div>

        <!-- การให้คะแนนสินค้า -->
        <div class="rating-section">
            <label for="rating-<?php echo $row['order_id']; ?>">ให้คะแนนสินค้า: </label>
            <div class="rating-stars" id="rating-<?php echo $row['order_id']; ?>">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<script>
    // การให้คะแนน (ดาว) 
    document.querySelectorAll('.rating-stars').forEach(function(starsContainer) {
        const stars = starsContainer.querySelectorAll('.star');
        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                // แสดงดาวที่ถูกเลือก
                stars.forEach(function(s) {
                    if (s.getAttribute('data-value') <= rating) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });

                // ส่งข้อมูลการให้คะแนนไปยังฐานข้อมูล
                const order_id = starsContainer.id.split('-')[1];  // ดึง order_id จาก id ของ container
                fetch('submit_rating.php', {
                    method: 'POST',
                    body: JSON.stringify({ order_id, rating }),
                    headers: { 'Content-Type': 'application/json' }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert('ขอบคุณสำหรับการให้คะแนน!');
                      }
                  }).catch(err => alert('เกิดข้อผิดพลาดในการส่งข้อมูล'));
            });
        });
    });
</script>

<?php include('../includes/footer.php'); ?>


