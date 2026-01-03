<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_flexible_link_carousel',
	'title' => 'Flexible Link Carousel Settings',
	'fields' => array(
		array(
			'key' => 'field_flc_items',
			'label' => 'Carousel Items',
			'name' => 'carousel_items',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Add Item',
			'sub_fields' => array(
				array(
					'key' => 'field_flc_image',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
                    'required' => 1,
				),
				array(
					'key' => 'field_flc_title',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
                    'description' => 'Optional text displayed below the image.',
				),
				array(
					'key' => 'field_flc_link',
					'label' => 'Link',
					'name' => 'link',
					'type' => 'link',
                    'return_format' => 'array',
				),
			),
		),
		array(
			'key' => 'field_flc_settings',
			'label' => 'Settings',
			'name' => 'carousel_settings',
			'type' => 'group',
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_flc_style_variant',
					'label' => 'Style Variant',
					'name' => 'style_variant',
					'type' => 'select',
					'choices' => array(
						'circle' => 'Circles (Categories)',
						'logo' => 'Logos (Partners)',
					),
					'default_value' => 'circle',
					'return_format' => 'value',
				),
				array(
					'key' => 'field_flc_show_title',
					'label' => 'Show Title',
					'name' => 'show_title',
					'type' => 'true_false',
					'ui' => 1,
                    'default_value' => 1,
				),
				array(
					'key' => 'field_flc_autoplay',
					'label' => 'Autoplay',
					'name' => 'autoplay',
					'type' => 'true_false',
					'ui' => 1,
					'default_value' => 1,
				),
				array(
					'key' => 'field_flc_speed',
					'label' => 'Autoplay Speed (seconds)',
					'name' => 'autoplay_speed',
					'type' => 'number',
					'default_value' => 5,
                    'min' => 1,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/flexible-link-carousel',
			),
		),
	),
));

endif;
