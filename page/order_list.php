<?php
include('../includes/header.php'); 
if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเข้าสู่ระบบ',
            text: 'คุณต้องเข้าสู่ระบบก่อนเข้าถึงหน้านี้',
            confirmButtonText: 'เข้าสู่ระบบ'
        }).then(() => {
            window.location.href = '../auth/login.php';
        });
    </script>";
    exit();
}

$user_id = $_SESSION['user_id']; // ใช้ user_id จาก session ซึ่งจะเป็นของผู้ที่ล็อกอิน

// กำหนดจำนวนรายการต่อหน้า
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// กรองข้อมูลตาม user_id ที่ล็อกอินอยู่
$where_clause = "AND oh.user_id = $user_id";

// ดึงข้อมูล grouped ตามวันที่ และ JOIN กับตาราง users
$sql = "SELECT order_date, u.username AS user_name, 
               GROUP_CONCAT(oh.product_id SEPARATOR ', ') AS products, 
               SUM(oh.total) AS total, 
               oh.order_id
        FROM order_history oh
        JOIN users u ON oh.user_id = u.user_id
        WHERE 1 $where_clause  -- เฉพาะข้อมูลของ user ที่ล็อกอินอยู่
        GROUP BY oh.user_id, order_date 
        ORDER BY order_date DESC 
        LIMIT $start, $limit";

$result = $conn->query($sql);
if (!$result) {
    die("SQL Error (main query): " . $conn->error);
}

// Query สำหรับนับจำนวนกลุ่มรายการทั้งหมด เพื่อใช้คำนวณจำนวนหน้า
$count_sql = "SELECT COUNT(*) AS total 
              FROM (
                  SELECT 1
                  FROM order_history oh
                  JOIN users u ON oh.user_id = u.user_id
                  WHERE 1 $where_clause
                  GROUP BY oh.user_id, order_date
              ) AS grouped_dates";

$count_result = $conn->query($count_sql);

if (!$count_result) {
    die("SQL Error (count query): " . $conn->error);
}

$total_orders = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $limit); // ✅ เพิ่มบรรทัดนี้เพื่อคำนวณจำนวนหน้า
?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center text-primary">📦 รายการสั่งซื้อ</h2>

        <div class="table-responsive">
            <table class="table table-bordered order-table">
                <thead>
                    <tr class="text-center">
                        <th>วันที่</th>
                        <th>ชื่อผู้สั่งซื้อ</th>
                        <th>จำนวนเงินรวม</th>
                        <th>รายการสั่งซื้อ</th>
                        <th>ดูรายละเอียด</th> <!-- เพิ่มคอลัมน์สำหรับปุ่ม -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center align-middle">
                        <td><?= date('d/m/Y', strtotime($row['order_date'])) ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= number_format($row['total'], 2) ?> บาท</td>
                        <td class="product-names-cell" title="<?php
    $product_ids = explode(', ', $row['products']);
    $product_names = [];

    foreach ($product_ids as $product_id) {
        $product_id = intval($product_id);
        $product_sql = "SELECT product_name FROM products WHERE product_id = $product_id";
        $product_result = $conn->query($product_sql);
        if ($product_result && $product_row = $product_result->fetch_assoc()) {
            $product_names[] = $product_row['product_name'];
        }
    }
    echo htmlspecialchars(implode(', ', $product_names));
?>">
                            <?= htmlspecialchars(implode(', ', $product_names)) ?>
                        </td>

                        <td>
                            <!-- ปุ่มเปิด Modal สำหรับแต่ละรายการ -->
                            <button type="button" class="view-order-btn" data-toggle="modal"
                                data-target="#orderModal<?= $row['order_id'] ?>" title="ดูรายละเอียด">
                                <i class="fas fa-eye"></i>
                            </button>


                        </td>
                    </tr>

                    <!-- Modal สำหรับแต่ละรายการ -->
                    <div class="modal fade" id="orderModal<?= $row['order_id'] ?>" tabindex="-1" role="dialog"
                        aria-labelledby="orderModalLabel<?= $row['order_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog custom-modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header custom-modal-header">
                                    <h5 class="modal-title custom-modal-title"
                                        id="orderModalLabel<?= $row['order_id'] ?>">ข้อมูลการสั่งซื้อ
                                    </h5>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <p><strong>รายละเอียดการสั่งซื้อ:</strong>
                                                <?php
                                    $product_ids = explode(', ', $row['products']);
                                    $product_names = [];

                                    foreach ($product_ids as $product_id) {
                                        $product_id = (int)$product_id; // แปลงให้แน่ใจว่าเป็นตัวเลข ป้องกัน SQL injection
                                        $sql_modal_product = "SELECT product_name FROM products WHERE product_id = $product_id";
                                        $result_modal_product = $conn->query($sql_modal_product);
                                        if ($result_modal_product && $product_row = $result_modal_product->fetch_assoc()) {
                                            $product_names[] = $product_row['product_name'];
                                        }
                                    }

                                    // แสดงชื่อสินค้ารวมกันแบบคั่นด้วย comma
                                    echo implode(', ', $product_names);
                                    ?>
                                            </p>
                                            <p><strong>จำนวนเงินรวม:</strong> <?= number_format($row['total'], 2) ?> บาท
                                            </p>
                                        </div>
                                    </div>

                                    <!-- แสดงภาพสินค้าที่สั่ง -->
                                    <h6 class="mt-4 mb-3">ภาพสินค้าที่สั่ง:</h6>
                                    <div class="custom-images-row">
                                        <?php
                                    $product_ids = explode(', ', $row['products']);
                                    foreach ($product_ids as $product_id) {
                                        // ดึงข้อมูลภาพสินค้าจากฐานข้อมูล
                                        $product_sql = "SELECT product_image FROM products WHERE product_id = $product_id";
                                        $product_result = $conn->query($product_sql);
                                        
                                        if ($product_result && $product_row = $product_result->fetch_assoc()) {
                                            $image_url = $product_row['product_image'];
                                            echo '<div class="col-6 col-md-3">';
                                            echo '<div class="card custom-image-card">';
                                            echo '<img src="../assets/image/' . $image_url . '" alt="Product Image" class="img-fluid">';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="modal-footer custom-modal-footer">
                                    <button type="button" class="btn custom-btn-close" data-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" style="margin-bottom: 250px;">
            <ul class="pagination justify-content-center">
                <!-- Previous -->
                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Page numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- รวมสคริปต์ของ Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
<?php include('../includes/footer.php'); ?>