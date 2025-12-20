<?php
/**
 * Hero Carousel Fullwidth Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_id = 'hero-carousel-' . $block['id'];
$slides = get_field('slides') ?: [];
$autoplay = get_field('autoplay');
$autoplay_speed = get_field('autoplay_speed') ?: 5;
$autoplay_ms = $autoplay_speed * 1000;

// Classes
$align_class = !empty($block['align']) ? 'align' . $block['align'] : 'alignfull';
$custom_class = !empty($block['className']) ? $block['className'] : '';
$classes = "hero-carousel acfb-relative acfb-w-full acfb-h-[70vh] md:acfb-h-[80vh] acfb-overflow-x-hidden acfb-group {$align_class} {$custom_class}";

if (empty($slides)) {
    if ($is_preview) {
        echo '<div class="acfb-bg-gray-200 acfb-p-8 acfb-text-center acfb-font-bold">Agrega slides al Hero Carousel</div>';
    }
    return;
}
?>

<section 
    id="<?php echo esc_attr($block_id); ?>" 
    class="<?php echo esc_attr($classes); ?>" 
    role="region" 
    aria-label="Hero Carousel"
    data-autoplay="<?php echo esc_attr($autoplay ? 'true' : 'false'); ?>"
    data-speed="<?php echo esc_attr($autoplay_ms); ?>"
>
    <!-- Slides Container -->
    <div class="acfb-flex acfb-h-full acfb-w-full acfb-overflow-x-auto acfb-snap-x acfb-snap-mandatory acfb-scroll-smooth acfb-scrollbar-hide hero-carousel-track">
        <?php foreach ($slides as $index => $slide): 
            $img_desktop = $slide['image_desktop'];
            $img_mobile = $slide['image_mobile'] ?: $img_desktop;
            $has_overlay = $slide['enable_overlay'];
            $heading = $slide['heading'];
            $text = $slide['text'];
            $button = $slide['button'];
            $slide_link = $slide['slide_link'];
        ?>
            <article 
                class="acfb-w-full acfb-min-w-full acfb-h-full acfb-flex-shrink-0 acfb-relative acfb-flex acfb-items-center acfb-justify-center acfb-overflow-hidden acfb-snap-center"
                aria-roledescription="slide"
                aria-label="<?php echo esc_attr("Slide " . ($index + 1) . " de " . count($slides)); ?>"
            >
                <!-- Background & Link Wrapper -->
                <?php if ($slide_link): 
                    $s_url = $slide_link['url'];
                    $s_target = $slide_link['target'] ?: '_self';
                    $s_rel = $s_target === '_blank' ? ' rel="nofollow"' : '';
                    $s_title = $slide_link['title'] ?: ($heading ?: 'Slide ' . ($index + 1));
                ?>
                    <a href="<?php echo esc_url($s_url); ?>" 
                       target="<?php echo esc_attr($s_target); ?>" 
                       <?php echo $s_rel; ?>
                       class="acfb-absolute acfb-inset-0 acfb-z-10 acfb-block acfb-border-none acfb-outline-none"
                       aria-label="<?php echo esc_attr($s_title); ?>"
                    >
                <?php endif; ?>

                <div class="acfb-absolute acfb-inset-0 acfb-bg-cover acfb-bg-center acfb-bg-no-repeat acfb-hidden md:acfb-block" 
                     style="background-image: url('<?php echo esc_url($img_desktop); ?>'); background-position: center center;">
                </div>
                <div class="acfb-absolute acfb-inset-0 acfb-bg-cover acfb-bg-center acfb-bg-no-repeat md:acfb-hidden" 
                     style="background-image: url('<?php echo esc_url($img_mobile); ?>'); background-position: center center;">
                </div>

                <!-- Overlay -->
                <?php if ($has_overlay): ?>
                    <div class="acfb-absolute acfb-inset-0 acfb-bg-main-black/60"></div>
                <?php endif; ?>

                <?php if ($slide_link): ?>
                    </a>
                <?php endif; ?>

                <!-- Content -->
                <?php if ($heading || $text || $button): ?>
                    <header class="acfb-relative acfb-z-20 acfb-text-left acfb-max-w-4xl acfb-px-8 md:acfb-px-16 acfb-mr-auto acfb-w-full">
                        <?php if ($heading): ?>
                            <h2 class="acfb-text-4xl md:acfb-text-6xl acfb-font-bold acfb-text-main-white acfb-mb-4 acfb-leading-tight">
                                <?php echo esc_html($heading); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ($text): ?>
                            <p class="acfb-text-lg md:acfb-text-xl acfb-text-main-white acfb-mb-8 acfb-max-w-2xl">
                                <?php echo nl2br(esc_html($text)); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($button): 
                            $btn_url = $button['url'];
                            $btn_title = $button['title'];
                            $btn_target = $button['target'] ? $button['target'] : '_self';
                        ?>
                            <a href="<?php echo esc_url($btn_url); ?>" 
                               target="<?php echo esc_attr($btn_target); ?>"
                               class="acfb-relative acfb-z-30 acfb-inline-block acfb-bg-main-black acfb-text-main-white acfb-font-medium acfb-py-3 acfb-px-8 acfb-rounded-full acfb-shadow-md acfb-transition-all acfb-duration-300 hover:acfb-scale-105 hover:acfb-shadow-lg acfb-no-underline acfb-transform"
                               style="text-decoration: none;"
                            >
                                <?php echo esc_html($btn_title); ?>
                            </a>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Navigation Arrows -->
    <?php if (count($slides) > 1): ?>
        <button style="border: none;" class="hero-carousel-prev acfb-absolute acfb-left-4 acfb-top-1/2 acfb-transform acfb--translate-y-1/2 acfb-z-20 acfb-bg-white/70 acfb-text-main-black acfb-p-3 acfb-rounded-full acfb-transition-all hover:acfb-bg-white acfb-border-none acfb-outline-none focus:acfb-ring-0 acfb-hidden md:acfb-flex" aria-label="Anterior">
            <svg xmlns="http://www.w3.org/2000/svg" class="acfb-h-6 acfb-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button style="border: none;" class="hero-carousel-next acfb-absolute acfb-right-4 acfb-top-1/2 acfb-transform acfb--translate-y-1/2 acfb-z-20 acfb-bg-white/70 acfb-text-main-black acfb-p-3 acfb-rounded-full acfb-transition-all hover:acfb-bg-white acfb-border-none acfb-outline-none focus:acfb-ring-0 acfb-hidden md:acfb-flex" aria-label="Siguiente">
            <svg xmlns="http://www.w3.org/2000/svg" class="acfb-h-6 acfb-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Dots Navigation -->
        <div class="acfb-absolute acfb-bottom-6 acfb-left-1/2 acfb-transform acfb--translate-x-1/2 acfb-flex acfb-items-center acfb-space-x-2 acfb-z-20">
            <?php foreach ($slides as $index => $slide): ?>
                <button 
                    class="hero-carousel-dot acfb-h-2 acfb-rounded-full acfb-transition-all acfb-duration-300 acfb-border-none acfb-outline-none focus:acfb-ring-0 <?php echo $index === 0 ? 'acfb-w-6 acfb-bg-main-black' : 'acfb-w-2 acfb-bg-secondary-400'; ?>"
                    aria-label="<?php echo esc_attr("Ir a slide " . ($index + 1)); ?>"
                    aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    data-index="<?php echo esc_attr($index); ?>"
                    style="border: none;"
                ></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
