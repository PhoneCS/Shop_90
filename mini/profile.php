<?php
session_start();
include 'connect.inc.php';

?>
<html>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
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

<div class="container mt-5">
        <div class="card p-4">
            <h2 class="mb-4">ข้อมูลโปรไฟล์ของคุณ</h2>
            <div class="row">
                <div class="col-md-4">
                    <img src="img/profile.jpg" alt="Profile Picture" class="img-fluid rounded-circle" style="max-width: 200px;">
                </div>
                <div class="col-md-8">
                    <h4>ชื่อ: <?php echo $_SESSION['name']; ?></h4>
                    <a href="edit_profile.php" class="btn btn-primary">แก้ไขข้อมูล</a>
                    <a href="change_password.php" class="btn btn-warning">เปลี่ยนรหัสผ่าน</a>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <ul>
                <li>คุณได้เข้าสู่ระบบเมื่อ 2 ชั่วโมงที่แล้ว</li>
            </ul>
        </div>
    </div>
    
</body>

</html>