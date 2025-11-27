jQuery(document).ready(function ($) {
  var $slider = $('.ls-sports-activities .ls-sports-slider');

  if (!$slider.length) return;

  var isRTL = $('html').attr('dir') === 'rtl';

  $slider.owlCarousel({
    items: 1,           // سلايد واحد فول ويدث
    loop: true,
    margin: 0,
    nav: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    smartSpeed: 800,
    rtl: isRTL,
    navText: [
      '<span>&lsaquo;</span>',
      '<span>&rsaquo;</span>'
    ]
  });
});