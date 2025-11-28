document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.js-scroll-up');
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // If you want the animation only once, stop observing:
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15 // 15% of element visible triggers the animation
    });

    elements.forEach(el => observer.observe(el));
});