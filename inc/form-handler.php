<?php
/**
 * Contact Form 7 Sync Logic
 * Automatically creates/updates CF7 forms from LX Form posts.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sync LX Form to Contact Form 7 on save.
 */
function lx_sync_to_cf7($post_id) {
    // Check if it's a numeric ID (sometimes acf/save_post passes strings)
    if (!is_numeric($post_id)) {
        return;
    }

    // Only handle lx_form post type and only when published
    if (get_post_type($post_id) !== 'lx_form' || get_post_status($post_id) !== 'publish') {
        return;
    }

    $post_title = get_the_title($post_id);
    $custom_title = get_field('lx_form_custom_title', $post_id);
    $form_display_title = !empty($custom_title) ? $custom_title : $post_title;

    $fields = get_field('lx_form_fields', $post_id);
    $description = get_field('lx_form_description', $post_id);
    $submit_text = get_field('lx_form_submit_text', $post_id) ?: 'Nhận tư vấn ngay';

    // ── Generate CF7 HTML ──────────────────────────────────────────────────
    $cf7_content = '<div class="lx_form_ctf7">' . "\n";
    $cf7_content .= '    <h3 class="lx_form_title">' . esc_html($form_display_title) . '</h3>' . "\n\n";

    if ($fields) {
        foreach ($fields as $index => $field) {
            $label = mb_strtoupper($field['label'], 'UTF-8');
            $type = $field['type'];
            $placeholder = $field['placeholder'];
            $required = $field['required'] ? '*' : '';
            $name = 'lx_field_' . sanitize_title($field['label']);

            $cf7_content .= '    <label> ' . esc_html($label) . ($field['required'] ? ' <span class="required">*</span>' : '') . "\n";

            switch ($type) {
                case 'textarea':
                    $cf7_content .= '        [textarea' . $required . ' ' . $name . ' placeholder "' . esc_attr($placeholder) . '"]' . "\n";
                    break;
                case 'select':
                    $options_arr = explode("\n", str_replace("\r", "", $field['options'] ?? ''));
                    $options_str = '"' . esc_attr($placeholder) . '"'; // First option as label
                    foreach ($options_arr as $opt) {
                        $opt = trim($opt);
                        if (!empty($opt)) {
                            $options_str .= ' "' . esc_attr($opt) . '"';
                        }
                    }
                    $cf7_content .= '        [select' . $required . ' ' . $name . ' first_as_label ' . $options_str . ']' . "\n";
                    break;
                case 'tel':
                    $cf7_content .= '        [tel' . $required . ' ' . $name . ' placeholder "' . esc_attr($placeholder) . '"]' . "\n";
                    break;
                case 'email':
                    $cf7_content .= '        [email' . $required . ' ' . $name . ' placeholder "' . esc_attr($placeholder) . '"]' . "\n";
                    break;
                default:
                    $cf7_content .= '        [text' . $required . ' ' . $name . ' placeholder "' . esc_attr($placeholder) . '"]' . "\n";
                    break;
            }
            $cf7_content .= '    </label>' . "\n\n";
        }
    }

    if (!empty($description)) {
        $cf7_content .= '    <p class="lx_form_note">' . nl2br(esc_html($description)) . '</p>' . "\n\n";
    }

    $cf7_content .= '    [submit "' . esc_attr($submit_text) . '"]' . "\n\n";
    $cf7_content .= '    [response]' . "\n";
    $cf7_content .= '</div>';

    // ── Create or Update CF7 ───────────────────────────────────────────────
    $linked_cf7_id = get_post_meta($post_id, 'lx_linked_cf7_id', true);
    
    $cf7_post_data = [
        'post_title'   => '[LX Sync] ' . $form_display_title,
        'post_content' => $cf7_content,
        'post_status'  => 'publish',
        'post_type'    => 'wpcf7_contact_form',
    ];

    if ($linked_cf7_id && get_post($linked_cf7_id)) {
        $cf7_post_data['ID'] = $linked_cf7_id;
        wp_update_post($cf7_post_data);
        update_post_meta($linked_cf7_id, '_form', $cf7_content);
    } else {
        $new_cf7_id = wp_insert_post($cf7_post_data);
        update_post_meta($post_id, 'lx_linked_cf7_id', $new_cf7_id);
        update_post_meta($new_cf7_id, '_form', $cf7_content);
    }
}
add_action('acf/save_post', 'lx_sync_to_cf7', 20);

/**
 * Add linked CF7 ID to LX Form list columns.
 */
function lx_add_cf7_column($columns) {
    $columns['cf7_shortcode'] = 'CF7 Shortcode';
    return $columns;
}
add_filter('manage_lx_form_posts_columns', 'lx_add_cf7_column');

function lx_display_cf7_column($column, $post_id) {
    if ($column === 'cf7_shortcode') {
        $cf7_id = get_post_meta($post_id, 'lx_linked_cf7_id', true);
        if ($cf7_id) {
            echo '<code>[contact-form-7 id="' . $cf7_id . '"]</code>';
        } else {
            echo '<em>Chưa tạo</em>';
        }
    }
}
add_action('manage_lx_form_posts_custom_column', 'lx_display_cf7_column', 10, 2);

/**
 * Add Meta Box to LX Form edit screen for quick access to CF7.
 */
function lx_add_form_meta_box() {
    add_meta_box(
        'lx_form_cf7_link',
        'Liên kết Contact Form 7',
        'lx_render_form_meta_box',
        'lx_form',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'lx_add_form_meta_box');

function lx_render_form_meta_box($post) {
    $cf7_id = get_post_meta($post->ID, 'lx_linked_cf7_id', true);
    
    if ($cf7_id && get_post($cf7_id)) {
        $edit_url = admin_url('admin.php?page=wpcf7&post=' . $cf7_id . '&active-tab=mail-panel');
        echo '<p>Form này đã được đồng bộ với CF7.</p>';
        echo '<p><strong>ID:</strong> <code>' . $cf7_id . '</code></p>';
        echo '<p><strong>Shortcode:</strong><br><input type="text" readonly value=\'[contact-form-7 id="' . $cf7_id . '"]\' style="width:100%; font-family:monospace; font-size:11px;"></p>';
        echo '<hr>';
        echo '<a href="' . esc_url($edit_url) . '" class="button button-primary" target="_blank" style="width:100%; text-align:center;">Cấu hình Mail & Thông báo →</a>';
        echo '<p class="description" style="margin-top:10px;">Nhấn vào đây để sang CF7 chỉnh sửa nội dung Email gửi về hoặc Lời nhắn thành công.</p>';
    } else {
        echo '<p>Chưa có form CF7 nào được tạo. Hãy nhấn <strong>Cập nhật</strong> để hệ thống tự động sinh form.</p>';
    }
}
