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

// Check if the user has posted a profile
$user_email = $_SESSION['email'];
$sql_check_post = "SELECT COUNT(*) AS post_count FROM graduates2 WHERE email = ?";
$stmt_check_post = $conn->prepare($sql_check_post);
$stmt_check_post->bind_param("s", $user_email);
$stmt_check_post->execute();
$result_check_post = $stmt_check_post->get_result();
$post_count = $result_check_post->fetch_assoc()['post_count'];
$stmt_check_post->close();

// Fetch the latest post's ID if available
$latest_post_id = null;
if ($post_count > 0) {
    $sql_latest = "SELECT id FROM graduates2 WHERE email = ? ORDER BY created_at DESC LIMIT 1";
    $stmt_latest = $conn->prepare($sql_latest);
    $stmt_latest->bind_param("s", $user_email);
    $stmt_latest->execute();
    $result_latest = $stmt_latest->get_result();
    if ($row_latest = $result_latest->fetch_assoc()) {
        $latest_post_id = $row_latest['id'];
    }
    $stmt_latest->close();
}

// Fetch user's posts from the database
$sql = "SELECT * FROM graduates2 WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Check for errors
if (!$result) {
    die("Error: " . $conn->error);
}

// Function to convert date to Buddhist calendar
function convertToBuddhistDate($date) {
    $datetime = new DateTime($date);
    $year = $datetime->format('Y') + 543; // Add 543 years
    return $datetime->format('d/m/') . $year; // Day/Month/Year
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</title>
    <link rel="stylesheet" href="styles_index2.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>ยินดีต้อนรับผู้ประกอบการ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="welcome">
                <p>อีเมลของคุณ: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <div class="links">
                    <?php if ($post_count > 0 && $latest_post_id !== null): ?>
                        <a href="edit_post2.php?id=<?php echo urlencode($latest_post_id); ?>">แก้ไขโพสต์</a>
                    <?php else: ?>
                        <a href="post_profile2.php">โพสต์โปรไฟล์</a>
                    <?php endif; ?>
                   
                    <a href="ent.php">ค้นหาโปรไฟล์บัณฑิต</a>
                    <a href="apply_job.php">รับสมัครงาน</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>

        <hr>

        <main class="profiles-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div class="post">
                        <div class="post-header">
                            <?php if (!empty($post['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($post['profile_picture']); ?>" alt="Profile Picture">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($post['company_name']); ?></h2>
                        </div>

                        <div class="post-content">
                            <!-- General Information -->
                            <div class="post-section">
                                <h3>ข้อมูลทั่วไป</h3>
                                <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($post['email']); ?></p>
                                <p><strong>ชื่อผู้ติดต่อ:</strong> <?php echo htmlspecialchars($post['contact_person']); ?></p>
                                <p><strong>ประเภทธุรกิจ:</strong> <?php echo htmlspecialchars($post['business_type']); ?></p>
                                <p><strong>ที่อยู่ที่ทำงาน:</strong> <?php echo htmlspecialchars($post['location']); ?></p>
                            </div>

                            <!-- Job Information -->
                            <div class="post-section">
                                <h3>ข้อมูลหาพนักงาน</h3>
                                <p><strong>คณะที่จบ:</strong> <?php echo htmlspecialchars($post['faculty']); ?></p>
                                <p><strong>สาขาที่จบ:</strong> <?php echo htmlspecialchars($post['major']); ?></p>
                                <p><strong>ตำแหน่งงาน:</strong> <?php echo htmlspecialchars($post['job_title']); ?></p>
                                <p><strong>รูปแบบงาน:</strong> <?php echo htmlspecialchars($post['job_type']); ?></p>
                                <p><strong>สถาที่ทำงาน:</strong> <?php echo htmlspecialchars($post['province']); ?></p>
                                <p><strong>เงินเดือน:</strong> <?php echo htmlspecialchars($post['salary']); ?> บาท</p>
                                
                                
                            </div>

                            <!-- Address Information -->
                            <div class="post-section">
                                <h3>ข้อมูลเพิ่มเติม</h3>
                                <p><strong>คุณสมบัติ:</strong> <?php echo htmlspecialchars($post['qualifications']); ?></p>
                                <p><strong>วุฒิการศึกษา:</strong> <?php echo htmlspecialchars($post['education_requirements']); ?></p>
                                <p><strong>สวัสดิการบริษัท:</strong> <?php echo htmlspecialchars($post['company_benefits']); ?></p>
                                
                            </div>

                            <!-- Contact Information -->
                            <div class="post-section">
                                <h3>ช่องทางติดต่อ</h3>
                                <p><strong>ช่องทางติดต่อ:</strong> <?php echo htmlspecialchars($post['contact_channels']); ?></p>
                                <p><strong>อีเมลติดต่อ:</strong> <?php echo htmlspecialchars($post['contact_email']); ?></p>
                            </div>

                            <div class="job-status">
                                <h3>สถานะงาน</h3>
                                <p>
                                    <strong>สถานะ:</strong> <?php echo htmlspecialchars($post['job_availability']); ?>
                                    <form action="update_job_status2.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($post['email']); ?>">
                                        <input type="hidden" name="current_status" value="<?php echo htmlspecialchars($post['job_availability']); ?>">

                                        <button type="submit" name="toggle_job_status" value="Available" class="button available-button <?php echo $post['job_availability'] === 'Available' ? 'active' : ''; ?>">
                                            งานว่าง
                                        </button>
                                        <button type="submit" name="toggle_job_status" value="Full" class="button full-button <?php echo $post['job_availability'] === 'Full' ? 'active' : ''; ?>">
                                            งานเต็ม
                                        </button>
                                    </form>
                                </p>
                            </div>

                        
                        </div>
                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>คุณยังไม่มีโพสต์งาน</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
