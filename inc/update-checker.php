<?php
/**
 * Theme Update Checker
 *
 * Connects the theme to GitHub for automatic updates.
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load the library
require_once CHILD_THEME_PATH . '/assets/inc/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Initialize the update checker
 */
function child_theme_setup_update_checker()
{
    $update_checker = PucFactory::buildUpdateChecker(
        'https://github.com/longnd2000/hc-luxury/', // Repo URL
        CHILD_THEME_PATH . '/style.css',            // Full path to style.css
        'lx-landing'                                // Theme slug
    );

    // Set the branch that contains the stable code
    $update_checker->setBranch('main');

    /**
     * Optional: If you use a Private Repository, uncomment the line below 
     * and replace 'YOUR_TOKEN' with your GitHub Personal Access Token.
     */
    // $update_checker->setAuthentication('YOUR_TOKEN');
}

add_action('after_setup_theme', 'child_theme_setup_update_checker');
