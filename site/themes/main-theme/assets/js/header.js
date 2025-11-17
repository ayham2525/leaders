(function(){
  const menu   = document.getElementById('offcanvasMenu');
  const openBtn= document.getElementById('openMenuBtn');
  const closeBtn=document.getElementById('closeMenuBtn');
  const overlay= document.getElementById('menuOverlay');

  function openMenu(){
    menu.classList.add('is-open');
    overlay.hidden = false;
    requestAnimationFrame(()=>overlay.classList.add('show'));
    document.body.classList.add('menu-open');
    openBtn.setAttribute('aria-expanded','true');
    menu.setAttribute('aria-hidden','false');
    // move focus for accessibility
    closeBtn.focus();
  }
  function closeMenu(){
    menu.classList.remove('is-open');
    overlay.classList.remove('show');
    overlay.addEventListener('transitionend', ()=>{ overlay.hidden = true; }, {once:true});
    document.body.classList.remove('menu-open');
    openBtn.setAttribute('aria-expanded','false');
    menu.setAttribute('aria-hidden','true');
    openBtn.focus();
  }

  openBtn.addEventListener('click', openMenu);
  closeBtn.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);
  window.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeMenu(); });
})();