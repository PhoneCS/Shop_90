<?php include('../includes/header.php'); ?>  <!-- รวมส่วนหัว -->

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
            <i class="fas fa-map-marker-alt"></i>
            <h3>ที่อยู่</h3>
            <p>1234 ถนนตัวอย่าง แขวงบางพลัด กรุงเทพมหานคร</p>
        </div>
    </div>

    <!-- ฟอร์มติดต่อ -->
    <div class="contact-form">
        <h3>ส่งข้อความถึงเรา</h3>
        <form action="submit_contact.php" method="POST">
            <div class="form-group">
                <label for="name">ชื่อ</label>
                <input type="text" id="name" name="name" placeholder="กรอกชื่อของคุณ" required>
            </div>

            <div class="form-group">
                <label for="email">อีเมล</label>
                <input type="email" id="email" name="email" placeholder="กรอกอีเมลของคุณ" required>
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

<?php include('../includes/footer.php'); ?>  <!-- รวมส่วนท้าย -->
