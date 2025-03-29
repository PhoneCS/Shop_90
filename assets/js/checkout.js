// สร้าง QR Code
QRCode.toDataURL("<?php echo $payment_link; ?>", function(err, url) {
    if (err) console.error(err);
    const img = document.createElement("img");
    img.src = url;
    img.style.width = "200px";
    img.style.height = "200px";
    document.getElementById("qrCode").appendChild(img);
});


function startPayment() { 
    // ตรวจสอบว่ามีสินค้าหรือไม่ โดยดึงข้อมูลจาก HTML แทน localStorage
    const cartTable = document.querySelector(".order-summary tbody");
    if (!cartTable || cartTable.children.length <= 1) {
        Swal.fire({
            icon: "warning",
            title: "ไม่มีสินค้าในตะกร้า!",
            text: "โปรดเลือกสินค้าก่อนทำการชำระเงิน",
        });
        return;
    }

    let timerInterval;
    Swal.fire({
        title: 'กำลังดำเนินการชำระเงิน...',
        html: 'กรุณารอสักครู่ <b></b> วินาที',
        timer: 5000, // กำหนดเวลาการรอ 5 วินาที
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getHtmlContainer().querySelector("b");
            let timeLeft = 5; // เวลาเริ่มต้น 5 วินาที
            timer.textContent = timeLeft;
            timerInterval = setInterval(() => {
                timeLeft--;
                timer.textContent = timeLeft;
            }, 1000);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then(() => {
        // เมื่อเสร็จสิ้นการชำระเงิน
        Swal.fire({
            title: 'ชำระเงินเสร็จสิ้น!',
            icon: 'success',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            localStorage.removeItem("cart"); // ล้างตะกร้าสินค้า
            window.location.href = "../page/order_tracking.php"; // ไปหน้าติดตามออเดอร์
        });
    });
}

