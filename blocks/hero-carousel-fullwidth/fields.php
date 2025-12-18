<?php

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_hero_carousel_fullwidth',
        'title' => 'Hero Carousel Fullwidth',
        'fields' => array(
            array(
                'key' => 'field_hcf_slides',
                'label' => 'Slides',
                'name' => 'slides',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Agregar Slide',
                'sub_fields' => array(
                    array(
                        'key' => 'field_hcf_image_desktop',
                        'label' => 'Imagen Desktop',
                        'name' => 'image_desktop',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'required' => 1,
                        'instructions' => 'Recomendado: 1920x900px (Desktop). Formato sugerido: WebP o JPG optimizado.',
                    ),
                    array(
                        'key' => 'field_hcf_image_mobile',
                        'label' => 'Imagen Mobile',
                        'name' => 'image_mobile',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'instructions' => 'Recomendado: 750x1100px (Mobile). Si se omite, se usa la de desktop.',
                    ),
                    array(
                        'key' => 'field_hcf_heading',
                        'label' => 'Título',
                        'name' => 'heading',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_hcf_text',
                        'label' => 'Texto Descriptivo',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_hcf_button',
                        'label' => 'Botón',
                        'name' => 'button',
                        'type' => 'link',
                        'return_format' => 'array',
                    ),
                    array(
                        'key' => 'field_hcf_enable_overlay',
                        'label' => 'Activar Overlay Oscuro',
                        'name' => 'enable_overlay',
                        'type' => 'true_false',
                        'ui' => 1,
                    ),
                ),
            ),
            array(
                'key' => 'field_hcf_autoplay',
                'label' => 'Autoplay',
                'name' => 'autoplay',
                'type' => 'true_false',
                'ui' => 1,
            ),
            array(
                'key' => 'field_hcf_autoplay_speed',
                'label' => 'Velocidad de Autoplay (segundos)',
                'name' => 'autoplay_speed',
                'type' => 'number',
                'default_value' => 5,
                'min' => 1,
                'max' => 20,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_hcf_autoplay',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/hero-carousel-fullwidth',
                ),
            ),
        ),
    ));

endif;
