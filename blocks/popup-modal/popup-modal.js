document.addEventListener('DOMContentLoaded', () => {
    const popups = document.querySelectorAll('.popup-modal-container');

    popups.forEach(popup => {
        // Ignorar en el editor de bloques si es necesario, pero ACF suele manejar esto.
        // Verificamos si ya se cerró anteriormente usando localStorage
        const blockId = popup.dataset.blockId;
        const storageKey = `popup_modal_closed_${blockId}`;
        const expiryHours = parseFloat(popup.dataset.expiry) || 1;

        const closedTime = localStorage.getItem(storageKey);

        if (closedTime) {
            const now = new Date().getTime();
            const hoursPassed = (now - parseInt(closedTime)) / (1000 * 60 * 60);

            if (hoursPassed < expiryHours) {
                return; // No mostrar si no ha pasado el tiempo de expiración
            }
        }

        const delay = (parseFloat(popup.dataset.delay) || 6) * 1000;
        const content = popup.querySelector('.popup-modal-content');
        const closeBtn = popup.querySelector('.popup-modal-close');
        const overlay = popup.querySelector('.popup-modal-overlay');

        const showPopup = () => {
            // Mover al body para evitar restricciones de contenedores padres
            if (popup.parentElement !== document.body) {
                document.body.appendChild(popup);
            }

            popup.classList.remove('acfb-invisible', 'acfb-opacity-0');
            popup.classList.add('acfb-visible', 'acfb-opacity-100');
            content.classList.remove('acfb-scale-95');
            content.classList.add('acfb-scale-100');
            document.body.classList.add('acfb-overflow-hidden');
        };

        const hidePopup = () => {
            popup.classList.add('acfb-opacity-0');
            content.classList.add('acfb-scale-95');

            setTimeout(() => {
                popup.classList.add('acfb-invisible');
                popup.classList.remove('acfb-visible', 'acfb-opacity-100');
                document.body.classList.remove('acfb-overflow-hidden');
            }, 500);

            // Guardar en localStorage
            localStorage.setItem(storageKey, new Date().getTime().toString());
        };

        // Timer
        setTimeout(showPopup, delay);

        // Close events
        closeBtn.addEventListener('click', hidePopup);
        overlay.addEventListener('click', hidePopup);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && popup.classList.contains('acfb-visible')) {
                hidePopup();
            }
        });
    });
});
