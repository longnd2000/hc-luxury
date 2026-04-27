<?php

/**
 * Asset Enqueue
 *
 * @package Child_Theme
 */

/**
 * Enqueue child theme assets.
 */
function child_theme_assets(): void
{
    // File path thật trên server
    $main_css_file_path = CHILD_THEME_PATH . '/assets/css/main.css';
    $main_js_file_path  = CHILD_THEME_PATH . '/assets/js/main.js';

    // Version động theo thời gian sửa file
    $ver_main_css = file_exists($main_css_file_path) ? filemtime($main_css_file_path) : CHILD_THEME_VERSION;
    $ver_main_js  = file_exists($main_js_file_path) ? filemtime($main_js_file_path) : CHILD_THEME_VERSION;

    // FontAwesome Free 6.4.2 (Load via CDN to keep theme light)
    wp_enqueue_style(
        'font-awesome-free',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        [],
        '6.4.2'
    );

    // Bootstrap Grid Only (chỉ grid: .row, .col-*, .align-*, .justify-*, .g-*)
    // Không load full Bootstrap — chỉ mình phần lưới để tránh xứng đột style
    wp_enqueue_style(
        'bootstrap-grid',
        CHILD_THEME_URL . '/assets/inc/bootstrap/bootstrap-grid.min.css',
        [],
        CHILD_THEME_VERSION
    );

    // Style gốc của child theme
    wp_enqueue_style(
        'child-theme-style',
        get_stylesheet_uri(),
        [],
        CHILD_THEME_VERSION
    );

    // Main CSS
    wp_enqueue_style(
        'child-theme-main',
        CHILD_THEME_URL . '/assets/css/main.css',
        ['child-theme-style'],
        $ver_main_css
    );

    // Slick CSS
    wp_enqueue_style(
        'child-theme-slick-css',
        CHILD_THEME_URL . '/assets/inc/slick/slick.css',
        [],
        CHILD_THEME_VERSION
    );

    wp_enqueue_style(
        'child-theme-slick-theme',
        CHILD_THEME_URL . '/assets/inc/slick/slick-theme.css',
        ['child-theme-slick-css'],
        CHILD_THEME_VERSION
    );


    wp_enqueue_script(
        'child-theme-slick-js',
        CHILD_THEME_URL . '/assets/inc/slick/slick.min.js',
        ['jquery'],
        CHILD_THEME_VERSION,
        true
    );

    wp_enqueue_script(
        'child-theme-matchheight',
        CHILD_THEME_URL . '/assets/inc/matchHeight/jquery.matchHeight.js',
        ['jquery'],
        CHILD_THEME_VERSION,
        true
    );

    // Main JS
    wp_enqueue_script(
        'child-theme-main-js',
        CHILD_THEME_URL . '/assets/js/main.js',
        ['jquery'],
        $ver_main_js,
        true
    );
}
add_action('wp_enqueue_scripts', 'child_theme_assets');

/**
 * Remove Elementor Default Styles to prevent overrides
 */
function lx_remove_elementor_base_styles()
{
    // Loại bỏ CSS Kit (Màu sắc/Font chữ mặc định của Elementor)
    wp_dequeue_style('elementor-kit');
    wp_dequeue_style('elementor-global');
}
add_action('wp_enqueue_scripts', 'lx_remove_elementor_base_styles', 999);

