<?php
session_start();
include('../includes/connect.inc.php'); // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['complaint_id'])) {
        $complaint_id = $_POST['complaint_id'];

        // ตรวจสอบว่า complaint_id มีอยู่ในฐานข้อมูลหรือไม่
        $check = $conn->prepare("SELECT status FROM complaints WHERE complaint_id = ?");
        $check->bind_param("i", $complaint_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            die("ไม่พบข้อมูล complaint_id = $complaint_id");
        }

        // อัปเดตสถานะ
        $sql = "UPDATE complaints SET status = 'n' WHERE complaint_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("เกิดข้อผิดพลาดในการเตรียม SQL: " . $conn->error);
        }

        $stmt->bind_param("i", $complaint_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('สถานะถูกเปลี่ยนเรียบร้อยแล้ว');
                window.location.href = '../page/issue_management.php';
            </script>";
        } else {
            echo "<script>
                alert('ไม่สามารถเปลี่ยนสถานะได้ อาจจะถูกเปลี่ยนไปแล้ว หรือ complaint_id ไม่ตรง');
                window.location.href = '../page/issue_management.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "ไม่พบข้อมูล complaint_id!";
    }

    $conn->close();
} else {
    header("Location: ../page/manage_complaints.php");
    exit;
}
?>
