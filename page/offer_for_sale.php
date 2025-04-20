<?php
include ('../includes/header.php');

// ดึงข้อมูลจากฐานข้อมูลหมวดหมู่
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<div class="form-sell-section">
    <h2 class="form-sell-title">แบบฟอร์มเสนอขายสินค้า</h2>
    <form action="../process/submit_sell.php" method="POST" enctype="multipart/form-data">
    <div class="form-sell-grid">
        <!-- ฝั่งซ้าย -->
        <div class="form-sell-col">
            <div class="form-sell-group">
                <label for="product_name">ชื่อสินค้า</label>
                <input type="text" id="product_name" name="product_name" placeholder="กรอกชื่อสินค้าของคุณ" required>
            </div>

            <div class="form-sell-group">
                <label for="product_price">ราคา</label>
                <input type="number" id="product_price" name="product_price" placeholder="กรอกราคา" required>
            </div>

            <div class="form-sell-group">
                <label for="product_stock">จำนวนสินค้า</label>
                <input type="number" id="product_stock" name="product_stock" placeholder="กรอกจำนวนสินค้าที่มี" required>
            </div>

            <div class="form-sell-group">
                <label for="image">แนบรูปภาพสินค้า</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-sell-group">
            <label for="image_hover">แนบรูปภาพสินค้า (ด้านหลัง)</label>
            <input type="file" id="image_hover" name="image_hover" accept="image/*">
        </div>


            <div class="form-sell-group">
                <label for="category">หมวดหมู่</label>
                <select id="category" name="category" required>
                    <option value="">เลือกหมวดหมู่</option>
                    <?php
                    // ดึงข้อมูลหมวดหมู่จากฐานข้อมูล
                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
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
include ('../includes/footer.php');
?>
