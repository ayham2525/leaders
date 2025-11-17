jQuery(document).ready(function($) {
  const $owl = $("#owl-carousel-example");

  $owl.owlCarousel({
    items: 1,
    loop: true,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    rtl: $("html").attr("dir") === "rtl",
    animateOut: 'fadeOut',
    onInitialized: addAriaLabels,
    onChanged: addAriaLabels
  });

  function addAriaLabels(event) {
    $owl.find('.owl-dot').each(function(index) {
      $(this).attr('aria-label', 'Slide ' + (index + 1));
    });
  }
});
