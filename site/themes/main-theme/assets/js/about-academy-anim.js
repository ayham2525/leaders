(function () {
  // Respect reduced-motion
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) return;

  function init() {
    if (!window.gsap || !window.ScrollTrigger) return;
    gsap.registerPlugin(ScrollTrigger);

    var sections = document.querySelectorAll('.about-academy');
    if (!sections.length) return;

    sections.forEach(function (section) {
      var media  = section.querySelector('.about-academy__media');
      var img    = section.querySelector('.about-academy__img');
      var swoosh = section.querySelector('.about-academy__red-swoosh');
      var card   = section.querySelector('.about-academy__content');

      // Reveal animation (plays on enter, reverses on leave-back)
      gsap.timeline({
        defaults: { ease: 'power3.out' },
        scrollTrigger: {
          trigger: section,
          start: 'top 80%',
          end: 'bottom 30%',
          toggleActions: 'play reverse play reverse'
        }
      })
      .from(card,   { y: 40, opacity: 0, duration: 0.8 })
      .from(media,  { opacity: 0, clipPath: 'inset(15% round 24px)', duration: 0.8 }, '-=0.4')
      .from(swoosh, { xPercent: -20, opacity: 0, duration: 0.6 }, '-=0.5');

      // Subtle parallax on image while scrolling
      if (img) {
        gsap.to(img, {
          yPercent: -10,
          ease: 'none',
          scrollTrigger: {
            trigger: section,
            start: 'top bottom',
            end: 'bottom top',
            scrub: true
          }
        });
      }
    });
  }

  // Run after DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
