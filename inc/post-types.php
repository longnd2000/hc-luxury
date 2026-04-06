<?php

/**
 * Custom Post Types & Taxonomies
 *
 * @package Child_Theme
 */

/**
 * Register Event Custom Post Type.
 */
function child_theme_register_event_post_type()
{
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
        'has_archive'           => 'event',
        'rewrite'               => ['slug' => 'event', 'with_front' => false],
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('event', $args);

    // Automatically flush permalinks so the new URL works instantly
    flush_rewrite_rules();
}
add_action('init', 'child_theme_register_event_post_type', 0);
