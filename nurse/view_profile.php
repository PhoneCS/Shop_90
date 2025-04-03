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

    // ดึงข้อมูลโปรไฟล์จาก email ที่ถูกส่งมาจาก URL
    if (isset($_GET['email'])) {
        $email = $_GET['email'];

        // ดึงข้อมูลโปรไฟล์จากฐานข้อมูลตาม email
        $stmt = $pdo->prepare("SELECT * FROM graduates WHERE email = ? ORDER BY created_at DESC");
        $stmt->execute([$email]);
        $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่าผู้ใช้มีโปรไฟล์อยู่หรือไม่
        $hasProfile = !empty($profiles);
    } else {
        // ถ้าไม่มีการส่ง email มาจาก URL ก็แสดงข้อผิดพลาด
        echo "Email not specified.";
        exit();
    }

    // ฟังก์ชันบันทึกสถานะ
    if (isset($_POST['interested']) && isset($_POST['company_email'])) {
        $company_email = $_POST['company_email'];

        // อัปเดตสถานะใน matchcompany
        $stmt_update = $pdo->prepare("UPDATE matchcompany SET status = 'y' WHERE company_email = ? AND candidate_email = ?");
        $stmt_update->execute([$company_email, $_SESSION['email']]);

        echo "คุณได้สนใจการสมัครงานนี้แล้ว!";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;
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
        <header class="header">
            <h1>โปรไฟล์บัณฑิต, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="welcome">
                <p>อีเมลของคุณ: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <div class="links">
                    <a href="index2.php">กลับสู่หน้าแรก</a>
                    <a href="ent.php">ค้นหาโปรไฟล์บัณฑิต</a>
                    <a href="apply_job.php">รับสมัครงาน</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>
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

                            <div class="profile-section skills-info">
                                <h3>ข้อมูลความสามารถ</h3>
                                <p><strong>ทักษะหรือความสามารถ:</strong> <?php echo nl2br(htmlspecialchars($profile['profile_text'])); ?></p>
                                <p><strong>ความสามารถทางภาษา:</strong> <?php echo nl2br(htmlspecialchars($profile['language_skills'])); ?></p>
                                <p><strong>ประวัติฝึกงาน:</strong> <?php echo nl2br(htmlspecialchars($profile['internship_experience'])); ?></p>
                            </div>

                            <div class="profile-section job-info">
                                <h3>ช่องทางติดต่อ</h3>
                                <p><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($profile['phone']); ?></p>
                                <p><strong>g-mail:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
                            </div>

                            <!-- ปุ่มสนใจ -->
                            <form action="view_profile_result.php" method="POST">
                                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($profile['email']); ?>">
                                <input type="hidden" name="candidate_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"> <!-- ส่งอีเมลของผู้สมัคร -->
                                <input type="hidden" name="status" value="y"> <!-- ส่งค่า 'y' สำหรับสนใจร่วมงาน -->
                                <button type="submit" name="interested" class="btn-interested">ตอบรับ</button>
                            </form>

                            <!-- ปุ่มไม่สนใจ -->
                            <form action="view_profile_result.php" method="POST">
                                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($profile['email']); ?>">
                                <input type="hidden" name="candidate_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"> <!-- ส่งอีเมลของผู้สมัคร -->
                                <input type="hidden" name="status" value="n"> <!-- ส่งค่า 'n' สำหรับไม่สนใจ -->
                                <button type="submit" name="not_interested" class="btn-not-interested">ไม่สนใจ</button>
                            </form>


                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>ไม่พบโปรไฟล์สำหรับอีเมลนี้</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>