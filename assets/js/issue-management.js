document.getElementById('deleteBtn').addEventListener('click', function(event) {
    event.preventDefault();  // ป้องกันการส่งฟอร์มโดยทันที

    Swal.fire({
        icon: 'warning',
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
        showCancelButton: true,
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // ถ้าผู้ใช้คลิก "ลบ"
            event.target.closest('form').submit(); // ส่งฟอร์ม
        }
    });
});