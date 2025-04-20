<?php
include('../includes/header.php');;

// ตรวจสอบว่าเข้าสู่ระบบหรือยัง
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

// ดึงรายการคำสั่งซื้อพร้อมชื่อสินค้าของผู้ใช้ที่ล็อกอิน
$sql = "SELECT oh.product_id, p.product_name, oh.status 
        FROM order_history oh
        INNER JOIN products p ON oh.product_id = p.product_id
        WHERE oh.user_id = ?
        ORDER BY oh.order_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>ยังไม่มีคำสั่งซื้อในระบบสำหรับผู้ใช้นี้</p>";
    include('../includes/footer.php');
    exit;
}
?>

<section class="order-tracking-container">
    <h2>ติดตามสถานะคำสั่งซื้อของคุณ</h2>

    <?php 
    $orderIndex = 0;
    while ($row = $result->fetch_assoc()):
        $product_name = $row['product_name'];
        $status = $row['status'];
        $product_id = $row['product_id'];
        $unique_id = "order-" . $orderIndex;
    ?>
    <div class="product-status-block" id="<?php echo $unique_id; ?>" data-product-id="<?php echo $product_id; ?>">
        <h3>สินค้า: <?php echo htmlspecialchars($product_name); ?></h3>

        <div class="tracking-timeline">
            <div class="step <?php echo ($status == 'รอดำเนินการ' || $status == 'กำลังจัดส่ง' || $status == 'จัดส่งแล้ว') ? 'active' : ''; ?>">
                <div class="circle">1</div>
                <p>รอดำเนินการ</p>
            </div>

            <div class="step <?php echo ($status == 'กำลังจัดส่ง' || $status == 'จัดส่งแล้ว') ? 'active' : ''; ?>">
                <div class="circle">2</div>
                <p>กำลังจัดส่ง</p>
            </div>

            <div class="step step-delivered <?php echo ($status == 'จัดส่งแล้ว') ? 'active' : ''; ?>">
                <div class="circle">3</div>
                <p>จัดส่งเสร็จสิ้น</p>
            </div>
        </div>

        <div class="status-info">
            <p>📌 สถานะ: 
                <strong class="status-text"><?php echo $status; ?></strong>
                <?php if ($status == 'กำลังจัดส่ง'): ?>
                    <br><span class="countdown" data-block-id="<?php echo $unique_id; ?>"></span>
                <?php endif; ?>
            </p>
        </div>
        <hr>
    </div>
    <?php 
        $orderIndex++; 
    endwhile; 
    ?>
</section>

<script>
function startDeliveryCountdown() {
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(el => {
        const blockId = el.dataset.blockId;
        const block = document.getElementById(blockId);
        const productId = block.dataset.productId;

        const storageKey = `delivery_start_${blockId}`;

        if (!localStorage.getItem(storageKey)) {
            localStorage.setItem(storageKey, Date.now());
        }

        const startTime = parseInt(localStorage.getItem(storageKey), 10);
        const now = Date.now();
        const elapsed = Math.floor((now - startTime) / 1000);
        const remaining = 60 - elapsed;

        if (remaining <= 0) {
            const statusText = block.querySelector('.status-text');
            const deliveredStep = block.querySelector('.step-delivered');

            statusText.textContent = 'จัดส่งเสร็จสิ้น';
            el.remove();
            deliveredStep.classList.add('active');
            localStorage.removeItem(storageKey);

            // ส่งคำขอ AJAX เพื่ออัปเดตสถานะในฐานข้อมูล
            fetch('../process/update_order_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${encodeURIComponent(productId)}`
            })
            .then(response => response.text())
            .then(data => {
                console.log('อัปเดตสถานะสำเร็จ:', data);
            })
            .catch(error => {
                console.error('เกิดข้อผิดพลาดในการอัปเดต:', error);
            });
        } else {
            el.textContent = `⏳ ขนส่งกำลังเข้าไปส่งภายใน ${remaining} วินาที`;
        }
    });
}

setInterval(startDeliveryCountdown, 1000);
</script>

<?php include('../includes/footer.php'); ?>
