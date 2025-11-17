// assets/js/home-banner.js
jQuery(function ($) {
  if ($('[data-fancybox="home-banner"]').length) {
    // Fancybox v3 options (already enqueued in your functions.php)
    $('[data-fancybox="home-banner"]').fancybox({
      buttons: ['close'],
      smallBtn: true,
      animationEffect: 'zoom-in-out',
      transitionEffect: 'fade',
      youtube: { controls: 1, modestbranding: 1, rel: 0 },
      vimeo:   { byline: 0, portrait: 0, title: 0 }
    });
  }
});
