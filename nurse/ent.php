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

// Fetch the logged-in user's faculty, major, job title, job type, province, and salary
$user_email = $_SESSION['email'];
$sql_user_info = "SELECT faculty, major, job_title, job_type, province, salary FROM graduates2 WHERE email = ?";
$stmt_user_info = $conn->prepare($sql_user_info);
$stmt_user_info->bind_param("s", $user_email);
$stmt_user_info->execute();
$result_user_info = $stmt_user_info->get_result();
$user_info = $result_user_info->fetch_assoc();
$user_faculty = $user_info['faculty'];
$user_major = $user_info['major'];
$user_job_title = $user_info['job_title']; // ดึง job_title จาก graduates2
$user_job_type = $user_info['job_type']; // ดึง job_type จาก graduates2
$user_province = $user_info['province']; // ดึง province จาก graduates2
$user_salary = $user_info['salary']; // ดึง salary จาก graduates2
$stmt_user_info->close();

// Fetch matching profiles based on faculty and major
$sql_profiles = "SELECT * FROM graduates WHERE faculty = ? AND major = ?";
$stmt_profiles = $conn->prepare($sql_profiles);
$stmt_profiles->bind_param("ss", $user_faculty, $user_major);
$stmt_profiles->execute();
$result_profiles = $stmt_profiles->get_result();
$stmt_profiles->close();

// Check for errors
if (!$result_profiles) {
    die("Error: " . $conn->error);
}

// Store profiles in an array
$profiles = [];
while ($profile = $result_profiles->fetch_assoc()) {
    // Calculate the number of matches (✓) for each profile
    $match_count = 0;

    // Compare faculty
    if ($profile['faculty'] == $user_faculty) $match_count++;
    // Compare major
    if ($profile['major'] == $user_major) $match_count++;
    // Compare job title
    if ($profile['job_title'] == $user_job_title) $match_count++;
    // Compare job type
    if ($profile['job_type'] == $user_job_type) $match_count++;
    // Compare location with province
    if ($profile['location'] == $user_province) $match_count++;
    // Compare salary range
    if ($profile['salary_range'] == $user_salary) $match_count++;

    // Add the profile and match count to the array
    $profile['match_count'] = $match_count;  // Store the match count for sorting
    $profiles[] = $profile;
}

// Sort profiles by match count in descending order
usort($profiles, function($a, $b) {
    return $b['match_count'] - $a['match_count']; // Sort from high to low
});
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบการจับคู่บัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</title>
    <link rel="stylesheet" href="styles_ent2.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <div class="welcome">
                <p>อีเมลของคุณ: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <div class="links">
                    <a href="index2.php">กลับไปหน้าแรก</a>
                    <a href="logout.php" class="logout">ออกจากระบบ</a>
                </div>
            </div>
        </header>

        <hr>

        <main class="profiles-list">
            <h2></h2>
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
                                <p><strong>คณะ:</strong> <?php 
                                    echo htmlspecialchars($profile['faculty']);
                                    if ($profile['faculty'] == $user_faculty) {
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?></p>
                                
                                <p><strong>สาขา:</strong> <?php 
                                    echo htmlspecialchars($profile['major']);
                                    if ($profile['major'] == $user_major) {
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?></p>
                                
                                <p><strong>ตำแหน่งงาน:</strong> <?php 
                                    echo htmlspecialchars($profile['job_title']);
                                    if ($profile['job_title'] == $user_job_title) { // เปรียบเทียบ job_title
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?></p>
                                
                                <p><strong>รูปแบบงาน:</strong> <?php 
                                    echo htmlspecialchars($profile['job_type']);
                                    if ($profile['job_type'] == $user_job_type) { // เปรียบเทียบ job_type
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?></p>
                                
                                <p><strong>สถานที่ทำงาน:</strong> <?php 
                                    echo htmlspecialchars($profile['location']);
                                    if ($profile['location'] == $user_province) { // เปรียบเทียบ location กับ province
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?></p>
                                 
                                <p><strong>เงินเดือนที่สนใจ:</strong> <?php 
                                    echo htmlspecialchars($profile['salary_range']);
                                    if ($profile['salary_range'] == $user_salary) { // เปรียบเทียบ salary_range กับ salary
                                        echo " ✓"; // เครื่องหมายถูกถ้าข้อมูลตรง
                                    }
                                ?> บาท</p>
                            </div>

                            <!-- ข้อมูลความสามารถ -->
                            <div class="profile-section education-info">
                                <h3>ข้อมูลความสามารถ</h3>
                                <p><strong>ทักษะหรือความสามารถ:</strong> <?php echo nl2br(htmlspecialchars($profile['profile_text'])); ?></p>
                                <p><strong>ความสามารถทางภาษา:</strong> <?php echo nl2br(htmlspecialchars($profile['language_skills'])); ?></p>
                                <p><strong>ประวัติฝึกงาน:</strong> <?php echo nl2br(htmlspecialchars($profile['internship_experience'])); ?></p>
                            </div>

                            <!-- ช่องทางติดต่อ -->
                            <div class="profile-section job-info">
                                <h3>ช่องทางติดต่อ</h3>
                                <p><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($profile['phone']); ?></p>
                                <p><strong>g-mail:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
                            </div>
                            <!-- ปุ่มส่งข้อมูล -->
            <form action="ent_result.php" method="post">
                <!-- ซ่อนค่า graduates.email -->
                <input type="hidden" name="graduates_email" value="<?php echo htmlspecialchars($profile['email']); ?>">
                <!-- ซ่อนค่า graduates2.email -->
                <input type="hidden" name="graduates2_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                
                <button type="submit">ส่งข้อมูล</button>
            </form>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>ไม่มีผลการจับคู่ที่ตรงกับข้อมูลของคุณ</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
