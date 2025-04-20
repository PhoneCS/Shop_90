<?php
include('../includes/header.php');

$sql = "SELECT s.*, u.username 
        FROM sell_offers s
        JOIN users u ON s.user_id = u.user_id
        ORDER BY s.submitted_at DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <h2 class="mb-4 text-center">รายการเสนอขายสินค้า</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <img src="../assets/image/<?= htmlspecialchars($row['product_image']) ?>" class="card-img-top" alt="ภาพสินค้า"
                    style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <!-- แสดงชื่อสินค้า -->
                    <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5>
                    
                    <!-- แสดงชื่อผู้ใช้ -->
                    <p class="card-text mb-1"><strong>ผู้ใช้:</strong> <?= htmlspecialchars($row['username']) ?></p>
                    
                    <!-- แสดงราคา -->
                    <p class="card-text mb-1"><strong>ราคา:</strong> <?= htmlspecialchars($row['product_price']) ?> บาท</p>
                    
                    <!-- แสดงวันที่เสนอ -->
                    <p class="card-text"><small class="text-muted">เสนอขายเมื่อ:
                            <?= date("d/m/Y H:i", strtotime($row['submitted_at'])) ?></small></p>

                    <!-- แสดงสถานะการอนุมัติ -->
                    <?php if ($row['sell_offers_status'] == 1): ?>
                    <span class="badge bg-success">อนุมัติแล้ว</span>
                    <?php else: ?>
                    <span class="badge bg-warning text-dark">รออนุมัติ</span>
                    <?php endif; ?>

                    <br>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal<?= $row['id'] ?>">
                        👁 ดูรายละเอียด
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal แสดงรายละเอียด -->
        <div class="modal fade" id="modal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel<?= $row['id'] ?>">รายละเอียดสินค้า</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="ปิด"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="position-relative overflow-hidden" style="height: 300px;">
    <img src="../assets/image/<?= htmlspecialchars($row['product_image']) ?>" 
         class="img-fluid rounded-3 img-main" 
         alt="ภาพสินค้า" 
         style="height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; width: 100%; transition: opacity 0.3s;">
    
    <img src="../assets/image/<?= htmlspecialchars($row['product_image_hover']) ?>" 
         class="img-fluid rounded-3 img-hover" 
         alt="ภาพ hover" 
         style="height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; width: 100%; opacity: 0; transition: opacity 0.3s;">
</div>

                    <div class="col-md-6">
                        <!-- แสดงข้อมูลเพิ่มเติม -->
                        <p><strong>ชื่อสินค้า:</strong> <?= htmlspecialchars($row['product_name']) ?></p>
                        <p><strong>ผู้ใช้:</strong> <?= htmlspecialchars($row['username']) ?></p>
                        <p><strong>จำนวน:</strong> <?= htmlspecialchars($row['product_stock']) ?></p>
                        <p><strong>ราคา:</strong> <?= htmlspecialchars($row['product_price']) ?> บาท</p>
                        <p><strong>อีเมล:</strong> <?= htmlspecialchars($row['email']) ?></p>
                        <p><strong>รายละเอียดสินค้า:</strong><br><?= nl2br(htmlspecialchars($row['product_description'])) ?></p>
                        <p><strong>เสนอขายเมื่อ:</strong> <?= date("d/m/Y H:i", strtotime($row['submitted_at'])) ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="../process/accept_product.php" method="POST" style="display: inline;">
                <input type="hidden" name="product_image_hover" value="<?= htmlspecialchars($row['product_image_hover']) ?>">

                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>">
                    <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['image_path']) ?>">
                    <button type="submit" class="btn btn-success">ยืนยันการนำเข้า</button>
                </form>
            </div>
        </div>
    </div>
</div>

        <?php endwhile; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
