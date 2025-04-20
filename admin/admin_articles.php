<?php

include('../includes/header.php'); 

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php'); // ถ้าไม่ได้ล็อกอินให้กลับไปหน้าหลัก
    exit();
}

$isAdmin = ($_SESSION['user_type'] === 'admin'); // เช็คว่าเป็น admin หรือไม่

// ดึงข้อมูลบทความ
$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บทความ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>บทความ</h2>

        <!-- แสดงปุ่มเพิ่มบทความเฉพาะ admin -->
        <?php if ($isAdmin): ?>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal"
            data-bs-target="#addArticleModal">เพิ่มบทความ</button>
        <?php endif; ?>

        <!-- รายการบทความ -->
        <div class="article-list">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="article d-flex mb-4">
                <!-- รูปภาพ -->
                <?php if ($row['image']): ?>
                <img src="../assets/image/<?= $row['image'] ?>" alt="Article Image" class="me-3"
                    style="width: 150px; height: 150px; object-fit: cover; flex-shrink: 0;">
                <?php endif; ?>


                <!-- เนื้อหาบทความ -->
                <div class="content">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p>เผยแพร่เมื่อ: <?= date('d/m/Y', strtotime($row['created_at'])) ?></p>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                    <!-- ปุ่มแก้ไขเฉพาะ admin -->
                    <?php if ($isAdmin): ?>
                    <button class="btn btn-warning btn-edit" data-id="<?= $row['id'] ?>"
                        data-title="<?= htmlspecialchars($row['title']) ?>"
                        data-content="<?= htmlspecialchars($row['content']) ?>" data-image="<?= $row['image'] ?>"
                        data-bs-toggle="modal" data-bs-target="#editArticleModal">
                        แก้ไข
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal เพิ่มบทความ (เฉพาะ Admin) -->
    <?php if ($isAdmin): ?>
    <div class="modal fade" id="addArticleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มบทความ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addArticleForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">หัวข้อ</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">เนื้อหา</label>
                            <textarea class="form-control" name="content" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">แนบรูปภาพ</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal แก้ไขบทความ (เฉพาะ Admin) -->
    <?php if ($isAdmin): ?>
    <div class="modal fade" id="editArticleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขบทความ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editArticleForm" enctype="multipart/form-data">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label class="form-label">หัวข้อ</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">เนื้อหา</label>
                            <textarea class="form-control" name="content" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">แนบรูปภาพ (หากต้องการเปลี่ยน)</label>
                            <input type="file" class="form-control" name="image">
                            <img id="currentImage" src="" alt="Current Image"
                                style="max-width: 100%; margin-top: 10px;">
                        </div>
                        <button type="submit" class="btn btn-success">อัปเดต</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
    // เพิ่มบทความ
    $('#addArticleForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '../process/insert_article.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // แสดง SweetAlert2 เมื่อเพิ่มบทความสำเร็จ
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มบทความสำเร็จ',
                    text: 'บทความของคุณได้ถูกเพิ่มเรียบร้อยแล้ว',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    location.reload();  // รีโหลดหน้าใหม่หลังจากกดตกลง
                });
            },
            error: function() {
                // แสดง SweetAlert2 เมื่อเกิดข้อผิดพลาด
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเพิ่มบทความได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonText: 'ตกลง'
                });
            }
        });
    });

    // แก้ไขบทความ
    $('.btn-edit').click(function() {
        $('#editArticleForm [name="id"]').val($(this).data('id'));
        $('#editArticleForm [name="title"]').val($(this).data('title'));
        $('#editArticleForm [name="content"]').val($(this).data('content'));
        $('#currentImage').attr('src', '../assets/image/' + $(this).data('image'));
    });

    $('#editArticleForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '../process/update_article.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // แสดง SweetAlert2 เมื่ออัปเดตบทความสำเร็จ
                Swal.fire({
                    icon: 'success',
                    title: 'อัปเดตบทความสำเร็จ',
                    text: 'บทความของคุณได้ถูกอัปเดตเรียบร้อยแล้ว',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    location.reload();  // รีโหลดหน้าใหม่หลังจากกดตกลง
                });
            },
            error: function() {
                // แสดง SweetAlert2 เมื่อเกิดข้อผิดพลาด
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถอัปเดตบทความได้ กรุณาลองใหม่อีกครั้ง',
                    confirmButtonText: 'ตกลง'
                });
            }
        });
    });
</script>

</body>

</html>

<?php include('../includes/footer.php'); ?>