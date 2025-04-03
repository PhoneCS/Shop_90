<?php
session_start();
include 'connect.inc.php';

// รับ ID จาก URL
$id = $_GET['id'] ?? null;
$msg = $msgType = "";

// ตรวจสอบว่ามีการส่ง ID มา
if ($id) {
    if (isset($_GET['delete_confirm']) && $_GET['delete_confirm'] === 'true') {
        // คำสั่ง SQL สำหรับคัดลอกข้อมูลจาก product_items ไปยัง bin
        $sql_bin = "UPDATE product_items SET status_item = 'n' WHERE id = '$id';";
        $result_bin = mysqli_query($link, $sql_bin);

        if ($result_bin) {
            if ($result_bin) {
                $msg = "ลบข้อมูลสำเร็จ!";
                $msgType = "success";
            } else {
                $msg = "การลบข้อมูลล้มเหลว: " . mysqli_error($link);
                $msgType = "error";
            }
        } else {
            $msg = "การสำรองข้อมูลล้มเหลว: " . mysqli_error($link);
            $msgType = "error";
        }
    }
} else {
    $msg = "ไม่มีการระบุ ID";
    $msgType = "warning";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deletion Status</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script type="text/javascript">
    <?php if ($msgType): ?>
        // แสดงผลลัพธ์ของการลบโดยใช้ SweetAlert
        Swal.fire({
            icon: "<?php echo $msgType; ?>",
            title: "<?php echo $msgType === 'success' ? 'สำเร็จ' : 'เกิดข้อผิดพลาด'; ?>",
            text: "<?php echo $msg; ?>",
            confirmButtonText: "ตกลง"
        }).then(() => {
            window.location = 'overview.php';
        });
    <?php else: ?>
        // การยืนยันการลบ
        Swal.fire({
            title: "คุณต้องการลบข้อมูลหรือไม่?",
            text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ลบเลย!",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "?id=<?php echo $id; ?>&delete_confirm=true";
            } else {
                window.location = 'overview.php';
            }
        });
    <?php endif; ?>
    </script>
</body>
</html>
