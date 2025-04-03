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
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // ดึงข้อมูลโปรไฟล์จากฐานข้อมูลตาม email
        $stmt = $pdo->prepare("SELECT * FROM graduates WHERE email = ? ORDER BY created_at DESC");
        $stmt->execute([$email]);
        $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่าผู้ใช้มีโปรไฟล์อยู่หรือไม่
        $hasProfile = !empty($profiles);
    } else {
        echo "Email not specified.";
        exit();
    }

    // ตรวจสอบว่า company_name ตรงกับ graduates2.email หรือไม่
    if (isset($_POST['company_name'])) {
        $company_name = $_POST['company_name'];

        // ตรวจสอบว่า company_name ตรงกับ email ในฐานข้อมูล graduates2 หรือไม่
        $stmt_check = $pdo->prepare("SELECT email FROM graduates2 WHERE email = ?");
        $stmt_check->execute([$company_name]);
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        // ถ้าตรงกัน ให้แสดง "GG"
        if ($result) {
            $message = "ข้อมูลตรงกัน";
        } else {
            $message = "ไม่ตรงกัน";
        }
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
                    <a href="index.php">กลับสู่หน้าแรก</a>
                    <a href="ent.php">ค้นหาโปรไฟล์บัณฑิต</a>
                    <a href="apply_job.php">รับสมัครงาน</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>
        <hr>
        <p>Company Name: <?php echo htmlspecialchars($_POST['company_name']); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Result: <?php echo isset($message) ? $message : ''; ?></p>

    </div>
</body>
</html>