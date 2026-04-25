<?php

/**
 * Custom Code Management
 * 
 * Allows embedding custom scripts in header, body, and footer.
 * 
 * @package lx-theme
 */

/**
 * Register settings for custom code.
 */
function lx_custom_code_register_settings()
{
    register_setting('lx_custom_code_group', 'lx_header_code');
    register_setting('lx_custom_code_group', 'lx_body_code');
    register_setting('lx_custom_code_group', 'lx_footer_code');
}
add_action('admin_init', 'lx_custom_code_register_settings');

/**
 * Add settings page to the menu.
 */
function lx_custom_code_add_menu()
{
    add_options_page(
        __('Chèn Code tùy chỉnh', 'lx-theme'),
        __('Chèn Code tùy chỉnh', 'lx-theme'),
        'manage_options',
        'lx-custom-code',
        'lx_render_custom_code_page'
    );
}
add_action('admin_menu', 'lx_custom_code_add_menu');

/**
 * Render the settings page.
 */
function lx_render_custom_code_page()
{
?>
    <style>
        .lx-code-wrap { max-width: 1000px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        .lx-page-title { font-size: 23px; font-weight: 600; color: #1d2327; margin-bottom: 24px !important; }
        .lx-page-title .dashicons { font-size: 26px; width: 26px; height: 26px; color: #2271b1; margin-right: 10px; vertical-align: middle; }
        
        .lx-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,.05); padding: 24px; margin-bottom: 24px; clear: both; }
        .lx-card-title { margin: 0 0 16px; font-size: 16px; font-weight: 600; color: #1d2327; border-bottom: 1px solid #f0f0f1; padding-bottom: 12px; }
        .lx-field-group { margin-bottom: 24px; }
        .lx-field-label { display: block; font-weight: 600; margin-bottom: 8px; color: #1d2327; }
        .lx-field-desc { font-size: 13px; color: #64748b; margin-bottom: 12px; line-height: 1.5; }
        
        .lx-textarea { 
            width: 100%; 
            height: 180px; 
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; 
            font-size: 13px; 
            padding: 12px; 
            border: 1px solid #d1d5db; 
            border-radius: 4px; 
            background: #f9fafb; 
            color: #1f2937;
            resize: vertical;
        }
        .lx-textarea:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; outline: none; }
        
        .lx-submit-btn {
            background: #2271b1;
            color: #fff;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .lx-submit-btn:hover { background: #135e96; }
        
        /* Force notices to be full width and stacked */
        .lx-code-wrap .notice { display: block !important; clear: both !important; width: auto !important; margin: 15px 0 !important; }
    </style>

    <div class="wrap lx-code-wrap">
        <h1 class="lx-page-title">
            <span class="dashicons dashicons-code-standards"></span>
            <?php echo __('Cấu hình Code tùy chỉnh', 'lx-theme'); ?>
        </h1>

        <div class="lx-card">
            <p style="margin-top: 0; color: #475569;"><?php echo __('Sử dụng tính năng này để nhúng các đoạn mã script (GTM, Analytics, Pixel,...) vào website của bạn một cách an toàn.', 'lx-theme'); ?></p>
            
            <form method="post" action="options.php">
                <?php settings_fields('lx_custom_code_group'); ?>
                
                <div class="lx_field_group">
                    <label class="lx-field-label"><?php echo __('Header Code (wp_head)', 'lx-theme'); ?></label>
                    <div class="lx-field-desc"><?php echo __('Chèn vào trước thẻ đóng <code>&lt;/head&gt;</code>. Thường dùng cho Google Tag Manager, CSS tùy chỉnh.', 'lx-theme'); ?></div>
                    <textarea name="lx_header_code" class="lx-textarea"><?php echo esc_textarea(get_option('lx_header_code')); ?></textarea>
                </div>

                <div class="lx_field_group" style="margin-top: 24px;">
                    <label class="lx-field-label"><?php echo __('Body Opening Code (wp_body_open)', 'lx-theme'); ?></label>
                    <div class="lx-field-desc"><?php echo __('Chèn ngay sau thẻ mở <code>&lt;body&gt;</code>. Thường dùng cho mãnoscript của Google Tag Manager.', 'lx-theme'); ?></div>
                    <textarea name="lx_body_code" class="lx-textarea"><?php echo esc_textarea(get_option('lx_body_code')); ?></textarea>
                </div>

                <div class="lx_field_group" style="margin-top: 24px;">
                    <label class="lx-field-label"><?php echo __('Footer Code (wp_footer)', 'lx-theme'); ?></label>
                    <div class="lx-field-desc"><?php echo __('Chèn vào trước thẻ đóng <code>&lt;/body&gt;</code>. Thường dùng cho mã Chat, Pixel hoặc JS tùy chỉnh.', 'lx-theme'); ?></div>
                    <textarea name="lx_footer_code" class="lx-textarea"><?php echo esc_textarea(get_option('lx_footer_code')); ?></textarea>
                </div>

                <div style="margin-top: 32px; border-top: 1px solid #f0f0f1; pt-4">
                    <br>
                    <?php submit_button(__('Lưu cài đặt', 'lx-theme'), 'primary', 'submit', false, array('class' => 'lx-submit-btn')); ?>
                </div>
            </form>
        </div>
    </div>
<?php
}

/**
 * Output header code.
 */
function lx_output_header_code()
{
    $code = get_option('lx_header_code');
    if ($code) {
        echo "<!-- Theme Custom Header Code -->\n";
        echo $code . "\n";
    }
}
add_action('wp_head', 'lx_output_header_code', 100);

/**
 * Output body open code.
 */
function lx_output_body_code()
{
    $code = get_option('lx_body_code');
    if ($code) {
        echo "<!-- Theme Custom Body Code -->\n";
        echo $code . "\n";
    }
}
add_action('wp_body_open', 'lx_output_body_code', 100);

/**
 * Output footer code.
 */
function lx_output_footer_code()
{
    $code = get_option('lx_footer_code');
    if ($code) {
        echo "<!-- Theme Custom Footer Code -->\n";
        echo $code . "\n";
    }
}
add_action('wp_footer', 'lx_output_footer_code', 100);
