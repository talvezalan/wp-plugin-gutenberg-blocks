<?php
/**
 * Flexible Link Carousel Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_id = 'flexible-link-carousel-' . $block['id'];
$items = get_field('carousel_items') ?: [];
$settings = get_field('carousel_settings') ?: [];

// Settings Defaults
$style_variant = $settings['style_variant'] ?? 'circle';
$show_title = $settings['show_title'] ?? false;
$autoplay = $settings['autoplay'] ?? true;
$autoplay_speed = $settings['autoplay_speed'] ?? 5;
$autoplay_ms = $autoplay_speed * 1000;

// Classes for alignment and layout
$align_class = !empty($block['align']) ? 'align' . $block['align'] : '';
$custom_class = !empty($block['className']) ? $block['className'] : '';
// Remove overflow-x-hidden from here to let arrows breathe
$classes = "acfb-flexible-carousel acfb-relative acfb-w-full acfb-group {$align_class} {$custom_class}";

// Preview/Empty state
if (empty($items)) {
    if ($is_preview) {
        echo '<div class="acfb-bg-gray-200 acfb-p-8 acfb-text-center acfb-font-bold">Agrega items al Flexible Link Carousel</div>';
    }
    return;
}

// Schema.org
$schema_items = [];
if (!empty($items)) {
    foreach ($items as $index => $item) {
        if (!empty($item['title'])) {
            $schema_items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'url' => $item['link']['url'] ?? '',
                'name' => $item['title']
            ];
        }
    }
}
?>

<section 
    id="<?php echo esc_attr($block_id); ?>" 
    class="<?php echo esc_attr($classes); ?> acfb-py-12" 
    aria-label="Carrusel de enlaces"
    data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
    data-speed="<?php echo $autoplay_ms; ?>"
>
    
    <?php if (!empty($schema_items)) : ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "itemListElement": <?php echo json_encode($schema_items); ?>
        }
        </script>
    <?php endif; ?>

    <!-- Carousel Container -->
    <div class="acfb-carousel-viewport acfb-overflow-hidden acfb-w-full">
        <ul class="acfb-carousel-track acfb-flex acfb-transition-transform acfb-duration-500 acfb-ease-in-out acfb-m-0 acfb-p-0 acfb-list-none">
                <?php foreach ($items as $item) : 
                    $image = $item['image'];
                    $title = $item['title'];
                    $link = $item['link'];
                    
                    // Item Styles
                    // flex-basis: 100% (mobile) / 33.333% (desktop) ensures exactly 1 or 3 per viewport
                    $item_classes = 'acfb-carousel-item acfb-flex-shrink-0 acfb-flex-[0_0_100%] lg:acfb-flex-[0_0_33.333333%] acfb-box-border acfb-px-4 md:acfb-px-6'; 
                ?>
                <li class="<?php echo esc_attr($item_classes); ?>">
                    <div class="acfb-slide-content acfb-group acfb-h-full acfb-flex acfb-flex-col acfb-items-center">
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link['url']); ?>" 
                               target="<?php echo esc_attr($link['target'] ?? '_self'); ?>"
                               class="acfb-block acfb-w-full acfb-no-underline hover:acfb-opacity-90 acfb-transition-opacity"
                               title="<?php echo esc_attr($link['title']); ?>">
                        <?php endif; ?>

                        <figure class="acfb-m-0 acfb-flex acfb-flex-col acfb-items-center acfb-justify-center acfb-w-full">
                            
                            <!-- Image Container -->
                            <div class="acfb-image-wrapper acfb-w-full acfb-flex acfb-justify-center <?php echo $style_variant === 'circle' ? 'acfb-aspect-square' : 'acfb-h-auto'; ?>">
                                <?php if ($image) : 
                                    $img_class = '';
                                    if ($style_variant === 'circle') {
                                        $img_class = 'acfb-rounded-full acfb-w-full acfb-h-full acfb-object-cover acfb-shadow-sm';
                                    } else {
                                        $img_class = 'acfb-object-contain acfb-h-24 acfb-w-auto'; 
                                    }
                                    echo wp_get_attachment_image($image['ID'], 'large', false, ['class' => $img_class]);
                                endif; ?>
                            </div>

                            <?php if ($show_title && !empty($title)) : ?>
                                <figcaption class="acfb-mt-4">
                                    <h3 class="acfb-text-lg acfb-font-medium acfb-text-center acfb-text-gray-900 acfb-m-0">
                                        <?php echo esc_html($title); ?>
                                    </h3>
                                </figcaption>
                            <?php endif; ?>
                            
                        </figure>

                        <?php if ($link) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Arrows -->
    <?php if (is_array($items) && count($items) > 1) : ?>
        <button class="acfb-carousel-arrow-prev acfb-absolute acfb-left-4 acfb-top-1/2 -acfb-translate-y-1/2 acfb-z-10 acfb-p-2 acfb-bg-white/80 hover:acfb-bg-white acfb-rounded-full acfb-shadow-md acfb-text-gray-800 acfb-cursor-pointer acfb-border-none acfb-outline-none focus:acfb-ring-2 focus:acfb-ring-primary-500 lg:acfb-left-2" aria-label="Previous Slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
        <button class="acfb-carousel-arrow-next acfb-absolute acfb-right-4 acfb-top-1/2 -acfb-translate-y-1/2 acfb-z-10 acfb-p-2 acfb-bg-white/80 hover:acfb-bg-white acfb-rounded-full acfb-shadow-md acfb-text-gray-800 acfb-cursor-pointer acfb-border-none acfb-outline-none focus:acfb-ring-2 focus:acfb-ring-primary-500 lg:acfb-right-2" aria-label="Next Slide">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>

        <!-- Dots -->
        <div class="acfb-carousel-dots acfb-flex acfb-justify-center acfb-gap-2 acfb-mt-6 <?php echo $style_variant === 'logo' ? 'acfb-hidden' : ''; ?>">
        </div>
    <?php endif; ?>

</section>
