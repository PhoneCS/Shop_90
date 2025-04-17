<?php include('../includes/header.php'); 

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือยัง
$name = '';
$email = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงชื่อและอีเมลจากฐานข้อมูล
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $user_email);
    $stmt->fetch();
    $stmt->close();

    $name = htmlspecialchars($username);
    $email = htmlspecialchars($user_email);
}
?>
<!-- รวมส่วนหัว -->

<!-- Contact Us Section -->
<section class="contact-us container">
    <h2 class="section-title">ติดต่อเรา</h2>

    <!-- ช่องทางการติดต่อ -->
    <div class="contact-methods">
        <div class="contact-method">
            <i class="fas fa-phone-alt"></i>
            <h3>เบอร์โทรศัพท์</h3>
            <p>โทร: <a href="tel:+66987654321">+66 98 765 4321</a></p>
        </div>


        <div class="contact-method">
            <i class="fas fa-envelope"></i>
            <h3>อีเมล</h3>
            <p>อีเมล: <a href="mailto:support@website.com">support@website.com</a></p>
        </div>

        <div class="contact-method">
            <i class="fas fa-briefcase"></i>
            <h3>เสนอขายสินค้า / บริการ</h3>
            <p>หากคุณต้องการนำเสนอสินค้าหรือบริการ กรุณา<a href="../page/offer_for_sale.php">กรอกแบบฟอร์มเสนอขาย</a>
            </p>
        </div>
    </div>

    <!-- ฟอร์มติดต่อ -->
    <div class="contact-form">
        <h3>ส่งข้อความถึงเรา</h3>
        <form action="../process/submit_contact.php" method="POST">
            <div class="form-group">
                <label for="name">ชื่อ</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" placeholder="กรอกชื่อของคุณ" required
                    readonly>
            </div>

            <div class="form-group">
                <label for="email">อีเมล</label>
                <input type="email" id="email" name="email" value="<?= $email ?>" placeholder="กรอกอีเมลของคุณ" required
                    readonly>
            </div>


            <div class="form-group">
                <label for="message">ข้อความ</label>
                <textarea id="message" name="message" rows="5" placeholder="กรอกข้อความของคุณ" required></textarea>
            </div>

            <button type="submit" class="btn-submit">ส่งข้อความ</button>
        </form>
    </div>

    <!-- แผนที่ -->

</section>

<?php include('../includes/footer.php'); ?>
<!-- รวมส่วนท้าย -->