<?php
session_start();
require_once 'config.php'; // Include database connection settings

// Check user login
if (!isset($_SESSION['username'])) {
    header("Location: login2.php");
    exit();
}

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's email from graduates
$user_email = $_SESSION['email'];
$sql_user_email = "SELECT email FROM graduates WHERE email = ?";
$stmt_user_email = $conn->prepare($sql_user_email);
$stmt_user_email->bind_param("s", $user_email);
$stmt_user_email->execute();
$user_email_result = $stmt_user_email->get_result();
$stmt_user_email->close();

// Check if the user has an email
$user_email_std = null;
if ($user_email_result->num_rows > 0) {
    $user_email_row = $user_email_result->fetch_assoc();
    $user_email_std = $user_email_row['email'];  // Correct column name
}

// Fetch all matches from matchstudent
$sql = "SELECT * FROM matchstudent";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รับสมัครงาน</title>
    <link rel="stylesheet" href="styles_index2.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>ระบบรับสมัครงาน, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="welcome">
                <p>อีเมลของคุณ: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <div class="links">
                    <a href="index.php">กลับสู่หน้าแรก</a>
                    <a href="company_interested.php">บริษัทสนใจคุณ</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>
        <hr>

        <?php
        // Fetch all matches from matchstudent
        $sql = "SELECT * FROM matchstudent";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        ?>

        <main class="profiles-list">
            <h2>บริษัทที่สนใจคุณ</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="match">
                        <p><strong>Company Name:</strong> <?php echo htmlspecialchars($row['company_name_std']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email_std']); ?></p>

                        <!-- ปุ่มดูโปรไฟล์ -->
                        <form action="view_profile_company.php" method="POST">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email_std']); ?>">
                            <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($row['company_name_std']); ?>"> <!-- เพิ่ม hidden field สำหรับ Company Name -->
                            <button type="submit">ดูโปรไฟล์</button>
                        </form>

                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>ยังไม่มีผู้ที่สนใจงานของคุณ</p>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>