<?php
include '../includes/connect.inc.php';
$alertMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);

    // รับค่าที่อยู่แต่ละส่วน
    $house_number = trim($_POST['house_number']);
    $sub_district = trim($_POST['sub_district']);
    $district = trim($_POST['district']);
    $province = trim($_POST['province']);
    $postcode = trim($_POST['postcode']);

    // รวมข้อมูลที่อยู่ทั้งหมดไว้ที่ address
    $address = "บ้านเลขที่ $house_number, ตำบล $sub_district, อำเภอ $district, จังหวัด $province, $postcode";

    // ตรวจสอบว่าชื่อผู้ใช้หรืออีเมลซ้ำหรือไม่
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alertMessage = "error|ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว!";
    } else {
        // บันทึกข้อมูลลงฐานข้อมูล
        $query = "INSERT INTO users (username, email, password, phone_number, address, user_type) VALUES (?, ?, ?, ?, ?, 'customer')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $username, $email, $password, $phone, $address);

        if ($stmt->execute()) {
            $alertMessage = "success|สมัครสมาชิกสำเร็จ!";
        } else {
            $alertMessage = "error|เกิดข้อผิดพลาดในการสมัครสมาชิก!";
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
                <label>บ้านเลขที่</label>
                <input type="text" name="house_number" required>
            </div>
            <div class="input-group">
                <label>ตำบล</label>
                <input type="text" name="sub_district" required>
            </div>
            <div class="input-group">
                <label>อำเภอ</label>
                <input type="text" name="district" required>
            </div>
            <div class="input-group">
                <label>จังหวัด</label>
                <input type="text" name="province" required>
            </div>
            <div class="input-group">
                <label>รหัสไปรษณีย์</label>
                <input type="text" name="postcode" required>
            </div>

            <button type="submit" class="register-btn">สมัครสมาชิก</button>
        </form>
        <p class="login-link">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
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
            text: "<?php echo ($icon === 'success') ? 'กำลังเปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ...' : ''; ?>",
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            <?php if ($icon === 'success') : ?>
                window.location.href = "login.php";
            <?php endif; ?>
        });
    <?php endif; ?>
</script>

</body>
</html>
<?php include('../includes/footer.php'); ?>
