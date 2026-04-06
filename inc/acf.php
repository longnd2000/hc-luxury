<?php

/**
 * ACF Configuration
 *
 * @package Child_Theme
 */

/**
 * ACF JSON Sync — Save path.
 */
add_filter('acf/settings/save_json', function ($path) {
    return CHILD_THEME_PATH . '/acf-json';
});

/**
 * ACF JSON Sync — Load path.
 */
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]); // Remove default path
    $paths[] = CHILD_THEME_PATH . '/acf-json';
    return $paths;
});
