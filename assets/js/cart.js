// ฟังก์ชันสำหรับอัปเดตจำนวนสินค้า
function updateQuantity(action, productId) {
    const quantityInput = document.getElementById(`quantity-${productId}`);
    let quantity = parseInt(quantityInput.value);

    // เพิ่มหรือลดจำนวน
    if (action === 'increase') {
        quantity++;
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
    }

    quantityInput.value = quantity;

    // คำนวณราคาหลังจากอัปเดตจำนวน
    updatePrice(productId, quantity);
}

// ฟังก์ชันสำหรับคำนวณราคา
function updatePrice(productId, quantity) {
    const pricePerUnit = parseFloat(document.getElementById(`price-${productId}`).innerText.replace('฿ ', '').replace(',', ''));
    const newPrice = pricePerUnit * quantity;

    // อัปเดตราคาในแต่ละสินค้า
    document.getElementById(`price-${productId}`).innerText = `฿ ${newPrice.toFixed(2)}`;

    // คำนวณยอดรวมทั้งหมด
    calculateTotal();
}

// ฟังก์ชันสำหรับคำนวณยอดรวม
function calculateTotal() {
    let total = 0;
    const prices = document.querySelectorAll('.price');
    
    prices.forEach(priceElement => {
        total += parseFloat(priceElement.innerText.replace('฿ ', '').replace(',', ''));
    });

    document.getElementById('total-price').innerText = `฿ ${total.toFixed(2)}`;
}

// ฟังก์ชันลบสินค้าออกจากตะกร้า
function removeItem(productId) {
    const cartItem = document.querySelector(`.cart-item:nth-child(${productId})`);
    cartItem.remove();
    calculateTotal();
}


// คิดยอด

// ฟังก์ชันเพื่อคำนวณยอดรวมในตะกร้า
function updateTotalPrice() {
    let totalPrice = 0;

    // วนลูปหาทุกสินค้าที่อยู่ในตะกร้า
    document.querySelectorAll('.cart-item').forEach(function(item) {
        let price = parseFloat(item.getAttribute('data-price'));  // ดึงราคาจาก data-attribute
        let quantity = parseInt(item.querySelector('.quantity-input').value); // ดึงจำนวนสินค้าจาก input

        // คำนวณยอดรวมของสินค้ารายการนี้
        totalPrice += price * quantity;
    });

    // อัพเดตยอดรวมในหน้าเว็บ
    document.getElementById('total-price').textContent = '฿ ' + totalPrice.toFixed(2);
}

// ฟังก์ชันเพิ่มหรือลดจำนวนสินค้า
function updateQuantity(action, productId) {
    let quantityInput = document.getElementById('quantity-' + productId);
    let quantity = parseInt(quantityInput.value);

    if (action === 'increase') {
        quantity++;
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
    }

    quantityInput.value = quantity;  // อัพเดตจำนวนใน input
    updateTotalPrice();  // คำนวณยอดรวมใหม่
}

// ฟังก์ชันลบสินค้า
function removeItem(productId) {
    let item = document.querySelector('.cart-item[data-product-id="' + productId + '"]');
    item.remove();  // ลบสินค้าออกจากตะกร้า

    updateTotalPrice();  // คำนวณยอดรวมใหม่
}

// เรียกฟังก์ชันเพื่อคำนวณยอดรวมตอนโหลดหน้า
window.onload = function() {
    updateTotalPrice();
};

// เพิ่มสิ้นค้าลงตะกล้า

document.addEventListener('DOMContentLoaded', function() {
    // สคริปต์สำหรับปุ่ม "เพิ่มลงตะกร้า"
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart-product');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            
            // ส่งข้อมูลไปยัง PHP ด้วย AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../process/update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // ใช้ SweetAlert2 แสดงข้อความเมื่อเพิ่มสินค้าลงตะกร้า
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มลงตะกร้า',
                        text: `เพิ่มสินค้า ${productName} ลงตะกร้าเรียบร้อยแล้ว!`,
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#3085d6',
                    });
                    
                    // อัพเดตจำนวนสินค้าในตะกร้า (จำลอง)
                    const cartCount = document.querySelector('.cart-count');
                    const currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;
                } else {
                    // แสดงข้อผิดพลาดถ้าการเพิ่มสินค้าล้มเหลว
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเพิ่มสินค้าได้ กรุณาลองใหม่อีกครั้ง',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#d33',
                    });
                }
            };
            xhr.send('product_id=' + productId + '&product_name=' + productName);
        });
    });
});

// เพิ่มลงตะกล้าของ index

document.addEventListener('DOMContentLoaded', function() {
    // สคริปต์สำหรับปุ่ม "เพิ่มลงตะกร้า"
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart-product');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            
            // ส่งข้อมูลไปยัง PHP ด้วย AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './process/update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // ใช้ SweetAlert2 แสดงข้อความเมื่อเพิ่มสินค้าลงตะกร้า
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มลงตะกร้า',
                        text: `เพิ่มสินค้า ${productName} ลงตะกร้าเรียบร้อยแล้ว!`,
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#3085d6',
                    });
                    
                    // อัพเดตจำนวนสินค้าในตะกร้า (จำลอง)
                    const cartCount = document.querySelector('.cart-count');
                    const currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;
                } else {
                    // แสดงข้อผิดพลาดถ้าการเพิ่มสินค้าล้มเหลว
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเพิ่มสินค้าได้ กรุณาลองใหม่อีกครั้ง',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#d33',
                    });
                }
            };
            xhr.send('product_id=' + productId + '&product_name=' + productName);
        });
    });
});

// ปุ่มลบ
function removeItem(productId) {
    // ส่งคำขอแบบ GET ไปยัง remove.php เพื่อลบสินค้าจากตะกร้า
    if (confirm("คุณต้องการลบสินค้านี้จากตะกร้า?")) {
        window.location.href = '../process/remove.php?product_id=' + productId;
    }
}

function updateQuantity(action, productId) {
    var quantityInput = document.getElementById('quantity-' + productId);
    var currentQuantity = parseInt(quantityInput.value);

    // ตรวจสอบการเพิ่มหรือลดปริมาณ
    if (action === 'increase') {
        quantityInput.value = currentQuantity + 1;
    } else if (action === 'decrease' && currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
    }

    // ส่งข้อมูลปริมาณใหม่ไปยังฐานข้อมูล
    var newQuantity = quantityInput.value;
    // ส่งข้อมูลด้วย AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_quantity.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // อัพเดตข้อมูลในตะกร้า
            document.getElementById('price-' + productId).innerHTML = '฿ ' + xhr.responseText;
            updateTotalPrice();
        }
    };
    xhr.send('product_id=' + productId + '&quantity=' + newQuantity);
}

function updateTotalPrice() {
    var totalPrice = 0;
    var prices = document.querySelectorAll('.cart-item .price');
    prices.forEach(function(price) {
        totalPrice += parseFloat(price.innerText.replace('฿', '').replace(',', ''));
    });
    document.getElementById('total-price').innerText = '฿ ' + totalPrice.toFixed(2);
}
