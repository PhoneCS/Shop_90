<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

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
            /* สีของไอคอน */
            font-size: 1.2rem;
        }

        .form-control {
            padding-left: 35px;
            /* เพิ่ม padding เพื่อเว้นที่สำหรับไอคอน */
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
                            <h4>New to our website?</h4>
                            <p>There are advances being made in science and technology </p>
                            <a class="primary-btn" href="register.php">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Log in</h3>
                        <form class="row login_form" action="checklogin.php" method="post" id="contactForm"
                            novalidate="novalidate">
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-user icon"></i>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Username'">
                            </div>
                            <div class="col-md-12 form-group position-relative">
                                <i class="fa fa-lock icon"></i> <!-- ไอคอนรูปกุญแจ -->
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'">
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>