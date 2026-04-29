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

/**
 * Register LX Form Builder Fields.
 */
add_action('acf/init', function() {
    acf_add_local_field_group([
        'key' => 'group_lx_form_builder',
        'title' => 'Cấu hình Form',
        'fields' => [
            [
                'key' => 'field_lx_form_custom_title',
                'label' => 'Tiêu đề hiển thị trên Form',
                'name' => 'lx_form_custom_title',
                'type' => 'text',
                'placeholder' => 'Ví dụ: Nhận tư vấn 1 - 1 Miễn phí',
            ],
            [
                'key' => 'field_lx_form_description',
                'label' => 'Ghi chú dưới form',
                'name' => 'lx_form_description',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key' => 'field_lx_form_submit_text',
                'label' => 'Chữ trên nút gửi',
                'name' => 'lx_form_submit_text',
                'type' => 'text',
                'default_value' => 'Nhận tư vấn ngay',
            ],
            [
                'key' => 'field_lx_form_fields',
                'label' => 'Danh sách các trường',
                'name' => 'lx_form_fields',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Thêm trường mới',
                'sub_fields' => [
                    [
                        'key' => 'field_lx_field_label',
                        'label' => 'Nhãn trường (Label)',
                        'name' => 'label',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_lx_field_type',
                        'label' => 'Loại trường',
                        'name' => 'type',
                        'type' => 'select',
                        'choices' => [
                            'text' => 'Văn bản (Text)',
                            'tel' => 'Số điện thoại (Tel)',
                            'email' => 'Email',
                            'select' => 'Danh sách thả (Select)',
                            'textarea' => 'Đoạn văn (Textarea)',
                        ],
                        'default_value' => 'text',
                    ],
                    [
                        'key' => 'field_lx_field_placeholder',
                        'label' => 'Gợi ý (Placeholder)',
                        'name' => 'placeholder',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_lx_field_required',
                        'label' => 'Bắt buộc?',
                        'name' => 'required',
                        'type' => 'true_false',
                        'ui' => 1,
                    ],
                    [
                        'key' => 'field_lx_field_width',
                        'label' => 'Độ rộng',
                        'name' => 'width',
                        'type' => 'select',
                        'choices' => [
                            '12' => '12 Cột (Đầy đủ)',
                            '6' => '6 Cột (Một nửa)',
                        ],
                        'default_value' => '12',
                    ],
                    [
                        'key' => 'field_lx_field_options',
                        'label' => 'Các tùy chọn (Mỗi dòng một mục)',
                        'name' => 'options',
                        'type' => 'textarea',
                        'conditional_logic' => [
                            [
                                [
                                    'field' => 'field_lx_field_type',
                                    'operator' => '==',
                                    'value' => 'select',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_lx_form_enable_recaptcha',
                'label' => 'Sử dụng reCAPTCHA?',
                'name' => 'lx_form_enable_recaptcha',
                'type' => 'true_false',
                'instructions' => 'Yêu cầu bạn đã cấu hình Integration trong Contact Form 7.',
                'ui' => 1,
                'default_value' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lx_form',
                ],
            ],
        ],
    ]);
});
