<?php
/**
 * Widget Name: LX Related Posts
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class LX_Related_Posts_Widget extends Widget_Base
{
    public function get_name() { return 'lx_related_posts'; }
    public function get_title() { return __('LX — Related Posts', 'lx-landing'); }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => __('Cấu hình', 'lx-landing')]);
        $this->add_control('posts_per_page', [
            'label' => __('Số lượng bài viết', 'lx-landing'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $categories = get_the_category();
        if (!$categories) return;

        $cat_ids = array_map(fn($cat) => $cat->term_id, $categories);

        $related_query = new WP_Query([
            'category__in'        => $cat_ids,
            'post__not_in'        => [get_the_ID()],
            'posts_per_page'      => $settings['posts_per_page'],
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
        ]);

        if ($related_query->have_posts()) :
?>
            <section class="lx_related_posts_section">
                <div class="lx_related_posts_header mb-4">
                    <h2 class="lx_related_posts_title"><?php echo __('BÀI VIẾT LIÊN QUAN', 'lx-landing'); ?></h2>
                </div>
                <div class="row">
                    <?php while ($related_query->have_posts()) : $related_query->the_post();
                        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $title = get_the_title();
                        $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                        $link = get_permalink();
                        $categories = get_the_category();
                    ?>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <?php include(get_stylesheet_directory() . '/templates/parts/post_card.php'); ?>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
<?php
        endif;
    }
}
