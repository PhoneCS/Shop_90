<?php
session_start();
require_once 'config.php';

// ตรวจสอบการเข้าสู่ระบบของผู้ใช้และสิทธิ์การเข้าถึง
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php"); // เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบถ้าไม่ใช่แอดมิน
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // ตรวจสอบข้อมูล
    if (!empty($username) && !empty($password) && !empty($email)) {
        // เชื่อมต่อฐานข้อมูล
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // เพิ่มข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO members (username, password, email, user_type) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            $success = "เพิ่มข้อมูลผู้ใช้เรียบร้อยแล้ว!";
        } else {
            $error = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<div class="welcome">

    <title>Admin - เพิ่มข้อมูลผู้ใช้</title>
    <link rel="stylesheet" href="styles_admin.css"> <!-- ใช้สไตล์ที่คล้ายกับ index.php -->
</head>
<body>
    <header>
        <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    </header>
    <p>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['email']); ?>)</p>
    <meta charset="UTF-8">
      
    <footer>
        <a href="adduser_admin.php">เพิ่มบัญชีบัณฑิต</a>
        
       
    </footer>
    <footer>
        <a href="admin_approval.php">ตรวจสอบและอนุมัติข้อมูลบัณฑิต</a>
        <a href="admin_approval2.php">ตรวจสอบและอนุมัติข้อมูลผู้ประกอบการ</a>
        
    </footer>
    <footer>
        <a href="https://regis.nsru.ac.th/verify/home.php?p=individual">ตรวจสอบข้อมูลบัณฑิต</a>
    </footer>
    <footer>
        <a href="logout.php">ออกจากระบบ</a>
    </footer>
</body>
</html>
