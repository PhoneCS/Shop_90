<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เสนอขายสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">แบบฟอร์มเสนอขายสินค้า</h2>
        <form action="submit_sell_proposal.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทร</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">รูปภาพสินค้า (ถ้ามี)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">ข้อมูลเพิ่มเติม</label>
                <textarea class="form-control" id="details" name="details" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">ส่งการเสนอขาย</button>
        </form>
    </div>
</body>
</html>
