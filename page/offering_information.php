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
                    <img src="../upload/<?= htmlspecialchars($row['image_path']) ?>" class="card-img-top" alt="ภาพสินค้า" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></h5>
                        <p class="card-text mb-1"><strong>ผู้ใช้:</strong> <?= htmlspecialchars($row['username']) ?></p>
                        <p class="card-text mb-1"><strong>อีเมล:</strong> <?= htmlspecialchars($row['email']) ?></p>
                        <p class="card-text mb-1"><strong>เบอร์โทร:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                        <p class="card-text"><small class="text-muted">เสนอขายเมื่อ: <?= date("d/m/Y H:i", strtotime($row['submitted_at'])) ?></small></p>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $row['id'] ?>">
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
                                <div class="col-md-6">
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>" class="img-fluid rounded-3" alt="ภาพสินค้า">
                                </div>
                                <div class="col-md-6">
                                    <p><strong>ชื่อ:</strong> <?= htmlspecialchars($row['first_name']) ?></p>
                                    <p><strong>นามสกุล:</strong> <?= htmlspecialchars($row['last_name']) ?></p>
                                    <p><strong>อีเมล:</strong> <?= htmlspecialchars($row['email']) ?></p>
                                    <p><strong>เบอร์โทร:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                                    <p><strong>รายละเอียด:</strong><br><?= nl2br(htmlspecialchars($row['details'])) ?></p>
                                    <p><strong>เสนอขายเมื่อ:</strong> <?= date("d/m/Y H:i", strtotime($row['submitted_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
