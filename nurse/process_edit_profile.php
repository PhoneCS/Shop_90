<?php
session_start();

// ใช้การจัดการข้อผิดพลาดของ session
if (session_status() !== PHP_SESSION_ACTIVE) {
    die("Session error.");
}

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
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// รับข้อมูลจากฟอร์ม
$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$university = $_POST['university'];
$faculty = $_POST['faculty'];
$major = $_POST['major'];
$graduation_year = $_POST['graduation_year'];
$job_title = $_POST['job_title'];
$job_type = $_POST['job_type'];
$location = $_POST['location'];
$salary_range = $_POST['salary_range'];
$profile_text = $_POST['profile_text'];
$birthdate = $_POST['birthdate'];
$nationality = $_POST['nationality'];
$religion = $_POST['religion'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$marital_status = $_POST['marital_status'];
$address = $_POST['address'];
$province = $_POST['province'];
$district = $_POST['district'];
$subdistrict = $_POST['subdistrict'];
$postal_code = $_POST['postal_code'];
$internship_experience = $_POST['internship_experience'];
$language_skills = $_POST['language_skills'];

// ตรวจสอบและจัดการไฟล์รูปภาพโปรไฟล์
$profile_picture = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $tmp_name = $_FILES['profile_picture']['tmp_name'];
    $name = basename($_FILES['profile_picture']['name']);
    $profile_picture = $upload_dir . $name;
    move_uploaded_file($tmp_name, $profile_picture);
}

$email = $_SESSION['email'];

try {
    // อัปเดตโปรไฟล์ของผู้ใช้
    $stmt = $pdo->prepare("
        UPDATE graduates 
        SET full_name = ?, phone = ?, university = ?, faculty = ?, major = ?, graduation_year = ?, job_title = ?, 
            job_type = ?, location = ?, salary_range = ?, profile_text = ?, birthdate = ?, nationality = ?, 
            religion = ?, weight = ?, height = ?, marital_status = ?, address = ?, province = ?, 
            district = ?, subdistrict = ?, postal_code = ?, internship_experience = ?, language_skills = ?, 
            profile_picture = ? 
        WHERE email = ?
    ");

    $stmt->execute([
        $full_name, $phone, $university, $faculty, $major, $graduation_year, $job_title, $job_type,
        $location, $salary_range, $profile_text, $birthdate, $nationality, $religion, $weight, $height,
        $marital_status, $address, $province, $district, $subdistrict, $postal_code, $internship_experience,
        $language_skills, $profile_picture, $email
    ]);

    // ปิดการเชื่อมต่อฐานข้อมูล
    $pdo = null;

    // ตั้งค่าข้อความแจ้งเตือนและเปลี่ยนเส้นทาง
    $_SESSION['message'] = "โปรไฟล์ได้รับการอัปเดตเรียบร้อยแล้ว";
    header("Location: index.php");
    exit();

} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}
