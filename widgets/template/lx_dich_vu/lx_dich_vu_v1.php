<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Dich_Vu_V1_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'lx_dich_vu_v1';
    }

    public function get_title()
    {
        return __('LX — Dịch vụ V1', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['lx_dich_vu'];
    }

    private function get_all_posts()
    {
        $options = [];
        // Lấy 100 bài viết mới nhất để hiển thị ra list chọn (mặc định lấy theo post_type là 'post')
        $posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => 100,
        ]);
        foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }
        return $options;
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'selected_posts',
            [
                'label' => __('Select Featured Posts', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_all_posts(),
                'description' => __('Select up to 4 posts. If you leave this empty, the 4 latest posts will be displayed instead.', 'child_theme'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $selected_posts = !empty($settings['selected_posts']) ? $settings['selected_posts'] : [];

        $args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'ignore_sticky_posts' => 1,
        ];

        if (!empty($selected_posts)) {
            $args['post__in'] = $selected_posts;
            $args['orderby'] = 'post__in';
            // Limit to 4 in case user selects more
            $args['posts_per_page'] = 4;
        } else {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        }

        $query = new \WP_Query($args);

        if ($query->have_posts()) :
            $posts_data = [];
            while ($query->have_posts()) {
                $query->the_post();

                // Get the first category
                $categories = get_the_category();
                $cat_name = '';
                $cat_link = '';
                if (!empty($categories)) {
                    $cat_name = $categories[0]->name;
                    $cat_link = get_category_link($categories[0]->term_id);
                }

                $posts_data[] = [
                    'title' => get_the_title(),
                    'link' => get_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'excerpt' => wp_trim_words(get_the_excerpt(), 20, '...'),
                    'category_name' => $cat_name,
                    'category_link' => $cat_link,
                    'date' => get_the_date('d/m/Y'),
                ];
            }
            wp_reset_postdata();

            // Guard against empty condition
            if (empty($posts_data)) return;

            // Separate the first post from the rest
            $first_post = $posts_data[0];
            $other_posts = array_slice($posts_data, 1);
?>
            <div class="featured_posts_widget_container">
                <div class="fp_grid">
                    <?php if ($first_post): ?>
                        <div class="fp_main_post">
                            <?php if ($first_post['link']): ?>
                                <a href="<?php echo $first_post['link']; ?>" class="fp_main_image_link">
                                <?php endif; ?>
                                <div class="fp_main_image_wrap">
                                    <?php if ($first_post['image']): ?>
                                        <img src="<?php echo $first_post['image']; ?>" alt="<?php echo $first_post['title']; ?>" width="800" height="600">
                                    <?php else: ?>
                                        <div class="fp_placeholder_img"></div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($first_post['link']): ?>
                                </a>
                            <?php endif; ?>

                            <div class="fp_main_content">
                                <div class="fp_meta">
                                    <?php if ($first_post['category_name']): ?>
                                        <?php if ($first_post['category_link']): ?>
                                            <a href="<?php echo $first_post['category_link']; ?>" class="fp_category_link">
                                            <?php endif; ?>
                                            <span class="fp_category_pill"><?php echo $first_post['category_name']; ?></span>
                                            <?php if ($first_post['category_link']): ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($first_post['date']): ?>
                                        <span class="fp_date"><?php echo $first_post['date']; ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($first_post['title']): ?>
                                    <h3 class="fp_title">
                                        <?php if ($first_post['link']): ?>
                                            <a href="<?php echo $first_post['link']; ?>"><?php echo $first_post['title']; ?></a>
                                        <?php else: ?>
                                            <?php echo $first_post['title']; ?>
                                        <?php endif; ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($first_post['link']): ?>
                                    <a href="<?php echo $first_post['link']; ?>" class="fp_read_more"><?php echo __('Xem thêm &rarr;', 'lx-landing'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($other_posts)): ?>
                        <div class="fp_side_posts">
                            <?php foreach ($other_posts as $post): ?>
                                <div class="fp_side_post">
                                    <?php if ($post['link']): ?>
                                        <a href="<?php echo $post['link']; ?>" class="fp_side_image_link">
                                        <?php endif; ?>
                                        <div class="fp_side_image_wrap">
                                            <?php if ($post['image']): ?>
                                                <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" width="400" height="300">
                                            <?php else: ?>
                                                <div class="fp_placeholder_img"></div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($post['link']): ?>
                                        </a>
                                    <?php endif; ?>

                                    <div class="fp_side_content">
                                        <div class="fp_meta">
                                            <?php if ($post['category_name']): ?>
                                                <?php if ($post['category_link']): ?>
                                                    <a href="<?php echo $post['category_link']; ?>" class="fp_category_link">
                                                    <?php endif; ?>
                                                    <span class="fp_category_pill"><?php echo $post['category_name']; ?></span>
                                                    <?php if ($post['category_link']): ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if ($post['date']): ?>
                                                <span class="fp_date"><?php echo $post['date']; ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($post['title']): ?>
                                            <h3 class="fp_title">
                                                <?php if ($post['link']): ?>
                                                    <a href="<?php echo $post['link']; ?>"><?php echo $post['title']; ?></a>
                                                <?php else: ?>
                                                    <?php echo $post['title']; ?>
                                                <?php endif; ?>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if ($post['link']): ?>
                                            <a href="<?php echo $post['link']; ?>" class="fp_read_more"><?php echo __('Xem thêm &rarr;', 'lx-landing'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


<?php
        endif;
    }
}
