<?php
include('../includes/header.php');

// จำนวนรายการที่แสดงต่อหน้า
$limit = 10;

// หาหน้า (page) ที่กำลังแสดง
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ดึงข้อมูลจาก complaints พร้อมชื่อและอีเมลของผู้ใช้ โดยเลือกเฉพาะสถานะ 'y'
$sql = "SELECT c.*, u.username, u.email 
        FROM complaints c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.status = 'y'  -- เพิ่มเงื่อนไขเลือกสถานะ 'y'
        ORDER BY c.created_at DESC
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// หาจำนวนข้อมูลทั้งหมดที่มีสถานะ 'y'
$total_sql = "SELECT COUNT(*) AS total FROM complaints WHERE status = 'y'";  // เฉพาะสถานะ 'y'
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// คำนวณจำนวนหน้าที่ต้องการแสดง
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>จัดการเรื่องที่แจ้งเข้ามา</title>
</head>

<body>
    <div class="issue-container">
        <h2>รายการแจ้งเรื่องทั้งหมด</h2>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="issue-card">
            <h3> <?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>ผู้แจ้ง:</strong> <?= htmlspecialchars($row['username']) ?></p>
            <p><strong>อีเมล:</strong> <?= htmlspecialchars($row['email']) ?></p>
            <p><strong>รายละเอียด:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <p><strong>วันที่แจ้ง:</strong> <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></p>
            <form action="../process/del_issue_management.php" method="POST" style="display:inline;">
                <input type="hidden" name="complaint_id" value="<?= $row['complaint_id'] ?>">
                <button type="submit" class="custom-delete-btn" id="deleteBtn">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
        <?php endwhile; ?>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>

<?php
$conn->close();
include('../includes/footer.php');
?>