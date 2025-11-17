document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".tryouts-swiper", {
        loop: true,
        autoplay: {
            delay: 2800,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 20,

        /* ENABLE ARROWS */
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        /* REMOVE BULLETS */
        pagination: {
            el: ".swiper-pagination",
            clickable: false,
            enabled: false
        },

        breakpoints: {
            576: { slidesPerView: 1 },
            768: { slidesPerView: 1 },
            992: { slidesPerView: 1 }
        }
    });
});
