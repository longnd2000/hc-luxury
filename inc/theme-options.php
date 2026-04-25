<?php

/**
 * Theme Options Management
 *
 * Provides an ACF Options Page for global theme settings
 * like fonts, colors, and logos.
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
        'page_title'    => __('Theme Settings', 'child-theme'),
        'menu_title'    => __('Theme Settings', 'child-theme'),
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
            'title' => __('Cài đặt Giao diện (Theme Options)', 'child-theme'),
            'fields' => [
                // Tab: Typography
                [
                    'key' => 'field_lx_tab_typography',
                    'label' => __('Typography', 'child-theme'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key'           => 'field_lx_primary_font',
                    'label'         => __('Font chữ chủ đạo (Google Fonts)', 'child-theme'),
                    'name'          => 'lx_primary_font',
                    'type'          => 'select',
                    'instructions'  => __('Tìm kiếm và chọn bất kỳ font nào từ Google Fonts (~1500+ fonts).', 'child-theme'),
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
                    'label' => __('Màu sắc', 'child-theme'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key'            => 'field_lx_primary_color',
                    'label'          => __('Màu chủ đạo (Primary Color)', 'child-theme'),
                    'name'           => 'lx_primary_color',
                    'type'           => 'color_picker',
                    'default_value'  => '#0d6efd',
                    'enable_opacity' => 0,
                    'return_format'  => 'string',
                ],
                [
                    'key'            => 'field_lx_secondary_color',
                    'label'          => __('Màu phụ (Secondary Color)', 'child-theme'),
                    'name'           => 'lx_secondary_color',
                    'type'           => 'color_picker',
                    'default_value'  => '#fd7c00',
                    'enable_opacity' => 0,
                    'return_format'  => 'string',
                ],

                // Tab: Logos
                [
                    'key' => 'field_lx_tab_logos',
                    'label' => __('Logos', 'child-theme'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key' => 'field_lx_main_logo',
                    'label' => __('Logo chính (Main Logo)', 'child-theme'),
                    'name' => 'lx_main_logo',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],
                [
                    'key' => 'field_lx_negative_logo',
                    'label' => __('Logo âm bản (Negative Logo)', 'child-theme'),
                    'name' => 'lx_negative_logo',
                    'type' => 'image',
                    'instructions' => __('Dùng cho Dark mode hoặc nền tối.', 'child-theme'),
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],

                // Tab: Layouts
                [
                    'key' => 'field_lx_tab_layouts',
                    'label' => __('Bố cục (Layouts)', 'child-theme'),
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                [
                    'key' => 'field_lx_single_layout',
                    'label' => __('Giao diện Bài viết (Single Post)', 'child-theme'),
                    'name' => 'lx_single_layout',
                    'type' => 'select',
                    'choices' => [
                        'v1' => 'Version 1 (Default)',
                    ],
                    'default_value' => 'v1',
                    'return_format' => 'value',
                ],
                [
                    'key' => 'field_lx_archive_layout',
                    'label' => __('Giao diện Danh mục (Archive)', 'child-theme'),
                    'name' => 'lx_archive_layout',
                    'type' => 'select',
                    'choices' => [
                        'v1' => 'Version 1 (Default)',
                    ],
                    'default_value' => 'v1',
                    'return_format' => 'value',
                ],
                [
                    'key' => 'field_lx_search_layout',
                    'label' => __('Giao diện Tìm kiếm (Search)', 'child-theme'),
                    'name' => 'lx_search_layout',
                    'type' => 'select',
                    'choices' => [
                        'v1' => 'Version 1 (Default)',
                    ],
                    'default_value' => 'v1',
                    'return_format' => 'value',
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



/**
 * Helper function to retrieve logo
 * 
 * @param string $type 'main' or 'negative'
 * @return string Image HTML or empty string
 */
function child_theme_get_logo($type = 'main')
{
    if (!function_exists('get_field')) {
        return '';
    }

    $field_name = ($type === 'negative') ? 'lx_negative_logo' : 'lx_main_logo';
    $logo_array = get_field($field_name, 'option');

    if ($logo_array && isset($logo_array['url'])) {
        $alt = !empty($logo_array['alt']) ? esc_attr($logo_array['alt']) : get_bloginfo('name');
        return sprintf('<img src="%s" alt="%s" width="%s" height="%s" class="lx-logo lx-logo-%s">',
            esc_url($logo_array['url']),
            $alt,
            esc_attr($logo_array['width']),
            esc_attr($logo_array['height']),
            esc_attr($type)
        );
    }

    // Fallback to text logo if no image is set
    return '<span class="lx-text-logo">' . get_bloginfo('name') . '</span>';
}
