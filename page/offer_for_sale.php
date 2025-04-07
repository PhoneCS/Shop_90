<?php
include ('../includes/header.php')
?>
<div class="form-sell-section">
    <h2 class="form-sell-title">แบบฟอร์มเสนอขายสินค้า</h2>
    <form action="../process/submit_sell.php" method="POST" enctype="multipart/form-data">
        <div class="form-sell-grid">
            <!-- ฝั่งซ้าย -->
            <div class="form-sell-col">
                <div class="form-sell-group">
                    <label for="first_name">ชื่อ</label>
                    <input type="text" id="first_name" name="first_name" placeholder="กรอกชื่อของคุณ" required>
                </div>

                <div class="form-sell-group">
                    <label for="last_name">นามสกุล</label>
                    <input type="text" id="last_name" name="last_name" placeholder="กรอกนามสกุลของคุณ" required>
                </div>

                <div class="form-sell-group">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <input type="tel" id="phone" name="phone" placeholder="กรอกเบอร์โทรศัพท์" required>
                </div>

                <div class="form-sell-group">
                    <label for="image">แนบรูปภาพสินค้า</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
            </div>

            <!-- ฝั่งขวา -->
            <div class="form-sell-col">
                <div class="form-sell-group">
                    <label for="email">อีเมล</label>
                    <input type="email" id="email" name="email" placeholder="กรอกอีเมลของคุณ" required>
                </div>

                <div class="form-sell-group">
                    <label for="details">ข้อมูลเพิ่มเติม</label>
                    <textarea id="details" name="details" rows="7" placeholder="รายละเอียดเกี่ยวกับสินค้าหรือการเสนอขาย..."></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="form-sell-submit">ส่งแบบฟอร์มเสนอขาย</button>
    </form>
</div>
<?php
include ('../includes/footer.php')
?>
