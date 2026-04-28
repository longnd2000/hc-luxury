<?php

/**
 * Required Plugins Management
 *
 * Displays admin notice when required plugins are missing.
 * Provides a dedicated page to install/activate them.
 *
 * @package lx-landing
 */

/**
 * List of required plugins.
 *
 * @return array
 */
function lx_required_plugins()
{
    return [
        // Elementor Core
        [
            'name' => 'Elementor',
            'slug' => 'elementor',
        ],
        [
            'name'    => 'ProElements',
            'slug'    => 'pro-elements',
            'zip_url' => 'https://github.com/proelements/proelements/releases/download/v3.35.0/pro-elements.zip',
        ],
        [
            'name'    => 'Advanced Custom Fields Pro',
            'slug'    => 'advanced-custom-fields-pro',
            'zip_url' => 'https://drive.google.com/uc?export=download&id=1Tie7c317vteS3G_15oAzhSwMXLkvLiH8',
        ],
        [
            'name'    => 'All-in-One WP Migration Master',
            'slug'    => 'all-in-one-wp-migration-master',
            'zip_url' => 'https://drive.google.com/uc?export=download&id=1kQB2bYkLs1bdq6j5yw3jShsXRgXqoTmI',
        ],
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
            'required_by' => 'contact-form-7',
        ],
        [
            'name' => 'WP Mail SMTP',
            'slug' => 'wp-mail-smtp',
            'required_by' => 'contact-form-7',
        ],
        [
            'name' => 'ReCaptcha v2 for Contact Form 7',
            'slug' => 'wpcf7-recaptcha',
            'required_by' => 'contact-form-7',
        ],
        // đa ngôn ngữ
        [
            'name' => 'EWWW Image Optimizer',
            'slug' => 'ewww-image-optimizer',
        ],
        [
            'name' => 'No Category Base (WPML)',
            'slug' => 'no-category-base-wpml',
        ],
        // bảo mật
        [
            'name'    => 'WP Cerber Security',
            'slug'    => 'wp-cerber',
            'zip_url' => 'https://downloads.wpcerber.com/plugin/wp-cerber.zip',
        ],
        [
            'name' => 'Login Security Captcha',
            'slug' => 'login-security-recaptcha',
        ],
        [
            'name' => 'WP File Manager',
            'slug' => 'wp-file-manager',
        ],
        [
            'name' => 'Yoast Duplicate Post',
            'slug' => 'duplicate-post',
        ],
        [
            'name' => 'Disable Comments',
            'slug' => 'disable-comments',
        ],
        [
            'name'    => 'Fixed TOC',
            'slug'    => 'fixed-toc',
            'zip_url' => 'https://drive.google.com/uc?export=download&id=1-7MkkHi4pTOMXtEzC4t2nK5v_XJT0pp2',
        ],
    ];
}

/**
 * Handle custom plugin actions (activate, deactivate, delete) from our custom page.
 */
function lx_handle_plugin_actions()
{
    if (!isset($_GET['page']) || $_GET['page'] !== 'child-theme-plugins') {
        return;
    }

    if (!isset($_GET['lx_action']) || !isset($_GET['plugin_file'])) {
        return;
    }

    $action = $_GET['lx_action'];
    $plugin = $_GET['plugin_file'];
    $nonce  = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';

    if (!wp_verify_nonce($nonce, 'lx_plugin_action_' . $plugin)) {
        wp_die(__('Yêu cầu bảo mật không hợp lệ.', 'lx-landing'));
    }

    if (!current_user_can('install_plugins')) {
        wp_die(__('Bạn không có quyền thực hiện hành động này.', 'lx-landing'));
    }

    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $redirect_url = admin_url('options-general.php?page=child-theme-plugins');
    $msg = '';

    switch ($action) {
        case 'activate':
            $result = activate_plugin($plugin);
            if (is_wp_error($result)) {
                $msg = 'error_activate';
            } else {
                $msg = 'success_activate';
            }
            break;

        case 'deactivate':
            deactivate_plugins($plugin);
            $msg = 'success_deactivate';
            break;

        case 'delete':
            require_once ABSPATH . 'wp-admin/includes/file.php';
            // Need to make sure filesystem is initialized
            WP_Filesystem();
            $result = delete_plugins(array($plugin));
            if (is_wp_error($result)) {
                $msg = 'error_delete';
            } else {
                $msg = 'success_delete';
            }
            break;
    }

    wp_safe_redirect(add_query_arg('lx_msg', $msg, $redirect_url));
    exit;
}
add_action('admin_init', 'lx_handle_plugin_actions');

/**
 * Get the status of each required plugin.
 *
 * @return array  [ 'name', 'slug', 'status' => 'active'|'installed'|'not_installed', 'file' => string|null ]
 */
function lx_get_plugin_statuses()
{
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $all_plugins     = get_plugins();
    $required        = lx_required_plugins();
    $result          = [];

    // First, identify all active plugin slugs to check dependencies
    $active_slugs = [];
    foreach ($all_plugins as $file => $data) {
        if (is_plugin_active($file)) {
            $parts = explode('/', $file);
            if (!empty($parts[0])) {
                $active_slugs[] = $parts[0];
            }
        }
    }

    foreach ($required as $plugin) {
        // Check dependency: If a plugin is required_by another, 
        // it only shows up if that parent plugin is active.
        if (isset($plugin['required_by'])) {
            if (!in_array($plugin['required_by'], $active_slugs)) {
                continue; // Skip this plugin as its dependency is not met
            }
        }

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
function lx_required_plugins_notice()
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

    $statuses    = lx_get_plugin_statuses();
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
    $page_url = admin_url('options-general.php?page=child-theme-plugins');
?>
    <div class="notice notice-error is-dismissible">
        <p>
            <strong>⚠️ Warning Theme:</strong>
            <?php printf(
                __('Có %d plugin cần thiết chưa được cài đặt hoặc kích hoạt. Website có thể không hoạt động đúng.', 'lx-landing'),
                $count
            ); ?>
        </p>
        <p>
            <a href="<?php echo $page_url; ?>" class="button button-primary">
                <?php echo __('Xem danh sách & cài đặt ngay', 'lx-landing'); ?>
            </a>
        </p>
    </div>
<?php
}
add_action('admin_notices', 'lx_required_plugins_notice');

/**
 * Override plugin download URL for plugins with custom zip_url.
 *
 * Hooks into the WordPress Plugin API to redirect the download
 * to our custom ZIP URL instead of WordPress.org.
 */
function lx_override_plugin_api($result, $action, $args)
{
    if ($action !== 'plugin_information') {
        return $result;
    }

    $required = lx_required_plugins();

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
add_filter('plugins_api', 'lx_override_plugin_api', 20, 3);

/**
 * Disable update notifications for specific custom plugins.
 */
function lx_disable_specific_plugin_updates($value)
{
    if (isset($value) && is_object($value)) {
        // Advanced Custom Fields PRO
        if (isset($value->response['advanced-custom-fields-pro/acf.php'])) {
            unset($value->response['advanced-custom-fields-pro/acf.php']);
        }
    }
    return $value;
}
add_filter('site_transient_update_plugins', 'lx_disable_specific_plugin_updates');

/**
 * Register the required plugins admin page under Settings menu.
 */
function lx_register_plugins_page()
{
    add_submenu_page(
        'options-general.php',
        __('Plugin cần thiết', 'lx-landing'),
        __('Plugin cần thiết', 'lx-landing'),
        'install_plugins',
        'child-theme-plugins',
        'lx_render_plugins_page'
    );
}
add_action('admin_menu', 'lx_register_plugins_page');

/**
 * Enqueue admin styles for the plugins page.
 */
function lx_plugins_page_styles($hook)
{
    if ($hook !== 'settings_page_child-theme-plugins') {
        return;
    }

    echo '<style>
        .ct-plugins-wrap { max-width: 1000px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        .ct-plugins-header { display: flex; align-items: center; margin-bottom: 24px; }
        .ct-plugins-header h1 { margin: 0; font-size: 23px; font-weight: 600; color: #1d2327; }
        .ct-plugins-header .dashicons { font-size: 26px; width: 26px; height: 26px; color: #2271b1; margin-right: 10px; }
        
        @keyframes lx-spin { 100% { transform: rotate(360deg); } }
        .lx-spin { animation: lx-spin 2s linear infinite; }
        
        @keyframes lx-pulse-shadow {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        
        .ct-plugins-actions { margin-bottom: 30px; display: flex; }
        .ct-btn-massive {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: lx-pulse-shadow 2s infinite;
        }
        .ct-btn-massive:hover {
            transform: translateY(-2px);
            animation: none;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
            color: #fff;
        }
        .ct-btn-massive .dashicons {
            font-size: 20px;
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
        .ct-btn-massive.installing {
            animation: none;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            pointer-events: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        
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
        .ct-btn--deactivate { background: #f59e0b; color: #fff; }
        .ct-btn--deactivate:hover { background: #d97706; color: #fff; }
        .ct-btn--delete { background: #ef4444; color: #fff; }
        .ct-btn--delete:hover { background: #dc2626; color: #fff; }
        .ct-btn--disabled { background: transparent; color: #94a3b8; box-shadow: none; cursor: not-allowed; pointer-events: none; padding-left: 0; }
    </style>';
}
add_action('admin_head', 'lx_plugins_page_styles');

/**
 * Render the required plugins page.
 */
function lx_render_plugins_page()
{
    $statuses     = lx_get_plugin_statuses();
    $missing_count = 0;
    $inactive_count = 0;

    foreach ($statuses as $p) {
        if ($p['status'] === 'not_installed') $missing_count++;
        if ($p['status'] === 'installed') $inactive_count++;
    }

    $all_ok = ($missing_count === 0 && $inactive_count === 0);

    $lx_msg = isset($_GET['lx_msg']) ? $_GET['lx_msg'] : '';
?>
    <div class="wrap ct-plugins-wrap">
        <?php
        if ($lx_msg) {
            $msg_text = '';
            $msg_class = 'notice-success';

            switch ($lx_msg) {
                case 'success_activate':
                    $msg_text = __('Plugin đã được kích hoạt thành công.', 'lx-landing');
                    break;
                case 'success_deactivate':
                    $msg_text = __('Plugin đã được vô hiệu hóa.', 'lx-landing');
                    break;
                case 'success_delete':
                    $msg_text = __('Plugin đã được xóa khỏi hệ thống.', 'lx-landing');
                    break;
                case 'error_activate':
                    $msg_text = __('Lỗi khi kích hoạt plugin.', 'lx-landing');
                    $msg_class = 'notice-error';
                    break;
                case 'error_delete':
                    $msg_text = __('Lỗi khi xóa plugin.', 'lx-landing');
                    $msg_class = 'notice-error';
                    break;
            }

            if ($msg_text) {
                echo '<div class="notice ' . $msg_class . ' is-dismissible" style="margin: 20px 0; max-width: 100%;"><p>' . $msg_text . '</p></div>';
            }
        }
        ?>
        <div class="ct-plugins-header">
            <span class="dashicons dashicons-admin-plugins"></span>
            <h1><?php echo __('Quản lý Plugin Tùy Chỉnh', 'lx-landing'); ?></h1>
        </div>

        <div class="ct-plugins-actions">
            <?php if ($all_ok): ?>
                <button class="ct-btn-massive" style="background: #e2e8f0; color: #94a3b8; cursor: not-allowed; box-shadow: none; animation: none; border: 1px solid #cbd5e1;" disabled>
                    <span class="dashicons dashicons-yes-alt" style="margin-top: 2px;"></span> <?php echo __('Tất cả plugin đã sẵn sàng', 'lx-landing'); ?>
                </button>
            <?php else: ?>
                <button id="lx-install-all-btn" class="ct-btn-massive">
                    <span class="dashicons dashicons-download" style="margin-top: 2px;"></span> <?php echo __('Cài đặt nhanh tất cả', 'lx-landing'); ?>
                </button>
            <?php endif; ?>
        </div>

        <div class="ct-summary <?php echo $all_ok ? 'ct-summary--ok' : ''; ?>">
            <?php if ($all_ok): ?>
                <strong><span class="dashicons dashicons-yes-alt" style="color: #00a32a; vertical-align: middle;"></span> <?php echo __('Tuyệt vời! Tất cả plugin yêu cầu đã được cài đặt và kích hoạt đầy đủ.', 'lx-landing'); ?></strong>
            <?php else: ?>
                <strong><span class="dashicons dashicons-warning" style="color: #d63638; vertical-align: middle;"></span> <?php printf(
                                                                                                                                __('Hệ thống phát hiện %d plugin chưa cài đặt và %d plugin chưa kích hoạt.', 'lx-landing'),
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
                        <th style="width:30%"><?php echo __('Tên Plugin', 'lx-landing'); ?></th>
                        <th style="width:20%"><?php echo __('Trạng thái', 'lx-landing'); ?></th>
                        <th style="width:20%"><?php echo __('Thao tác', 'lx-landing'); ?></th>
                        <th style="width:20%"><?php echo __('Gỡ bỏ', 'lx-landing'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statuses as $i => $p): ?>
                        <tr class="lx-plugin-item" data-slug="<?php echo esc_attr($p['slug']); ?>" data-status="<?php echo esc_attr($p['status']); ?>">
                            <td><span style="color: #64748b; font-weight: 500;"><?php echo $i + 1; ?></span></td>
                            <td>
                                <span class="ct-plugin-name">
                                    <?php echo $p['name']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($p['status'] === 'active'): ?>
                                    <span class="ct-badge ct-badge--active"><?php echo __('Đã kích hoạt', 'lx-landing'); ?></span>
                                <?php elseif ($p['status'] === 'installed'): ?>
                                    <span class="ct-badge ct-badge--installed"><?php echo __('Đã cài đặt', 'lx-landing'); ?></span>
                                <?php else: ?>
                                    <span class="ct-badge ct-badge--missing"><?php echo __('Chưa cài đặt', 'lx-landing'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['status'] === 'active'): ?>
                                    <span class="ct-btn ct-btn--disabled"><span class="dashicons dashicons-yes"></span> <?php echo __('Hoàn tất', 'lx-landing'); ?></span>

                                <?php elseif ($p['status'] === 'installed'): ?>
                                    <?php
                                    $activate_url = wp_nonce_url(
                                        admin_url('options-general.php?page=child-theme-plugins&lx_action=activate&plugin_file=' . urlencode($p['file'])),
                                        'lx_plugin_action_' . $p['file']
                                    );
                                    ?>
                                    <a href="<?php echo $activate_url; ?>" class="ct-btn ct-btn--activate">
                                        <span class="dashicons dashicons-controls-play"></span> <?php echo __('Kích hoạt ngay', 'lx-landing'); ?>
                                    </a>

                                <?php else: ?>
                                    <?php if ($p['external_url']): ?>
                                        <a href="<?php echo $p['external_url']; ?>" class="ct-btn ct-btn--install" target="_blank">
                                            <span class="dashicons dashicons-external"></span> <?php echo __('Tải từ trang chủ', 'lx-landing'); ?>
                                        </a>
                                    <?php else: ?>
                                        <?php
                                        $install_url = wp_nonce_url(
                                            admin_url('update.php?action=install-plugin&plugin=' . $p['slug'] . '&_wp_http_referer=' . urlencode(admin_url('options-general.php?page=child-theme-plugins'))),
                                            'install-plugin_' . $p['slug']
                                        );
                                        ?>
                                        <a href="<?php echo $install_url; ?>" class="ct-btn ct-btn--install">
                                            <span class="dashicons dashicons-download"></span> <?php echo __('Cài đặt ngay', 'lx-landing'); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['status'] === 'active'): ?>
                                    <?php
                                    $deactivate_url = wp_nonce_url(
                                        admin_url('options-general.php?page=child-theme-plugins&lx_action=deactivate&plugin_file=' . urlencode($p['file'])),
                                        'lx_plugin_action_' . $p['file']
                                    );
                                    ?>
                                    <a href="<?php echo $deactivate_url; ?>" class="ct-btn ct-btn--deactivate" onclick="return confirm('<?php echo __('Bạn có chắc chắn muốn vô hiệu hóa plugin này?', 'lx-landing'); ?>')">
                                        <span class="dashicons dashicons-controls-pause"></span> <?php echo __('Vô hiệu hóa', 'lx-landing'); ?>
                                    </a>
                                <?php elseif ($p['status'] === 'installed'): ?>
                                    <?php
                                    $delete_url = wp_nonce_url(
                                        admin_url('options-general.php?page=child-theme-plugins&lx_action=delete&plugin_file=' . urlencode($p['file'])),
                                        'lx_plugin_action_' . $p['file']
                                    );
                                    ?>
                                    <a href="<?php echo $delete_url; ?>" class="ct-btn ct-btn--delete" onclick="return confirm('<?php echo __('Bạn có chắc chắn muốn XÓA plugin này? Hành động này không thể hoàn tác.', 'lx-landing'); ?>')">
                                        <span class="dashicons dashicons-trash"></span> <?php echo __('Xóa luôn', 'lx-landing'); ?>
                                    </a>
                                <?php else: ?>
                                    <span class="ct-btn ct-btn--disabled"><?php echo __('Chưa có sẵn', 'lx-landing'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    jQuery(document).ready(function($) {
        $('#lx-install-all-btn').on('click', function(e) {
            e.preventDefault();
            
            var $btn = $(this);
            if ($btn.hasClass('installing')) return;
            
            var pluginsToInstall = [];
            $('.lx-plugin-item').each(function() {
                var status = $(this).data('status');
                var slug = $(this).data('slug');
                if (status !== 'active') {
                    pluginsToInstall.push({
                        slug: slug,
                        row: $(this)
                    });
                }
            });
            
            if (pluginsToInstall.length === 0) {
                alert('<?php echo esc_js(__('Tất cả plugin đã được cài đặt và kích hoạt!', 'lx-landing')); ?>');
                return;
            }
            
            if (!confirm('<?php echo esc_js(__('Bạn có muốn cài đặt và kích hoạt tất cả plugin còn thiếu không?', 'lx-landing')); ?>')) {
                return;
            }
            
            $btn.addClass('installing').html('<span class="dashicons dashicons-update-alt lx-spin" style="margin-top: 2px;"></span> <?php echo esc_js(__('Đang xử lý...', 'lx-landing')); ?>');
            
            var currentIndex = 0;
            
            function processNextPlugin() {
                if (currentIndex >= pluginsToInstall.length) {
                    $btn.removeClass('installing').html('<span class="dashicons dashicons-yes-alt" style="margin-top: 2px;"></span> <?php echo esc_js(__('Đã hoàn tất!', 'lx-landing')); ?>');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                    return;
                }
                
                var plugin = pluginsToInstall[currentIndex];
                var $row = plugin.row;
                
                $row.find('.ct-btn--install, .ct-btn--activate').replaceWith('<span class="ct-btn ct-btn--disabled lx-processing-btn"><span class="dashicons dashicons-update-alt lx-spin"></span> <?php echo esc_js(__('Đang xử lý...', 'lx-landing')); ?></span>');
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'lx_install_activate_plugin',
                        nonce: '<?php echo wp_create_nonce('lx_plugin_install_all'); ?>',
                        slug: plugin.slug
                    },
                    success: function(response) {
                        if (response.success) {
                            $row.find('.lx-processing-btn').html('<span class="dashicons dashicons-yes"></span> <?php echo esc_js(__('Hoàn tất', 'lx-landing')); ?>').css({'color': '#059669', 'font-weight': '600'});
                            $row.find('.ct-badge').replaceWith('<span class="ct-badge ct-badge--active"><?php echo esc_js(__('Đã kích hoạt', 'lx-landing')); ?></span>');
                            $row.data('status', 'active');
                        } else {
                            $row.find('.lx-processing-btn').html('<span class="dashicons dashicons-warning"></span> <?php echo esc_js(__('Lỗi', 'lx-landing')); ?>').css({'color': '#dc2626', 'font-weight': '600'});
                            console.error('Lỗi cài đặt plugin ' + plugin.slug + ':', response.data);
                        }
                    },
                    error: function() {
                        $row.find('.lx-processing-btn').html('<span class="dashicons dashicons-warning"></span> <?php echo esc_js(__('Lỗi kết nối', 'lx-landing')); ?>').css({'color': '#dc2626', 'font-weight': '600'});
                    },
                    complete: function() {
                        currentIndex++;
                        processNextPlugin();
                    }
                });
            }
            
            processNextPlugin();
        });
    });
    </script>
<?php
}

/**
 * AJAX handler to install and activate a single plugin.
 */
function lx_ajax_install_activate_plugin() {
    check_ajax_referer('lx_plugin_install_all', 'nonce');

    if (!current_user_can('install_plugins')) {
        wp_send_json_error(__('Bạn không có quyền thực hiện hành động này.', 'lx-landing'));
    }

    $slug = isset($_POST['slug']) ? sanitize_text_field($_POST['slug']) : '';
    if (empty($slug)) {
        wp_send_json_error(__('Thiếu slug plugin.', 'lx-landing'));
    }

    require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';

    // Get plugin file if already installed
    $plugin_file = false;
    $all_plugins = get_plugins();
    foreach ($all_plugins as $file => $data) {
        if (strpos($file, $slug . '/') === 0 || $file === $slug . '.php') {
            $plugin_file = $file;
            break;
        }
    }

    // Install if not installed
    if (!$plugin_file) {
        $api = plugins_api('plugin_information', array(
            'slug' => $slug,
            'fields' => array('sections' => false)
        ));

        if (is_wp_error($api)) {
            wp_send_json_error($api->get_error_message());
        }

        // Initialize Filesystem
        if (!WP_Filesystem()) {
            wp_send_json_error(__('Không thể khởi tạo Filesystem.', 'lx-landing'));
        }

        ob_start();
        $skin = new Automatic_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader($skin);
        $result = $upgrader->install($api->download_link);
        $output = ob_get_clean();

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } elseif ($result === false) {
            wp_send_json_error(__('Lỗi khi cài đặt plugin.', 'lx-landing'));
        }

        // Search for the plugin file again
        wp_cache_delete('plugins', 'plugins');
        $all_plugins = get_plugins();
        foreach ($all_plugins as $file => $data) {
            if (strpos($file, $slug . '/') === 0 || $file === $slug . '.php') {
                $plugin_file = $file;
                break;
            }
        }
    }

    // Activate plugin
    if ($plugin_file) {
        if (!is_plugin_active($plugin_file)) {
            $activate = activate_plugin($plugin_file);
            if (is_wp_error($activate)) {
                wp_send_json_error(__('Đã cài đặt nhưng lỗi khi kích hoạt: ', 'lx-landing') . $activate->get_error_message());
            }
        }
        wp_send_json_success(__('Đã cài đặt và kích hoạt thành công!', 'lx-landing'));
    }

    wp_send_json_error(__('Không tìm thấy file plugin sau khi cài đặt.', 'lx-landing'));
}
add_action('wp_ajax_lx_install_activate_plugin', 'lx_ajax_install_activate_plugin');
