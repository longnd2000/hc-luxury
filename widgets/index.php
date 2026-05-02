<?php

/**
 * Custom Elementor Widgets registration.
 *
 * @package Child_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Custom Widgets.
 */
function child_theme_register_custom_widgets($widgets_manager)
{
    // Define paths
    if (!defined('WIDGETS_PATH')) {
        define('WIDGETS_PATH', get_stylesheet_directory() . '/widgets/template/');
    }

    // Basic Widgets
    require_once WIDGETS_PATH . 'lx_tieu_de/lx_tieu_de_v1.php';
    require_once WIDGETS_PATH . 'lx_nut/lx_nut_v1.php';
    require_once WIDGETS_PATH . 'lx_text_editor/lx_van_ban_v1.php';

    // Section Widgets
    require_once WIDGETS_PATH . 'lx_banner/lx_banner_v1.php';
    require_once WIDGETS_PATH . 'lx_banner/lx_banner_v2.php';
    require_once WIDGETS_PATH . 'lx_gioi_thieu/lx_gioi_thieu_v1.php';
    require_once WIDGETS_PATH . 'lx_gia_tri/lx_gia_tri_v1.php';
    require_once WIDGETS_PATH . 'lx_so_lieu/lx_so_lieu_v1.php';
    require_once WIDGETS_PATH . 'lx_loi_ich/lx_loi_ich_v1.php';
    require_once WIDGETS_PATH . 'lx_loi_ich/lx_loi_ich_v2.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/lx_dich_vu_v1.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/lx_dich_vu_v2.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/lx_dich_vu_v3.php';

    // Theme Builder
    require_once WIDGETS_PATH . 'lx_menu/lx_menu_v1.php';
    require_once WIDGETS_PATH . 'lx_menu/lx_menu_v2.php';
    require_once WIDGETS_PATH . 'lx_menu/lx_menu_v3.php';
    require_once WIDGETS_PATH . 'lx_faqs/lx_faqs_v1.php';
    require_once WIDGETS_PATH . 'lx_quy_trinh/lx_quy_trinh_v1.php';
    require_once WIDGETS_PATH . 'lx_quy_trinh/lx_quy_trinh_v2.php';
    require_once WIDGETS_PATH . 'lx_cta/lx_cta_v1.php';
    require_once WIDGETS_PATH . 'lx_danh_gia/lx_danh_gia_v1.php';
    require_once WIDGETS_PATH . 'lx_danh_gia/lx_danh_gia_v2.php';
    require_once WIDGETS_PATH . 'lx_tinh_nang/lx_tinh_nang_v1.php';
    require_once WIDGETS_PATH . 'lx_lien_he/lx_lien_he_v1.php';
    require_once WIDGETS_PATH . 'lx_lien_he/lx_lien_he_v2.php';
    require_once WIDGETS_PATH . 'lx_archive/lx_archive_v1.php';
    require_once WIDGETS_PATH . 'lx_du_an/lx_du_an_v1.php';
    require_once WIDGETS_PATH . 'lx_nang_luc/lx_nang_luc_v1.php';
    require_once WIDGETS_PATH . 'lx_single/lx_single_v1.php';

    // Core Theme Widgets
    require_once WIDGETS_PATH . 'lx_breadcrumbs/lx_breadcrumbs_v1.php';
    require_once WIDGETS_PATH . 'lx_footer/lx_footer_v1.php';
    require_once WIDGETS_PATH . 'lx_404/lx_404_v1.php';


    // Register widgets
    $widgets_manager->register(new \LX_Banner_V1_Widget());
    $widgets_manager->register(new \LX_Banner_V2_Widget());
    $widgets_manager->register(new \LX_Gioi_Thieu_V1_Widget());
    $widgets_manager->register(new \LX_Gia_Tri_V1_Widget());
    $widgets_manager->register(new \LX_So_Lieu_V1_Widget());
    $widgets_manager->register(new \LX_Loi_Ich_V1_Widget());
    $widgets_manager->register(new \LX_Loi_Ich_V2_Widget());
    $widgets_manager->register(new \LX_Quy_Trinh_V1_Widget());
    $widgets_manager->register(new \LX_Quy_Trinh_V2_Widget());
    $widgets_manager->register(new \LX_Dich_Vu_V1_Widget());
    $widgets_manager->register(new \LX_Dich_Vu_V2_Widget());
    $widgets_manager->register(new \LX_Dich_Vu_V3_Widget());
    $widgets_manager->register(new \LX_Tieu_De_V1_Widget());
    $widgets_manager->register(new \LX_Nut_V1_Widget());
    $widgets_manager->register(new \LX_Van_Ban_V1_Widget());
    $widgets_manager->register(new \LX_Faqs_V1_Widget());
    $widgets_manager->register(new \LX_Menu_V1_Widget());
    $widgets_manager->register(new \LX_Menu_V2_Widget());
    $widgets_manager->register(new \LX_Menu_V3_Widget());
    $widgets_manager->register(new \LX_Cta_V1_Widget());
    $widgets_manager->register(new \LX_Danh_Gia_V1_Widget());
    $widgets_manager->register(new \LX_Danh_Gia_V2_Widget());
    $widgets_manager->register(new \LX_Tinh_Nang_V1_Widget());
    $widgets_manager->register(new \LX_Lien_He_V1_Widget());
    $widgets_manager->register(new \LX_Lien_He_V2_Widget());
    $widgets_manager->register(new \LX_Archive_V1_Widget());
    $widgets_manager->register(new \LX_Du_An_V1_Widget());
    $widgets_manager->register(new \LX_Nang_Luc_V1_Widget());
    $widgets_manager->register(new \LX_Single_V1_Widget());

    // Core Theme Widgets Registration
    $widgets_manager->register(new \LX_Breadcrumbs_Widget());
    $widgets_manager->register(new \LX_Footer_Widget());
    $widgets_manager->register(new \LX_404_Section_Widget());
}

add_action('elementor/widgets/register', 'child_theme_register_custom_widgets');

function child_theme_register_widget_categories($elements_manager)
{
    $categories = [
        'lx_tieu_de'          => [__('LX - Tiêu đề',    'lx-landing'), 5],
        'lx_nut'              => [__('LX - Nút',          'lx-landing'), 6],
        'lx_text_editor'      => [__('LX - Văn bản',      'lx-landing'), 7],
        'lx_banner'           => [__('LX - Banner',       'lx-landing'), 10],
        'lx_menu'             => [__('LX - Menu',         'lx-landing'), 12],
        'lx_gioi_thieu'       => [__('LX - Giới thiệu',   'lx-landing'), 15],
        'lx_gia_tri'          => [__('LX - Giá trị cốt lõi', 'lx-landing'), 17],
        'lx_so_lieu'          => [__('LX - Số liệu',       'lx-landing'), 18],
        'lx_khach_hang'       => [__('LX - Khách hàng',   'lx-landing'), 20],
        'lx_doi_tac'          => [__('LX - Đối tác',      'lx-landing'), 30],
        'lx_van_de'           => [__('LX - Vấn đề',       'lx-landing'), 40],
        'lx_giai_phap'        => [__('LX - Giải pháp',    'lx-landing'), 50],
        'lx_loi_ich'          => [__('LX - Lợi ích',      'lx-landing'), 60],
        'lx_tinh_nang'        => [__('LX - Tính năng',    'lx-landing'), 70],
        'lx_dich_vu'          => [__('LX - Dịch vụ',      'lx-landing'), 80],
        'lx_du_an'            => [__('LX - Dự án',       'lx-landing'), 85],
        'lx_quy_trinh'        => [__('LX - Quy trình',     'lx-landing'), 90],
        'lx_danh_gia'         => [__('LX - Đánh giá',      'lx-landing'), 100],
        'lx_bang_gia'         => [__('LX - Bảng giá',      'lx-landing'), 110],
        'lx_faqs'             => [__('LX - FAQs',          'lx-landing'), 120],
        'lx_cta'              => [__('LX - CTA',           'lx-landing'), 130],
        'lx_lien_he'          => [__('LX - Liên hệ',      'lx-landing'), 140],
        'lx_archive'          => [__('LX - Archive',     'lx-landing'), 160],
        'lx_single'           => [__('LX - Single',      'lx-landing'), 170],
        'lx_footer'           => [__('LX - Footer',      'lx-landing'), 180],
        'lx_404'              => [__('LX - 404',         'lx-landing'), 190],
        'lx_breadcrumbs'      => [__('LX - Breadcrumbs', 'lx-landing'), 200],
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
