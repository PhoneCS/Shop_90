<?php
include('../includes/header.php');

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo "<script>
        alert('❌ คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        window.location.href = '../index.php'; // ส่งกลับไปหน้าหลัก
    </script>";
    exit();
}
// ดึงประเภทสินค้าเพื่อแสดงใน <select>
$sql = "SELECT category_id, category_name FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // เมื่อเลือกหมวดหมู่สินค้า
            $('#category_id').change(function() {
                var categoryId = $(this).val();
                if (categoryId == 'เสื้อผ้า') { // เปลี่ยน 'เสื้อผ้า' ให้ตรงกับชื่อหมวดหมู่ที่คุณใช้ในฐานข้อมูล
                    $('#size_section').show();  // แสดงเลือกไซต์
                } else {
                    $('#size_section').hide();  // ซ่อนเลือกไซต์
                }
            });
        });
    </script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">เพิ่มสินค้าใหม่</h2>
    <form action="../process/insert_product.php" method="POST" enctype="multipart/form-data">
        <!-- ชื่อสินค้า -->
        <div class="mb-3">
            <label for="product_name" class="form-label">ชื่อสินค้า</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>

        <!-- ราคา -->
        <div class="mb-3">
            <label for="product_price" class="form-label">ราคา (บาท)</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required>
        </div>

        <!-- รายละเอียดสินค้า -->
        <div class="mb-3">
            <label for="product_description" class="form-label">รายละเอียดสินค้า</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="3"></textarea>
        </div>

        <!-- รายละเอียดเพิ่มเติม -->
        <div class="mb-3">
            <label for="product_additional_info" class="form-label">รายละเอียดเพิ่มเติม</label>
            <textarea class="form-control" id="product_additional_info" name="product_additional_info" rows="3"></textarea>
        </div>

        <!-- จำนวนสินค้า -->
        <div class="mb-3">
            <label for="product_stock" class="form-label">จำนวนสินค้า</label>
            <input type="number" class="form-control" id="product_stock" name="product_stock" required>
        </div>

        <!-- ประเภทสินค้า -->
        <div class="mb-3">
            <label for="category_id" class="form-label">ประเภทสินค้า</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- เลือกประเภทสินค้า --</option>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['category_name']; ?>"><?= $row['category_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- เลือกไซต์เสื้อ -->
        <div id="size_section" class="mb-3" style="display:none;">
    <label for="product_size" class="form-label">เลือกไซต์เสื้อ</label>
    <div>
        <input type="checkbox" id="size_s" name="product_size[]" value="S">
        <label for="size_s">S</label>
    </div>
    <div>
        <input type="checkbox" id="size_m" name="product_size[]" value="M">
        <label for="size_m">M</label>
    </div>
    <div>
        <input type="checkbox" id="size_l" name="product_size[]" value="L">
        <label for="size_l">L</label>
    </div>
    <div>
        <input type="checkbox" id="size_xl" name="product_size[]" value="XL">
        <label for="size_xl">XL</label>
    </div>
</div>


        <!-- อัปโหลดรูปภาพสินค้า -->
        <div class="mb-3">
            <label for="product_image" class="form-label">รูปภาพสินค้า</label>
            <input type="file" class="form-control" id="product_image" name="product_image" required>
        </div>

        <div class="mb-3">
            <label for="product_image_hover" class="form-label">รูปภาพขณะโฮเวอร์</label>
            <input type="file" class="form-control" id="product_image_hover" name="product_image_hover" required>
        </div>

        <!-- ปุ่มบันทึก -->
        <button type="submit" class="btn btn-primary">บันทึกสินค้า</button>
    </form>
</div>

</body>
</html>

<?php
include('../includes/footer.php');
?>
