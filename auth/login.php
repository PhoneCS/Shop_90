<?php
include('../includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = trim($_POST['username_email']);
    $password = trim($_POST['password']);

    // ค้นหาผู้ใช้จาก username หรือ email
    $query = "SELECT user_id, username, email, password, user_type FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // **เปลี่ยนเส้นทางไปหน้า index.php**
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "❌ รหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        $_SESSION['login_error'] = "❌ ไม่พบบัญชีผู้ใช้นี้!";
    }

    $stmt->close();
    $conn->close();
}
?>



<center>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <?php if (isset($_SESSION['login_error'])): ?>
            <p class="error-message"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label>ชื่อผู้ใช้ หรือ อีเมล</label>
                <input type="text" name="username_email" required>
            </div>
            <div class="input-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">เข้าสู่ระบบ</button>
        </form>
        <p class="register-link">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
    </div>
    </center>
</body>
</html>
<?php
include('../includes/footer.php');
?>
