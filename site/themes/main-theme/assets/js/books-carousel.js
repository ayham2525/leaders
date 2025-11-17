jQuery(document).ready(function ($) {
  // Owl Carousel initialization
  var owl = $("#books-carousel").owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    rtl: $("html").attr("dir") === "rtl",
    animateOut: 'slideOutLeft',
    margin: 20,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      1024: { items: 4 }
    }
  });

  // Navigation buttons
  $('#books-prev-btn').on('click', function () {
    owl.trigger('prev.owl.carousel');
  });

  $('#books-next-btn').on('click', function () {
    owl.trigger('next.owl.carousel');
  });
  const $popup = $('#book-popup');
  const $popupText = $('#popup-text');
  const $popupImage = $('#popup-image');
  const $popupClose = $('.close-popup');

  // Force hide popup on page load
  $popup.hide();

  // Open Popup on book click
  $('.book-card').on('click', function () {
    const text = $(this).data('text') || '';
    const image = $(this).data('image') || '';

    $popupText.html(text);
    $popupImage.attr('src', image);

    $popup.fadeIn(300);
    $('body').css('overflow', 'hidden'); // ⛔️ Disable scroll
  });

  // Close Popup on X button click
  $popupClose.on('click', function () {
    $popup.fadeOut(300);
    $('body').css('overflow', 'auto'); // ✅ Enable scroll
  });

  // Close Popup on outside click
  $(window).on('click', function (e) {
    if ($(e.target).is('#book-popup')) {
      $popup.fadeOut(300);
      $('body').css('overflow', 'auto'); // ✅ Enable scroll
    }
  });
});