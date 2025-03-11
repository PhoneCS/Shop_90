<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/all.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Shop 90 - หน้าแรก</title>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-top">
                <div class="logo" onclick="window.location.href='../index.php'">
                    Shop 90
                </div>


                <div class="search-bar">
                    <form class="search-form">
                        <input type="text" placeholder="ค้นหาสินค้า..." class="search-input">
                        <button type="submit">🔍</button>
                    </form>
                </div>

                <div class="user-actions">
                    <a href="../auth/login.php">เข้าสู่ระบบ</a>
                    <a href="../auth/register.php">สมัครสมาชิก</a>
                    <a href="../page/cart.php">ตะกร้า (<span class="cart-count">0</span>)</a>
                </div>
            </div>

            <nav class="nav-main">
                <ul>
                    <li><a href="../index.php">หน้าแรก</a></li>
                    <li><a href="../page/products.php">สินค้าทั้งหมด</a></li>
                    <li><a href="../page/promotions.php">โปรโมชั่น</a></li>
                    <li><a href="../page/about.php">เกี่ยวกับเรา</a></li>
                    <li><a href="../page/contact.php">ติดต่อเรา</a></li>
                </ul>
            </nav>
        </div>
    </header>