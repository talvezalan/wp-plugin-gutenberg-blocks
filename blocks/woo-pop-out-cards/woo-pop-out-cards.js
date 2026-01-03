(function () {
    /**
     * Woo Pop-out Cards Block Initialization
     */
    const initWooPopOutCards = () => {
        const blocks = document.querySelectorAll('.acfb-woo-pop-out-cards-container');

        blocks.forEach(block => {
            const slider = block.querySelector('ul');
            if (!slider) return;

            // Optional: Drag to scroll implementation for better desktop UX if needed
            // Currently utilizing native CSS Scroll Snap as requested, which is performant and robust.

            // Enable drag scrolling
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('acfb-cursor-grabbing');
                slider.classList.remove('acfb-cursor-grab');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('acfb-cursor-grabbing');
                slider.classList.add('acfb-cursor-grab');
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.classList.remove('acfb-cursor-grabbing');
                slider.classList.add('acfb-cursor-grab');
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Scroll-fast
                slider.scrollLeft = scrollLeft - walk;
            });

            // Navigation Buttons Logic
            const prevBtn = block.querySelector('.acfb-nav-prev');
            const nextBtn = block.querySelector('.acfb-nav-next');

            if (prevBtn && nextBtn) {
                const scrollAmount = () => {
                    const firstItem = slider.querySelector('li');
                    return firstItem ? firstItem.offsetWidth + 32 : slider.offsetWidth; // width + gap
                };

                prevBtn.addEventListener('click', () => {
                    slider.scrollBy({
                        left: -scrollAmount(),
                        behavior: 'smooth'
                    });
                });

                nextBtn.addEventListener('click', () => {
                    slider.scrollBy({
                        left: scrollAmount(),
                        behavior: 'smooth'
                    });
                });
            }
        });
    };

    // Initialize on DOMContentLoaded and check for dynamic block loading (if any)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWooPopOutCards);
    } else {
        initWooPopOutCards();
    }
})();
