<?php
/**
 * Widget Autoloader & Category Registration
 *
 * @package Child_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ── Widget Registration ────────────────────────────────────────────────────

function child_theme_register_custom_widgets($widgets_manager): void
{
    // include files
    // Tiêu đề, Nút, Văn bản
    require_once WIDGETS_PATH . 'lx_tieu_de/lx_heading_widget.php';
    require_once WIDGETS_PATH . 'lx_nut/lx_button_widget.php';
    require_once WIDGETS_PATH . 'lx_text_editor/lx_text_editor_widget.php';

    // Banner
    require_once WIDGETS_PATH . 'lx_banner/image_gallery_widget.php';
    require_once WIDGETS_PATH . 'lx_banner/youtube_iframe_slider.php';

    // Nghiệp vụ
    require_once WIDGETS_PATH . 'lx_loi_ich/company_highlight_widget.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/featured_posts_widget.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/category_section_widget.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/event_widget.php';


    // Register widgets
    $widgets_manager->register(new \Image_Gallery_Widget());
    $widgets_manager->register(new \Youtube_Iframe_Slider_Widget());
    $widgets_manager->register(new \Company_Highlight_Widget());
    $widgets_manager->register(new \featured_posts_widget());
    $widgets_manager->register(new \category_section_widget());
    $widgets_manager->register(new \event_widget());
    $widgets_manager->register(new \LX_Heading_Widget());
    $widgets_manager->register(new \LX_Button_Widget());
    $widgets_manager->register(new \LX_Text_Editor_Widget());
}
add_action('elementor/widgets/register', 'child_theme_register_custom_widgets');

// ── Category Registration ──────────────────────────────────────────────────

/**
 * Register all LX widget categories in Elementor.
 *
 * Slug convention : lx_<slug>
 * Priority        : lower number = higher in the Elementor panel
 */
function child_theme_register_widget_categories($elements_manager): void
{
    $categories = [
        // slug                => [title (vi), priority]
        'lx_tieu_de'          => [__('LX — Tiêu đề',    'child-theme'), 5],
        'lx_nut'              => [__('LX — Nút',          'child-theme'), 6],
        'lx_text_editor'      => [__('LX — Văn bản',      'child-theme'), 7],
        'lx_banner'           => [__('LX — Banner',       'child-theme'), 10],
        'lx_khach_hang'       => [__('LX — Khách hàng',   'child-theme'), 20],
        'lx_doi_tac'          => [__('LX — Đối tác',      'child-theme'), 30],
        'lx_van_de'           => [__('LX — Vấn đề',       'child-theme'), 40],
        'lx_giai_phap'        => [__('LX — Giải pháp',    'child-theme'), 50],
        'lx_loi_ich'          => [__('LX — Lợi ích',      'child-theme'), 60],
        'lx_tinh_nang'        => [__('LX — Tính năng',    'child-theme'), 70],
        'lx_dich_vu'          => [__('LX — Dịch vụ',      'child-theme'), 80],
        'lx_quy_trinh'        => [__('LX — Quy trình',     'child-theme'), 90],
        'lx_danh_gia'         => [__('LX — Đánh giá',      'child-theme'), 100],
        'lx_bang_gia'         => [__('LX — Bảng giá',      'child-theme'), 110],
        'lx_faqs'             => [__('LX — FAQs',          'child-theme'), 120],
        'lx_cta'              => [__('LX — CTA',           'child-theme'), 130],
        'lx_lien_he'          => [__('LX — Liên hệ',      'child-theme'), 140],
    ];

    foreach ($categories as $slug => [$title, $priority]) {
        $elements_manager->add_category(
            $slug,
            [
                'title'    => $title,
                'priority' => $priority,
            ]
        );
    }
}
add_action('elementor/elements/categories_registered', 'child_theme_register_widget_categories');

