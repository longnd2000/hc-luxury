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
    require_once WIDGETS_PATH . 'lx_banner/lx_hero_slider.php';
    require_once WIDGETS_PATH . 'lx_banner/lx_image_slider.php';
    require_once WIDGETS_PATH . 'lx_gioi_thieu/lx_about.php';

    // Nghiệp vụ
    require_once WIDGETS_PATH . 'lx_loi_ich/lx_why_choose_us.php';
    require_once WIDGETS_PATH . 'lx_loi_ich/lx_why_choose_us_v2.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/featured_posts_widget.php';
    require_once WIDGETS_PATH . 'lx_dich_vu/category_section_widget.php';

    // Theme Builder / Dynamic
    require_once WIDGETS_PATH . 'lx_dynamic/lx_archive_posts.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_breadcrumbs.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_post_title.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_post_meta.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_post_content.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_author_box.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_related_posts.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_archive_title.php';
    require_once WIDGETS_PATH . 'lx_menu/lx_menu.php';
    require_once WIDGETS_PATH . 'lx_menu/lx_menu_v2.php';
    require_once WIDGETS_PATH . 'lx_menu/lx_menu_v3.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_footer.php';
    require_once WIDGETS_PATH . 'lx_faqs/lx_faqs.php';
    require_once WIDGETS_PATH . 'lx_quy_trinh/lx_process_steps.php';
    require_once WIDGETS_PATH . 'lx_cta/lx_cta.php';
    require_once WIDGETS_PATH . 'lx_danh_gia/lx_video_reviews.php';
    require_once WIDGETS_PATH . 'lx_danh_gia/lx_video_reviews_grid.php';
    require_once WIDGETS_PATH . 'lx_tinh_nang/lx_feature_gallery.php';
    require_once WIDGETS_PATH . 'lx_lien_he/lx_contact_form_image.php';
    require_once WIDGETS_PATH . 'lx_lien_he/lx_dynamic_form.php';
    require_once WIDGETS_PATH . 'lx_dynamic/lx_404_section.php';
    require_once WIDGETS_PATH . 'lx_archive/v1.php';
    require_once WIDGETS_PATH . 'lx_single/v1.php';


    // Register widgets
    $widgets_manager->register(new \LX_Hero_Slider_Widget());
    $widgets_manager->register(new \LX_Image_Slider_Widget());
    $widgets_manager->register(new \LX_About_Widget());
    $widgets_manager->register(new \LX_Why_Choose_Us_Widget());
    $widgets_manager->register(new \LX_Why_Choose_Us_V2_Widget());
    $widgets_manager->register(new \LX_Process_Steps_Widget());
    $widgets_manager->register(new \featured_posts_widget());
    $widgets_manager->register(new \category_section_widget());
    $widgets_manager->register(new \LX_Heading_Widget());
    $widgets_manager->register(new \LX_Button_Widget());
    $widgets_manager->register(new \LX_Text_Editor_Widget());
    $widgets_manager->register(new \LX_Archive_Posts());
    $widgets_manager->register(new \LX_Breadcrumbs_Widget());
    $widgets_manager->register(new \LX_Post_Title_Widget());
    $widgets_manager->register(new \LX_Post_Meta_Widget());
    $widgets_manager->register(new \LX_Post_Content_Widget());
    $widgets_manager->register(new \LX_Author_Box_Widget());
    $widgets_manager->register(new \LX_Related_Posts_Widget());
    $widgets_manager->register(new \LX_Archive_Title_Widget());
    $widgets_manager->register(new \LX_FAQs_Widget());
    $widgets_manager->register(new \LX_Menu_Widget());
    $widgets_manager->register(new \LX_Menu_V2_Widget());
    $widgets_manager->register(new \LX_Menu_V3_Widget());
    $widgets_manager->register(new \LX_Footer_Widget());
    $widgets_manager->register(new \LX_CTA_Widget());
    $widgets_manager->register(new \LX_Video_Reviews_Widget());
    $widgets_manager->register(new \LX_Video_Reviews_Grid_Widget());
    $widgets_manager->register(new \LX_Feature_Gallery_Widget());
    $widgets_manager->register(new \LX_Contact_Form_Image_Widget());
    $widgets_manager->register(new \LX_Dynamic_Form_Widget());
    $widgets_manager->register(new \LX_404_Section_Widget());
    $widgets_manager->register(new \LX_Archive_V1());
    $widgets_manager->register(new \LX_Single_V1());
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
        'lx_tieu_de'          => [__('LX — Tiêu đề',    'lx-landing'), 5],
        'lx_nut'              => [__('LX — Nút',          'lx-landing'), 6],
        'lx_text_editor'      => [__('LX — Văn bản',      'lx-landing'), 7],
        'lx_banner'           => [__('LX — Banner',       'lx-landing'), 10],
        'lx_menu'             => [__('LX — Menu',         'lx-landing'), 12],
        'lx_gioi_thieu'       => [__('LX — Giới thiệu',   'lx-landing'), 15],
        'lx_khach_hang'       => [__('LX — Khách hàng',   'lx-landing'), 20],
        'lx_doi_tac'          => [__('LX — Đối tác',      'lx-landing'), 30],
        'lx_van_de'           => [__('LX — Vấn đề',       'lx-landing'), 40],
        'lx_giai_phap'        => [__('LX — Giải pháp',    'lx-landing'), 50],
        'lx_loi_ich'          => [__('LX — Lợi ích',      'lx-landing'), 60],
        'lx_tinh_nang'        => [__('LX — Tính năng',    'lx-landing'), 70],
        'lx_dich_vu'          => [__('LX — Dịch vụ',      'lx-landing'), 80],
        'lx_quy_trinh'        => [__('LX — Quy trình',     'lx-landing'), 90],
        'lx_danh_gia'         => [__('LX — Đánh giá',      'lx-landing'), 100],
        'lx_bang_gia'         => [__('LX — Bảng giá',      'lx-landing'), 110],
        'lx_faqs'             => [__('LX — FAQs',          'lx-landing'), 120],
        'lx_cta'              => [__('LX — CTA',           'lx-landing'), 130],
        'lx_lien_he'          => [__('LX — Liên hệ',      'lx-landing'), 140],
        'lx_dynamic'          => [__('LX — Năng động',    'lx-landing'), 150],
        'lx_archive'          => [__('LX — Archive',     'lx-landing'), 160],
        'lx_single'           => [__('LX — Single',      'lx-landing'), 170],
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

