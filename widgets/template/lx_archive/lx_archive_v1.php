<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class LX_Archive_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_archive_v1';
    }

    public function get_title(): string
    {
        return __('LX â€” Archive V1', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-post-list';
    }

    public function get_categories(): array
    {
        return ['lx_archive'];
    }

    protected function register_controls(): void
    {
        // â”€â”€ Search Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $this->start_controls_section(
            'section_search',
            [
                'label' => __('Thanh tÃ¬m kiáº¿m', 'lx-landing'),
            ]
        );

        $this->add_control(
            'search_title',
            [
                'label'   => __('TiÃªu Ä‘á» tÃ¬m kiáº¿m', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('SEONGON CÃ“ THá»‚ GIÃšP GÃŒ Báº N?', 'lx-landing'),
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label'   => __('Placeholder tÃ¬m kiáº¿m', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('TÃ¬m kiáº¿m...', 'lx-landing'),
            ]
        );

        $this->add_control(
            'search_bg',
            [
                'label'   => __('áº¢nh ná»n tÃ¬m kiáº¿m', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        // â”€â”€ Filter Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $this->start_controls_section(
            'section_filter',
            [
                'label' => __('Bá»™ lá»c danh má»¥c', 'lx-landing'),
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'label'     => __('Hiá»ƒn thá»‹ bá»™ lá»c', 'lx-landing'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => __('Hiá»‡n', 'lx-landing'),
                'label_off' => __('áº¨n', 'lx-landing'),
            ]
        );

        $this->add_control(
            'all_text',
            [
                'label'     => __('Text "Táº¥t cáº£"', 'lx-landing'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => __('Táº¥t cáº£', 'lx-landing'),
                'condition' => ['show_filter' => 'yes'],
            ]
        );

        $this->add_control(
            'all_link',
            [
                'label'     => __('Link "Táº¥t cáº£"', 'lx-landing'),
                'type'      => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default'   => [
                    'url' => '',
                ],
                'condition' => ['show_filter' => 'yes'],
            ]
        );

        $this->end_controls_section();

        // â”€â”€ Posts Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $this->start_controls_section(
            'section_posts',
            [
                'label' => __('Danh sÃ¡ch bÃ i viáº¿t', 'lx-landing'),
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'   => __('TiÃªu Ä‘á» (Chá»‰ Ã¡p dá»¥ng cho trang Táº¥t cáº£)', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tin tá»©c', 'lx-landing'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $current_term = get_queried_object();
        $taxonomy = 'category';

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 9,
            'paged'          => $paged,
            'post_status'    => 'publish',
        ];

        if (is_archive() && isset($current_term->taxonomy) && $current_term->taxonomy === $taxonomy) {
            $args['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $current_term->term_id,
                ],
            ];
            $display_title = $current_term->name;
        } elseif (is_search()) {
            $display_title = __('TÃ¬m kiáº¿m', 'lx-landing');
        } else {
            $display_title = !empty($settings['section_title']) ? $settings['section_title'] : __('Tin tá»©c', 'lx-landing');
        }

        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $args['s'] = sanitize_text_field($_GET['s']);
        }

        $query = new WP_Query($args);
        $bg_url = !empty($settings['search_bg']['url']) ? $settings['search_bg']['url'] : '';
        ?>

        <div class="lx_archive_v1">
            <!-- â”€â”€ Hero Search Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
            <section class="lx_wrap lx_archive_hero" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
                <div class="lx_con">
                    <h2 class="lx_hero_title"><?php echo esc_html($settings['search_title']); ?></h2>
                    <form role="search" method="get" class="lx_search_form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="lx_search_input_wrap">
                            <span class="lx_search_icon"><i class="fas fa-search"></i></span>
                            <input type="text" name="s" placeholder="<?php echo esc_attr($settings['search_placeholder']); ?>" value="<?php echo get_search_query(); ?>">
                            <button type="submit"><?php _e('TÃ¬m kiáº¿m', 'lx-landing'); ?></button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- â”€â”€ Filter Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
            <?php if ($settings['show_filter'] === 'yes') : ?>
                <section class="lx_wrap lx_archive_filter_wrap">
                    <div class="lx_con">
                        <ul class="lx_filter_list">
                            <?php
                            $terms = get_terms([
                                'taxonomy'   => $taxonomy,
                                'hide_empty' => true,
                            ]);

                            $all_link = !empty($settings['all_link']['url']) ? $settings['all_link']['url'] : get_post_type_archive_link('post');
                            if (empty($all_link)) {
                                $blog_page_id = get_option('page_for_posts');
                                $all_link = $blog_page_id ? get_permalink($blog_page_id) : home_url('/');
                            }

                            $is_all_active = !is_category() && !is_tag() && !is_tax() && !is_search();
                            ?>
                            <li>
                                <a href="<?php echo esc_url($all_link); ?>" class="<?php echo $is_all_active ? 'active' : ''; ?>">
                                    <?php echo esc_html($settings['all_text']); ?>
                                </a>
                            </li>

                            <?php foreach ($terms as $term) :
                                $term_link = get_term_link($term);
                                $is_active = (is_archive() && isset($current_term->term_id) && $current_term->term_id === $term->term_id);
                            ?>
                                <li>
                                    <a href="<?php echo esc_url($term_link); ?>" class="<?php echo $is_active ? 'active' : ''; ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>
            <?php endif; ?>

            <!-- â”€â”€ Post Grid Section â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
            <section class="lx_wrap lx_archive_list_wrap">
                <div class="lx_con">
                    <div class="lx_archive_title_wrap lx_text_center">
                        <h1 class="lx_heading"><?php echo esc_html($display_title); ?></h1>
                        <?php if (function_exists('lx_get_breadcrumbs')) echo lx_get_breadcrumbs(); ?>
                    </div>

                    <?php if ($query->have_posts()) : ?>
                        <div class="row lx_g32">
                            <?php while ($query->have_posts()) : $query->the_post();
                                $post_terms = get_the_terms(get_the_ID(), $taxonomy);
                                $first_term = ($post_terms && !is_wp_error($post_terms)) ? $post_terms[0]->name : '';
                            ?>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <article class="lx_post_card">
                                        <div class="lx_post_media">
                                            <a href="<?php the_permalink(); ?>" class="lx_post_img">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('large'); ?>
                                                <?php else : ?>
                                                    <img src="<?php echo \Elementor\Utils::get_placeholder_image_src(); ?>" alt="<?php the_title_attribute(); ?>">
                                                <?php endif; ?>
                                            </a>
                                            <?php if ($first_term) : ?>
                                                <div class="lx_post_badge"><?php echo esc_html($first_term); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="lx_post_content">
                                            <h3 class="lx_post_title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <div class="lx_post_excerpt">
                                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                                            </div>
                                            <div class="lx_post_footer">
                                                <a href="<?php the_permalink(); ?>" class="lx_post_link">
                                                    <?php _e('XEM NGAY', 'lx-landing'); ?>
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                                <div class="lx_post_meta">

                                                    <span><?php echo get_the_date('j F, Y'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="lx_pagination">
                            <?php
                            echo paginate_links([
                                'total'        => $query->max_num_pages,
                                'current'      => $paged,
                                'format'       => '?paged=%#%',
                                'show_all'     => false,
                                'type'         => 'plain',
                                'prev_next'    => true,
                                'prev_text'    => '<i class="fas fa-chevron-left"></i>',
                                'next_text'    => '<i class="fas fa-chevron-right"></i>',
                            ]);
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="lx_no_posts">
                            <p><?php _e('KhÃ´ng tÃ¬m tháº¥y bÃ i viáº¿t nÃ o.', 'lx-landing'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php
    }
}

