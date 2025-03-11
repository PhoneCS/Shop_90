document.addEventListener('DOMContentLoaded', function() {
    const decreaseButtons = document.querySelectorAll('.btn-decrease');
    const increaseButtons = document.querySelectorAll('.btn-increase');
    const quantityDisplays = document.querySelectorAll('.quantity-value');
    const totalPriceElement = document.querySelector('.total-price-display');

    // ฟังก์ชั่นอัปเดตราคารวมของแต่ละสินค้า
    function updateTotalPriceForItem(item) {
        const price = parseFloat(item.dataset.price); // ราคาต่อหน่วย
        const quantity = parseInt(item.querySelector('.quantity-value').textContent); // จำนวนสินค้า
        const totalPrice = price * quantity; // ราคารวมของสินค้านั้น
        item.querySelector('.total-price').textContent = '฿' + totalPrice.toFixed(2); // แสดงราคาใหม่ในรายการ
    }

    // ฟังก์ชั่นอัปเดตรารวมทั้งหมด
    function updateTotalPrice() {
        let totalPrice = 0;

        document.querySelectorAll('.cart-item').forEach(function(item) {
            const price = parseFloat(item.dataset.price);
            const quantity = parseInt(item.querySelector('.quantity-value').textContent);
            totalPrice += price * quantity; // คำนวณราคาทั้งหมด
        });

        totalPriceElement.textContent = '฿' + totalPrice.toFixed(2); // อัปเดตยอดรวม
    }

    // ฟังก์ชั่นเพิ่มจำนวน
    increaseButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const quantityDisplay = button.previousElementSibling;
            let quantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = ++quantity; // เพิ่มจำนวน
            const item = button.closest('.cart-item');
            updateTotalPriceForItem(item); // อัปเดตราคาของสินค้านี้
            updateTotalPrice(); // อัปเดตยอดรวมทั้งหมด
        });
    });

    // ฟังก์ชั่นลดจำนวน
    decreaseButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const quantityDisplay = button.nextElementSibling;
            let quantity = parseInt(quantityDisplay.textContent);
            if (quantity > 1) { // ป้องกันการลดจำนวนต่ำกว่า 1
                quantityDisplay.textContent = --quantity; // ลดจำนวน
                const item = button.closest('.cart-item');
                updateTotalPriceForItem(item); // อัปเดตราคาของสินค้านี้
                updateTotalPrice(); // อัปเดตยอดรวมทั้งหมด
            }
        });
    });

    // เริ่มต้นอัปเดตราคารวมเมื่อโหลดหน้า
    updateTotalPrice();
});
