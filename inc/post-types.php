<?php

/**
 * Custom Post Types & Taxonomies
 *
 * @package Child_Theme
 */



/**
 * Register LX Form Custom Post Type.
 */
function child_theme_register_lx_form_post_type()
{
    $labels = [
        'name'                  => _x('LX Forms', 'Post Type General Name', 'child_theme'),
        'singular_name'         => _x('LX Form', 'Post Type Singular Name', 'child_theme'),
        'menu_name'             => __('LX Forms', 'child_theme'),
        'name_admin_bar'        => __('LX Form', 'child_theme'),
        'all_items'             => __('All Forms', 'child_theme'),
        'add_new_item'          => __('Add New Form', 'child_theme'),
        'add_new'               => __('Add New', 'child_theme'),
        'edit_item'             => __('Edit Form', 'child_theme'),
        'update_item'           => __('Update Form', 'child_theme'),
        'view_item'             => __('View Form', 'child_theme'),
        'search_items'          => __('Search Form', 'child_theme'),
    ];
    $args = [
        'label'                 => __('LX Form', 'child_theme'),
        'labels'                => $labels,
        'supports'              => ['title'], // Only need title, fields managed via ACF
        'hierarchical'          => false,
        'public'                => false, // Not accessible via URL
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-feedback',
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
    ];
    register_post_type('lx_form', $args);
}
add_action('init', 'child_theme_register_lx_form_post_type', 0);
