<?php
/**
 * Popup Modal Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$popup_image = get_field('popup_image');
$popup_link = get_field('popup_link');
$show_overlay = get_field('overlay');
$delay_seconds = get_field('delay_seconds') !== null ? get_field('delay_seconds') : 6;
$cookie_expiry = get_field('cookie_expiry') !== null ? get_field('cookie_expiry') : 1;

if (!$popup_image && !$is_preview) {
    return;
}

$block_id = 'popup-modal-' . $block['id'];
$custom_class = !empty($block['className']) ? $block['className'] : '';

// En el editor siempre mostramos algo para poder editarlo
if ($is_preview && !$popup_image) {
    echo '<div class="acfb-bg-gray-200 acfb-p-8 acfb-text-center acfb-font-bold">Selecciona una imagen para el Popup Modal</div>';
    return;
}
?>

<section 
    id="<?php echo esc_attr($block_id); ?>" 
    class="popup-modal-container acfb-fixed acfb-inset-0 acfb-w-screen acfb-h-screen acfb-z-[9999] acfb-flex acfb-items-center acfb-justify-center acfb-invisible acfb-opacity-0 acfb-transition-all acfb-duration-500 <?php echo esc_attr($custom_class); ?>"
    role="dialog" 
    aria-modal="true"
    data-delay="<?php echo esc_attr($delay_seconds); ?>"
    data-expiry="<?php echo esc_attr($cookie_expiry); ?>"
    data-block-id="<?php echo esc_attr($block['id']); ?>"
>
    <!-- Overlay -->
    <?php if ($show_overlay): ?>
        <div class="popup-modal-overlay acfb-absolute acfb-inset-0 acfb-bg-main-black/60 acfb-backdrop-blur-sm"></div>
    <?php else: ?>
        <div class="popup-modal-overlay acfb-absolute acfb-inset-0 acfb-bg-transparent"></div>
    <?php endif; ?>

    <!-- Modal Content -->
    <div class="popup-modal-content acfb-relative acfb-z-10 acfb-max-w-[90vw] md:acfb-max-w-[70vw] acfb-bg-white acfb-rounded-2xl acfb-shadow-2xl acfb-overflow-hidden acfb-transform acfb-scale-95 acfb-transition-all acfb-duration-500">
        
        <!-- Close Button -->
        <button 
            type="button"
            class="popup-modal-close acfb-absolute acfb-top-4 acfb-right-4 acfb-z-20 acfb-text-main-white acfb-bg-main-black/40 hover:acfb-bg-main-black/60 acfb-rounded-full acfb-p-2 acfb-transition-colors acfb-border-none acfb-outline-none"
            aria-label="Cerrar modal"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="acfb-h-6 acfb-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Image / Link -->
        <div class="popup-modal-body">
            <?php if ($popup_link): ?>
                <a href="<?php echo esc_url($popup_link['url']); ?>" target="<?php echo esc_attr($popup_link['target'] ?: '_self'); ?>" class="acfb-block">
            <?php endif; ?>

            <img 
                src="<?php echo esc_url($popup_image['url']); ?>" 
                alt="<?php echo esc_attr($popup_image['alt'] ?: 'Popup Image'); ?>" 
                class="acfb-w-full acfb-h-auto acfb-max-h-[80vh] acfb-object-contain acfb-block"
            />

            <?php if ($popup_link): ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
