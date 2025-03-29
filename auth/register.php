<?php
include '../includes/connect.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // ตรวจสอบว่าชื่อผู้ใช้หรืออีเมลซ้ำหรือไม่
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว!";
    } else {
        // บันทึกข้อมูลลงฐานข้อมูล
        $query = "INSERT INTO users (username, email, password, phone_number, address, user_type) VALUES (?, ?, ?, ?, ?, 'customer')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $username, $email, $password, $phone, $address);

        if ($stmt->execute()) {
            echo "สมัครสมาชิกสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a>";
        } else {
            echo "เกิดข้อผิดพลาดในการสมัครสมาชิก!";
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<?php include('../includes/header.php'); ?>
<center>
    <div class="register-container">
        <h2>สมัครสมาชิก</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label>ชื่อผู้ใช้</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label>อีเมล</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-group">
                <label>เบอร์โทรศัพท์</label>
                <input type="text" name="phone">
            </div>
            <div class="input-group">
                <label>ที่อยู่</label>
                <textarea name="address"></textarea>
            </div>
            <button type="submit" class="register-btn">สมัครสมาชิก</button>
        </form>
        <p class="login-link">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
    </center>
</body>
</html>
<?php
include('../includes/footer.php');
?>
