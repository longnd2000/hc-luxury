<?php
/**
 * Breadcrumbs Logic
 *
 * Provides a standardized breadcrumb system for the theme.
 * Usage: <?php echo lx_get_breadcrumbs(); ?> or [lx_breadcrumbs]
 *
 * @package Child_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode for breadcrumbs
 */
add_shortcode('lx_breadcrumbs', 'child_theme_breadcrumbs_shortcode');
function child_theme_breadcrumbs_shortcode()
{
    return child_theme_get_breadcrumbs();
}

/**
 * Main breadcrumbs function
 *
 * @return string Breadcrumbs HTML
 */
function child_theme_get_breadcrumbs(): string
{
    // Don't show on front page
    if (is_front_page()) {
        return '';
    }

    global $post;

    $delimiter = '<i class="fa-solid fa-chevron-right mx-2"></i>';
    $home_text = __('Trang chủ', 'lx-landing');
    $before    = '<span class="lx_breadcrumb_current">';
    $after     = '</span>';

    $output = '<nav class="lx_breadcrumbs_nav mb-4" aria-label="breadcrumb">';
    $output .= '<div class="lx_breadcrumbs_container d-flex align-items-center flex-wrap">';

    // Home link
    $output .= '<a href="' . esc_url(home_url('/')) . '" class="lx_breadcrumb_home">' . $home_text . '</a>';

    if (is_home()) {
        // Blog index
        $output .= $delimiter . $before . get_the_title(get_option('page_for_posts')) . $after;
    } elseif (is_category() || is_tag() || is_tax()) {
        // Archive (Category, Tag, Taxonomy)
        $output .= $delimiter;
        $queried_object = get_queried_object();
        $output .= $before . $queried_object->name . $after;
    } elseif (is_archive()) {
        // Post Type Archive
        $output .= $delimiter;
        $output .= $before . post_type_archive_title('', false) . $after;
    } elseif (is_search()) {
        // Search Results
        $output .= $delimiter;
        $output .= $before . sprintf(__('Kết quả tìm kiếm cho: "%s"', 'lx-landing'), get_search_query()) . $after;
    } elseif (is_single()) {
        // Single Post
        $output .= $delimiter;
        $post_type = get_post_type();

        if ($post_type == 'post') {
            $cat = get_the_category();
            if ($cat) {
                $cat = $cat[0];
                $output .= '<a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>' . $delimiter;
            }
        } elseif ($post_type == 'event') {
             $output .= '<a href="' . get_post_type_archive_link('event') . '">' . __('Sự kiện', 'lx-landing') . '</a>' . $delimiter;
        } else {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && $post_type_obj->has_archive) {
                $output .= '<a href="' . get_post_type_archive_link($post_type) . '">' . $post_type_obj->labels->name . '</a>' . $delimiter;
            }
        }

        $output .= $before . get_the_title() . $after;
    } elseif (is_page()) {
        // Page
        if ($post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                $output .= $delimiter . $crumb;
            }
        }
        $output .= $delimiter . $before . get_the_title() . $after;
    } elseif (is_404()) {
        // 404
        $output .= $delimiter;
        $output .= $before . __('Lỗi 404', 'lx-landing') . $after;
    }

    $output .= '</div>';
    $output .= '</nav>';

    return $output;
}

// Aliases for backward compatibility if needed, but we follow child_theme_ prefix
function lx_get_breadcrumbs() {
    return child_theme_get_breadcrumbs();
}
