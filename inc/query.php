<?php

/**
 * Query Modifications
 *
 * @package Child_Theme
 */

/**
 * Customize archive query: Set posts_per_page to 10.
 */
function child_theme_customize_archive_query($query)
{
    if (!is_admin() && $query->is_main_query() && (is_category() || is_tag() || is_archive())) {
        $query->set('posts_per_page', 10);
    }
}
add_action('pre_get_posts', 'child_theme_customize_archive_query');

/**
 * Restrict Search Results to Posts Only.
 */
function child_theme_search_filter($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', 'post');
    }
}
add_action('pre_get_posts', 'child_theme_search_filter');
