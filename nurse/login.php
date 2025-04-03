<?php
session_start();
require_once 'config.php';

// ตัวแปรสำหรับจัดการข้อผิดพลาด
$error = '';

// ตรวจสอบว่าการร้องขอเป็น POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์มและป้องกันการโจมตี XSS
    $student_id = htmlspecialchars(trim($_POST['student_id']));
    $password = htmlspecialchars(trim($_POST['password']));

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เตรียมคำสั่ง SQL เพื่อลดความเสี่ยงจาก SQL Injection
    $sql = "SELECT * FROM members1 WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบว่ามีข้อมูลผู้ใช้ที่ตรงกันหรือไม่
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password_hash'])) {
            // ตั้งค่าตัวแปรเซสชัน
            $_SESSION['username'] = $student_id;
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['email'] = $row['email'];

            // เปลี่ยนเส้นทางตามประเภทของผู้ใช้
            if ($row['user_type'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "รหัสนักศึกษาไม่ถูกต้อง";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    <div class="container">
        <h2>เข้าสู่ระบบบัณฑิต</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="student_id">รหัสนักศึกษา:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">เข้าสู่ระบบ</button>
            <div class="links">
                <a href="register.php">สร้างบัญชีใหม่</a>
                <a href="login2.php">สำหรับผู้ประกอบการ</a>
            </div>
        </form>
        <?php
        if (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
    </div>
    <footer>
        <!-- ใส่ข้อมูลในฟุตเตอร์ถ้าจำเป็น -->
    </footer>
</body>
</html>
