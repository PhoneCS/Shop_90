<?php
session_start();
require_once 'config.php';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$birthdate = $_POST['birthdate'];
$nationality = $_POST['nationality'];
$religion = $_POST['religion'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$marital_status = $_POST['marital_status'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$province = $_POST['province'];
$district = $_POST['district'];
$subdistrict = $_POST['subdistrict'];
$postal_code = $_POST['postal_code'];
$internship_experience = $_POST['internship_experience'];
$language_skills = $_POST['language_skills'];

// ใช้คำสั่ง SQL สำหรับอัพเดตข้อมูล
$stmt = $conn->prepare("UPDATE graduates SET 
    birthdate = ?, nationality = ?, religion = ?, weight = ?, height = ?, marital_status = ?, 
    phone_number = ?, address = ?, province = ?, district = ?, subdistrict = ?, postal_code = ?, 
    internship_experience = ?, language_skills = ? 
    WHERE email = ?");
$stmt->bind_param("ssssssssssssssssssss", $birthdate, $nationality, $religion, $weight, $height, 
    $marital_status, $phone_number, $address, $province, $district, $subdistrict, $postal_code, 
    $internship_experience, $language_skills, $email);
$stmt->execute();
$stmt->close();

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

header("Location: index.php");
exit();
?>
