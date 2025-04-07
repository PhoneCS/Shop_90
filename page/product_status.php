<?php
include('../includes/header.php');
?>
<div class="ship-form-container">
  <h2 class="ship-form-title">อัปเดตสถานะการจัดส่ง</h2>
  <form action="submit_shipping.php" method="POST">
    <div class="ship-form-grid">
      <!-- ฝั่งซ้าย -->
      <div class="ship-form-left">
        <div class="ship-input-box">
          <label for="tracking_number">เลขพัสดุ</label>
          <input type="text" id="tracking_number" name="tracking_number" required>
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

        <div class="ship-input-box">
          <label for="price">ราคา (บาท)</label>
          <input type="number" id="price" name="price" step="0.01" required>
        </div>
      </div>
    </div>

    <div class="ship-form-action">
      <button type="submit" class="ship-btn-submit">บันทึก</button>
    </div>
  </form>
</div>

<?php
include('../includes/footer.php');
?>
