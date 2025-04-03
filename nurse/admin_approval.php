<?php
session_start();
require_once 'config.php';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลที่รอการอนุมัติจาก pending_members
$sql = "SELECT * FROM pending_members";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ตรวจสอบสมาชิก</title>
    <link rel="stylesheet" href="styles_admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('img/nsru2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        h1 {
            color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #bdc3c7;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            color: #2980b9;
        }

        footer {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-top: 20px;
        }

        footer a {
            color: #2c3e50;
            text-decoration: none;
            margin-right: 10px;
            font-weight: bold;
        }

        footer a:hover {
            color: #3498db;
        }

        .alert {
            background-color: #f39c12;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">ระบบการหางานบัณฑิตมหาวิทยาลัยราชภัฏนครสวรรค์</div>
    <div class="container">
        <h1>ตรวจสอบสมาชิก</h1>
        
        <!-- แสดงข้อความแจ้งเตือน -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="alert"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
            <?php unset($_SESSION['message']); // ลบข้อความหลังจากแสดงผลแล้ว ?>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อ-นามสกุล</th>
                        <th>รหัสนักศึกษา</th>
                        <th>สาขาวิชา</th>
                        <th>คณะ</th>
                        <th>Email</th>
                        <th>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['field_of_study']); ?></td>
                            <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <a href="approve.php?id=<?php echo $row['id']; ?>" class="status-btn unemployed">อนุมัติ</a> |
                                <a href="reject.php?id=<?php echo $row['id']; ?>" class="status-btn employed">ปฏิเสธ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>ไม่มีข้อมูลสมาชิกที่รอการอนุมัติ</p>
        <?php endif; ?>

        <?php
        $conn->close();
        ?>
    </div>

    <footer>
        <a href="admin.php">หน้าแรก</a>
    </footer>
</body>
</html>
