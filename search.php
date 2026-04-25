<?php
/**
 * The template for displaying search results pages
 *
 * @package Child_Theme
 */

get_header();

// Get layout version from theme options
$layout_version = function_exists('get_field') ? get_field('lx_search_layout', 'option') : 'v1';
$layout_version = $layout_version ?: 'v1';

// Load the selected template
$template_path = "templates/layouts/search/{$layout_version}.php";

if (file_exists(get_stylesheet_directory() . '/' . $template_path)) {
    include(get_stylesheet_directory() . '/' . $template_path);
} else {
    // Fallback to v1 if file not found
    include(get_stylesheet_directory() . '/templates/layouts/search/v1.php');
}

get_footer();
