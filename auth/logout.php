<?php
session_start();

// ลบข้อมูล session ที่เกี่ยวข้อง
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ออกจากระบบ</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<script>
    Swal.fire({
        icon: "success",
        title: "ออกจากระบบสำเร็จ!",
        text: "กำลังกลับไปยังหน้าหลัก...",
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = "../index.php"; // เปลี่ยนเส้นทางไปหน้า index.php หรือเปลี่ยนเป็น login.php ได้
    });
</script>

</body>
</html>
