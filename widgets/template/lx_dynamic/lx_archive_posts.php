<?php
/**
 * Widget Name: LX Archive Posts
 * Description: Hiển thị danh sách bài viết từ truy vấn hiện tại (Archive/Search).
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class LX_Archive_Posts extends Widget_Base
{
    public function get_name()
    {
        return 'lx_archive_posts';
    }

    public function get_title()
    {
        return __('LX — Archive Posts', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-archive-posts';
    }

    public function get_categories()
    {
        return ['lx_dynamic'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Cấu hình', 'lx-landing'),
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label' => __('Kiểu giao diện', 'lx-landing'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid_2_cols',
                'options' => [
                    'grid_1_col' => __('1 Cột (Danh sách)', 'lx-landing'),
                    'grid_2_cols' => __('2 Cột', 'lx-landing'),
                    'grid_3_cols' => __('3 Cột', 'lx-landing'),
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => __('Hiển thị phân trang', 'lx-landing'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Hiện', 'lx-landing'),
                'label_off' => __('Ẩn', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $layout_class = $settings['layout_style'];

        // Determine column class based on layout
        $col_class = 'col-12';
        if ($layout_class === 'grid_2_cols') {
            $col_class = 'col-md-6';
        } elseif ($layout_class === 'grid_3_cols') {
            $col_class = 'col-md-6 col-lg-4';
        }

        if (have_posts()) :
?>
            <div class="lx_archive_posts_widget">
                <div class="row">
                    <?php while (have_posts()) : the_post();
                        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $title = get_the_title();
                        $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                        $link = get_permalink();
                        $categories = get_the_category();
                    ?>
                        <div class="<?php echo esc_attr($col_class); ?> mb-4">
                            <?php include(get_stylesheet_directory() . '/templates/parts/post_card.php'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <?php if ($settings['show_pagination'] === 'yes') : ?>
                    <div class="lx_archive_pagination mt-5">
                        <?php
                        echo paginate_links([
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                            'type'      => 'list',
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <p><?php echo __('Rất tiếc, không tìm thấy bài viết nào.', 'lx-landing'); ?></p>
<?php
        endif;
    }
}
