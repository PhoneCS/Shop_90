<?php
session_start();
include 'connect.inc.php';

// กำหนดจำนวนรายการที่จะแสดงต่อหน้า
$items_per_page = 10; // จำนวนรายการต่อหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // ตรวจสอบหมายเลขหน้าจาก URL
$offset = ($page - 1) * $items_per_page; // คำนวณ offset สำหรับ SQL

// ดึงข้อมูลจากตาราง product_items โดยใช้ limit และ offset
$sql = "SELECT * FROM product_items WHERE status_item='y' ORDER BY id LIMIT $items_per_page OFFSET $offset;";
$result = mysqli_query($link, $sql);

// ตรวจสอบว่าการ query สำเร็จหรือไม่
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// ดึงข้อมูลทั้งหมดเพื่อคำนวณจำนวนหน้า
$total_items_sql = "SELECT COUNT(*) as total FROM product_items;";
$total_items_result = mysqli_query($link, $total_items_sql);
$total_items_row = mysqli_fetch_assoc($total_items_result);
$total_items = $total_items_row['total'];
$total_pages = ceil($total_items / $items_per_page); // คำนวณจำนวนหน้า

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>OVERVIEW</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .status-online {
            color: green;
            font-weight: bold;
        }

        .status-offline {
            color: red;
            font-weight: bold;
        }

        body {
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .tableoverview {
            background-color: #5287C4;
            color: #E5E5E5;
        }

        .font {
            color: white;
        }

        .navbar-text {
            background-color: #355983;
            /* สีดำโปร่งใส */
            color: white;
            /* สีตัวอักษรเป็นสีขาว */
            border-radius: 15px;
            /* กรอบมน */
            padding: 5px 15px;
            /* เพิ่ม padding ให้สวยงาม */
            font-weight: bold;
            /* ตัวหนาสำหรับชื่อผู้ใช้ */
            border: 2px solid white;
            /* ขอบสีขาว */
        }

        .navbar-text i {
            margin-right: 8px;
            /* ระยะห่างระหว่างไอคอนและข้อความ */
            font-size: 1.2rem;
            /* ขนาดของไอคอน */
        }

        .btn-logout {
            background-color: white;
            /* พื้นหลังเป็นสีขาว */
            color: #355983;
            /* สีของข้อความและไอคอน */
            border: 2px solid #007bff;
            /* ขอบสีฟ้า */
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 50px;
            /* ทำให้ปุ่มมีมุมมน */
            display: flex;
            align-items: center;
            /* จัดตำแหน่งไอคอนและข้อความให้ตรงกลาง */
        }

        .btn-logout i {
            margin-right: 8px;
            /* เพิ่มระยะห่างระหว่างไอคอนและข้อความ */
            font-size: 1.2rem;
            /* ขนาดไอคอน */
        }

        .btn-logout:hover {
            background-color: #f8f9fa;
            /* เปลี่ยนสีพื้นหลังเมื่อ hover */
            color: #0056b3;
            /* เปลี่ยนสีข้อความเมื่อ hover */
            border-color: #0056b3;
            /* เปลี่ยนสีขอบเมื่อ hover */
        }
    </style>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #355983;">
        <div class="container-fluid">
            <a class="navbar-brand font" href="overview.php">
                <img src="img/logo.png" alt="Logo" style="height: 50px;">
                COMPUTER
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <span class="navbar-text ms-auto me-3 font">
                    <!-- ห่อไอคอนและชื่อใน <a> แท็กเดียวกัน -->
                    <a href="profile.php" class="text-white d-flex align-items-center" style="text-decoration: none;">
                        <i class="fa-solid fa-user" style="margin-right: 8px;"></i>
                        <?php echo $_SESSION['name']; ?>
                    </a>
                </span>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <form method="POST" action="LOGOUT.php">
                            <button type="submit" class="btn btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="add.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</a>
        </div>
        <table class="table table-hover table">
            <thead class="tableoverview ">
                <tr>
                    <th scope="col">
                        <center>No.</center>
                    </th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Detail</th>
                    <th scope="col">
                        <center>Quantity</center>
                    </th>
                    <th scope="col">
                        <center>Status</center>
                    </th>
                    <th scope="col">
                        <center>Manage</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // กำหนดตัวนับสำหรับลำดับที่
                $no = ($page - 1) * $items_per_page + 1;

                // แสดงผลข้อมูลในตาราง
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<th scope='row'><center>" . $no++ . "</center></th>";  // แสดงลำดับที่จากตัวนับ
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["details"] . "</td>";
                    echo "<td><center>" . $row["quantity"] . "</center></td>";
                    echo "<td class='" . ($row["status"] == "on" ? "status-online" : "status-offline") . "'><center>" . ($row["status"] == "on" ? "online" : "offline") . "</center></td>";
                    echo "<td><center>";
                    echo "<button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#viewModal' data-id='{$row['id']}' data-name='{$row['product_name']}' data-price='{$row['price']}' data-details='{$row['details']}' data-quantity='{$row['quantity']}' data-status='{$row['status']}'><i class='fa-regular fa-eye'></i></button> ";
                    echo "<a href='edit.php?id={$row['id']}' class='btn btn-warning'><i class='fa-regular fa-pen-to-square'></i></a> ";
                    echo "<a href='delete.php?id={$row['id']}' class='btn btn-danger'><i class='fa-regular fa-trash-can'></i></a>";
                    echo "</center></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>


        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true"><i class="fa-solid fa-angles-left"></i></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page === $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true"><i class="fa-solid fa-angles-right"></i></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="productId"></span></p>
                    <p><strong>Name:</strong> <span id="productName"></span></p>
                    <p><strong>Price:</strong> <span id="productPrice"></span></p>
                    <p><strong>Details:</strong> <span id="productDetails"></span></p>
                    <p><strong>Quantity:</strong> <span id="productQuantity"></span></p>
                    <p><strong>Status:</strong> <span id="productStatus"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
        // ตั้งค่า Modal เมื่อคลิกปุ่ม View
        const viewButtons = document.querySelectorAll('.btn-info');
        viewButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                const details = button.getAttribute('data-details');
                const quantity = button.getAttribute('data-quantity');
                const status = button.getAttribute('data-status');

                // แสดงข้อมูลใน Modal
                document.getElementById('productId').innerText = id;
                document.getElementById('productName').innerText = name;
                document.getElementById('productPrice').innerText = price;
                document.getElementById('productDetails').innerText = details;
                document.getElementById('productQuantity').innerText = quantity;
                document.getElementById('productStatus').innerText = status === 'on' ? 'Online' : 'Offline';
            });
        });
    </script>
</body>

</html>