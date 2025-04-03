<?php
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="styles_regis2.css"> <!-- ลิงก์ไปยังไฟล์ CSS ของคุณ -->
</head>
<body>
    <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    <div class="container">
        <h1>สมัครสมาชิกผู้ประกอบการ</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo '<p class="alert">' . htmlspecialchars($_SESSION['message']) . '</p>';
            unset($_SESSION['message']);
        }
        ?>

        <form action="process_register2.php" method="post">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_]{3,50}">
                <small>ชื่อผู้ใช้ควรมีความยาว 3-50 ตัวอักษร และสามารถประกอบด้วยตัวอักษร, ตัวเลข, และขีดล่าง</small>
            </div>
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required maxlength="100">
            </div>
            <div class="form-group">
                <label for="company_name">ชื่อบริษัท:</label>
                <input type="text" id="company_name" name="company_name" required maxlength="100">
            </div>
            <div class="form-group">
    <label for="business_type">ประเภทธุรกิจ:</label>
    <select id="business_type" name="business_type" required>
        <option value="">-- กรุณาเลือกประเภทธุรกิจ --</option>
        <option value="การก่อสร้างอาคารที่พักอาศัย">การก่อสร้างอาคารที่พักอาศัย</option>
        <option value="การก่อสร้างอาคารที่ไม่ใช่ที่พักอาศัย">การก่อสร้างอาคารที่ไม่ใช่ที่พักอาศัย</option>
        <option value="การเกษตร">การเกษตร</option>
        <option value="การขายส่ง">การขายส่ง</option>
        <option value="การดำเนินงานของสถานที่ออกกำลังกาย">การดำเนินงานของสถานที่ออกกำลังกาย</option>
        <option value="การผลิตเครื่องประดับจากอัญมณีและโลหะมีค่า">การผลิตเครื่องประดับจากอัญมณีและโลหะมีค่า</option>
        <option value="การผลิตและผู้จัดจำหน่าย">การผลิตและผู้จัดจำหน่าย</option>
        <option value="การพิมพ์-สิ่งพิมพ์">การพิมพ์-สิ่งพิมพ์</option>
        <option value="การวิจัยและพัฒนา">การวิจัยและพัฒนา</option>
        <option value="การศึกษา">การศึกษา</option>
        <option value="กรุณากรอกชื่อผู้ติดต่อ">กรุณากรอกชื่อผู้ติดต่อ</option>
        <option value="กรุณากรอกที่อยู่">กรุณากรอกที่อยู่</option>
        <option value="กิจกรรมการบริหารจัดการด้านการขนส่งและสถานที่จัดส่ง">กิจกรรมการบริหารจัดการด้านการขนส่งและสถานที่จัดส่ง</option>
        <option value="กิจกรรมเกี่ยวกับบัญชีการทำบัญชีและการตรวจสอบบัญชี">กิจกรรมเกี่ยวกับบัญชีการทำบัญชีและการตรวจสอบบัญชี</option>
        <option value="ที่ปรึกษา">ที่ปรึกษา</option>
        <option value="ธนาคารพาณิชย์">ธนาคารพาณิชย์</option>
        <option value="ธุรกิจอื่นๆ">ธุรกิจอื่นๆ</option>
        <option value="บริการ">บริการ</option>
        <option value="บริหารศูนย์การค้า">บริหารศูนย์การค้า</option>
        <option value="บันเทิง">บันเทิง</option>
        <option value="ประกันภัย-ประกันชีวิต-ประกันรถยนต์">ประกันภัย-ประกันชีวิต-ประกันรถยนต์</option>
        <option value="พลังงาน">พลังงาน</option>
        <option value="พาณิชย์">พาณิชย์</option>
        <option value="ยา / เครื่องสำอาง / อุปกรณ์ทางการแพทย์">ยา / เครื่องสำอาง / อุปกรณ์ทางการแพทย์</option>
        <option value="ราชการ/รัฐวิสาหกิจ/มูลนิธิ">ราชการ/รัฐวิสาหกิจ/มูลนิธิ</option>
        <option value="กิจกรรมของบริษัทโฆษณา">กิจกรรมของบริษัทโฆษณา</option>
        <option value="ส่งออก-นำเข้า">ส่งออก-นำเข้า</option>
        <option value="สื่อสาร">สื่อสาร</option>
        <option value="อสังหาริมทรัพย์">อสังหาริมทรัพย์</option>
        <option value="ออกแบบ-ตกแต่ง">ออกแบบ-ตกแต่ง</option>
        <option value="ออนไลน์มีเดีย">ออนไลน์มีเดีย</option>
        <option value="อาหาร-เครื่องดื่ม">อาหาร-เครื่องดื่ม</option>
        <option value="อุตสาหกรรมกระดาษ/เครืองเขียน">อุตสาหกรรมกระดาษ/เครืองเขียน</option>
        <option value="อุตสาหกรรมเคมี-พลาสติก">อุตสาหกรรมเคมี-พลาสติก</option>
        <option value="อุตสาหกรรมบรรจุภัณฑ์">อุตสาหกรรมบรรจุภัณฑ์</option>
        <option value="อุตสาหกรรมไฟฟ้า">อุตสาหกรรมไฟฟ้า</option>
        <option value="อุตสาหกรรมยานพาหนะ">อุตสาหกรรมยานพาหนะ</option>
        <option value="อุตสาหกรรมโลหะ">อุตสาหกรรมโลหะ</option>
        <option value="กิจกรรมทางกฎหมาย">กิจกรรมทางกฎหมาย</option>
        <option value="อุตสาหกรรมสิ่งทอ">อุตสาหกรรมสิ่งทอ</option>
        <option value="อุตสาหกรรมอิเลคโทรนิค">อุตสาหกรรมอิเลคโทรนิค</option>
        <option value="กิจกรรมโรงพยาบาล">กิจกรรมโรงพยาบาล</option>
        <option value="กิจกรรมให้คำปรึกษาด้านการสื่อสารประชาสัมพันธ์">กิจกรรมให้คำปรึกษาด้านการสื่อสารประชาสัมพันธ์</option>
        <option value="ขนส่ง">ขนส่ง</option>
        <option value="คอมพิวเตอร์-ไอที">คอมพิวเตอร์-ไอที</option>
        <option value="ค้าปลีก">ค้าปลีก</option>
        <option value="เงินทุนหลักทรัพย์">เงินทุนหลักทรัพย์</option>
        <option value="จัดนำเที่ยว">จัดนำเที่ยว</option>
        <option value="ที่ปรึกษาจัดหางาน">ที่ปรึกษาจัดหางาน</option>
    </select>
</div>

            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required minlength="8">
                <small>รหัสผ่านควรมีความยาวอย่างน้อย 8 ตัวอักษร</small>
            </div>
            <div class="form-group">
                <label for="confirm_password">ยืนยันรหัสผ่าน:</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                <small>กรุณายืนยันรหัสผ่านของคุณ</small>
            </div>
            <div class="form-group">
                <button type="submit">สมัครสมาชิก</button>
            </div>
            <a href="login2.php" class="login-link">เข้าสู่ระบบ</a>
        </form>
    </div>
</body>
</html>
