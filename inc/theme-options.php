<?php

/**
 * Theme Options Management
 *
 * Provides an ACF Options Page for global theme settings
 * like fonts and colors.
 *
 * @package Child_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title'    => __('Theme Settings', 'lx-landing'),
        'menu_title'    => __('Theme Settings', 'lx-landing'),
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_theme_options',
        'redirect'      => false,
        'icon_url'      => 'dashicons-admin-customizer',
        'position'      => 60,
    ]);
}

/**
 * Register ACF Field Group for Theme Settings
 */
add_action('acf/init', 'lx_register_theme_options_fields');
function lx_register_theme_options_fields()
{
    if (function_exists('acf_add_local_field_group')) {

        acf_add_local_field_group([
            'key' => 'group_lx_theme_options',
            'title' => __('Cài đặt Giao diện (Theme Options)', 'lx-landing'),
            'fields' => [
                // Tab: Typography
                [
                    'key' => 'field_lx_tab_typography',
                    'label' => __('Typography', 'lx-landing'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key'           => 'field_lx_primary_font',
                    'label'         => __('Font chữ chủ đạo (Google Fonts)', 'lx-landing'),
                    'name'          => 'lx_primary_font',
                    'type'          => 'select',
                    'instructions'  => __('Tìm kiếm và chọn bất kỳ font nào từ Google Fonts (~1500+ fonts).', 'lx-landing'),
                    'choices'       => [],
                    'default_value' => 'Inter',
                    'allow_null'    => 0,
                    'multiple'      => 0,
                    'ui'            => 1,
                    'ajax'          => 0,
                    'return_format' => 'value',
                ],

                // Tab: Colors
                [
                    'key' => 'field_lx_tab_colors',
                    'label' => __('Màu sắc', 'lx-landing'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key'            => 'field_lx_primary_color',
                    'label'          => __('Màu chủ đạo (Primary Color)', 'lx-landing'),
                    'name'           => 'lx_primary_color',
                    'type'           => 'color_picker',
                    'default_value'  => '#0d6efd',
                    'enable_opacity' => 0,
                    'return_format'  => 'string',
                ],
                [
                    'key'            => 'field_lx_secondary_color',
                    'label'          => __('Màu phụ (Secondary Color)', 'lx-landing'),
                    'name'           => 'lx_secondary_color',
                    'type'           => 'color_picker',
                    'default_value'  => '#fd7c00',
                    'enable_opacity' => 0,
                    'return_format'  => 'string',
                ],

                // Tab: Buttons
                [
                    'key' => 'field_lx_tab_buttons',
                    'label' => __('Nút (Buttons)', 'lx-landing'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key' => 'field_lx_btn_font_size',
                    'label' => __('Cỡ chữ của nút (px)', 'lx-landing'),
                    'name' => 'lx_btn_font_size',
                    'type' => 'number',
                    'default_value' => 16,
                    'append' => 'px',
                ],
                [
                    'key' => 'field_lx_btn_font_weight',
                    'label' => __('Độ đậm của chữ', 'lx-landing'),
                    'name' => 'lx_btn_font_weight',
                    'type' => 'select',
                    'choices' => [
                        '400' => '400 - Normal',
                        '500' => '500 - Medium',
                        '600' => '600 - Semi-Bold',
                        '700' => '700 - Bold',
                    ],
                    'default_value' => '500',
                ],
                [
                    'key' => 'field_lx_btn_padding_y',
                    'label' => __('Khoảng cách Trên/Dưới (px)', 'lx-landing'),
                    'name' => 'lx_btn_padding_y',
                    'type' => 'number',
                    'default_value' => 12,
                    'append' => 'px',
                ],
                [
                    'key' => 'field_lx_btn_padding_x',
                    'label' => __('Khoảng cách Trái/Phải (px)', 'lx-landing'),
                    'name' => 'lx_btn_padding_x',
                    'type' => 'number',
                    'default_value' => 24,
                    'append' => 'px',
                ],
                [
                    'key' => 'field_lx_btn_border_width',
                    'label' => __('Độ dày viền (px)', 'lx-landing'),
                    'name' => 'lx_btn_border_width',
                    'type' => 'number',
                    'default_value' => 1,
                    'append' => 'px',
                ],
                [
                    'key' => 'field_lx_btn_border_radius',
                    'label' => __('Độ bo góc (px)', 'lx-landing'),
                    'name' => 'lx_btn_border_radius',
                    'type' => 'number',
                    'default_value' => 4,
                    'append' => 'px',
                ],
                [
                    'key' => 'field_lx_btn_bg_color',
                    'label' => __('Màu nền nút (Primary)', 'lx-landing'),
                    'name' => 'lx_btn_bg_color',
                    'type' => 'color_picker',
                    'default_value' => '#0d6efd',
                ],
                [
                    'key' => 'field_lx_btn_border_color',
                    'label' => __('Màu viền nút (Primary)', 'lx-landing'),
                    'name' => 'lx_btn_border_color',
                    'type' => 'color_picker',
                    'default_value' => '#0d6efd',
                ],
                [
                    'key' => 'field_lx_btn_text_color',
                    'label' => __('Màu chữ nút (Primary)', 'lx-landing'),
                    'name' => 'lx_btn_text_color',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                ],
                [
                    'key' => 'field_lx_btn_bg_color_hover',
                    'label' => __('Màu nền nút khi Hover', 'lx-landing'),
                    'name' => 'lx_btn_bg_color_hover',
                    'type' => 'color_picker',
                    'default_value' => '#0056b3',
                ],
                [
                    'key' => 'field_lx_btn_border_color_hover',
                    'label' => __('Màu viền nút khi Hover', 'lx-landing'),
                    'name' => 'lx_btn_border_color_hover',
                    'type' => 'color_picker',
                    'default_value' => '#0056b3',
                ],
                [
                    'key' => 'field_lx_btn_text_color_hover',
                    'label' => __('Màu chữ nút khi Hover', 'lx-landing'),
                    'name' => 'lx_btn_text_color_hover',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                ],




                ],

            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-settings',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ]);
    }
}

/**
 * Inject Dynamic CSS Variables and Google Fonts into <head>
 */
add_action('wp_head', 'lx_inject_theme_options_css', 5);
function lx_inject_theme_options_css()
{
    if (!function_exists('get_field')) {
        return;
    }

    $primary_font    = get_field('lx_primary_font', 'option') ?: 'Inter';
    $primary_color   = get_field('lx_primary_color', 'option') ?: '#0d6efd';
    $secondary_color = get_field('lx_secondary_color', 'option') ?: '#fd7c00';

    // Button Settings
    $btn_font_size     = get_field('lx_btn_font_size', 'option') ?: 15;
    $btn_font_weight   = get_field('lx_btn_font_weight', 'option') ?: '600';
    $btn_padding_y     = get_field('lx_btn_padding_y', 'option') ?: 12;
    $btn_padding_x     = get_field('lx_btn_padding_x', 'option') ?: 24;
    $btn_border_width  = get_field('lx_btn_border_width', 'option') ?: 1;
    $btn_border_radius = get_field('lx_btn_border_radius', 'option') ?: 4;

    // Button Colors
    $btn_bg_color     = get_field('lx_btn_bg_color', 'option') ?: '#0d6efd';
    $btn_border_color = get_field('lx_btn_border_color', 'option') ?: '#0d6efd';
    $btn_text_color   = get_field('lx_btn_text_color', 'option') ?: '#ffffff';

    $btn_bg_hover     = get_field('lx_btn_bg_color_hover', 'option') ?: '#0056b3';
    $btn_border_hover = get_field('lx_btn_border_color_hover', 'option') ?: '#0056b3';
    $btn_text_hover   = get_field('lx_btn_text_color_hover', 'option') ?: '#ffffff';

    // Format font name for Google Fonts URL (replace spaces with +)


    $font_url_param   = str_replace(' ', '+', $primary_font);
    $google_fonts_url = "https://fonts.googleapis.com/css2?family={$font_url_param}:ital,wght@0,400..900;1,400..900&display=swap";

    // Enqueue the font
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link href="' . esc_url($google_fonts_url) . '" rel="stylesheet">' . "\n";

    // Output CSS Custom Properties
    echo '<style id="lx-dynamic-theme-options">' . "\n";
    echo ':root {' . "\n";
    echo '  --lx-primary-color: ' . esc_attr($primary_color) . ';' . "\n";
    echo '  --lx-secondary-color: ' . esc_attr($secondary_color) . ';' . "\n";
    echo '  --lx-primary-font: "' . esc_attr($primary_font) . '", sans-serif;' . "\n";
    
    // Global Button Variables
    echo '  --lx-btn-font-size: ' . esc_attr($btn_font_size) . 'px;' . "\n";
    echo '  --lx-btn-font-weight: ' . esc_attr($btn_font_weight) . ';' . "\n";
    echo '  --lx-btn-padding-y: ' . esc_attr($btn_padding_y) . 'px;' . "\n";
    echo '  --lx-btn-padding-x: ' . esc_attr($btn_padding_x) . 'px;' . "\n";
    echo '  --lx-btn-border-width: ' . esc_attr($btn_border_width) . 'px;' . "\n";
    echo '  --lx-btn-border-radius: ' . esc_attr($btn_border_radius) . 'px;' . "\n";
    echo '  --lx-btn-bg-color: ' . esc_attr($btn_bg_color) . ';' . "\n";
    echo '  --lx-btn-border-color: ' . esc_attr($btn_border_color) . ';' . "\n";
    echo '  --lx-btn-text-color: ' . esc_attr($btn_text_color) . ';' . "\n";
    echo '  --lx-btn-bg-hover: ' . esc_attr($btn_bg_hover) . ';' . "\n";
    echo '  --lx-btn-border-hover: ' . esc_attr($btn_border_hover) . ';' . "\n";
    echo '  --lx-btn-text-hover: ' . esc_attr($btn_text_hover) . ';' . "\n";
    echo '}' . "\n";


    echo '</style>' . "\n";

}

// ── Google Fonts AJAX Support ──────────────────────────────────────────────

/**
 * Fetch the full list of Google Fonts from the public metadata endpoint.
 * Results are cached in a transient for 7 days to avoid repeated HTTP calls.
 *
 * @return array Associative array: ['Font Name' => 'Font Name', ...]
 */
function child_theme_get_google_fonts_list(): array
{
    $transient_key = 'child_theme_google_fonts_list';
    $cached        = get_transient($transient_key);

    if (false !== $cached) {
        return $cached;
    }

    $response = wp_remote_get(
        'https://fonts.google.com/metadata/fonts',
        ['timeout' => 10, 'sslverify' => false]
    );

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        // Fallback: return a minimal list so the field is still usable
        return [
            'Inter'            => 'Inter',
            'Roboto'           => 'Roboto',
            'Open Sans'        => 'Open Sans',
            'Montserrat'       => 'Montserrat',
            'Poppins'          => 'Poppins',
            'Lato'             => 'Lato',
            'Oswald'           => 'Oswald',
            'Raleway'          => 'Raleway',
            'Playfair Display' => 'Playfair Display',
            'Lora'             => 'Lora',
        ];
    }

    $body = wp_remote_retrieve_body($response);

    // Google prepends ")]}'\'\n" as XSSI protection – strip it
    $body  = preg_replace('/^\)\]\}\'\n/', '', $body);
    $data  = json_decode($body, true);
    $fonts = [];

    if (!empty($data['familyMetadataList']) && is_array($data['familyMetadataList'])) {
        foreach ($data['familyMetadataList'] as $family) {
            $name          = $family['family'] ?? '';
            if ($name) {
                $fonts[$name] = $name;
            }
        }
        ksort($fonts);
    }

    if (empty($fonts)) {
        return ['Inter' => 'Inter'];
    }

    set_transient($transient_key, $fonts, 7 * DAY_IN_SECONDS);

    return $fonts;
}

/**
 * Inject the full Google Fonts list into the ACF select field choices
 * before the field is rendered in the admin.
 * The Select2 UI (ui=1) will add a live-search box automatically.
 */
add_filter('acf/load_field/name=lx_primary_font', 'child_theme_acf_load_google_fonts_field');
function child_theme_acf_load_google_fonts_field(array $field): array
{
    $field['choices'] = child_theme_get_google_fonts_list();
    return $field;
}




