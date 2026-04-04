<?php

/**
 * Child Theme functions.
 *
 * @package Child_Theme
 */

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

    // FontAwesome Free 6.4.2
    wp_enqueue_style(
        'font-awesome-free',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        [],
        '6.4.2'
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
    
    wp_enqueue_script(
        'child-theme-slick',
        CHILD_THEME_URL . '/assets/js/vendor/slick.min.js',
        ['jquery'],
        CHILD_THEME_VERSION,
        true
    );

    // wp_enqueue_script(
    //     'child-theme-mh',
    //     CHILD_THEME_URL . '/assets/js/vendor/jquery.matchHeight.js',
    //     ['jquery'],
    //     CHILD_THEME_VERSION,
    //     true
    // );

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

// load widgets library by elementor
function load_custom_widgets()
{
    require CHILD_THEME_PATH . '/widgets/index.php';
}
add_action('elementor/init', 'load_custom_widgets');

/**
 * Register Event Custom Post Type
 */
function register_event_post_type() {
    $labels = [
        'name'                  => _x('Events', 'Post Type General Name', 'child_theme'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'child_theme'),
        'menu_name'             => __('Events', 'child_theme'),
        'name_admin_bar'        => __('Event', 'child_theme'),
        'archives'              => __('Event Archives', 'child_theme'),
        'attributes'            => __('Event Attributes', 'child_theme'),
        'parent_item_colon'     => __('Parent Event:', 'child_theme'),
        'all_items'             => __('All Events', 'child_theme'),
        'add_new_item'          => __('Add New Event', 'child_theme'),
        'add_new'               => __('Add New', 'child_theme'),
        'new_item'              => __('New Event', 'child_theme'),
        'edit_item'             => __('Edit Event', 'child_theme'),
        'update_item'           => __('Update Event', 'child_theme'),
        'view_item'             => __('View Event', 'child_theme'),
        'view_items'            => __('View Events', 'child_theme'),
        'search_items'          => __('Search Event', 'child_theme'),
        'not_found'             => __('Not found', 'child_theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'child_theme'),
        'featured_image'        => __('Featured Image', 'child_theme'),
        'set_featured_image'    => __('Set featured image', 'child_theme'),
        'remove_featured_image' => __('Remove featured image', 'child_theme'),
        'use_featured_image'    => __('Use as featured image', 'child_theme'),
        'insert_into_item'      => __('Insert into event', 'child_theme'),
        'uploaded_to_this_item' => __('Uploaded to this event', 'child_theme'),
        'items_list'            => __('Events list', 'child_theme'),
        'items_list_navigation' => __('Events list navigation', 'child_theme'),
        'filter_items_list'     => __('Filter events list', 'child_theme'),
    ];
    $args = [
        'label'                 => __('Event', 'child_theme'),
        'description'           => __('Event Description', 'child_theme'),
        'labels'                => $labels,
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('event', $args);
}
add_action('init', 'register_event_post_type', 0);

/**
 * ACF JSON Sync
 */
add_filter('acf/settings/save_json', function($path) {
    return CHILD_THEME_PATH . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]); // Remove default path
    $paths[] = CHILD_THEME_PATH . '/acf-json';
    return $paths;
});