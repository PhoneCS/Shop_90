<?php
require_once 'config.php'; // Include database connection settings

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่า graduates.email และ graduates2.email
    $graduates_email = $_POST['graduates_email'] ?? null;
    $graduates2_email = $_POST['graduates2_email'] ?? null;

    // ตรวจสอบว่าค่าที่รับมาไม่ว่าง
    if ($graduates_email && $graduates2_email) {
        // เชื่อมต่อฐานข้อมูล
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL สำหรับบันทึกข้อมูล
        $sql_insert = "INSERT INTO matchstudent (email_std, company_name_std) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("ss", $graduates_email, $graduates2_email);
            if ($stmt->execute()) {
                echo "<h1>บันทึกข้อมูลสำเร็จ</h1>";
                echo "<p><strong>Graduates Email:</strong> " . htmlspecialchars($graduates_email) . "</p>";
                echo "<p><strong>Graduates2 Email:</strong> " . htmlspecialchars($graduates2_email) . "</p>";
            } else {
                echo "<h1>เกิดข้อผิดพลาดในการบันทึกข้อมูล</h1>";
                echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
            }
            $stmt->close();
        } else {
            echo "<h1>เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL</h1>";
        }

        // ปิดการเชื่อมต่อ
        $conn->close();
    } else {
        echo "<h1>ข้อมูลที่ส่งมาไม่ครบถ้วน</h1>";
    }
} else {
    echo "ไม่มีข้อมูลส่งมา";
}
?>
