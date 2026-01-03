<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key' => 'group_woo_pop_out_cards',
		'title' => 'Woo Pop-out Cards',
		'fields' => array(
			array(
				'key' => 'field_wpoc_selected_products',
				'label' => 'Seleccionar Productos',
				'name' => 'selected_products',
				'type' => 'relationship',
				'instructions' => 'Selecciona exactamente 3 productos para mostrar.',
				'required' => 1,
				'post_type' => array(
					0 => 'product',
				),
				'filters' => array(
					0 => 'search',
				),
				'return_format' => 'id',
				'min' => 1,
				'max' => 6,
			),
			array(
				'key' => 'field_wpoc_enable_schema',
				'label' => 'Activar Schema',
				'name' => 'enable_schema',
				'type' => 'true_false',
				'instructions' => 'Generar datos estructurados (Product/Offer) para estos productos.',
				'default_value' => 0,
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'acf/woo-pop-out-cards',
				),
			),
		),
	) );

endif;
