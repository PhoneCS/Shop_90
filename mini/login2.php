<?php
session_start();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand" href="login.php">
                <b>WELCOME</b>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow p-4 mb-5 bg-white rounded">
                    <div class="text-center">
                        <img src="img/computer.png" alt="Logo" width="200" height="150">
                        <h4 class="mb-4">เข้าสู่ระบบ</h4>
                    </div>
                    <form name="form-login" method="POST" action="checklogin.php">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" required minlength="3"
                                placeholder="ชื่อผู้ใช้">
                        </div>
                        <div class="mb-4">
                            <input type="password" name="password" class="form-control" required minlength="3"
                                placeholder="รหัสผ่าน">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">ล็อกอิน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"></script>
</body>
</html>