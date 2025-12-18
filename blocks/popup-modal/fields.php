<?php

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_popup_modal',
        'title' => 'Popup Modal',
        'fields' => array(
            array(
                'key' => 'field_pm_image',
                'label' => 'Imagen del Popup',
                'name' => 'popup_image',
                'type' => 'image',
                'required' => 1,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_pm_link',
                'label' => 'Enlace (Opcional)',
                'name' => 'popup_link',
                'type' => 'link',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_pm_overlay',
                'label' => 'Overlay Oscuro',
                'name' => 'overlay',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_pm_delay',
                'label' => 'Segundos de Retraso',
                'name' => 'delay_seconds',
                'type' => 'number',
                'default_value' => 6,
                'min' => 0,
            ),
            array(
                'key' => 'field_pm_expiry',
                'label' => 'Expiración de Cookie (Horas)',
                'name' => 'cookie_expiry',
                'type' => 'number',
                'default_value' => 1,
                'min' => 0,
                'instructions' => 'Horas para no volver a mostrar el popup al usuario después de cerrarlo.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/popup-modal',
                ),
            ),
        ),
    ));

endif;
