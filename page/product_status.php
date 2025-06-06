<?php
include('../includes/header.php');
// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_id'])) {
  echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script>
      Swal.fire({
          icon: 'warning',
          title: 'กรุณาเข้าสู่ระบบ',
          text: 'คุณต้องเข้าสู่ระบบก่อนใช้งานหน้านี้',
          confirmButtonText: 'เข้าสู่ระบบ'
      }).then(() => {
          window.location.href = '../auth/login.php';
      });
  </script>";
  exit();
}

// ตรวจสอบสิทธิ์ว่าเป็น admin
if ($_SESSION['user_type'] !== 'admin') {
  echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script>
      Swal.fire({
          icon: 'error',
          title: 'สิทธิ์ไม่เพียงพอ',
          text: 'หน้านี้สำหรับผู้ดูแลระบบเท่านั้น',
          confirmButtonText: 'กลับหน้าหลัก'
      }).then(() => {
          window.location.href = '../index.php';
      });
  </script>";
  exit();
}
// ดึง order_id และ product_name จากตาราง products โดยเชื่อมกับ order_history
$sql = "SELECT o.order_id, p.product_name 
        FROM order_history o
        JOIN products p ON o.product_id = p.product_id
        WHERE o.status = 'รอดำเนินการ'";
$result = $conn->query($sql);
?>

<div class="ship-form-container">
  <h2 class="ship-form-title">อัปเดตสถานะการจัดส่ง</h2>
  <form action="../process/submit_shipping.php" method="POST">
    <div class="ship-form-grid">
      <!-- ฝั่งซ้าย -->
      <div class="ship-form-left">

        <!-- เลือกเลขออเดอร์ -->
        <div class="ship-input-box">
          <label for="order_id">หมายเลขพัสดุ (เลขคำสั่งซื้อ)</label>
          <select id="order_id" name="order_id" required>
            <option value="">-- เลือกคำสั่งซื้อ --</option>
            <?php while ($row = $result->fetch_assoc()): ?>
              <option value="<?= $row['order_id'] ?>">#<?= $row['order_id'] ?> (<?= $row['product_name'] ?>)</option>
            <?php endwhile; ?>
          </select>
        </div>
      </div>

      <!-- ฝั่งขวา -->
      <div class="ship-form-right">
        <div class="ship-input-box">
          <label for="delivery_company">บริษัทขนส่ง</label>
          <select id="delivery_company" name="delivery_company" required>
            <option value="">-- เลือกบริษัท --</option>
            <option value="Kerry Express">Kerry Express</option>
            <option value="Flash Express">Flash Express</option>
            <option value="Shopee Express">Shopee Express</option>
            <option value="J&T Express">J&T Express</option>
          </select>
        </div>

        <div class="ship-input-box">
          <label for="product_code">รหัสสินค้า</label>
          <input type="text" id="product_code" name="product_code" required>
        </div>
      </div>
    </div>

    <div class="ship-form-action">
      <button type="submit" class="ship-btn-submit">บันทึก</button>
    </div>
  </form>
</div>

<?php include('../includes/footer.php'); ?>
