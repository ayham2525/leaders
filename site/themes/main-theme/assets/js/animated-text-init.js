(function () {
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.gsap) return;

  var ST = window.ScrollTrigger;
  if (ST) gsap.registerPlugin(ST);

  var sections = document.querySelectorAll('.animated-text [data-anim="section"]');
  if (!sections.length) return;

  sections.forEach(function (wrap) {
    var host   = wrap.closest('.animated-text');
    var isRTL  = host && host.getAttribute('dir') === 'rtl';

    var title   = wrap.querySelector('[data-anim="title"]');
    var body    = wrap.querySelector('[data-anim="body"]');
    var values  = wrap.querySelector('.animated-text__values');
    var labelEl = values ? values.querySelector('.animated-text__label') : null;
    var stage   = values ? values.querySelector('.animated-text__chipstage') : null;
    var chips   = stage  ? Array.from(stage.querySelectorAll('.animated-text__chip')) : [];

    /* --- 1) Reveal once (no reverse) --- */
    var tl = gsap.timeline({
      defaults: { ease: 'power3.out' },
      scrollTrigger: ST ? { trigger: wrap, start: 'top 80%', once: true } : undefined
    });
    if (title) tl.from(title, { y:30, opacity:0, duration:.6, immediateRender:false });
    if (body)  tl.from(body,  { x:isRTL?24:-24, opacity:0, duration:.6, immediateRender:false }, '-=0.25');
    if (values) tl.from(values,{ y:12, opacity:0, duration:.4, immediateRender:false }, '-=0.2');

    if (!stage || !chips.length) return;

    /* --- 2) Measure widest/tallest chip to lock stage size (no layout shift) --- */
    (function setStageSize(){
      var w = 0, h = 0;
      chips.forEach(function(c){
        var prev = c.style.cssText;
        c.style.opacity = '0'; c.style.transform = 'none'; c.style.position = 'static'; c.style.visibility='hidden';
        w = Math.max(w, c.offsetWidth);
        h = Math.max(h, c.offsetHeight);
        c.style.cssText = prev;
      });
      stage.style.width  = (w || 120) + 'px';
      stage.style.height = (h || 40)  + 'px';
    })();
    window.addEventListener('resize', function(){ /* re-measure on resize */
      stage.style.width = stage.style.height = ''; // reset then recalc
      var ev = new Event('recalc'); stage.dispatchEvent(ev);
    });
    stage.addEventListener('recalc', function(){
      var w = 0, h = 0;
      chips.forEach(function(c){
        var prev = c.style.cssText;
        c.style.opacity = '0'; c.style.transform = 'none'; c.style.position = 'static'; c.style.visibility='hidden';
        w = Math.max(w, c.offsetWidth);
        h = Math.max(h, c.offsetHeight);
        c.style.cssText = prev;
      });
      stage.style.width  = (w || 120) + 'px';
      stage.style.height = (h || 40)  + 'px';
    });

    /* --- 3) Cycle: show one chip at a time in the same spot --- */
    gsap.set(chips, { autoAlpha: 0, scale: .95 });

    var cycle = gsap.timeline({ paused: true, repeat: -1, defaults: { ease: 'power2.out' } });
    var fade = .25, grow = .28, hold = 1.4;

    chips.forEach(function(chip, i){
      var step = 's'+i;
      cycle
        .add(step)
        .to(chips, { autoAlpha: 0, duration: fade }, step)            // hide all
        .to(chip,  { autoAlpha: 1, scale: 1, duration: grow }, step)  // show current
        .to(chip,  { duration: hold }, '>')
        .to(chip,  { scale: .98, duration: .16 }, '>');
    });

    // Play/pause cycle only while in view
    if (ST) {
      ScrollTrigger.create({
        trigger: wrap,
        start: 'top 80%',
        end: 'bottom top',
        onEnter: function(){ cycle.play(); },
        onEnterBack: function(){ cycle.play(); },
        onLeave: function(){ cycle.pause(); },
        onLeaveBack: function(){ cycle.pause(); }
      });
    } else {
      cycle.play();
    }
  });
})();
