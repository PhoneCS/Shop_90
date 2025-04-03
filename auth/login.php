<?php
include('../includes/header.php');
include '../includes/connect.inc.php'; // ตรวจสอบให้แน่ใจว่ามีการเชื่อมต่อฐานข้อมูล
$alertMessage = '';

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

            // ส่งค่าไปยัง JavaScript
            $alertMessage = "success|เข้าสู่ระบบสำเร็จ!";
        } else {
            $alertMessage = "error|❌ รหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        $alertMessage = "error|❌ ไม่พบบัญชีผู้ใช้นี้!";
    }

    $stmt->close();
    $conn->close();
}
?>

<center>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (!empty($alertMessage)) : 
        list($icon, $message) = explode("|", $alertMessage); ?>
        Swal.fire({
            icon: "<?php echo $icon; ?>",
            title: "<?php echo $message; ?>",
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            <?php if ($icon === 'success') : ?>
                window.location.href = "../index.php"; // เปลี่ยนหน้าเมื่อเข้าสู่ระบบสำเร็จ
            <?php endif; ?>
        });
    <?php endif; ?>
</script>

</body>
</html>
<?php
include('../includes/footer.php');
?>
