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
        // contact form 7
        [
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
        ],
        [
            'name' => 'Contact Form CFDB7',
            'slug' => 'contact-form-cfdb7',
        ],
        [
            'name' => 'WP Mail SMTP',
            'slug' => 'wp-mail-smtp',
        ],
        [
            'name' => 'ReCaptcha v2 for Contact Form 7',
            'slug' => 'wpcf7-recaptcha',
        ],
        // theme elementor
        [
            'name' => 'Elementor',
            'slug' => 'elementor',
        ],
        [
            'name'    => 'Pro Elements',
            'slug'    => 'pro-elements',
            'zip_url' => 'https://github.com/proelements/proelements/releases/download/v3.35.0/pro-elements.zip',
        ],
        [
            'name' => 'Safe SVG',
            'slug' => 'safe-svg',
        ],
        // đa ngôn ngữ
        [
            'name' => 'Polylang',
            'slug' => 'polylang',
        ],
        [
            'name' => 'EWWW Image Optimizer',
            'slug' => 'ewww-image-optimizer',
        ],
        [
            'name' => 'No Category Base (WPML)',
            'slug' => 'no-category-base-wpml',
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
    if ($screen && $screen->id === 'settings_page_child-theme-plugins') {
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
            <strong>⚠️ Warning Theme:</strong>
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
 * Register the required plugins admin page under Settings menu.
 */
function child_theme_register_plugins_page()
{
    add_submenu_page(
        'options-general.php',
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
    if ($hook !== 'settings_page_child-theme-plugins') {
        return;
    }

    echo '<style>
        .ct-plugins-wrap { max-width: 1000px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        .ct-plugins-header { display: flex; align-items: center; margin-bottom: 24px; }
        .ct-plugins-header h1 { margin: 0; font-size: 23px; font-weight: 600; color: #1d2327; }
        .ct-plugins-header .dashicons { font-size: 26px; width: 26px; height: 26px; color: #2271b1; margin-right: 10px; }
        
        .ct-summary { margin: 0 0 24px; padding: 16px 20px; border-left: 4px solid #2271b1; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,.05); border-radius: 4px; border: 1px solid #c3c4c7; border-left-width: 4px; font-size: 14px; }
        .ct-summary--ok { border-left-color: #00a32a; }

        /* Table styles matching screenshot */
        .ct-plugins-table { width: 100%; border-collapse: collapse; font-size: 14px; background: #fff; overflow: hidden; border: 1px solid #e2e8f0; }
        .ct-plugins-table th { background: #f1f5f9; color: #334155; font-weight: 600; font-size: 14px; text-align: left; padding: 16px 20px; border: none; }
        .ct-plugins-table td { padding: 16px 20px; text-align: left; border: none; vertical-align: middle; color: #475569; }
        .ct-plugins-table tr { border-bottom: none; }
        .ct-plugins-table tbody tr:nth-child(odd) { background-color: #ffffff; }
        .ct-plugins-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        
        .ct-plugin-name { color: #3b82f6; font-weight: 500; display: inline-block; }
        
        .ct-badge { font-weight: 500; font-size: 13px; }
        .ct-badge--active { color: #059669; }
        .ct-badge--installed { color: #d97706; }
        .ct-badge--missing { color: #dc2626; }
        
        /* Action buttons matching screenshot (green pills) */
        .ct-btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 18px; border-radius: 30px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s ease; border: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .ct-btn .dashicons { font-size: 16px; width: 16px; height: 16px; margin-right: 6px; }
        .ct-btn--install { background: #10b981; color: #fff; } /* Green like screenshot */
        .ct-btn--install:hover { background: #059669; color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .ct-btn--activate { background: #3b82f6; color: #fff; } /* Blue for activate */
        .ct-btn--activate:hover { background: #2563eb; color: #fff; }
        .ct-btn--disabled { background: transparent; color: #94a3b8; box-shadow: none; cursor: not-allowed; pointer-events: none; padding-left: 0; }
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
        <div class="ct-plugins-header">
            <span class="dashicons dashicons-admin-plugins"></span>
            <h1><?php echo __('Quản lý Plugin Tùy Chỉnh', 'child-theme'); ?></h1>
        </div>

        <div class="ct-summary <?php echo $all_ok ? 'ct-summary--ok' : ''; ?>">
            <?php if ($all_ok): ?>
                <strong><span class="dashicons dashicons-yes-alt" style="color: #00a32a; vertical-align: middle;"></span> <?php echo __('Tuyệt vời! Tất cả plugin yêu cầu đã được cài đặt và kích hoạt đầy đủ.', 'child-theme'); ?></strong>
            <?php else: ?>
                <strong><span class="dashicons dashicons-warning" style="color: #d63638; vertical-align: middle;"></span> <?php printf(
                                __('Hệ thống phát hiện %d plugin chưa cài đặt và %d plugin chưa kích hoạt.', 'child-theme'),
                                $missing_count,
                                $inactive_count
                            ); ?></strong>
            <?php endif; ?>
        </div>

        <div class="ct-plugins-table-wrap">
            <table class="ct-plugins-table">
                <thead>
                    <tr>
                        <th style="width:10%">STT</th>
                        <th style="width:40%"><?php echo __('Tên Plugin', 'child-theme'); ?></th>
                        <th style="width:25%"><?php echo __('Trạng thái', 'child-theme'); ?></th>
                        <th style="width:25%"><?php echo __('Thao tác', 'child-theme'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statuses as $i => $p): ?>
                        <tr>
                            <td><span style="color: #64748b; font-weight: 500;"><?php echo $i + 1; ?></span></td>
                            <td>
                                <span class="ct-plugin-name">
                                    <?php echo $p['name']; ?>
                                </span>
                            </td>
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
                                    <span class="ct-btn ct-btn--disabled"><span class="dashicons dashicons-yes"></span> <?php echo __('Hoàn tất', 'child-theme'); ?></span>

                                <?php elseif ($p['status'] === 'installed'): ?>
                                    <?php
                                    $activate_url = wp_nonce_url(
                                        admin_url('plugins.php?action=activate&plugin=' . urlencode($p['file'])),
                                        'activate-plugin_' . $p['file']
                                    );
                                    ?>
                                    <a href="<?php echo $activate_url; ?>" class="ct-btn ct-btn--activate">
                                        <span class="dashicons dashicons-controls-play"></span> <?php echo __('Kích hoạt ngay', 'child-theme'); ?>
                                    </a>

                                <?php else: ?>
                                    <?php if ($p['external_url']): ?>
                                        <a href="<?php echo $p['external_url']; ?>" class="ct-btn ct-btn--install" target="_blank">
                                            <span class="dashicons dashicons-external"></span> <?php echo __('Tải từ trang chủ', 'child-theme'); ?>
                                        </a>
                                    <?php else: ?>
                                        <?php
                                        $install_url = wp_nonce_url(
                                            admin_url('update.php?action=install-plugin&plugin=' . $p['slug']),
                                            'install-plugin_' . $p['slug']
                                        );
                                        ?>
                                        <a href="<?php echo $install_url; ?>" class="ct-btn ct-btn--install">
                                            <span class="dashicons dashicons-download"></span> <?php echo __('Cài đặt ngay', 'child-theme'); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
