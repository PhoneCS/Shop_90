<?php
include('../includes/header.php');

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

        <div class="ship-input-box">
          <label for="order_date">วันที่สั่งซื้อ</label>
          <input type="date" id="order_date" name="order_date" required>
        </div>

        <div class="ship-input-box">
          <label for="address">ที่อยู่</label>
          <textarea id="address" name="address" rows="3" required></textarea>
        </div>

        <div class="ship-input-box">
          <label for="phone">เบอร์ติดต่อ</label>
          <input type="tel" id="phone" name="phone" required>
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
