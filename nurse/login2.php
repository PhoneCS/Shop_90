<?php
session_start();
require_once 'config.php'; // รวมการตั้งค่าการเชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่ามีชื่อผู้ใช้และรหัสผ่านที่ตรงกันหรือไม่ในตาราง members2
    $sql = "SELECT * FROM members2 WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // ตั้งค่าตัวแปร session
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['company_name'] = $row['company_name']; // เพิ่มข้อมูลบริษัท
            $_SESSION['business_type'] = $row['business_type']; // เพิ่มประเภทธุรกิจ

            header("Location: index2.php"); // เปลี่ยนเส้นทางไปที่หน้า index2.php
            exit();
        } else {
            $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="styles_login2.css">
</head>
<body>
    <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    <div class="container">
        <h2>เข้าสู่ระบบผู้ประกอบการ</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">เข้าสู่ระบบ</button>
            <div class="links">
                <a href="register2.php">สร้างบัญชีใหม่</a>
                <a href="login.php">สำหรับบัณฑิต</a>
            </div>
        </form>
        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
    </div>
    <footer>
        <!-- เพิ่มเนื้อหาของฟุตเตอร์ที่นี่ -->
    </footer>
</body>
</html>
