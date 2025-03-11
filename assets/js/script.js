document.addEventListener('DOMContentLoaded', function() {
    // สคริปต์สำหรับปุ่ม "เพิ่มลงตะกร้า"
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart-product');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            
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
        });
    });
    
    // สคริปต์สำหรับการค้นหา
    const searchForm = document.querySelector('.search-form');
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const searchTerm = document.querySelector('.search-input').value;
        
        // ใช้ SweetAlert2 แสดงข้อความค้นหา
        Swal.fire({
            icon: 'info',
            title: 'กำลังค้นหา',
            text: `กำลังค้นหา: ${searchTerm}`,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#3085d6',
        });
    });
});


document.querySelectorAll('.product-link').forEach(function(link) {
    link.addEventListener('click', function() {
        window.location.href = link.getAttribute('data-url');
    });
});



