<?php

/**
 * Website Security Checklist
 * 
 * Provides a checklist of security hardening measures that can be toggled.
 * 
 * @package lx-landing
 */

/**
 * Register security settings.
 */
function lx_security_register_settings()
{
    register_setting('lx_security_group', 'lx_security_options', [
        'type' => 'array',
        'default' => [],
    ]);
}
add_action('admin_init', 'lx_security_register_settings');

/**
 * Add security settings page to the menu.
 */
function lx_security_add_menu()
{
    add_options_page(
        __('Bảo mật website', 'lx-landing'),
        __('Bảo mật website', 'lx-landing'),
        'manage_options',
        'lx-security',
        'lx_render_security_page'
    );
}
add_action('admin_menu', 'lx_security_add_menu');

/**
 * Render the security settings page.
 */
function lx_render_security_page()
{
    $options = get_option('lx_security_options', []);
    if (!is_array($options)) $options = [];

    $checklist = [
        'hide_wp_version' => [
            'label' => __('Ẩn phiên bản WordPress', 'lx-landing'),
            'desc'  => __('Loại bỏ thông tin phiên bản WordPress trong mã nguồn (head, scripts, RSS) để tránh bị tin tặc dò tìm lỗ hổng.', 'lx-landing')
        ],
        'disable_auto_updates' => [
            'label' => __('Tắt tự động cập nhật', 'lx-landing'),
            'desc'  => __('Ngăn chặn WordPress tự động cập nhật phiên bản Core và Plugins để tránh xung đột mã nguồn đột ngột.', 'lx-landing')
        ],
        'disallow_file_mods' => [
            'label' => __('Chế độ Read-Only (Lock Files)', 'lx-landing'),
            'desc'  => __('<strong>Nghiêm ngặt:</strong> Vô hiệu hóa việc cài đặt, cập nhật, xóa Plugin/Theme và chỉnh sửa file trực tiếp. Thích hợp khi đã hoàn tất deploy.', 'lx-landing'),
            'warning' => true
        ],
        'cleanup_head' => [
            'label' => __('Dọn dẹp Header (RSD, WLW, Generator)', 'lx-landing'),
            'desc'  => __('Loại bỏ các liên kết không cần thiết như RSD, WLW Manifest và Shortlink giúp website sạch sẽ và bảo mật hơn.', 'lx-landing')
        ],
        'disable_emoji' => [
            'label' => __('Tắt Emoji', 'lx-landing'),
            'desc'  => __('Vô hiệu hóa các scripts và styles phục vụ Emoji giúp tăng tốc website và giảm thiểu rủi ro.', 'lx-landing')
        ],
        'hide_login_logo' => [
            'label' => __('Ẩn Logo WordPress trang đăng nhập', 'lx-landing'),
            'desc'  => __('Ẩn logo WordPress mặc định tại trang wp-login.php để tăng tính chuyên nghiệp và giảm nhận diện WP.', 'lx-landing')
        ],
        'remove_admin_bar_logo' => [
            'label' => __('Ẩn Logo WordPress thanh công cụ', 'lx-landing'),
            'desc'  => __('Xóa logo WordPress ở góc trên bên trái của thanh Admin Bar.', 'lx-landing')
        ],
        'disable_wp_cron' => [
            'label' => __('Tắt WP Cron (Virtual Cron)', 'lx-landing'),
            'desc'  => __('Vô hiệu hóa cơ chế cron mặc định của WP. Bạn nên cài đặt System Cron (Crontab) trên server sau khi bật tùy chọn này.', 'lx-landing')
        ],
        'hide_login_errors' => [
            'label' => __('Ẩn thông báo lỗi đăng nhập cụ thể', 'lx-landing'),
            'desc'  => __('Chỉ hiển thị thông báo lỗi chung chung khi đăng nhập sai, không tiết lộ tên user tồn tại hay không.', 'lx-landing')
        ],
        'disable_lost_password' => [
            'label' => __('Tắt chức năng Quên mật khẩu', 'lx-landing'),
            'desc'  => __('Ẩn liên kết "Lost your password?" và vô hiệu hóa tính năng reset mật khẩu tự động.', 'lx-landing')
        ],
        'limit_upload_size' => [
            'label' => __('Giới hạn dung lượng tải lên 2MB', 'lx-landing'),
            'desc'  => __('Giới hạn kích thước file tối đa khi tải lên là 2MB. Nếu không bật, giới hạn mặc định là 50MB để bảo vệ dung lượng lưu trữ.', 'lx-landing')
        ],
        'limit_cookie_expiration' => [
            'label' => __('Giới hạn thời gian đăng nhập lại', 'lx-landing'),
            'desc'  => __('<strong>Bảo mật cao:</strong> Giảm thời gian duy trì phiên đăng nhập. Không chọn "Nhớ mật khẩu" tối đa 1 ngày (mặc định 48 giờ). Có chọn "Nhớ mật khẩu" tối đa 5 ngày (mặc định 14 ngày). Tránh rủi ro bị cướp session khi dùng Wifi công cộng.', 'lx-landing'),
            'warning' => true
        ],
    ];
?>
    <style>
        .lx-security-wrap { max-width: 1000px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        .lx-page-title { font-size: 23px; font-weight: 600; color: #1d2327; margin-bottom: 24px !important; }
        .lx-page-title .dashicons { font-size: 26px; width: 26px; height: 26px; color: #d63638; margin-right: 10px; vertical-align: middle; }
        
        .lx-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,.05); padding: 24px; margin-bottom: 24px; }
        .lx-card-title { margin: 0 0 16px; font-size: 16px; font-weight: 600; color: #1d2327; border-bottom: 1px solid #f0f0f1; padding-bottom: 12px; }
        
        .lx-security-list { list-style: none; margin: 0; padding: 0; }
        .lx-security-item { 
            display: flex; 
            align-items: flex-start; 
            padding: 16px 0; 
            border-bottom: 1px solid #f0f0f1;
        }
        .lx-security-item:last-child { border-bottom: none; }
        
        .lx-toggle-wrap { margin-right: 16px; padding-top: 2px; }
        
        /* Modern Switch Style */
        .lx-switch { position: relative; display: inline-block; width: 44px; height: 22px; }
        .lx-switch input { opacity: 0; width: 0; height: 0; }
        .lx-slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1; transition: .4s; border-radius: 34px;
        }
        .lx-slider:before {
            position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px;
            background-color: white; transition: .4s; border-radius: 50%;
        }
        input:checked + .lx-slider { background-color: #d63638; }
        input:focus + .lx-slider { box-shadow: 0 0 1px #d63638; }
        input:checked + .lx-slider:before { transform: translateX(22px); }

        .lx-item-content { flex: 1; }
        .lx-item-label { display: block; font-weight: 600; color: #1e293b; margin-bottom: 4px; cursor: pointer; }
        .lx-item-desc { font-size: 13px; color: #64748b; line-height: 1.5; }

        .lx-submit-btn {
            background: #d63638;
            color: #fff;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .lx-submit-btn:hover { background: #b32d2e; }
        
        .lx-security-wrap .notice { display: block !important; clear: both !important; width: auto !important; margin: 15px 0 !important; }
    </style>

    <div class="wrap lx-security-wrap">
        <h1 class="lx-page-title">
            <span class="dashicons dashicons-shield-alt"></span>
            <?php echo __('Cấu hình Bảo mật website', 'lx-landing'); ?>
        </h1>

        <div class="lx-card">
            <p style="margin-top: 0; color: #475569; padding-bottom: 12px; border-bottom: 1px solid #f0f0f1;">
                <?php echo __('Kích hoạt các biện pháp bảo mật bên dưới để tối ưu hóa và bảo vệ website của bạn trước các cuộc tấn công phổ biến.', 'lx-landing'); ?>
                <br><span style="color: #64748b; font-size: 12px;"><?php echo __('Lưu ý: Các tính năng nâng cao khác đã được quản lý bởi WP Cerber.', 'lx-landing'); ?></span>
            </p>
            
            <form method="post" action="options.php">
                <?php settings_fields('lx_security_group'); ?>
                
                <ul class="lx-security-list">
                    <?php foreach ($checklist as $key => $item) : ?>
                        <li class="lx-security-item">
                            <div class="lx-toggle-wrap">
                                <label class="lx-switch">
                                    <input type="checkbox" name="lx_security_options[<?php echo $key; ?>]" value="1" <?php checked(isset($options[$key]) && $options[$key] == '1'); ?>>
                                    <span class="lx-slider"></span>
                                </label>
                            </div>
                            <div class="lx-item-content">
                                <label class="lx-item-label" for="lx_security_options[<?php echo $key; ?>]">
                                    <?php echo $item['label']; ?>
                                    <?php if (isset($item['warning']) && $item['warning']) : ?>
                                        <span style="color: #d63638; font-size: 10px; text-transform: uppercase; background: #fecaca; padding: 2px 6px; border-radius: 10px; margin-left: 8px; vertical-align: middle;"><?php echo __('Bảo mật cao', 'lx-landing'); ?></span>
                                    <?php endif; ?>
                                </label>
                                <div class="lx-item-desc"><?php echo $item['desc']; ?></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #f0f0f1; display: flex; gap: 12px; align-items: center;">
                    <?php submit_button(__('Lưu cài đặt', 'lx-landing'), 'primary', 'submit', false, array('class' => 'lx-submit-btn')); ?>
                    <button type="button" id="lx-enable-all-btn" class="button button-secondary" style="display: inline-flex; align-items: center; padding: 6px 14px;">
                        <span class="dashicons dashicons-yes" style="margin-right: 4px;"></span> <?php echo __('Bật tất cả (Thường)', 'lx-landing'); ?>
                    </button>
                    <button type="button" id="lx-disable-all-btn" class="button button-secondary" style="display: inline-flex; align-items: center; padding: 6px 14px;">
                        <span class="dashicons dashicons-no-alt" style="margin-right: 4px;"></span> <?php echo __('Tắt tất cả (Thường)', 'lx-landing'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var normalSecurityKeys = [
            <?php 
            foreach ($checklist as $key => $item) {
                if (empty($item['warning'])) {
                    echo "'" . esc_js($key) . "', ";
                }
            }
            ?>
        ];
        
        $('#lx-enable-all-btn').on('click', function() {
            normalSecurityKeys.forEach(function(key) {
                $('input[name="lx_security_options[' + key + ']"]').prop('checked', true);
            });
        });
        
        $('#lx-disable-all-btn').on('click', function() {
            normalSecurityKeys.forEach(function(key) {
                $('input[name="lx_security_options[' + key + ']"]').prop('checked', false);
            });
        });
    });
    </script>
<?php
}

/**
 * Apply security hardening measures based on settings.
 */
function lx_apply_security_hardening()
{
    $options = get_option('lx_security_options', []);
    if (!is_array($options)) return;

    // 1. Hide WP Version
    if (isset($options['hide_wp_version']) && $options['hide_wp_version'] == '1') {
        remove_action('wp_head', 'wp_generator');
        add_filter('the_generator', '__return_empty_string');
        
        // Remove version from scripts and styles
        $remove_ver = function($src) {
            if (strpos($src, 'ver=')) {
                $src = remove_query_arg('ver', $src);
            }
            return $src;
        };
        add_filter('style_loader_src', $remove_ver, 9999);
        add_filter('script_loader_src', $remove_ver, 9999);
    }

    // 2. Disable Auto Updates
    if (isset($options['disable_auto_updates']) && $options['disable_auto_updates'] == '1') {
        add_filter('auto_update_core', '__return_false');
        add_filter('auto_update_plugin', '__return_false');
        add_filter('auto_update_theme', '__return_false');
        add_filter('automatic_updater_disabled', '__return_true');
    }

    // 10. Disallow File Mods (Strict Mode)
    if (isset($options['disallow_file_mods']) && $options['disallow_file_mods'] == '1') {
        if (!defined('DISALLOW_FILE_MODS')) {
            define('DISALLOW_FILE_MODS', true);
        }
    }

    // 3. Cleanup Head
    if (isset($options['cleanup_head']) && $options['cleanup_head'] == '1') {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
    }

    // 4. Disable Emoji
    if (isset($options['disable_emoji']) && $options['disable_emoji'] == '1') {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', function($plugins) {
            if (is_array($plugins)) {
                return array_diff($plugins, array('wpemoji'));
            }
            return array();
        });
        add_filter('wp_resource_hints', function($urls, $relation_type) {
            if ('dns-prefetch' === $relation_type) {
                $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/14.0.0/svg/');
                $urls = array_diff($urls, array($emoji_svg_url));
            }
            return $urls;
        }, 10, 2);
    }

    // 5. Hide Login Logo
    if (isset($options['hide_login_logo']) && $options['hide_login_logo'] == '1') {
        add_action('login_enqueue_scripts', function() {
            echo '<style type="text/css">.login h1 a { display: none !important; }</style>';
        });
    }

    // 6. Remove Admin Bar Logo
    if (isset($options['remove_admin_bar_logo']) && $options['remove_admin_bar_logo'] == '1') {
        add_action('admin_bar_menu', function($wp_admin_bar) {
            $wp_admin_bar->remove_node('wp-logo');
        }, 999);
    }

    // 7. Disable WP Cron
    if (isset($options['disable_wp_cron']) && $options['disable_wp_cron'] == '1') {
        if (!defined('DISABLE_WP_CRON')) {
            define('DISABLE_WP_CRON', true);
        }
    }

    // 8. Hide Login Errors
    if (isset($options['hide_login_errors']) && $options['hide_login_errors'] == '1') {
        add_filter('login_errors', function() {
            return __('Thông tin tài khoản không chính xác.', 'lx-landing');
        });
    }

    // 9. Disable Lost Password
    if (isset($options['disable_lost_password']) && $options['disable_lost_password'] == '1') {
        add_filter('allow_password_reset', '__return_false');
        add_action('login_enqueue_scripts', function() {
            echo '<style type="text/css">#nav { display: none !important; }</style>';
        });
    }

    // 11. Limit Upload Size
    add_filter('upload_size_limit', function($size) use ($options) {
        if (isset($options['limit_upload_size']) && $options['limit_upload_size'] == '1') {
            return 2 * 1024 * 1024; // 2MB
        }
        return 50 * 1024 * 1024; // 50MB
    }, 999);

    // 12. Limit Cookie Expiration
    if (isset($options['limit_cookie_expiration']) && $options['limit_cookie_expiration'] == '1') {
        add_filter('auth_cookie_expiration', function($length, $user_id, $remember) {
            if ($remember) {
                return 5 * DAY_IN_SECONDS; // 5 days
            }
            return DAY_IN_SECONDS; // 1 day (24 hours)
        }, 999, 3);
    }
}
add_action('init', 'lx_apply_security_hardening');

/**
 * Set default security options on theme activation.
 */
function lx_security_set_defaults()
{
    $options = get_option('lx_security_options');
    if (empty($options)) {
        $defaults = [
            'hide_wp_version'       => '1',
            'disable_auto_updates'  => '1',
            'cleanup_head'          => '1',
            'disable_emoji'         => '1',
            'hide_login_logo'       => '1',
            'remove_admin_bar_logo' => '1',
            'disable_wp_cron'       => '1',
            'hide_login_errors'     => '1',
            'disable_lost_password' => '1',
            'limit_upload_size'       => '1',
            'limit_cookie_expiration' => '0', // Keep this off by default
            'disallow_file_mods'      => '0', // Keep this off by default
        ];
        update_option('lx_security_options', $defaults);
    }
}
add_action('after_switch_theme', 'lx_security_set_defaults');
