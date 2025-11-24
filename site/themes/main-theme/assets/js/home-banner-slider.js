document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".homeBannerSlider", {
        effect: "fade",
        fadeEffect: { crossFade: true },
        speed: 1000,
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function (index, className) {
                return `<span class="${className}">0${index + 1}</span>`;
            }
        },

        direction: document.body.classList.contains("rtl") ? "rtl" : "ltr",
    });
});
