(function () {
  const initCarousel = () => {
    const carousels = document.querySelectorAll('.acfb-flexible-carousel');

    carousels.forEach(carousel => {
      // Prevent double init
      if (carousel.dataset.initialized === 'true') return;
      carousel.dataset.initialized = 'true';

      const track = carousel.querySelector('.acfb-carousel-track');
      const slides = Array.from(track.children);
      const prevBtn = carousel.querySelector('.acfb-carousel-arrow-prev');
      const nextBtn = carousel.querySelector('.acfb-carousel-arrow-next');
      const dotsContainer = carousel.querySelector('.acfb-carousel-dots');

      if (!slides.length) return;

      const settings = {
        autoplay: carousel.dataset.autoplay === 'true',
        speed: parseInt(carousel.dataset.speed) || 5000,
        infinite: true // Logic implementation choice (handled by goToSlide maxIndex wrapping)
      };

      let currentIndex = 0;
      let intervalId;
      let isDragging = false;
      let startPos = 0;

      const getSlidesPerView = () => window.innerWidth >= 1024 ? 3 : 1;

      const createDots = () => {
        dotsContainer.innerHTML = '';
        const slidesPerView = getSlidesPerView();
        const numDots = Math.max(1, slides.length - slidesPerView + 1);

        for (let i = 0; i < numDots; i++) {
          const dot = document.createElement('button');
          dot.classList.add('acfb-carousel-dot', 'acfb-h-2', 'acfb-rounded-full', 'acfb-transition-all', 'acfb-duration-300', 'acfb-border-none', 'acfb-outline-none', 'acfb-cursor-pointer');
          // Initial styling will be handled by updatePosition
          dot.classList.add('acfb-w-2', 'acfb-bg-secondary-400'); // Default inactive state
          dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
          dot.addEventListener('click', () => goToSlide(i));
          dotsContainer.appendChild(dot);
        }
      };

      createDots();

      // Slide Movement Logic
      // We use percentages. 
      // Mobile: 1 item visible => 100% width per slide.
      // Desktop: 3 items visible => 33.333% width per slide.
      // We need to know the effective width. CSS grids handle layout, but for sliding track, we normally translate.
      // Given requirements "1 columna mobile, 3 columnas desktop", and "step: 1",
      // The track should probably use flexbox.


      const updateDots = (index) => {
        const dots = Array.from(dotsContainer.children);
        dots.forEach((dot, i) => {
          if (i === index) {
            dot.classList.remove('acfb-w-2', 'acfb-bg-secondary-400');
            dot.classList.add('acfb-w-6', 'acfb-bg-main-black');
          } else {
            dot.classList.add('acfb-w-2', 'acfb-bg-secondary-400');
            dot.classList.remove('acfb-w-6', 'acfb-bg-main-black');
          }
        });
      };

      const updatePosition = () => {
        if (!slides[currentIndex]) return;
        const offset = slides[currentIndex].offsetLeft;
        track.style.transform = `translateX(-${offset}px)`;
        updateDots(currentIndex);
      };

      const goToSlide = (index) => {
        const slidesPerView = getSlidesPerView();
        // Calculate the maximum valid starting index
        // Example: 5 items, 3 visible. maxIndex = 2. (Indices: 0, 1, 2)
        // If we go to 2, we show 3,4,5. Perfect.
        const maxIndex = Math.max(0, slides.length - slidesPerView);

        if (index < 0) {
          currentIndex = maxIndex;
        } else if (index > maxIndex) {
          currentIndex = 0;
        } else {
          currentIndex = index;
        }

        updatePosition();
      };

      const nextSlide = () => {
        goToSlide(currentIndex + 1);
      };

      const prevSlide = () => {
        goToSlide(currentIndex - 1);
      };

      // Events
      if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        resetAutoplay();
      });

      if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        resetAutoplay();
      });

      // Swipe
      carousel.addEventListener('touchstart', (e) => {
        startPos = e.touches[0].clientX;
        isDragging = true;
        resetAutoplay();
      });

      carousel.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        // Optional: dynamic drag visual feedback
      });

      carousel.addEventListener('touchend', (e) => {
        isDragging = false;
        const endPos = e.changedTouches[0].clientX;
        const diff = startPos - endPos;

        if (Math.abs(diff) > 50) { // Threshold
          if (diff > 0) nextSlide();
          else prevSlide();
        }
      });

      // Autoplay
      const startAutoplay = () => {
        if (!settings.autoplay) return;
        intervalId = setInterval(nextSlide, settings.speed);
      };

      const stopAutoplay = () => {
        clearInterval(intervalId);
      };

      const resetAutoplay = () => {
        stopAutoplay();
        startAutoplay();
      };

      // Resize observer to handle breakpoint changes
      window.addEventListener('resize', () => {
        createDots();
        updatePosition();
      });

      // Init
      updatePosition();
      startAutoplay();

      // Accessibility
      carousel.addEventListener('mouseenter', stopAutoplay);
      carousel.addEventListener('mouseleave', startAutoplay);
      carousel.addEventListener('focusin', stopAutoplay);
      carousel.addEventListener('focusout', startAutoplay);
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCarousel);
  } else {
    initCarousel();
  }
})();
