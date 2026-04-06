<?php

/**
 * Child Theme functions.
 *
 * @package Child_Theme
 */

// ── Constants ──────────────────────────────────────────
if (! defined('CHILD_THEME_VERSION')) {
    define('CHILD_THEME_VERSION', '2.0.0');
}

if (! defined('CHILD_THEME_URL')) {
    define('CHILD_THEME_URL', get_stylesheet_directory_uri());
}

if (! defined('CHILD_THEME_PATH')) {
    define('CHILD_THEME_PATH', get_stylesheet_directory());
}

if (! defined('WIDGETS_PATH')) {
    define('WIDGETS_PATH', get_stylesheet_directory() . '/widgets/template/');
}

// ── Load Modules ───────────────────────────────────────
$child_theme_inc_files = [
    '/inc/helpers.php',       // Debug & utility functions (load first)
    '/inc/enqueue.php',       // CSS, JS, fonts
    '/inc/elementor.php',     // Elementor custom widgets loader
    '/inc/post-types.php',    // Custom Post Types (event, ...)
    '/inc/acf.php',           // ACF JSON sync settings
    '/inc/query.php',         // pre_get_posts modifications
    '/inc/template-tags.php', // Archive title, helpers
];

foreach ($child_theme_inc_files as $file) {
    require_once CHILD_THEME_PATH . $file;
}
