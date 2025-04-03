<?php
session_start();
require_once 'config.php'; // รวมการตั้งค่าการเชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login2.php");
    exit();
}

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามี ID ของโพสต์ใน URL หรือไม่
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$post_id = (int) $_GET['id'];

// ตรวจสอบว่าผู้ใช้เป็นเจ้าของโพสต์หรือไม่
$sql_check_owner = "SELECT email FROM graduates2 WHERE id = ?";
$stmt_check_owner = $conn->prepare($sql_check_owner);
$stmt_check_owner->bind_param("i", $post_id);
$stmt_check_owner->execute();
$result_check_owner = $stmt_check_owner->get_result();
$post = $result_check_owner->fetch_assoc();

if ($post['email'] !== $_SESSION['email']) {
    die("You are not authorized to edit this post.");
}

// ดึงข้อมูลโพสต์ที่ต้องการแก้ไข
$sql = "SELECT * FROM graduates2 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post_data = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบการกรอกข้อมูล
    $company_name = $_POST['company_name'] ?? '';
    $job_title = $_POST['job_title'] ?? '';
    $job_type = $_POST['job_type'] ?? '';
    $location = $_POST['location'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $education_requirements = $_POST['education_requirements'] ?? '';
    $company_benefits = $_POST['company_benefits'] ?? '';
    $contact_channels = $_POST['contact_channels'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $business_type = $_POST['business_type'] ?? '';
    $province = $_POST['province'] ?? '';
    $district = $_POST['district'] ?? '';
    $sub_district = $_POST['sub_district'] ?? '';
    $postal_code = $_POST['postal_code'] ?? '';
    $qualifications = $_POST['qualifications'] ?? '';
    $contact_email = $_POST['contact_email'] ?? '';
    $faculty = $_POST['faculty'] ?? '';
    $major = $_POST['major'] ?? '';

    // ตรวจสอบข้อมูลที่กรอก
    if (empty($company_name) || empty($job_title) || empty($job_type) || empty($location) || empty($salary) || empty($education_requirements) 
       || empty($company_benefits) || empty($contact_channels) || empty($contact_person) || empty($business_type) || empty($province) 
       || empty($qualifications) || empty($contact_email) || empty($faculty) || empty($major)) {
        echo "<p>กรุณากรอกข้อมูลให้ครบถ้วน</p>";
    } else {
        // เตรียมคำสั่ง SQL สำหรับการแก้ไขโพสต์
        $sql_update = "UPDATE graduates2 SET company_name = ?, job_title = ?, job_type = ?, location = ?, salary = ?, education_requirements = ?, company_benefits = ?, contact_channels = ?, contact_person = ?, business_type = ?, province = ?, district = ?, sub_district = ?, postal_code = ?, qualifications = ?, contact_email = ?, faculty = ?, major = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssssssssssssss", $company_name, $job_title, $job_type, $location, $salary, $education_requirements, 
        $company_benefits, $contact_channels, $contact_person, $business_type, $province, $district, $sub_district, $postal_code, 
        $qualifications, $contact_email, $faculty, $major, $post_id);

        if ($stmt_update->execute()) {
            // รีไดเรกต์ไปยังหน้า index2.php หลังจากการอัปเดตสำเร็จ
            header("Location: index2.php");
            exit();
        } else {
            echo "<p>เกิดข้อผิดพลาด: " . $stmt_update->error . "</p>";
        }

        $stmt_update->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโพสต์งาน</title>
    <link rel="stylesheet" href="styles_edit2.css"> <!-- ใช้ไฟล์ CSS ของคุณ -->
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>แก้ไขโพสต์งาน</h1>
            <nav class="nav">
                <a href="index2.php">กลับไปที่หน้าหลัก</a>
                <a href="logout.php" class="logout-link">ออกจากระบบ</a>
            </nav>
        </header>
        <main class="edit-form">
            <form action="edit_post2.php?id=<?php echo urlencode($post_id); ?>" method="POST">
                <div class="post-section">
                            <h3>ข้อมูลทั่วไป</h3>
                            <div class="form-group">
                    <label for="company_name">ชื่อบริษัท:</label>
                    <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($post_data['company_name']); ?>" required>
                </div>
                            <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($post['email']); ?></p>
                            <div class="form-group">
                    <label for="contact_person">ชื่อผู้ติดต่อ:</label>
                    <input type="text" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($post_data['contact_person']); ?>" required>
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
                    <label for="location">ที่อยู่ที่ทำงาน:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($post_data['location']); ?>" required>
                </div>

                        <!-- ข้อมูลตำแหน่งงาน -->
                        <div class="post-section">
                            <h3>ข้อมูลหาพนักงาน</h3>
                            <div class="form-group">
    <label for="faculty">คณะ:</label>
    <select id="faculty" name="faculty" onchange="updateMajor()">
        <option value="">--กรุณาเลือก--</option>
        <option value="คณะวิทยาศาสตร์และเทคโนโลยี">คณะวิทยาศาสตร์และเทคโนโลยี</option>
        <option value="คณะมนุษยศาสตร์และสังคมศาสตร์">คณะมนุษยศาสตร์และสังคมศาสตร์</option>
        <option value="คณะวิทยาการจัดการ">คณะวิทยาการจัดการ</option>
        <option value="คณะเทคโนโลยีการเกษตรและเทคโนโลยีอุตสาหกรรม">คณะเทคโนโลยีการเกษตรและเทคโนโลยีอุตสาหกรรม</option>
        <option value="คณะครุศาสตร์">คณะครุศาสตร์</option>
        <option value="บัณฑิตศึกษา">บัณฑิตศึกษา</option>
    </select>
</div>
<div class="form-group">
    <label for="major">สาขา:</label>
    <select id="major" name="major">
        <option value="">-- กรุณาเลือกสาขา --</option>
        <!-- ตัวเลือกสาขาจะถูกเติมโดย JavaScript -->
    </select>
</div>

<script>
    function updateMajor() {
        var faculty = document.getElementById("faculty").value;
        var major = document.getElementById("major");

        // ล้างตัวเลือกในช่องสาขา
        major.innerHTML = '<option value="">-- กรุณาเลือกสาขา --</option>';

        // ตัวเลือกสาขาตามคณะที่เลือก
        var options = [];

        if (faculty === "คณะวิทยาศาสตร์และเทคโนโลยี") {
            options = [
                "สาขาวิชาคณิตศาสตร์",
                "สาขาวิชาชีววิทยา",
                "สาขาวิชาเทคโนโลยีชีวภาพ",
                "สาขาวิชาฟิสิกส์อุตสาหกรรม",
                "สาขาวิชาวิทยาการคอมพิวเตอร์",
                "สาขาวิชาวิทยาการคอมพิวเตอร์ภาษาไทย",
                "สาขาวิชาวิทยาการคอมพิวเตอร์ภาษาอังกฤษ",
                "สาขาวิชาวิทยาศาสตร์สิ่งแวดล้อม",
                "สาขาวิชาสถิติ",
                "สาขาวิชาสาธารณสุขศาสตร์",
                "สาขาวิชาเคมี",
                "สาขาวิชาเทคโนโลยีสารสนเทศและการสื่อสาร",
                "สาขาวิชาวิทยาการคอมพิวเตอร์คณิตศาสตร์",
                "สาขาวิชาวิทยาการคอมพิวเตอร์สถิติ"
            ];
        } else if (faculty === "คณะมนุษยศาสตร์และสังคมศาสตร์") {
            options = [
                "สาขาวิชาสหวิทยาการเพื่อการพัฒนาท้องถิ่น",
                "สาขาวิชาการพัฒนาชุมชน",
                "สาขาวิชาดนตรี สาขาวิชาดนตรีสากล",
                "สาขาวิชาดนตรี สาขาวิชาดนตรีไทย",
                "สาขาวิชานาฏศิลป์และการละคร",
                "สาขาวิชานิติศาสตร์",
                "สาขาวิชาภาษาอังกฤษ",
                "สาขาวิชารัฐประศาสนศาสตร์ สาขาวิชาการปกครองท้องถิ่น", 
                "สาขาวิชารัฐศาสตร์ แขนงวิชาการเมืองการปกครอง",
                "สาขาวิชารัฐศาสตร์ แขนงวิชาการปกครองท้องถิ่น",
                "สาขาวิชารัฐศาสตร์ แขนงวิชารัฐประศาสนศาสตร์",
                "สาขาวิชารัฐศาสตร์ แขนงวิชากระบวนการบริหารงานยุติธรรม",
                "สาขาวิชาวัฒนธรรมศึกษา",
                "สาขาวิชาออกแบบประยุกต์ศิลป์",
                "สาขาวิชาภาษาอังกฤษภาษาจีน",
                "สาขาวิชาภาษาไทยเพื่ออาชีพ",
                "สาขาวิชาภาษาไทยเพื่ออาชีพ (ต่อเนื่อง)",
                "สาขาวิชาภูมิสารสนเทศเพื่อการพัฒนา",
                "สาขาวิชาภาษาอังกฤษเพื่อการสื่อสารทางธุรกิจ"
            ];
        } else if (faculty === "คณะครุศาสตร์") {
            options = [
                "วิชาเอกการศึกษาปฐมวัย",
                "วิชาเอกพลศึกษา",
                "วิชาเอกภาษาไทย",
                "วิชาเอกภาษาอังกฤษ",
                "วิชาเอกคอมพิวเตอร์ศึกษา",
                "วิชาเอกสังคมศึกษา",
                "วิชาเอกคณิตศาสตร์",
                "วิชาเอกวิทยาศาสตร์"
            ];
        } else if (faculty === "คณะเทคโนโลยีการเกษตรและเทคโนโลยีอุตสาหกรรม") {
            options = [
                "สาขาวิชาเกษตรศาสตร์ แขนงวิชาเทคโนโลยีการผลิตพืช",
                "สาขาวิชาเกษตรศาสตร์ แขนงวิชาเทคโนโลยีการผลิตสัตว์",
                "สาขาวิชาเกษตรศาสตร์ แขนงวิชาเทคโนโลยีเพาะเลี้ยงสัตว์น้ำ",
                "สาขาวิชาวิทยาศาสตร์และเทคโนโลยีการอาหาร",
                "สาขาวิชาเทคโนโลยีเครื่องกล",
                "สาขาวิชาเทคโนโลยีการจัดการอุตสาหกรรม",
                "สาขาวิชาเทคโนโลยีเซรามิกส์",
                "สาขาวิชาไฟฟ้าอุตสาหกรรม",
                "สาขาวิชาไฟฟ้าสื่อสาร",
                "สาขาวิชาการออกแบบ แขนงออกแบบผลิตภัณฑ์อุตสาหกรรม",
                "สาขาวิชาการออกแบบ แขนงคอมพิวเตอร์กราฟิก",
                "สาขาวิชาการออกแบบ แขนงออกแบบบรรจุภัณฑ์"
            ];
        } else if (faculty === "คณะวิทยาการจัดการ") {
            options = [
                "สาขาวิชาการบริหารธุรกิจ สาขาวิชาการตลาด",
                "สาขาวิชาการบริหารธุรกิจ สาขาวิชาการบริหารทรัพยากรมนุษย์",
                "สาขาวิชาการบริหารธุรกิจ สาขาวิชาคอมพิวเตอร์ธุรกิจ",
                "สาขาวิชาการบัญชี",
                "สาขาวิชาเศรษฐศาสตร์ธุรกิจ",
                "สาขาวิชาการท่องเที่ยวและการโรงแรม",
                "สาขาวิชานิเทศศาสตร์ วิชาเอกการโฆษณา",
                "สาขาวิชานิเทศศาสตร์ วิชาเอกการประชาสัมพันธ์",
                "สาขาวิชานิเทศศาสตร์ วิชาเอกวารสารศาสตร์"
            ];
        } else if (faculty === "บัณฑิตศึกษา") {
            options = [
                "ครุศาสตรดุษฎีบัณฑิต สาขาวิชาการจัดการศึกษาและการเรียนรู้",
                "ครุศาสตรมหาบัณฑิตสาขาวิชาการบริหารการศึกษา",
                "ครุศาสตรมหาบัณฑิต สาขาวิชาหลักสูตรและการสอน",
                "ครุศาสตรมหาบัณฑิต สาขาวิชาการส่งเสริมสุขภาพ",
                "ครุศาสตรมหาบัณฑิต สาขาวิชาวิจัยและประเมินผลการศึกษา",
                "ศิลปศาสตรมหาบัณฑิต สาขาวิชายุทธศาสตร์การพัฒนา",
                "วิทยาศาสตรมหาบัณฑิต สาขาวิชาการจัดการการเกษตร",
                "ประกาศนียบัตรบัณฑิต สาขาวิชาวิชาชีพครู"
            ];
        }

        // เพิ่มตัวเลือกสาขาที่เกี่ยวข้อง
        for (var i = 0; i < options.length; i++) {
            var opt = document.createElement('option');
            opt.value = options[i];
            opt.innerHTML = options[i];
            major.appendChild(opt);
        }
    }

    // ตั้งค่าให้ฟังก์ชัน updateMajor ทำงานเมื่อหน้าโหลดเสร็จ
    window.onload = function() {
        updateMajor(); // ฟังก์ชันนี้จะทำงานเมื่อหน้าโหลดเสร็จ
    };
</script>

                
                            <div class="form-group">
    <label for="job_title">ตำแหน่งงาน:</label>
    <select id="job_title" name="job_title">
        <option value=""><?php echo htmlspecialchars($post_data['job_title']); ?></option>
        <option value="งานบัญชี">งานบัญชี</option>
        <option value="งานธุรการ">งานธุรการ</option>
        <option value="งานโฆษณา">งานโฆษณา</option>
        <option value="งานศิลปะ">งานศิลปะ</option>
        <option value="งานสื่อ">งานสื่อ</option>
        <option value="งานธนาคาร">งานธนาคาร</option>
        <option value="งานการเงิน">งานการเงิน</option>
        <option value="งานวิศวกรรม">งานวิศวกรรม</option>
        <option value="งานราชการ">งานราชการ</option>
        <option value="งานดูแลสุขภาพและการแพทย์">งานดูแลสุขภาพและการแพทย์</option>
        <option value="งานบริการ">งานบริการ</option>
        <option value="งานท่องเที่ยว">งานท่องเที่ยว</option>
        <option value="งานทรัพยากรบุคคล">งานทรัพยากรบุคคล</option>
        <option value="งานสรรหาบุคลากร">งานสรรหาบุคลากร</option>
        <option value="งานไอที">งานไอที</option>
        <option value="งานเทคโนโลยีสื่อสาร">งานเทคโนโลยีสื่อสาร</option>
        <option value="งานกฎหมาย">งานกฎหมาย</option>
        <option value="งานการผลิต">งานการผลิต</option>
        <option value="งานขนส่ง">งานขนส่ง</option>
        <option value="งานการตลาด">งานการตลาด</option>
        <option value="งานสื่อสาร">งานสื่อสาร</option>
        <option value="งานวิทยาศาสตร์">งานวิทยาศาสตร์</option>
        <option value="งานเทคโนโลยี">งานเทคโนโลยี</option>
    </select>
</div>
                <div class="form-group">
    <label for="job_type">รูปแบบงาน:</label>
    <select id="job_type" name="job_type">
        <option value=""><?php echo htmlspecialchars($post_data['job_type']); ?></option>
        
        
        
        <option value="Part time">Part time</option>
        <option value="งานประจำ">งานประจำ</option>
    </select>
    
                <div class="form-group">
    <label for="province">จังหวัด:</label>
    <select id="province" name="province" required>
        <option value="">-- กรุณาเลือกจังหวัด --</option>
        <?php
        $provinces = [
            "กรุงเทพมหานคร", "เชียงใหม่", "เชียงราย", "นครราชสีมา", "สงขลา",
            "ชลบุรี", "ขอนแก่น", "พิษณุโลก", "นครปฐม", "ประจวบคีรีขันธ์",
            "อยุธยา", "อุดรธานี", "อุบลราชธานี", "บุรีรัมย์", "สุพรรณบุรี",
            "นครสวรรค์", "สมุทรปราการ", "ระยอง", "ราชบุรี", "นราธิวาส",
            "ยะลา", "ปัตตานี", "กรุงเทพมหานคร", "พิจิตร", "เพชรบูรณ์",
            "ตาก", "พิษณุโลก", "เพชรบุรี", "สระบุรี", "ลำพูน",
            "ลำปาง", "แพร่", "น่าน", "แม่ฮ่องสอน", "เชียงใหม่",
            "ขอนแก่น", "อุดรธานี", "บึงกาฬ", "หนองบัวลำภู", "เลย",
            "นครพนม", "สกลนคร", "กาฬสินธุ์", "ร้อยเอ็ด", "มหาสารคาม",
            "ยโสธร", "อำนาจเจริญ", "บุรีรัมย์", "ศรีสะเกษ", "อุบลราชธานี",
            "สุรินทร์", "นครราชสีมา", "ชัยภูมิ", "ระนอง", "สุราษฎร์ธานี",
            "พังงา", "ภูเก็ต", "กระบี่", "ตรัง", "พัทลุง",
            "สงขลา", "นราธิวาส", "ยะลา", "ปัตตานี", "ภูเก็ต",
            "สตูล", "ตราด", "จันทบุรี", "ระยอง"
        ];

        foreach ($provinces as $province) {
            $selected = ($province === $post_data['province']) ? 'selected' : '';
            echo "<option value=\"{$province}\" {$selected}>{$province}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
                    <label for="salary">เงินเดือน:</label>
                    <input type="text" id="salary" name="salary" value="<?php echo htmlspecialchars($post_data['salary']); ?>" required>
                </div>
                        <!-- ข้อมูลที่อยู่ -->
                        <div class="post-section">
                            <h3>ข้อมูลเพิ่มเติม</h3>
                            <div class="form-group">
                    <label for="qualifications">คุณสมบัติ:</label>
                    <textarea id="qualifications" name="qualifications" rows="4" required><?php echo htmlspecialchars($post_data['qualifications']); ?></textarea>
                </div>
                <div class="form-group">
    <label for="education_requirements">วุฒิการศึกษา:</label>
    <select id="education_requirements" name="education_requirements">
        <option value="ปริญญาตรี">ปริญญาตรี</option>
    </select>
</div>
<div class="form-group">
                    <label for="company_benefits">สวัสดิการบริษัท:</label>
                    <textarea id="company_benefits" name="company_benefits" rows="4" required><?php echo htmlspecialchars($post_data['company_benefits']); ?></textarea>
                </div>

                


                
                        </div>

                        
                        <!-- ช่องทางติดต่อ -->
                        <div class="post-section">
                            <h3>ช่องทางติดต่อ</h3>
                            <div class="form-group">
                    <label for="contact_channels">ช่องทางติดต่อ:</label>
                    <textarea id="contact_channels" name="contact_channels" rows="4" required><?php echo htmlspecialchars($post_data['contact_channels']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_email">อีเมลติดต่อ:</label>
                    <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($post_data['contact_email']); ?>" required>
                </div>
            </div>
                <button type="submit">อัปเดตโพสต์</button>
            </form>
        </main>
    </div>
</body>
</html>
