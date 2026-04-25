<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function register_custom_widgets($widgets_manager)
{
    // include file
    require_once WIDGETS_PATH . '/image_gallery_widget.php';
    require_once WIDGETS_PATH . '/youtube_iframe_slider.php';
    require_once WIDGETS_PATH . '/company_highlight_widget.php';
    require_once WIDGETS_PATH . '/featured_posts_widget.php';
    require_once WIDGETS_PATH . '/category_section_widget.php';
    require_once WIDGETS_PATH . '/event_widget.php';

    // Register widgets
    $widgets_manager->register(new \Image_Gallery_Widget());
    $widgets_manager->register(new \Youtube_Iframe_Slider_Widget());
    $widgets_manager->register(new \Company_Highlight_Widget());
    $widgets_manager->register(new \featured_posts_widget());
    $widgets_manager->register(new \category_section_widget());
    $widgets_manager->register(new \event_widget());
}
add_action('elementor/widgets/register', 'register_custom_widgets');

function register_custom_widget_categories($elements_manager)
{
    $categories = [
        'lx_typography' => 'LX Typography',
        'lx_media'      => 'LX Media & Sliders',
        'lx_cards'      => 'LX Cards & Blocks',
        'lx_sections'   => 'LX Sections',
        'lx_loops'      => 'LX Post Loops',
        'lx_forms'      => 'LX Forms',
        'lx_misc'       => 'LX Misc',
    ];

    foreach ($categories as $slug => $title) {
        $elements_manager->add_category(
            $slug,
            [
                'title' => __($title, 'child_theme'),
                'priority' => 0,
            ]
        );
    }
}
add_action('elementor/elements/categories_registered', 'register_custom_widget_categories');
