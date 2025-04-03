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
    $stmt = $pdo->prepare("SELECT * FROM graduates WHERE email = ?");
    $stmt->execute([$email]);
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ตรวจสอบว่าผู้ใช้มีโปรไฟล์อยู่หรือไม่
    $hasProfile = !empty($profiles);

    // ถ้ามีโปรไฟล์ผู้ใช้ ดึงคณะและสาขาของผู้ใช้งาน
    $matchedCompanies = []; // ตัวแปรเก็บผลลัพธ์การจับคู่บริษัท

    if ($hasProfile) {
        $profile = $profiles[0]; // เลือกโปรไฟล์ของผู้ใช้
        $faculty = $profile['faculty'];
        $major = $profile['major'];

        // ค้นหาบริษัทที่มีคณะและสาขาตรงกับโปรไฟล์ผู้ใช้
        $stmt2 = $pdo->prepare("SELECT * FROM graduates2 WHERE faculty = ? AND major = ?");
        $stmt2->execute([$faculty, $major]);
        $matchedCompanies = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    }

    // ฟังก์ชันในการนับจำนวนการตรงกัน
    function countMatches($company, $profile)
    {
        $matches = 0;

        if ($company['faculty'] == $profile['faculty']) $matches++;
        if ($company['major'] == $profile['major']) $matches++;
        if ($company['job_title'] == $profile['job_title']) $matches++;
        if ($company['job_type'] == $profile['job_type']) $matches++;
        if ($company['province'] == $profile['location']) $matches++;
        if ($company['salary'] == $profile['salary_range']) $matches++;

        return $matches;
    }

    // เพิ่มจำนวนการตรงกันในแต่ละบริษัท
    foreach ($matchedCompanies as $key => $company) {
        $matchedCompanies[$key]['match_count'] = countMatches($company, $profile);
    }

    // เรียงลำดับบริษัทตามจำนวนการตรงกันมากที่สุด
    usort($matchedCompanies, function ($a, $b) {
        return $b['match_count'] - $a['match_count']; // เรียงลำดับจากมากไปน้อย
    });
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// ปิดการเชื่อมต่อฐานข้อมูล
$pdo = null;
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบการจับคู่บัณฑิตกับบริษัท</title>
    <link rel="stylesheet" href="styles_ent2.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>ระบบการจับคู่บัณฑิตกับบริษัท</h1>
            <div class="welcome">
                <p>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['email']); ?>)</p>
                <div class="links">
                    <a href="index.php">กลับสู่หน้าแรก</a>
                    <a href="logout.php" class="logout-link">ออกจากระบบ</a>
                </div>
            </div>
        </header>

        <hr>

        <main class="profiles-list">
            <?php if ($hasProfile): ?>
                <?php if (count($matchedCompanies) > 0): ?>
                    <?php foreach ($matchedCompanies as $company): ?>
                        <div class="pair">
                            <div class="profile-header">
                                <?php if (!empty($company['profile_picture'])): ?>
                                    <img src="<?php echo htmlspecialchars($company['profile_picture']); ?>" alt="Profile Picture">
                                <?php endif; ?>
                                <h2><?php echo htmlspecialchars($company['company_name']); ?></h2>
                            </div>

                            <div class="profile-content">
                                <!-- ข้อมูลทั่วไป -->
                                <div class="profile-section">
                                    <h3>ข้อมูลทั่วไป</h3>
                                    <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($company['email']); ?></p>
                                    <p><strong>ชื่อผู้ติดต่อ:</strong> <?php echo htmlspecialchars($company['contact_person']); ?></p>
                                    <p><strong>ประเภทธุรกิจ:</strong> <?php echo htmlspecialchars($company['business_type']); ?></p>
                                    <p><strong>ที่อยู่ที่ทำงาน:</strong> <?php echo htmlspecialchars($company['location']); ?></p>
                                </div>

                                <!-- ข้อมูลหาพนักงาน -->
                                <div class="profile-section">
                                    <h3>ข้อมูลหาพนักงาน</h3>
                                    <p><strong>คณะที่จบ:</strong> <?php echo htmlspecialchars($company['faculty']); ?>
                                        <?php if ($company['faculty'] == $profile['faculty']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                    <p><strong>สาขาที่จบ:</strong> <?php echo htmlspecialchars($company['major']); ?>
                                        <?php if ($company['major'] == $profile['major']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                    <p><strong>ตำแหน่งงาน:</strong> <?php echo htmlspecialchars($company['job_title']); ?>
                                        <?php if ($company['job_title'] == $profile['job_title']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                    <p><strong>รูปแบบงาน:</strong> <?php echo htmlspecialchars($company['job_type']); ?>
                                        <?php if ($company['job_type'] == $profile['job_type']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                    <p><strong>สถานที่ทำงาน:</strong> <?php echo htmlspecialchars($company['province']); ?>
                                        <?php if ($company['province'] == $profile['location']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                    <p><strong>เงินเดือน:</strong> <?php echo htmlspecialchars($company['salary']); ?> บาท
                                        <?php if ($company['salary'] == $profile['salary_range']) {
                                            echo '<span class="checkmark">&#10003;</span>';
                                        } ?>
                                    </p>
                                </div>

                                <!-- ข้อมูลความสามารถ -->
                                <div class="profile-section">
                                    <h3>ข้อมูลเพิ่มเติม</h3>
                                    <p><strong>คุณสมบัติ:</strong> <?php echo htmlspecialchars($company['qualifications']); ?></p>
                                    <p><strong>วุฒิการศึกษา:</strong> <?php echo htmlspecialchars($company['education_requirements']); ?></p>
                                    <p><strong>สวัสดิการบริษัท:</strong> <?php echo htmlspecialchars($company['company_benefits']); ?></p>
                                </div>

                                <!-- ช่องทางติดต่อ -->
                                <div class="profile-section">
                                    <h3>ช่องทางติดต่อ</h3>
                                    <p><strong>ช่องทางติดต่อ:</strong> <?php echo htmlspecialchars($company['contact_channels']); ?></p>
                                    <p><strong>อีเมลติดต่อ:</strong> <?php echo htmlspecialchars($company['contact_email']); ?></p>
                                </div>
                            </div>
                            <form action="ent2_result.php" method="post">
                                <!-- ซ่อนค่า email -->
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                                <!-- ซ่อนค่า company_name -->
                                <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>">

                                <button type="submit">ส่งข้อมูล</button>
                            </form>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>ไม่พบข้อมูลบริษัทที่ตรงกับคณะและสาขาของคุณ</p>
                <?php endif; ?>
            <?php else: ?>
                <p>กรุณาโพสต์โปรไฟล์ของคุณก่อนเพื่อทำการจับคู่กับบริษัท</p>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>