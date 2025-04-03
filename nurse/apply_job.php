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

// Fetch the logged-in user's company name from graduates2
$user_email = $_SESSION['email'];
$sql_user_company = "SELECT company_name FROM graduates2 WHERE email = ?";
$stmt_user_company = $conn->prepare($sql_user_company);
$stmt_user_company->bind_param("s", $user_email);
$stmt_user_company->execute();
$user_company_result = $stmt_user_company->get_result();
$stmt_user_company->close();

// Check if the user has a company name
$user_company_name = null;
if ($user_company_result->num_rows > 0) {
    $user_company_row = $user_company_result->fetch_assoc();
    $user_company_name = $user_company_row['company_name'];
}

// Fetch all matches from matchcompany
$sql = "SELECT * FROM matchcompany";
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
                    <a href="index2.php">กลับสู่หน้าแรก</a>
                    <a href="ent.php">ค้นหาโปรไฟล์บัณฑิต</a>
                    <a href="apply_job.php">รับสมัครงาน</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>



        <hr>

        <main class="profiles-list">
            <h2>ผู้ที่สนใจงานของคุณ</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Check if the company_name from matchcompany matches the user's company_name
                    if ($row['company_name'] === $user_company_name):
                    ?>
                        <div class="match">
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                            <p><strong>Company Name:</strong> <?php echo htmlspecialchars($row['company_name']); ?></p>

                            <!-- ปุ่มดูโปรไฟล์ -->
                            <form action="view_profile.php" method="get">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                <button type="submit">ดูโปรไฟล์</button>
                            </form>
                        </div>
                        <hr>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p>ยังไม่มีผู้ที่สนใจงานของคุณ</p>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>