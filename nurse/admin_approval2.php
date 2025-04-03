<?php
session_start();
require 'database.php'; // ไฟล์ที่เชื่อมต่อฐานข้อมูล

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli('localhost', 'root', '', 'users');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลการสมัครสมาชิกที่รอการตรวจสอบ
$result = $conn->query("SELECT * FROM pending_members2 WHERE status = 'pending'");

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบการสมัครสมาชิก</title>
    <link rel="stylesheet" href="styles_admin.css"> <!-- ลิงก์ไปยังไฟล์ CSS ของคุณ -->
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

        .button {
            padding: 10px 20px;
            margin-right: 10px;
            text-align: center;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
        }

        .approve {
            background-color: #27ae60;
        }

        .approve:hover {
            background-color: #2ecc71;
        }

        .reject {
            background-color: #e74c3c;
        }

        .reject:hover {
            background-color: #c0392b;
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
        <h1>ตรวจสอบการสมัครสมาชิก</h1>
        <a href="admin.php">หน้าแรก</a>
        
        <?php if (isset($_SESSION['message'])): ?>
            <p class="alert"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ชื่อผู้ใช้</th>
                    <th>อีเมล</th>
                    <th>ชื่อบริษัท</th>
                    <th>ประเภทธุรกิจ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['business_type']); ?></td>
                    <td>
                        <a href="approve2.php?id=<?php echo $row['id']; ?>" class="button approve">อนุมัติ</a>
                        <a href="reject2.php?id=<?php echo $row['id']; ?>" class="button reject">ปฏิเสธ</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>ไม่มีการสมัครสมาชิกที่รอการตรวจสอบ</p>
        <?php endif; ?>
    </div>

    <footer>
        <a href="admin.php">หน้าแรก</a>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
