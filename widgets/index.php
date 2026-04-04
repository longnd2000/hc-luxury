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

function register_custom_widget_category($elements_manager)
{
    $elements_manager->add_category(
        'custom_widgets_theme',
        [
            'title' => __('Custom Widgets', 'child_theme'),
            'priority' => 0,
        ]
    );
}
add_action('elementor/elements/categories_registered', 'register_custom_widget_category');
