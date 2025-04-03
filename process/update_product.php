<?php
include('../includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_additional_info = $_POST['product_additional_info'];
    $product_price = $_POST['product_price'];

    $image_path = $_POST['current_image'];
    $image_hover_path = $_POST['current_image_hover'];

    function uploadImage($file, $upload_dir) {
        if (isset($file) && $file['error'] == 0) {
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_ext, $allowed_exts)) {
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_file = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_file)) {
                    return $new_file_name;
                }
            }
        }
        return null;
    }

    $upload_dir = '../assets/image/';
    $new_image = uploadImage($_FILES['product_image'], $upload_dir);
    $new_image_hover = uploadImage($_FILES['product_image_hover'], $upload_dir);

    if ($new_image) $image_path = $new_image;
    if ($new_image_hover) $image_hover_path = $new_image_hover;

    $sql = "UPDATE products 
            SET product_name = ?, product_description = ?, product_price = ?, 
                product_image = ?, product_image_hover = ? 
            WHERE product_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $product_name, $product_description, $product_price, $image_path, $image_hover_path, $product_id);

    $sql_detail = "UPDATE product_detail 
                   SET product_description = ?, product_additional_info = ? 
                   WHERE product_id = ?";

    $stmt_detail = $conn->prepare($sql_detail);
    $stmt_detail->bind_param("ssi", $product_description, $product_additional_info, $product_id);

    if ($stmt->execute() && $stmt_detail->execute()) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'อัปเดตสินค้าสำเร็จ!',
                text: 'กำลังนำคุณไปยังหน้ารายละเอียดสินค้า...',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '../page/product-details.php?product_id=" . $product_id . "';
            });
        </script>";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'เกิดข้อผิดพลาด!',
                text: 'โปรดตรวจสอบอีกครั้ง',
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        </script>";
    }

    $stmt->close();
    $stmt_detail->close();
}

$conn->close();
?>
<?php include('../includes/footer.php'); ?>
