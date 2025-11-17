jQuery(document).ready(function($) {
  var owl = $("#posts-carousel").owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    rtl: $("html").attr("dir") === "rtl",
    animateOut: 'fadeOut',
    margin: 20,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      1024: {
        items: 4
      }
    }
  });

  $('.our_partners-prev-btn').on('click', function() {
    owl.trigger('prev.owl.carousel');
});


$('.our_partners-next-btn').on('click', function() {
    owl.trigger('next.owl.carousel');
});
});
