<?php
session_start();
require_once 'config.php';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login2.php");
    exit();
}

$email = $_SESSION['email'];

// ตรวจสอบว่าผู้ใช้มีโพสต์อยู่แล้วหรือไม่
$stmt = $conn->prepare("SELECT COUNT(*) AS post_count FROM graduates2 WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$post_count = $result['post_count'];
$stmt->close();

// การตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($post_count > 0) {
        echo "<p>คุณได้โพสต์งานไปแล้วหนึ่งครั้ง ไม่สามารถโพสต์เพิ่มได้</p>";
    } else {
        // ตรวจสอบการกรอกข้อมูล
        $company_name = $_POST['company_name'] ?? '';
        $business_type = $_POST['business_type'] ?? '';
        $contact_person = $_POST['contact_person'] ?? '';
        $job_title = $_POST['job_title'] ?? '';
        $job_type = $_POST['job_type'] ?? '';
        $location = $_POST['location'] ?? '';
        $province = $_POST['province'] ?? '';
        $district = $_POST['district'] ?? '';
        $sub_district = $_POST['sub_district'] ?? '';
        $postal_code = $_POST['postal_code'] ?? '';
        $salary = $_POST['salary'] ?? '';
        $education_requirements = $_POST['education_requirements'] ?? '';
        $company_benefits = $_POST['company_benefits'] ?? '';
        $contact_channels = $_POST['contact_channels'] ?? '';
        $email = $_POST['email'] ?? '';
        $qualifications = $_POST['qualifications'] ?? '';

        // ตรวจสอบข้อมูลที่กรอก
        if (empty($company_name) || empty($business_type) || empty($contact_person) || empty($job_title) || empty($job_type) || empty($location) || empty($province) || empty($district) || empty($sub_district) || empty($postal_code) || empty($salary) || empty($education_requirements) || empty($company_benefits) || empty($contact_channels) || empty($email) || empty($qualifications)) {
            echo "<p>กรุณากรอกข้อมูลให้ครบถ้วน</p>";
        } else {
            // เตรียมคำสั่ง SQL สำหรับการโพสต์ใหม่
            $stmt = $conn->prepare("INSERT INTO graduates2 (company_name, business_type, contact_person, job_title, job_type, location, province, district, sub_district, postal_code, salary, education_requirements, company_benefits, contact_channels, email, qualifications) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssssss", $company_name, $business_type, $contact_person, $job_title, $job_type, $location, $province, $district, $sub_district, $postal_code, $salary, $education_requirements, $company_benefits, $contact_channels, $email, $qualifications);
            
            if ($stmt->execute()) {
                // ปิดการเชื่อมต่อฐานข้อมูล
                $stmt->close();
                $conn->close();
                // เปลี่ยนเส้นทางไปยังหน้า index2.php
                header("Location: index2.php");
                exit();
            } else {
                echo "<p>เกิดข้อผิดพลาด: " . $stmt->error . "</p>";
            }
        }
    }
}
?>
