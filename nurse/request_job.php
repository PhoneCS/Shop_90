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

    // ดึงข้อมูลคำขอร่วมงานจาก matchcompany
    $stmt_job = $pdo->prepare("SELECT * FROM matchcompany WHERE email = ? ORDER BY company_name ASC");
    $stmt_job->execute([$email]);
    $job_requests = $stmt_job->fetchAll(PDO::FETCH_ASSOC);
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
    <title>คำขอร่วมงาน</title>
    <link rel="stylesheet" href="styles_index.css">
    <style>
        /* เพิ่มการกำหนดสีสำหรับแต่ละสถานะ */
        .status-pending {
            color: gray;
        }

        .status-interested {
            color: green;
        }

        .status-unknown {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>คำขอร่วมงาน</h1>

        <div class="welcome">
            <p>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['email']); ?>)</p>
            <div class="links">
                <a href="index.php" class="logout">กลับหน้าโปรไฟล์</a>
                <a href="logout.php" class="logout">ออกจากระบบ</a>
            </div>
        </div>
        <hr>

        <div class="job-requests">
            <?php if (!empty($job_requests)): ?>
                <h3>คำขอร่วมงาน:</h3>
                <ul>
                    <?php foreach ($job_requests as $job): ?>
                        <li>
                            <p><strong>บริษัท:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                            <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($job['email']); ?></p>
                            <p><strong>สถานะ:</strong>
                                <?php
                                if (empty($job['status'])) {
                                    echo "<span class='status-pending'>ส่งคำขอแล้ว</span>"; // ถ้า status เป็น NULL หรือไม่มีค่าให้แสดงว่า Pending
                                } elseif ($job['status'] === 'y') {
                                    echo "<span class='status-interested'>บริษัทสนใจร่วมงานกับคุณ</span>"; // ถ้า status เป็น 'y' ให้แสดงว่า บริษัทสนใจ
                                } elseif ($job['status'] === 'n') {
                                    echo "<span class='status-unknown'>บริษัทปฏิเสธการร่วมงานกับคุณ</span>"; // ถ้า status เป็น 'n' ให้แสดงว่า บริษัทปฏิเสธ
                                }
                                ?>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>คุณยังไม่ได้สมัครงานกับบริษัทใดๆ</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>