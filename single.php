<?php
/**
 * The template for displaying all single posts
 *
 * @package Child_Theme
 */

get_header();

// Get layout version from theme options
$layout_version = function_exists('get_field') ? get_field('lx_single_layout', 'option') : 'v1';
$layout_version = $layout_version ?: 'v1';

// Load the selected template
$template_path = "templates/layouts/single/{$layout_version}.php";

if (file_exists(get_stylesheet_directory() . '/' . $template_path)) {
    include(get_stylesheet_directory() . '/' . $template_path);
} else {
    // Fallback to v1 if file not found
    include(get_stylesheet_directory() . '/templates/layouts/single/v1.php');
}

get_footer();