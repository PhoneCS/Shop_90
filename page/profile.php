<?php
include('../includes/header.php');

// ตรวจสอบว่ามี user_id หรือไม่
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo "ไม่พบข้อมูลผู้ใช้";
    exit;
}

$user_id = $_GET['user_id'];

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT username, phone_number, address, email,profile_image,created_at,user_type FROM users WHERE user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "ไม่พบข้อมูลผู้ใช้";
    exit;
}
// แปลงวันที่จาก created_at
$created_at = new DateTime($user['created_at']);
$first_membership_date = $created_at->format('d-m-Y');  // แสดงผลในรูปแบบวันที่-เดือน-ปี


$user_type = ($user['user_type'] == 'admin') ? 'แอดมิน' : 'ผู้ใช้ธรรมดา';


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของ <?php echo htmlspecialchars($user['username']); ?></title>
</head>

<body>
    <div class="user-profile-container">
        <!-- ส่วนหัวของโปรไฟล์ -->
        <div class="user-profile-header">
        <img src="../upload/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="user-profile-img">
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>
            <p class="user-member-since">เป็นสมาชิกตั้งแต่: <?php echo $first_membership_date; ?></p>
            <p class="user-status <?php echo ($user['user_type'] == 'admin') ? 'user-status-admin' : 'user-status-regular'; ?>">สถานะ: <?php echo $user_type; ?></p>


        </div>

        <!-- รายละเอียดผู้ใช้ -->
        <div class="user-profile-details">
            <p><strong>อีเมล:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
            <p><strong>ที่อยู่:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <!-- ปุ่มแก้ไขโปรไฟล์ -->
        <div class="user-profile-actions">
            <a href="../page/edit_profile.php?user_id=<?php echo $user_id; ?>" class="user-edit-btn">✏️ แก้ไขโปรไฟล์</a>
        </div>
    </div>
</body>

</html>
<?php
include('../includes/footer.php');
?>