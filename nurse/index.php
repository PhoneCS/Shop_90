<?php
session_start();

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

try {
    // เชื่อมต่อฐานข้อมูลด้วย PDO
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูลโปรไฟล์ของผู้ใช้
    $email = $_SESSION['email'];
    $stmt = $pdo->prepare("SELECT * FROM graduates WHERE email = ? ORDER BY created_at DESC");
    $stmt->execute([$email]);
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ตรวจสอบว่าผู้ใช้มีโปรไฟล์อยู่หรือไม่
    $hasProfile = !empty($profiles);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;

// ฟังก์ชันแปลงวันที่เป็นปีพ.ศ.
function convertToBuddhistDate($date)
{
    $datetime = new DateTime($date);
    $year = $datetime->format('Y') + 543; // เพิ่ม 543 ปี
    return $datetime->format('d/m/') . $year; // วันที่/เดือน/ปี
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</title>
    <link rel="stylesheet" href="styles_index.css">
</head>

<body>
    <div class="container">
        <h1>โปรไฟล์บัณฑิต</h1>

        <div class="welcome">
            <p>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['email']); ?>)</p>
            <div class="links">
                <?php if (!$hasProfile): ?>
                    <a href="post_profile.php">โพสต์โปรไฟล์</a>
                <?php else: ?>
                    <a href="edit_profile.php">แก้ไขโปรไฟล์</a>
                    <a href="ent2.php">การจับคู่งาน</a>
                    <a href="request_job.php">ยื่นคำขอร่วมงาน</a>
                    <a href="company_interested.php">บริษัทสนใจคุณ</a>
                <?php endif; ?>
                <a href="upload_document.php">อัปโหลดไฟล์เอกสาร</a>
                <a href="upload_profile_picture.php">อัปโหลดรูปโปรไฟล์</a>
                <a href="logout.php" class="logout">ออกจากระบบ</a>
            </div>
        </div>
        <hr>
        <div class="profiles-list">
            <?php if (!empty($profiles)): ?>
                <?php foreach ($profiles as $profile): ?>
                    <div class="profile">
                        <div class="profile-header">
                            <?php if (!empty($profile['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($profile['full_name']); ?></h2>
                        </div>

                        <div class="profile-content">
                            <!-- ข้อมูลส่วนตัว -->
                            <div class="profile-section personal-info">
                                <h3>ข้อมูลส่วนตัว</h3>
                                <p><strong>มหาวิทยาลัย:</strong> <?php echo htmlspecialchars($profile['university']); ?></p>
                                <p><strong>สัญชาติ:</strong> <?php echo htmlspecialchars($profile['nationality']); ?></p>
                                <p><strong>ศาสนา:</strong> <?php echo htmlspecialchars($profile['religion']); ?></p>
                                <p><strong>น้ำหนัก:</strong> <?php echo htmlspecialchars($profile['weight']); ?> กิโลกรัม</p>
                                <p><strong>ส่วนสูง:</strong> <?php echo htmlspecialchars($profile['height']); ?> เซนติเมตร</p>
                                <p><strong>วันเกิด:</strong> <?php echo htmlspecialchars($profile['birthdate']); ?></p>
                                <p><strong>สถานภาพสมรส:</strong> <?php echo htmlspecialchars($profile['marital_status']); ?></p>
                                <p><strong>ที่อยู่ปัจจุบัน:</strong> <?php echo nl2br(htmlspecialchars($profile['address'])); ?></p>
                            </div>

                            <!-- ข้อมูลการจัดคู่งาน -->
                            <div class="profile-section education-info">
                                <h3>ข้อมูลการจัดคู่งาน</h3>
                                <p><strong>คณะ:</strong> <?php echo htmlspecialchars($profile['faculty']); ?></p>
                                <p><strong>สาขา:</strong> <?php echo htmlspecialchars($profile['major']); ?></p>
                                <p><strong>ตำแหน่งงาน:</strong> <?php echo htmlspecialchars($profile['job_title']); ?></p>
                                <p><strong>รูปแบบงาน:</strong> <?php echo htmlspecialchars($profile['job_type']); ?></p>
                                <p><strong>สถานที่ทำงาน:</strong> <?php echo htmlspecialchars($profile['location']); ?></p>
                                <p><strong>เงินเดือนที่สนใจ:</strong> <?php echo htmlspecialchars($profile['salary_range']); ?>บาท</p>
                            </div>

                            <!-- ข้อมูลเอกสาร -->
                            <div class="profile-section document-info">
                                <h3>เอกสารที่อัปโหลด</h3>
                                <?php if (!empty($profile['id_card_file'])): ?>
                                    <p><strong>สำเนาบัตรประชาชน (ปปช.):</strong> <a href="<?php echo htmlspecialchars($profile['id_card_file']); ?>" target="_blank">คลิกเพื่อดู</a></p>
                                <?php else: ?>
                                    <p>ยังไม่มีการอัปโหลดบัตรประชาชน</p>
                                <?php endif; ?>

                                <?php if (!empty($profile['house_register_file'])): ?>
                                    <p><strong>สำเนาทะเบียนบ้าน:</strong> <a href="<?php echo htmlspecialchars($profile['house_register_file']); ?>" target="_blank">คลิกเพื่อดู</a></p>
                                <?php else: ?>
                                    <p>ยังไม่มีการอัปโหลดทะเบียนบ้าน</p>
                                <?php endif; ?>

                                <?php if (!empty($profile['transcript_file'])): ?>
                                    <p><strong>สำเนาใบรับรองผลการเรียน:</strong> <a href="<?php echo htmlspecialchars($profile['transcript_file']); ?>" target="_blank">คลิกเพื่อดู</a></p>
                                <?php else: ?>
                                    <p>ยังไม่มีการอัปโหลดผลการเรียน</p>
                                <?php endif; ?>

                                <?php if (!empty($profile['military_service_file'])): ?>
                                    <p><strong>ใบผ่านการเกณฑ์ทหารหรือใบผ่านการเรียนรักษาดินแดน:</strong> <a href="<?php echo htmlspecialchars($profile['military_service_file']); ?>" target="_blank">คลิกเพื่อดู</a></p>
                                <?php else: ?>
                                    <p>ยังไม่มีการอัปโหลดเอกสารการเกณฑ์ทหาร</p>
                                <?php endif; ?>

                                <?php if (!empty($profile['work_certificate_file'])): ?>
                                    <p><strong>หนังสือรับรองการทำงาน:</strong> <a href="<?php echo htmlspecialchars($profile['work_certificate_file']); ?>" target="_blank">คลิกเพื่อดู</a></p>
                                <?php else: ?>
                                    <p>ยังไม่มีการอัปโหลดหนังสือรับรองการทำงาน</p>
                                <?php endif; ?>
                            </div>


                            <!-- ข้อมูลความสามารถ -->
                            <div class="profile-section education-info">
                                <h3>ข้อมูลเพิ่มเติม</h3>
                                <p><strong>ทักษะหรือความสามารถ:</strong> <?php echo nl2br(htmlspecialchars($profile['profile_text'])); ?></p>
                                <p><strong>ความสามารถทางภาษา:</strong> <?php echo nl2br(htmlspecialchars($profile['language_skills'])); ?></p>
                                <p><strong>ประวัติฝึกงาน:</strong> <?php echo nl2br(htmlspecialchars($profile['internship_experience'])); ?></p>
                            </div>

                            <div class="profile-section job-info">
                                <h3>ช่องทางติดต่อ</h3>
                                <p><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($profile['phone']); ?></p>
                                <p><strong>g-mail:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
                            </div>

                            <div class="profile-status">
                                <h3>สถานะการจ้างงาน</h3>
                                <p>
                                    <strong>สถานะ:</strong> <?php echo htmlspecialchars($profile['employment_status']); ?>
                                <form action="update_status.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>">
                                    <input type="hidden" name="current_status" value="<?php echo htmlspecialchars($profile['employment_status']); ?>">

                                    <button type="submit" name="toggle_status" class="button unemployed-button <?php echo $profile['employment_status'] === 'Unemployed' ? 'active' : ''; ?>">
                                        ว่างงาน
                                    </button>
                                    <button type="submit" name="toggle_status" class="button employed-button <?php echo $profile['employment_status'] === 'Employed' ? 'active' : ''; ?>">
                                        ได้งานแล้ว
                                    </button>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>ยังไม่มีข้อมูลโปรไฟล์</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>