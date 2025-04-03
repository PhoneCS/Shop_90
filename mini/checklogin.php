<?php
session_start();
include 'connect.inc.php';

$username = $_POST['username'];
$password = $_POST['password'];
?>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
// ตรวจสอบว่าชื่อผู้ใช้มีอยู่ในฐานข้อมูลหรือไม่
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) === 1) {
    $arr = mysqli_fetch_array($result);

    // ตรวจสอบรหัสผ่านที่ป้อนกับรหัสผ่านที่เข้ารหัสในฐานข้อมูล
    if (password_verify($password, $arr['password'])) {
        // หากเข้าสู่ระบบสำเร็จ
        $_SESSION['id'] = $arr['id'];
        $_SESSION['name'] = $arr['name'];

        $msg = "Login successful!";
        ?>
        <script type="text/javascript">
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '<?php echo $msg; ?>',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location = 'overview.php'; // เปลี่ยนเส้นทางไปยังหน้า overview
            });
        </script>
        <?php
    } else {
        // รหัสผ่านไม่ถูกต้อง
        $msg0 = "Incorrect username or password";
        ?>
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $msg0; ?>',
                confirmButtonText: 'Try Again'
            }).then(() => {
                window.location = 'login.php'; // กลับไปยังหน้าเข้าสู่ระบบ
            });
        </script>
        <?php
    }
} else {
    // ไม่พบชื่อผู้ใช้
    $msg0 = "Incorrect username or password";
    ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $msg0; ?>',
            confirmButtonText: 'Try Again'
        }).then(() => {
            window.location = 'login.php'; // กลับไปยังหน้าเข้าสู่ระบบ
        });
    </script>
    <?php
}
?>
</body>
</html>
