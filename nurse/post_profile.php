<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>โพสต์โปรไฟล์</title>
    <link rel="stylesheet" href="styles_post.css">
</head>
<body>
    <div class="container">
        <h1>โพสต์โปรไฟล์</h1>

        <!-- เพิ่มลิงค์ย้อนกลับ -->
        <a href="index.php" class="back-link">ย้อนกลับ</a>
        
        <form action="process_profile.php" method="post" enctype="multipart/form-data">
            <div class="profile-content">
                
                <!-- ข้อมูลส่วนตัว -->
                <div class="profile-section personal-info">
                    <h3>ข้อมูลส่วนตัว</h3>
                    <div class="form-group">
                        <label for="full_name">ชื่อ-นามสกุล:</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="university">มหาวิทยาลัย:</label>
                        <select id="university" name="university">
                            <option value="มหาวิทยาลัยราชภัฏนครสวรรค์">มหาวิทยาลัยราชภัฏนครสวรรค์</option>
                            <!-- เพิ่มมหาวิทยาลัยอื่น ๆ ได้ตามต้องการ -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nationality">สัญชาติ:</label>
                        <input type="text" id="nationality" name="nationality">
                    </div>
                    <div class="form-group">
                        <label for="religion">ศาสนา:</label>
                        <select id="religion" name="religion">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="พุทธ">พุทธ</option>
                            <option value="อิสลาม">อิสลาม</option>
                            <option value="คริสต์">คริสต์</option>
                            <option value="พราหมณ์ ฮินดู">พราหมณ์ ฮินดู</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">น้ำหนัก (กิโลกรัม):</label>
                        <input type="number" id="weight" name="weight" min="0">
                    </div>
                    <div class="form-group">
                        <label for="height">ส่วนสูง (เซนติเมตร):</label>
                        <input type="number" id="height" name="height" min="0">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">วันเกิด:</label>
                        <input type="date" id="birthdate" name="birthdate">
                    </div>
                    <div class="form-group">
                        <label for="marital_status">สถานภาพสมรส:</label>
                        <select id="marital_status" name="marital_status">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="โสด">โสด</option>
                            <option value="แต่งงานและอยู่ด้วยกัน">แต่งงานและอยู่ด้วยกัน</option>
                            <option value="แต่งงานแต่ไม่ได้อยู่ด้วยกัน">แต่งงานแต่ไม่ได้อยู่ด้วยกัน</option>
                            <option value="ไม่แต่งงานแต่อยู่ด้วยกัน">ไม่แต่งงานแต่อยู่ด้วยกัน</option>
                            <option value="หม้าย">หม้าย</option>
                            <option value="หย่าร้าง/แยกทาง/เลิกกัน">หย่าร้าง/แยกทาง/เลิกกัน</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">ที่อยู่ปัจจุบัน:</label>
                        <textarea id="address" name="address" rows="3"></textarea>
                    </div>
                </div>

                <!-- ข้อมูลการศึกษา -->
                <div class="profile-section education-info">
                    <h3>ข้อมูลการจัดคู่งาน</h3>
                    
                    <div class="form-group">
                        <label for="faculty">คณะ:</label>
                        <select id="faculty" name="faculty" onchange="updateMajor()">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="คณะวิทยาศาสตร์และเทคโนโลยี">คณะวิทยาศาสตร์และเทคโนโลยี</option>
                            <option value="คณะมนุษยศาสตร์และสังคมศาสตร์">คณะมนุษยศาสตร์และสังคมศาสตร์</option>
                            <option value="คณะวิทยาการจัดการ">คณะวิทยาการจัดการ</option>
                            <option value="คณะเทคโนโลยีการเกษตรและเทคโนโลยีอุตสาหกรรม">คณะเทคโนโลยีการเกษตรและเทคโนโลยีอุตสาหกรรม</option>
                            <option value="คณะครุศาสตร์">คณะครุศาสตร์</option>
                            <option value="บัณฑิตศึกษา">บัณฑิตศึกษา</option>
                            <!-- เพิ่มคณะอื่น ๆ ได้ตามต้องการ -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="major">สาขา:</label>
                        <select id="major" name="major">
                            <option value="">-- กรุณาเลือก --</option>
                            <!-- ตัวเลือกสาขาจะถูกเติมโดย JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="job_title">ตำแหน่งงาน:</label>
                        <select id="job_title" name="job_title">
                            <option value="">-- กรุณาเลือก --</option>
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
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="Part time">Part time</option>
                            <option value="งานประจำ">งานประจำ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">สถานที่ทำงาน (จังหวัด):</label>
                        <select id="location" name="location">
                            <option value="">-- กรุณาเลือก --</option>
                            <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                            <option value="กระบี่">กระบี่</option>
                            <option value="กาญจนบุรี">กาญจนบุรี</option>
                            <option value="กาฬสินธุ์">กาฬสินธุ์</option>
                            <option value="กำแพงเพชร">กำแพงเพชร</option>
                            <option value="ขอนแก่น">ขอนแก่น</option>
                            <option value="จันทบุรี">จันทบุรี</option>
                            <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
                            <option value="ชลบุรี">ชลบุรี</option>
                            <option value="ชัยนาท">ชัยนาท</option>
                            <option value="ชัยภูมิ">ชัยภูมิ</option>
                            <option value="ชุมพร">ชุมพร</option>
                            <option value="เชียงราย">เชียงราย</option>
                            <option value="เชียงใหม่">เชียงใหม่</option>
                            <option value="ตรัง">ตรัง</option>
                            <option value="ตราด">ตราด</option>
                            <option value="ตาก">ตาก</option>
                            <option value="นครนายก">นครนายก</option>
                            <option value="นครปฐม">นครปฐม</option>
                            <option value="นครพนม">นครพนม</option>
                            <option value="นครราชสีมา">นครราชสีมา</option>
                            <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                            <option value="นครสวรรค์">นครสวรรค์</option>
                            <option value="นนทบุรี">นนทบุรี</option>
                            <option value="นราธิวาส">นราธิวาส</option>
                            <option value="น่าน">น่าน</option>
                            <option value="บึงกาฬ">บึงกาฬ</option>
                            <option value="บุรีรัมย์">บุรีรัมย์</option>
                            <option value="ปทุมธานี">ปทุมธานี</option>
                            <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
                            <option value="ปราจีนบุรี">ปราจีนบุรี</option>
                            <option value="ปัตตานี">ปัตตานี</option>
                            <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option>
                            <option value="พังงา">พังงา</option>
                            <option value="พัทลุง">พัทลุง</option>
                            <option value="พิจิตร">พิจิตร</option>
                            <option value="พิษณุโลก">พิษณุโลก</option>
                            <option value="เพชรบุรี">เพชรบุรี</option>
                            <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                            <option value="แพร่">แพร่</option>
                            <option value="พะเยา">พะเยา</option>
                            <option value="ภูเก็ต">ภูเก็ต</option>
                            <option value="มหาสารคาม">มหาสารคาม</option>
                            <option value="มุกดาหาร">มุกดาหาร</option>
                            <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
                            <option value="ยโสธร">ยโสธร</option>
                            <option value="ยะลา">ยะลา</option>
                            <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                            <option value="ระนอง">ระนอง</option>
                            <option value="ระยอง">ระยอง</option>
                            <option value="ราชบุรี">ราชบุรี</option>
                            <option value="ลพบุรี">ลพบุรี</option>
                            <option value="ลำปาง">ลำปาง</option>
                            <option value="ลำพูน">ลำพูน</option>
                            <option value="เลย">เลย</option>
                            <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                            <option value="สกลนคร">สกลนคร</option>
                            <option value="สงขลา">สงขลา</option>
                            <option value="สตูล">สตูล</option>
                            <option value="สมุทรปราการ">สมุทรปราการ</option>
                            <option value="สมุทรสงคราม">สมุทรสงคราม</option>
                            <option value="สมุทรสาคร">สมุทรสาคร</option>
                            <option value="สระแก้ว">สระแก้ว</option>
                            <option value="สระบุรี">สระบุรี</option>
                            <option value="สิงห์บุรี">สิงห์บุรี</option>
                            <option value="สุโขทัย">สุโขทัย</option>
                            <option value="สุพรรณบุรี">สุพรรณบุรี</option>
                            <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
                            <option value="สุรินทร์">สุรินทร์</option>
                            <option value="หนองคาย">หนองคาย</option>
                            <option value="หนองบัวลำภู">หนองบัวลำภู</option>
                            <option value="อ่างทอง">อ่างทอง</option>
                            <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                            <option value="อุดรธานี">อุดรธานี</option>
                            <option value="อุตรดิตถ์">อุตรดิตถ์</option>
                            <option value="อุทัยธานี">อุทัยธานี</option>
                            <option value="อุบลราชธานี">อุบลราชธานี</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary_range">เงินเดือนที่สนใจ:</label>
                        <input type="text" id="salary_range" name="salary_range">
                    </div>
                    
                </div>

               
                <div class="profile-section job-info">
                <h3>ข้อมูลความสามารถ</h3>
                    
                    <div class="form-group">
                        <label for="profile_text">ทักษะหรือความสามารถพิเศษ:</label>
                        <textarea id="profile_text" name="profile_text" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="language_skills">ความสามารถทางภาษา:</label>
                        <textarea id="language_skills" name="language_skills" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="internship_experience">ประวัติฝึกงาน:</label>
                        <textarea id="internship_experience" name="internship_experience" rows="5"></textarea>
                    </div>
                </div>
                
                <!-- ช่องทางติดต่อ -->
                <div class="profile-section contact-info">
                    <h3>ช่องทางติดต่อ</h3>
                    <div class="form-group">
                        <label for="phone">โทรศัพท์:</label>
                        <input type="text" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">อีเมล:</label>
                        <input type="text" id="email" name="email">
                    </div>
                    
                </div>
            </div>
            
           

            <div class="form-group">
                <button type="submit">บันทึกโปรไฟล์</button>
            </div>
        </form>
    </div>

    <script>
        function updateMajor() {
            var faculty = document.getElementById("faculty").value;
            var major = document.getElementById("major");

            // ล้างตัวเลือกในช่องสาขา
            major.innerHTML = '<option value="">-- กรุณาเลือก --</option>';

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
                opt.textContent = options[i];
                major.appendChild(opt);
            }
        }

        // ตั้งค่าให้ฟังก์ชัน updateMajor ทำงานเมื่อหน้าโหลดเสร็จ
        window.onload = function() {
            // ตรวจสอบว่ามีการเลือกคณะไว้แล้วหรือไม่ ถ้ามีให้เติมสาขา
            var facultySelected = document.getElementById("faculty").value;
            if (facultySelected !== "") {
                updateMajor();
            }
        };
    </script>
</body>
</html>
