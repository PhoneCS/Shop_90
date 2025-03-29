let currentIndex = 0; // ตัวแปรที่ใช้ติดตามตำแหน่งของภาพที่แสดงอยู่
const slides = document.querySelectorAll('.hero-banner-slide'); // เลือกทุกสไลด์ในคอนเทนเนอร์
const totalSlides = slides.length;

function changeSlide() {
    // ซ่อนทุกภาพ
    slides.forEach(slide => {
        slide.style.display = 'none';
    });

    // แสดงภาพปัจจุบัน
    slides[currentIndex].style.display = 'block';

    // เปลี่ยนไปยังภาพถัดไป
    currentIndex++;
    if (currentIndex >= totalSlides) {
        currentIndex = 0; // หากถึงภาพสุดท้ายแล้วให้กลับไปที่ภาพแรก
    }
}

// เริ่มเปลี่ยนภาพทุกๆ 3 วินาที
setInterval(changeSlide, 3000); // เปลี่ยนทุกๆ 3000ms (3 วินาที)
