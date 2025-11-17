(function ($) {
  $(document).ready(function () {
    const $slider = $(".ls-news__slider.owl-carousel");

    if ($slider.length && typeof $.fn.owlCarousel === "function") {
      $slider.owlCarousel({
        items: 4,
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        smartSpeed: 700,
        rtl: $("html").attr("dir") === "rtl",
        responsive: {
          0: {
            items: 1,
            margin: 10,
          },
          576: {
            items: 2,
          },
          992: {
            items: 3,
          },
          1200: {
            items: 4,
          },
        },
      });

      // custom navigation
      $(".ls-news__next").on("click", function () {
        $slider.trigger("next.owl.carousel");
      });
      $(".ls-news__prev").on("click", function () {
        $slider.trigger("prev.owl.carousel");
      });

      console.log("✅ Leaders News Slider initialized successfully");
    } else {
      console.warn("⚠️ OwlCarousel not found or .ls-news__slider missing");
    }
  });
})(jQuery);
