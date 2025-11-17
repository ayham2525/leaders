jQuery(document).ready(function($) {
  const modal = $('#videoModalHome');
  const iframe = $('#youtubePlayerHome');
  const close = $('.close-modal');

  $('.video-card').on('click', function() {
    const videoId = $(this).data('video-id');
    if (videoId) {
      iframe.attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1');
      modal.css('display', 'flex').hide().fadeIn(); // <-- Force flex then animate
    }
  });

  close.on('click', function() {
    iframe.attr('src', '');
    modal.fadeOut(function() {
      modal.css('display', 'none'); // cleanup
    });
  });

  $(window).on('click', function(e) {
    if ($(e.target).is('#videoModalHome')) {
      iframe.attr('src', '');
      modal.fadeOut(function() {
        modal.css('display', 'none');
      });
    }
  });
});
