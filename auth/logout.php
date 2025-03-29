<?php
session_start();

// ลบข้อมูล session ที่เกี่ยวข้อง
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปที่หน้าแรกหรือหน้าเข้าสู่ระบบ
header("Location: ../index.php"); // หรือคุณสามารถเปลี่ยนเป็นหน้า login.php ได้
exit();
?>
