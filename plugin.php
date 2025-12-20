<?php
/**
 * Plugin Name: ACF Blocks Starter
 * Plugin URI: https://github.com/sil7en/wp-plugin-gutenberg-blocks
 * Description: Plugin base para crear bloques Gutenberg personalizados con ACF Pro, Tailwind CSS y mejores prácticas SEO
 * Version: 1.1.2
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: Pablo Silva Pastén Sil7en
 * Author URI: https://github.com/sil7en
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-blocks-starter
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Definir constantes del plugin
define('ACF_BLOCKS_VERSION', '1.1.2');
define('ACF_BLOCKS_PATH', plugin_dir_path(__FILE__));
define('ACF_BLOCKS_URL', plugin_dir_url(__FILE__));

// Incluir archivos necesarios
require_once ACF_BLOCKS_PATH . 'includes/acf-setup.php';
require_once ACF_BLOCKS_PATH . 'includes/register-blocks.php';
require_once ACF_BLOCKS_PATH . 'includes/schema-helper.php';

/**
 * Encolar estilos compilados de Tailwind
 */
function acf_blocks_enqueue_styles() {
    $css_file = ACF_BLOCKS_PATH . 'dist/blocks.css';
    
    if (file_exists($css_file)) {
        wp_enqueue_style(
            'acf-blocks-styles',
            ACF_BLOCKS_URL . 'dist/blocks.css',
            [],
            filemtime($css_file)
        );
    }
}
add_action('enqueue_block_assets', 'acf_blocks_enqueue_styles');

/**
 * Crear categoría personalizada para los bloques ACF
 */
function acf_blocks_category($categories) {
    return array_merge(
        [
            [
                'slug'  => 'acf-blocks',
                'title' => __('Bloques Personalizados', 'acf-blocks-starter'),
                'icon'  => 'layout',
            ],
        ],
        $categories
    );
}
add_filter('block_categories_all', 'acf_blocks_category');

/**
 * Inyectar Schema.org JSON-LD en el <head>
 */
function acf_blocks_output_schema() {
    acfb_output_schema();
}
add_action('wp_head', 'acf_blocks_output_schema');

/**
 * Mensaje de advertencia si ACF Pro no está activo
 */
function acf_blocks_admin_notice() {
    if (!function_exists('acf_register_block_type')) {
        ?>
        <div class="notice notice-error">
            <p>
                <strong><?php _e('ACF Blocks Starter', 'acf-blocks-starter'); ?></strong>: 
                <?php _e('Este plugin requiere Advanced Custom Fields PRO para funcionar.', 'acf-blocks-starter'); ?>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'acf_blocks_admin_notice');
