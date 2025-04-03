document.addEventListener('DOMContentLoaded', function() {
    // สคริปต์สำหรับปุ่ม "เพิ่มลงตะกร้า"
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart-product');
    
    
    
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


// dropdown
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    // ซ่อนเมนู dropdown ทันทีที่โหลดหน้าใหม่
    dropdownMenu.style.display = 'none';

    // เมื่อคลิกที่ปุ่ม dropdown (การจัดส่ง)
    dropdownToggle.addEventListener('click', function(event) {
        // ตรวจสอบสถานะการแสดงผลเมนู
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none'; // ซ่อนเมนู
        } else {
            dropdownMenu.style.display = 'block'; // แสดงเมนู
        }

        // ป้องกันไม่ให้เกิดการรีเฟรชหรือลิงค์ทำงาน
        event.preventDefault();
    });

    // หากคลิกนอกเมนู dropdown จะทำการซ่อนเมนู
    document.addEventListener('click', function(event) {
        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none'; // ซ่อนเมนู
        }
    });
});
