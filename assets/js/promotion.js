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