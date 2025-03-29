// คำนวณเปอร์เซ็นต์ส่วนลด
function calculateDiscount(originalPrice, discountPrice) {
    return Math.round(((originalPrice - discountPrice) / originalPrice) * 100);
}

// แสดงเปอร์เซ็นต์ส่วนลด
document.querySelectorAll('.product-card').forEach((card) => {
    const originalPrice = parseFloat(card.querySelector('.original-price').textContent.replace('฿', ''));
    const discountPrice = parseFloat(card.querySelector('.discount-price').textContent.replace('฿', ''));
    const discountPercentage = calculateDiscount(originalPrice, discountPrice);
    card.querySelector('.discount-tag').textContent = `ลด ${discountPercentage}%`;
});

