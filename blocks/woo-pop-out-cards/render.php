<?php
/**
 * Woo Pop-out Cards Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'woo-pop-out-cards-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'acfb-woo-pop-out-cards-container acfb-relative acfb-w-full';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Get fields
$selected_products = get_field( 'selected_products' );
$enable_schema     = get_field( 'enable_schema' );

/**
 * Render Schema if enabled
 * This is a helper function to output JSON-LD
 */
if ( $enable_schema && ! empty( $selected_products ) && ! $is_preview ) {
	$schema_data = [
		'@context' => 'https://schema.org',
		'@type'    => 'ItemList',
		'itemListElement' => [],
	];

	foreach ( $selected_products as $index => $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) continue;

		$schema_data['itemListElement'][] = [
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'item'     => [
				'@type'       => 'Product',
				'name'        => $product->get_name(),
				'description' => wp_strip_all_tags( $product->get_short_description() ),
				'image'       => wp_get_attachment_url( $product->get_image_id() ),
				'url'         => $product->get_permalink(),
				'offers'      => [
					'@type'         => 'Offer',
					'price'         => $product->get_price(),
					'priceCurrency' => get_woocommerce_currency(),
					'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
				],
			],
		];
	}
	echo '<script type="application/ld+json">' . json_encode( $schema_data ) . '</script>';
}
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( empty( $selected_products ) ) : ?>
		<div class="acfb-p-8 acfb-text-center acfb-border-2 acfb-border-dashed acfb-border-gray-300 acfb-rounded-lg">
			<p class="acfb-text-gray-500">Por favor, selecciona al menos 1 producto en el panel lateral.</p>
		</div>
	<?php else : ?>
		
		<!-- Container with padding -->
		<div class="acfb-container acfb-mx-auto acfb-py-12">
			
			<!-- List / Carousel wrapper -->
			<!-- Added px-6 and pb-12 to prevent clipping of shadows and pop-outs -->
			<ul class="acfb-list-none acfb-p-0 acfb-m-0 acfb-flex acfb-gap-8 acfb-overflow-x-auto acfb-snap-x acfb-snap-mandatory acfb-px-6 acfb-pb-10 acfb-pt-20 lg:acfb-grid lg:acfb-grid-cols-3 lg:acfb-overflow-visible lg:acfb-pb-0 lg:acfb-pt-24 acfb-scrollbar-hide acfb-cursor-grab active:acfb-cursor-grabbing">
				
				<?php foreach ( $selected_products as $product_id ) : 
					$product = wc_get_product( $product_id );
					if ( ! $product ) continue;

					$image_id  = $product->get_image_id();
					$image_url = wp_get_attachment_image_url( $image_id, 'large' );
					$title     = $product->get_name();
					$price     = $product->get_price_html();
					$link      = $product->get_permalink();
				?>
					<li class="acfb-slide-item acfb-snap-center acfb-shrink-0 acfb-w-[85vw] sm:acfb-w-[400px] lg:acfb-w-auto acfb-group acfb-list-none acfb-overflow-visible">
						<article class="acfb-relative acfb-bg-white acfb-border-2 acfb-border-black acfb-rounded-3xl acfb-p-6 acfb-h-full acfb-flex acfb-flex-col acfb-justify-between acfb-transition-colors acfb-duration-300 group-hover:acfb-bg-black group-hover:acfb-border-black acfb-overflow-visible">
							
							<!-- Image Wrapper with Pop-out Effect -->
							<div class="acfb-mb-6 acfb-relative acfb-z-10 -acfb-mt-24 acfb-transition-transform acfb-duration-300 group-hover:acfb-scale-110 group-hover:-acfb-translate-y-2 acfb-overflow-visible">
								<div class="acfb-aspect-square acfb-w-full acfb-relative acfb-rounded-2xl acfb-overflow-visible acfb-bg-transparent group-hover:acfb-shadow-xl acfb-transition-shadow acfb-duration-300 acfb-flex acfb-items-center acfb-justify-center">
									<?php if ( $image_url ) : ?>
										<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="acfb-w-full acfb-h-full acfb-object-contain acfb-p-4 acfb-overflow-visible" loading="lazy">
									<?php else : ?>
										<div class="acfb-w-full acfb-h-full acfb-flex acfb-items-center acfb-justify-center acfb-text-gray-300 acfb-bg-gray-50 acfb-rounded-2xl">
											<svg class="acfb-w-16 acfb-h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<!-- Content -->
							<div class="acfb-text-center acfb-flex-grow acfb-flex acfb-flex-col acfb-items-center">
								<h3 class="acfb-text-xl acfb-font-bold acfb-mb-2 acfb-text-black group-hover:acfb-text-white acfb-transition-colors acfb-duration-300">
									<a href="<?php echo esc_url( $link ); ?>" class="acfb-no-underline focus:acfb-outline-none">
										<?php echo esc_html( $title ); ?>
									</a>
								</h3>
								
								<div class="acfb-text-lg acfb-font-medium acfb-mb-6 acfb-text-gray-900 group-hover:acfb-text-gray-200 acfb-transition-colors acfb-duration-300 acfb-price-wrapper">
									<?php echo $price; // WPCS: XSS ok. ?>
								</div>
							</div>

							<!-- Action Footer -->
							<div class="acfb-mt-auto acfb-pt-4 acfb-flex acfb-justify-center">
								<a href="<?php echo esc_url( $link ); ?>" class="acfb-inline-block acfb-w-full acfb-py-3 acfb-px-6 acfb-border-2 acfb-border-black acfb-bg-black acfb-text-white acfb-font-bold acfb-uppercase acfb-tracking-wider acfb-text-sm acfb-rounded-full acfb-text-center acfb-no-underline acfb-transition-all acfb-duration-300 group-hover:acfb-bg-white group-hover:acfb-text-black group-hover:acfb-border-white hover:acfb-opacity-90">
									Ver Producto
								</a>
							</div>

						</article>
					</li>
				<?php endforeach; ?>
			</ul>

			<!-- Navigation Buttons -->
			<?php if ( count( $selected_products ) > 1 ) : ?>
				<div class="acfb-navigation-controls lg:acfb-hidden">
					<button class="acfb-nav-prev acfb-absolute acfb-left-2 acfb-top-1/2 -acfb-translate-y-1/2 acfb-z-20 acfb-p-2 acfb-bg-white/80 hover:acfb-bg-white acfb-rounded-full acfb-shadow-md acfb-text-gray-800 acfb-cursor-pointer acfb-border-none acfb-outline-none focus:acfb-ring-2 focus:acfb-ring-black acfb-transition-all" aria-label="Anterior">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
					</button>
					<button class="acfb-nav-next acfb-absolute acfb-right-2 acfb-top-1/2 -acfb-translate-y-1/2 acfb-z-20 acfb-p-2 acfb-bg-white/80 hover:acfb-bg-white acfb-rounded-full acfb-shadow-md acfb-text-gray-800 acfb-cursor-pointer acfb-border-none acfb-outline-none focus:acfb-ring-2 focus:acfb-ring-black acfb-transition-all" aria-label="Siguiente">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</button>
				</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>
</section>

<style>
	/* Custom styles to ensure price styling inside the black bg works well */
	.acfb-price-wrapper del {
		@apply acfb-text-gray-500 acfb-text-sm;
	}
	.group:hover .acfb-price-wrapper del {
		@apply acfb-text-gray-400;
	}
	.acfb-price-wrapper ins {
		@apply acfb-no-underline acfb-font-bold;
	}
</style>
