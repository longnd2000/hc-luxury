<?php

/**
 * Elementor Integration
 *
 * @package Child_Theme
 */

/**
 * Load custom Elementor widgets.
 */
function child_theme_load_custom_widgets()
{
    require CHILD_THEME_PATH . '/widgets/index.php';
}
add_action('elementor/init', 'child_theme_load_custom_widgets');

/**
 * Disable Elementor Default Colors and Fonts
 */
add_action('after_setup_theme', function () {
    // Disable default colors
    update_option('elementor_disable_color_schemes', 'yes');
    // Disable default fonts
    update_option('elementor_disable_typography_schemes', 'yes');
});

