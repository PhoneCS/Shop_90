<?php
session_start();
include 'connect.inc.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Passwords do not match!',
                confirmButtonText: 'Try Again'
            }).then(() => {
                window.location = 'register.php';
            });
        });
    </script>
    <?php
    exit();
}

// Check if username already exists
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // Username already taken
    ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username is already taken!',
                confirmButtonText: 'Try Again'
            }).then(() => {
                window.location = 'register.php';
            });
        });
    </script>
    <?php
} else {
    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$hashed_password')";
    $result = mysqli_query($link, $sql);

    if ($result) {
        // Registration successful
        ?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Register Success!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location = 'login.php'; // Redirect to login page
                });
            });
        </script>
        <?php
    } else {
        // Registration failed
        ?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'There was an error with registration. Please try again.',
                    confirmButtonText: 'Try Again'
                }).then(() => {
                    window.location = 'register.php';
                });
            });
        </script>
        <?php
    }
}
?>
