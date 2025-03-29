<?php
include('../includes/header.php'); // ส่วนหัว
$user_id = $_SESSION['user_id']; 

// จำลองสถานะการจัดส่ง (ปกติจะดึงจากฐานข้อมูล)
$delivery_status = "กำลังจัดส่ง"; // สถานะปัจจุบัน ("กำลังดำเนินการจัดส่ง", "กำลังจัดส่ง", "จัดส่งเสร็จสิ้น")
?>

<section class="order-tracking-container">
    <h2>ติดตามสถานะคำสั่งซื้อ</h2>
    
    <div class="tracking-timeline">
        <div class="step <?php echo ($delivery_status == 'กำลังดำเนินการจัดส่ง' || $delivery_status == 'กำลังจัดส่ง' || $delivery_status == 'จัดส่งเสร็จสิ้น') ? 'active' : ''; ?>">
            <div class="circle">1</div>
            <p>กำลังดำเนินการจัดส่ง</p>
        </div>

        <div class="step <?php echo ($delivery_status == 'กำลังจัดส่ง' || $delivery_status == 'จัดส่งเสร็จสิ้น') ? 'active' : ''; ?>">
            <div class="circle">2</div>
            <p>กำลังจัดส่ง</p>
        </div>

        <div class="step <?php echo ($delivery_status == 'จัดส่งเสร็จสิ้น') ? 'active' : ''; ?>">
            <div class="circle">3</div>
            <p>จัดส่งเสร็จสิ้น</p>
        </div>
    </div>

    <div class="status-info">
        <p>📌 สถานะปัจจุบัน: <strong><?php echo $delivery_status; ?></strong></p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
