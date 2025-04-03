<?php
include('../includes/header.php'); 

// กำหนดจำนวนรายการต่อหน้า
$limit = 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM orders ORDER BY created_at DESC LIMIT $start, $limit";
$result = $conn->query($sql);

// หาจำนวนหน้าทั้งหมด
$count_sql = "SELECT COUNT(*) AS total FROM orders";
$count_result = $conn->query($count_sql);
$total_orders = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $limit);
?>


<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center text-primary">📦 รายการสั่งซื้อ</h2>
        <div class="table-responsive">
            <table class="table table-bordered order-table">
                <thead>
                    <tr class="text-center">
                        <th>วันที่</th>
                        <th>หมายเลขออร์เดอร์</th>
                        <th>ชื่อผู้สั่งซื้อ</th>
                        <th>จำนวนเงิน</th>
                        <th>รายการสั่งซื้อ</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center align-middle">
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= number_format($row['total_price'], 2) ?> บาท</td>
                        <td><?= htmlspecialchars($row['product_id']) ?></td>
                        <td>
                            <span class="status-badge status-<?= htmlspecialchars($row['status']) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

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
<?php include('../includes/footer.php'); ?>