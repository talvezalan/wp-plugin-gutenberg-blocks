(function () {
    'use strict';

    /**
     * Initialize Hero Carousel
     * @param {HTMLElement} carousel 
     */
    function initCarousel(carousel) {
        const track = carousel.querySelector('.hero-carousel-track');
        const slides = Array.from(track.children);
        const prevButton = carousel.querySelector('.hero-carousel-prev');
        const nextButton = carousel.querySelector('.hero-carousel-next');
        const dots = carousel.querySelectorAll('.hero-carousel-dot');
        let currentIndex = 0;
        let autoplayInterval;

        // Configuration
        const autoplayEnabled = carousel.dataset.autoplay === 'true';
        const autoplaySpeed = parseInt(carousel.dataset.speed) || 5000;

        // --- Functions ---

        const updateDots = (activeIndex) => {
            dots.forEach((dot, index) => {
                if (index === activeIndex) {
                    dot.classList.remove('acfb-bg-secondary-400', 'acfb-w-2');
                    dot.classList.add('acfb-bg-main-black', 'acfb-w-6');
                    dot.setAttribute('aria-current', 'true');
                } else {
                    dot.classList.add('acfb-bg-secondary-400', 'acfb-w-2');
                    dot.classList.remove('acfb-bg-main-black', 'acfb-w-6');
                    dot.setAttribute('aria-current', 'false');
                }
            });
        };

        const scrollToSlide = (index) => {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;

            const slideWidth = track.offsetWidth;
            track.scrollTo({
                left: index * slideWidth,
                behavior: 'smooth'
            });
        };

        // --- Adjustment for true Full Width ---
        const adjustFullWidth = () => {
            const viewportWidth = document.documentElement.clientWidth;
            carousel.style.width = `${viewportWidth}px`;
            carousel.style.marginLeft = '0px';
            const rect = carousel.getBoundingClientRect();
            carousel.style.marginLeft = `${-rect.left}px`;
        };

        // --- Scroll Listener ---
        const handleScroll = () => {
            const scrollLeft = track.scrollLeft;
            const slideWidth = track.offsetWidth;
            const activeIndex = Math.round(scrollLeft / slideWidth);

            if (activeIndex !== currentIndex) {
                currentIndex = activeIndex;
                updateDots(currentIndex);
            }
        };

        // --- Autoplay ---
        const startAutoplay = () => {
            if (!autoplayEnabled || slides.length <= 1) return;
            stopAutoplay();
            autoplayInterval = setInterval(() => {
                scrollToSlide(currentIndex + 1);
            }, autoplaySpeed);
        };

        const stopAutoplay = () => {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
        };

        // --- Event Listeners ---

        if (prevButton) prevButton.addEventListener('click', () => {
            scrollToSlide(currentIndex - 1);
            if (autoplayEnabled) { stopAutoplay(); startAutoplay(); }
        });

        if (nextButton) nextButton.addEventListener('click', () => {
            scrollToSlide(currentIndex + 1);
            if (autoplayEnabled) { stopAutoplay(); startAutoplay(); }
        });

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.index);
                scrollToSlide(index);
                if (autoplayEnabled) { stopAutoplay(); startAutoplay(); }
            });
        });

        track.addEventListener('scroll', handleScroll);

        if (autoplayEnabled) {
            carousel.addEventListener('mouseenter', stopAutoplay);
            carousel.addEventListener('mouseleave', startAutoplay);
            carousel.addEventListener('focusin', stopAutoplay);
            carousel.addEventListener('focusout', startAutoplay);
        }

        carousel.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                scrollToSlide(currentIndex - 1);
                if (autoplayEnabled) { stopAutoplay(); startAutoplay(); }
            } else if (e.key === 'ArrowRight') {
                scrollToSlide(currentIndex + 1);
                if (autoplayEnabled) { stopAutoplay(); startAutoplay(); }
            }
        });

        // Init
        adjustFullWidth();
        startAutoplay();

        window.addEventListener('resize', () => {
            adjustFullWidth();
            scrollToSlide(currentIndex);
        });
    }

    /**
     * Initialize all carousels
     */
    function initAllCarousels() {
        const carousels = document.querySelectorAll('.hero-carousel');
        carousels.forEach(initCarousel);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllCarousels);
    } else {
        initAllCarousels();
    }

    if (window.acf) {
        window.acf.addAction('render_block_preview/type=acf/hero-carousel-fullwidth', function (element) {
            const carousel = element[0].querySelector('.hero-carousel');
            if (carousel) initCarousel(carousel);
        });
    }

})();
