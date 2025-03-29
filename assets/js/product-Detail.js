document.getElementById('decreaseQuantity').addEventListener('click', function() {
    let quantityInput = document.getElementById('productQuantity');
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
        quantityInput.value = quantity - 1;
    }
});

document.getElementById('increaseQuantity').addEventListener('click', function() {
    let quantityInput = document.getElementById('productQuantity');
    let quantity = parseInt(quantityInput.value);
    quantityInput.value = quantity + 1;
});

function openModal() {
    document.getElementById("editModal").style.display = "block";
    document.body.classList.add("modal-open"); // ปิดการเลื่อนของ body
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
    document.body.classList.remove("modal-open"); // เปิดการเลื่อนของ body เมื่อปิด modal
}

function openPromotionModal() {
    document.getElementById("promotionModal").style.display = "block";
    document.body.classList.add("modal-open");
}

function closePromotionModal() {
    document.getElementById("promotionModal").style.display = "none";
    document.body.classList.remove("modal-open");
}
function calculateDiscountAndPercentage() {
    var originalPrice = parseFloat(document.getElementById('original_price_promotion').value); // ราคาเดิม
    var discountedPrice = parseFloat(document.getElementById('discounted_price').value); // ราคาที่ลดแล้ว

    // ตรวจสอบว่าราคาทั้งสองมีค่ามากกว่า 0
    if (originalPrice > 0 && discountedPrice >= 0) {
        var discount = originalPrice - discountedPrice; // ส่วนลด
        // คำนวณเปอร์เซ็นต์ส่วนลด
        var discountPercentage = ((discount / originalPrice) * 100).toFixed(2);

        // แสดงเปอร์เซ็นต์ในส่วนที่แสดงค่า
        document.getElementById('discount_percentage').textContent = discountPercentage + '%';
    } else {
        // ถ้าราคาเดิมหรือราคาที่ลดแล้วไม่ถูกต้อง
        document.getElementById('discount_percentage').textContent = '0%';
    }
}





document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.getElementById("productQuantity");
    const increaseBtn = document.getElementById("increaseQuantity");
    const decreaseBtn = document.getElementById("decreaseQuantity");
    const stockElement = document.getElementById("productStock");

    const maxStock = parseInt(stockElement.dataset.stock, 10); // ตรวจสอบจำนวนสินค้าจากฐานข้อมูล

    function checkStockStatus() {
        if (maxStock === 0) {
            // หากสินค้าเหลือ 0 ให้ปิดปุ่มทั้งหมด
            increaseBtn.disabled = true;
            decreaseBtn.disabled = true;
            increaseBtn.style.backgroundColor = "#ccc"; // สีจางๆ
            decreaseBtn.style.backgroundColor = "#ccc"; // สีจางๆ
            quantityInput.disabled = true;
            quantityInput.style.backgroundColor = "#f0f0f0"; // สีจางๆ
        } else {
            // หากสินค้ามีให้เปิดปุ่มและสีปกติ
            increaseBtn.disabled = false;
            decreaseBtn.disabled = false;
            increaseBtn.style.backgroundColor = ""; 
            decreaseBtn.style.backgroundColor = "";
            quantityInput.disabled = false;
            quantityInput.style.backgroundColor = "";
        }
    }

    function updateQuantity(change) {
        let currentValue = parseInt(quantityInput.value, 10);
        let newValue = currentValue + change;

        if (newValue < 1) {
            newValue = 1;
        } else if (newValue > maxStock) {
            newValue = maxStock;
        }

        quantityInput.value = newValue;
        checkStockStatus();
    }

    // ฟังค์ชันสำหรับเพิ่มและลดจำนวน
    increaseBtn.addEventListener("click", function () {
        updateQuantity(1);
    });

    decreaseBtn.addEventListener("click", function () {
        updateQuantity(-1);
    });

    // ตรวจสอบจำนวนสินค้า
    checkStockStatus();
});