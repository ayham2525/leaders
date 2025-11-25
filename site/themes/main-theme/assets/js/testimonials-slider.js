document.addEventListener("DOMContentLoaded", function () {
    new Swiper('.testimonials-slider', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,       
            disableOnInteraction: false,  
        },
        speed: 900,  
        pagination: {
            el: '.testimonials-pagination',
            clickable: true,
        },
    });
});
