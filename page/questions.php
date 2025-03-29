<?php
include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คำถามที่พบบ่อย | Shopee Style</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="faq-container">
        <h2 class="faq-header">คำถามที่พบบ่อย</h2>
        <div class="accordion" id="faqAccordion">
            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                        <i class="fas fa-question-circle me-2"></i> วิธีการสั่งซื้อสินค้า?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        คุณสามารถเลือกสินค้าลงตะกร้า กรอกที่อยู่ และดำเนินการชำระเงินได้ง่าย ๆ ผ่านระบบของเรา
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                        <i class="fas fa-truck me-2"></i> ระยะเวลาการจัดส่ง?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ระยะเวลาการจัดส่งขึ้นอยู่กับพื้นที่ของคุณ โดยทั่วไปใช้เวลา 1-3 วันทำการในกรุงเทพฯ และ 3-7 วันทำการในต่างจังหวัด
                    </div>
                </div>
            </div>
            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                        <i class="fas fa-exchange-alt me-2"></i> นโยบายการคืนสินค้า?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        คุณสามารถคืนสินค้าได้ภายใน 7 วันหลังจากได้รับสินค้า โดยสินค้าต้องอยู่ในสภาพสมบูรณ์
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include('../includes/footer.php');
?>