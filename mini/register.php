<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="CodePixar">
    <meta charset="UTF-8">
    <title>MiniProject</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        /* ใช้ position relative กับ parent div เพื่อให้ไอคอนอยู่ในตำแหน่งที่ถูกต้อง */
        .position-relative {
            position: relative;
        }

        .icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.2rem;
        }

        .form-control {
            padding-left: 35px; /* เพิ่ม padding เพื่อเว้นที่สำหรับไอคอน */
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="img/login.jpg" alt="">
                        <div class="hover">
                            <h4>Already have an account?</h4>
                            <p>Log in to access your account and explore our services.</p>
                            <a class="primary-btn" href="login.php">Log in</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Create an Account</h3>
                        <form class="row login_form" action="register_result.php" method="post" id="registerForm" novalidate="novalidate">
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-user icon"></i>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Name" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Name'" required>
                            </div>
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-user icon"></i> <!-- ไอคอนสำหรับ Username -->
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Username'" required>
                            </div>
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-lock icon"></i> <!-- ไอคอนสำหรับ Password -->
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'" required>
                                <i class="fa fa-eye eye-icon" id="eye-icon" onclick="togglePassword()"></i> <!-- ไอคอนตา -->
                            </div>
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-lock icon"></i> <!-- ไอคอนสำหรับ Confirm Password -->
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Confirm Password'" required>
                                <i class="fa fa-eye eye-icon" id="eye-icon-confirm" onclick="toggleConfirmPassword()"></i> <!-- ไอคอนตา สำหรับยืนยันรหัสผ่าน -->
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="primary-btn">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // ฟังก์ชันสำหรับแสดง/ซ่อนรหัสผ่าน
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            // ตรวจสอบสถานะการมองเห็นของรหัสผ่าน
            if (passwordField.type === "password") {
                passwordField.type = "text"; // แสดงรหัสผ่าน
                eyeIcon.classList.remove("fa-eye"); // เปลี่ยนไอคอนตา
                eyeIcon.classList.add("fa-eye-slash"); // เปลี่ยนไอคอนเป็นตาปิด
            } else {
                passwordField.type = "password"; // ซ่อนรหัสผ่าน
                eyeIcon.classList.remove("fa-eye-slash"); // เปลี่ยนไอคอนตาปิด
                eyeIcon.classList.add("fa-eye"); // เปลี่ยนไอคอนเป็นตา
            }
        }

        // ฟังก์ชันสำหรับแสดง/ซ่อนยืนยันรหัสผ่าน
        function toggleConfirmPassword() {
            var confirmPasswordField = document.getElementById("confirm_password");
            var eyeIconConfirm = document.getElementById("eye-icon-confirm");

            // ตรวจสอบสถานะการมองเห็นของยืนยันรหัสผ่าน
            if (confirmPasswordField.type === "password") {
                confirmPasswordField.type = "text"; // แสดงยืนยันรหัสผ่าน
                eyeIconConfirm.classList.remove("fa-eye"); // เปลี่ยนไอคอนตา
                eyeIconConfirm.classList.add("fa-eye-slash"); // เปลี่ยนไอคอนเป็นตาปิด
            } else {
                confirmPasswordField.type = "password"; // ซ่อนยืนยันรหัสผ่าน
                eyeIconConfirm.classList.remove("fa-eye-slash"); // เปลี่ยนไอคอนตาปิด
                eyeIconConfirm.classList.add("fa-eye"); // เปลี่ยนไอคอนเป็นตา
            }
        }
    </script>
</body>

</html>
