<?php
session_start();
require_once 'config.php';
require 'vendor/autoload.php'; // Include Composer autoload file for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

            // ส่งอีเมลแจ้งเตือนด้วย PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->SMTPAuth   = true;                               
                $mail->Username   = 'your-email@gmail.com'; // อีเมล Gmail ของคุณ
                $mail->Password   = 'your-email-password'; // รหัสผ่านของ Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
                $mail->Port       = 587; // ใช้พอร์ต 587 สำหรับ TLS

                $mail->setFrom('your-email@gmail.com', 'Mailer');
                $mail->addAddress($email); // เพิ่มอีเมลของผู้ใช้

                $mail->isHTML(true);                                  
                $mail->Subject = 'ยินดีต้อนรับสู่ระบบ';
                $mail->Body    = "สวัสดี $username,<br><br>คุณได้ถูกเพิ่มเข้ามาในระบบแล้ว คุณสามารถเข้าสู่ระบบได้ที่: <a href='http://yourwebsite.com/login.php'>เข้าสู่ระบบ</a><br><br>ขอบคุณครับ";

                $mail->send();
                $success .= " อีเมลแจ้งเตือนถูกส่งไปยัง $email แล้ว.";
            } catch (Exception $e) {
                $error = "เกิดข้อผิดพลาดในการส่งอีเมล: {$mail->ErrorInfo}";
            }

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
    <meta charset="UTF-8">
    <title>Admin - เพิ่มข้อมูลผู้ใช้</title>
    <link rel="stylesheet" href="styles_admin.css"> <!-- ใช้สไตล์ที่คล้ายกับ index.php -->
</head>
<body>
    <header>
        <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    </header>
    <main class="container">
        <h2>เพิ่มข้อมูลผู้ใช้ใหม่</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="name">ชื่อ:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="username">username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">เพิ่มข้อมูล</button>
            <?php
            if (isset($success)) {
                echo "<p class='success'>$success</p>";
            }
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            }
            ?>
        </form>
    </main>
    <footer>
        <a href="admin.php">หน้าหลัก</a>
        <a href="logout.php">ออกจากระบบ</a>
    </footer>
</body>
</html>
