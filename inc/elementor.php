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
