(function ($) {
  $(document).ready(function () {
    const $slider = $(".ls-news__slider.owl-carousel");

    if ($slider.length && typeof $.fn.owlCarousel === "function") {
      const isRTL = $("html").attr("dir") === "rtl";

      $slider.owlCarousel({
        items: 1,              // سلايد واحد يحتوي (1 كبير + 4 صغار)
        loop: true,
        margin: 24,
        nav: false,            // نستخدم أزرارنا custom
        dots: false,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        smartSpeed: 800,
        rtl: isRTL,
      });

      // custom navigation
      $(".ls-news__next").on("click", function () {
        $slider.trigger("next.owl.carousel");
      });

      $(".ls-news__prev").on("click", function () {
        $slider.trigger("prev.owl.carousel");
      });

      console.log("✅ Leaders News 1-big + 4-small slider initialized");
    } else {
      console.warn("⚠️ OwlCarousel not found or .ls-news__slider missing");
    }
  });
})(jQuery);