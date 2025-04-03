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
        .input__container {
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: rgba(255, 255, 255, 0.3);
            padding: 50px;
            border-radius: 20px;
            position: relative;
            margin-bottom: 20px;
        }

        .input__container::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            filter: blur(25px);
            border-radius: 20px;
            background-color: #e499ff;
            background-image: radial-gradient(at 47% 69%, hsla(17, 62%, 65%, 1) 0px, transparent 50%),
                radial-gradient(at 9% 32%, hsla(222, 75%, 60%, 1) 0px, transparent 50%);
        }

        .input__label {
            display: block;
            color: #000;
            text-transform: uppercase;
            font-size: 1em;
            font-weight: bold;
            margin-left: 0.2em;
        }

        .input__description {
            font-size: 0.9em;
            font-weight: bold;
            text-align: center;
            color: rgba(0, 0, 0, 0.6);
            margin-top: 10px;
        }

        .input-field {
            position: relative;
        }

        .icon {
            position: absolute;
            top: 70%;
            left: 15px;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.4rem;
        }

        .input {
            border: none;
            outline: none;
            width: 100%;
            padding: 0.8em 1em 0.8em 3em;
            border-radius: 20px;
            font-size: 1rem;
            background: #fff;
            transition: background 300ms, color 300ms;
        }

        .input:hover,
        .input:focus {
            background: rgb(0, 0, 0);
            color: #fff;
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
                            <p>There are advances being made in science and technology</p>
                            <a class="primary-btn" href="register.php">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Log in</h3>
                        <form class="row login_form" action="checklogin.php" method="post" id="contactForm" novalidate="novalidate">
                            <div class="input__container">
                                <div class="input-field">
                                    <label class="input__label" for="username">Username</label>
                                    <i class="fa fa-user icon"></i>
                                    <input type="text" class="form-control input" id="username" name="username" placeholder="Enter your username">
                                </div>
                                <div class="input-field">
                                    <label class="input__label" for="password">Password</label>
                                    <i class="fa fa-lock icon"></i>
                                    <input type="password" class="form-control input" id="password" name="password" placeholder="Enter your password">
                                </div>
                                <p class="input__description">Please enter your credentials to log in.</p>
                            </div>
                            <div class="col-md-12 form-group mt-3">
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
