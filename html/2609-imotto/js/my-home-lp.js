(function () {
    'use strict';

    var page = document.querySelector('.mh-lp');
    if (!page) return;

    var revealItems = page.querySelectorAll('[data-mh-reveal]');
    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px'
        });

        revealItems.forEach(function (item) {
            revealObserver.observe(item);
        });
    } else {
        revealItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
    }

    page.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(function (link) {
        link.addEventListener('click', function (event) {
            var target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            event.preventDefault();
            if (target.tagName === 'DETAILS') target.open = true;
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    document.querySelectorAll('#my_home a[href="#"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
        });
    });

    if (window.location.hash) {
        var initialTarget = document.querySelector(window.location.hash);
        if (initialTarget && initialTarget.tagName === 'DETAILS') initialTarget.open = true;
    }

    var lightbox = page.querySelector('.mh-lightbox');
    if (!lightbox) return;

    var lightboxImage = lightbox.querySelector('figure img');
    var lightboxCaption = lightbox.querySelector('figcaption');
    var closeButton = lightbox.querySelector('.mh-lightbox__close');
    var lastTrigger = null;

    function openLightbox(trigger) {
        var source = trigger.getAttribute('data-mh-lightbox');
        var alt = trigger.getAttribute('data-mh-alt') || '';
        if (!source) return;

        lastTrigger = trigger;
        lightboxImage.src = source;
        lightboxImage.alt = alt;
        lightboxCaption.textContent = alt;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        closeButton.focus();
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.src = '';
        document.body.style.overflow = '';
        if (lastTrigger) lastTrigger.focus();
    }

    page.querySelectorAll('[data-mh-lightbox]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            openLightbox(trigger);
        });
    });

    closeButton.addEventListener('click', closeLightbox);
    lightbox.querySelector('[data-mh-lightbox-close]').addEventListener('click', closeLightbox);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
}());
