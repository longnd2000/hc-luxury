<?php

/**
 * Required Plugins Management
 *
 * Displays admin notice when required plugins are missing.
 * Provides a dedicated page to install/activate them.
 *
 * @package Child_Theme
 */

/**
 * List of required plugins.
 *
 * @return array
 */
function child_theme_required_plugins()
{
    return [
        [
            'name' => 'Classic Editor',
            'slug' => 'classic-editor',
        ],
        [
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
        ],
        [
            'name' => 'Elementor',
            'slug' => 'elementor',
        ],
        [
            'name' => 'Polylang',
            'slug' => 'polylang',
        ],
        [
            'name' => 'EWWW Image Optimizer',
            'slug' => 'ewww-image-optimizer',
        ],
        [
            'name' => 'Fixed TOC',
            'slug' => 'fixed-toc',
        ],
        [
            'name' => 'No Category Base (WPML)',
            'slug' => 'no-category-base-wpml',
        ],
        [
            'name' => 'Safe SVG',
            'slug' => 'safe-svg',
        ],
        [
            'name'    => 'WP Cerber Security',
            'slug'    => 'wp-cerber',
            'zip_url' => 'https://downloads.wpcerber.com/plugin/wp-cerber.zip',
        ],
        [
            'name' => 'WP File Manager',
            'slug' => 'wp-file-manager',
        ],
        [
            'name' => 'WPCode Lite',
            'slug' => 'insert-headers-and-footers',
        ],
        [
            'name' => 'Yoast Duplicate Post',
            'slug' => 'duplicate-post',
        ],
        [
            'name'    => 'Pro Elements',
            'slug'    => 'pro-elements',
            'zip_url' => 'https://github.com/proelements/proelements/releases/download/v3.35.0/pro-elements.zip',
        ],
    ];
}

/**
 * Get the status of each required plugin.
 *
 * @return array  [ 'name', 'slug', 'status' => 'active'|'installed'|'not_installed', 'file' => string|null ]
 */
function child_theme_get_plugin_statuses()
{
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $all_plugins     = get_plugins();
    $required        = child_theme_required_plugins();
    $result          = [];

    foreach ($required as $plugin) {
        $found_file = null;
        $status     = 'not_installed';

        // Search installed plugins by directory slug
        foreach ($all_plugins as $file => $data) {
            if (strpos($file, $plugin['slug'] . '/') === 0) {
                $found_file = $file;
                $status     = is_plugin_active($file) ? 'active' : 'installed';
                break;
            }
        }

        $result[] = [
            'name'         => $plugin['name'],
            'slug'         => $plugin['slug'],
            'status'       => $status,
            'file'         => $found_file,
            'zip_url'      => isset($plugin['zip_url']) ? $plugin['zip_url'] : null,
            'external_url' => isset($plugin['external_url']) ? $plugin['external_url'] : null,
        ];
    }

    return $result;
}

/**
 * Show admin notice when required plugins are missing or inactive.
 */
function child_theme_required_plugins_notice()
{
    // Only show to administrators
    if (!current_user_can('install_plugins')) {
        return;
    }

    // Don't show on our own page
    $screen = get_current_screen();
    if ($screen && $screen->id === 'appearance_page_child-theme-plugins') {
        return;
    }

    $statuses    = child_theme_get_plugin_statuses();
    $missing     = [];

    foreach ($statuses as $p) {
        if ($p['status'] !== 'active') {
            $missing[] = $p['name'];
        }
    }

    if (empty($missing)) {
        return;
    }

    $count    = count($missing);
    $page_url = admin_url('themes.php?page=child-theme-plugins');
    ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <strong>⚠️ Warning theme:</strong>
            <?php printf(
                __('Có %d plugin cần thiết chưa được cài đặt hoặc kích hoạt. Website có thể không hoạt động đúng.', 'child-theme'),
                $count
            ); ?>
        </p>
        <p>
            <a href="<?php echo $page_url; ?>" class="button button-primary">
                <?php echo __('Xem danh sách & cài đặt ngay', 'child-theme'); ?>
            </a>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'child_theme_required_plugins_notice');

/**
 * Override plugin download URL for plugins with custom zip_url.
 *
 * Hooks into the WordPress Plugin API to redirect the download
 * to our custom ZIP URL instead of WordPress.org.
 */
function child_theme_override_plugin_api($result, $action, $args)
{
    if ($action !== 'plugin_information') {
        return $result;
    }

    $required = child_theme_required_plugins();

    foreach ($required as $plugin) {
        if (
            isset($plugin['zip_url'])
            && isset($args->slug)
            && $args->slug === $plugin['slug']
        ) {
            $result = (object) [
                'name'          => $plugin['name'],
                'slug'          => $plugin['slug'],
                'download_link' => $plugin['zip_url'],
                'version'       => '1.0',
                'author'        => '',
                'sections'      => ['description' => $plugin['name']],
            ];
            break;
        }
    }

    return $result;
}
add_filter('plugins_api', 'child_theme_override_plugin_api', 20, 3);

/**
 * Register the required plugins admin page under Appearance menu.
 */
function child_theme_register_plugins_page()
{
    add_theme_page(
        __('Plugin cần thiết', 'child-theme'),
        __('Plugin cần thiết', 'child-theme'),
        'install_plugins',
        'child-theme-plugins',
        'child_theme_render_plugins_page'
    );
}
add_action('admin_menu', 'child_theme_register_plugins_page');

/**
 * Enqueue admin styles for the plugins page.
 */
function child_theme_plugins_page_styles($hook)
{
    if ($hook !== 'appearance_page_child-theme-plugins') {
        return;
    }

    echo '<style>
        .ct-plugins-wrap { max-width: 900px; }
        .ct-plugins-table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .ct-plugins-table th,
        .ct-plugins-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .ct-plugins-table th { background: #23282d; color: #fff; font-weight: 600; }
        .ct-plugins-table tr:last-child td { border-bottom: none; }
        .ct-plugins-table tr:hover td { background: #f9f9f9; }
        .ct-badge { display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .ct-badge--active { background: #d4edda; color: #155724; }
        .ct-badge--installed { background: #fff3cd; color: #856404; }
        .ct-badge--missing { background: #f8d7da; color: #721c24; }
        .ct-btn { display: inline-block; padding: 6px 16px; border-radius: 4px; font-size: 13px; font-weight: 500; text-decoration: none; cursor: pointer; border: none; }
        .ct-btn--install { background: #0073aa; color: #fff; }
        .ct-btn--install:hover { background: #005a87; color: #fff; }
        .ct-btn--activate { background: #f0ad4e; color: #fff; }
        .ct-btn--activate:hover { background: #d9960a; color: #fff; }
        .ct-btn--disabled { background: #e0e0e0; color: #999; cursor: not-allowed; pointer-events: none; }
        .ct-summary { margin: 16px 0 24px; padding: 12px 16px; border-left: 4px solid #0073aa; background: #f0f6fc; }
        .ct-summary--ok { border-left-color: #46b450; background: #ecf7ed; }
    </style>';
}
add_action('admin_head', 'child_theme_plugins_page_styles');

/**
 * Render the required plugins page.
 */
function child_theme_render_plugins_page()
{
    $statuses     = child_theme_get_plugin_statuses();
    $missing_count = 0;
    $inactive_count = 0;

    foreach ($statuses as $p) {
        if ($p['status'] === 'not_installed') $missing_count++;
        if ($p['status'] === 'installed') $inactive_count++;
    }

    $all_ok = ($missing_count === 0 && $inactive_count === 0);
    ?>
    <div class="wrap ct-plugins-wrap">
        <h1><?php echo __('Plugin cần thiết cho Theme', 'child-theme'); ?></h1>

        <div class="ct-summary <?php echo $all_ok ? 'ct-summary--ok' : ''; ?>">
            <?php if ($all_ok): ?>
                <strong>✅ <?php echo __('Tất cả plugin đã được cài đặt và kích hoạt. Website hoạt động đầy đủ!', 'child-theme'); ?></strong>
            <?php else: ?>
                <strong>⚠️ <?php printf(
                    __('Còn %d plugin chưa cài đặt và %d plugin chưa kích hoạt.', 'child-theme'),
                    $missing_count,
                    $inactive_count
                ); ?></strong>
            <?php endif; ?>
        </div>

        <table class="ct-plugins-table">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:35%"><?php echo __('Plugin', 'child-theme'); ?></th>
                    <th style="width:25%"><?php echo __('Trạng thái', 'child-theme'); ?></th>
                    <th style="width:35%"><?php echo __('Thao tác', 'child-theme'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statuses as $i => $p): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><strong><?php echo $p['name']; ?></strong></td>
                        <td>
                            <?php if ($p['status'] === 'active'): ?>
                                <span class="ct-badge ct-badge--active"><?php echo __('Đã kích hoạt', 'child-theme'); ?></span>
                            <?php elseif ($p['status'] === 'installed'): ?>
                                <span class="ct-badge ct-badge--installed"><?php echo __('Đã cài đặt', 'child-theme'); ?></span>
                            <?php else: ?>
                                <span class="ct-badge ct-badge--missing"><?php echo __('Chưa cài đặt', 'child-theme'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['status'] === 'active'): ?>
                                <span class="ct-btn ct-btn--disabled"><?php echo __('Đã hoàn tất', 'child-theme'); ?></span>

                            <?php elseif ($p['status'] === 'installed'): ?>
                                <?php
                                $activate_url = wp_nonce_url(
                                    admin_url('plugins.php?action=activate&plugin=' . urlencode($p['file'])),
                                    'activate-plugin_' . $p['file']
                                );
                                ?>
                                <a href="<?php echo $activate_url; ?>" class="ct-btn ct-btn--activate">
                                    <?php echo __('Kích hoạt ngay', 'child-theme'); ?>
                                </a>

                            <?php else: ?>
                                <?php if ($p['external_url']): ?>
                                    <a href="<?php echo $p['external_url']; ?>" class="ct-btn ct-btn--install" target="_blank">
                                        <?php echo __('Tải từ website ↗', 'child-theme'); ?>
                                    </a>
                                <?php else: ?>
                                    <?php
                                    $install_url = wp_nonce_url(
                                        admin_url('update.php?action=install-plugin&plugin=' . $p['slug']),
                                        'install-plugin_' . $p['slug']
                                    );
                                    ?>
                                    <a href="<?php echo $install_url; ?>" class="ct-btn ct-btn--install">
                                        <?php echo __('Cài đặt ngay', 'child-theme'); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
