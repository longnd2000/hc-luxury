<?php

 if (!defined('ABSPATH')) {
     exit; // Exit if accessed directly
 }

 class LX_Single_V1_Widget extends \Elementor\Widget_Base
 {
     public function get_name(): string
     {
         return 'lx_single_v1';
     }

     public function get_title(): string
     {
         return __('LX — Single V1', 'lx-landing');
     }

     public function get_icon(): string
     {
         return 'eicon-post-content';
     }

     public function get_categories(): array
     {
         return ['lx_single'];
     }

     protected function register_controls(): void
     {
         // ── Sidebar Section ──────────────────────────────────────────────────
         $this->start_controls_section(
             'section_sidebar',
             [
                 'label' => __('Sidebar', 'lx-landing'),
             ]
         );

         $this->add_control(
             'sidebar_title',
             [
                 'label'   => __('Tiêu đề Sidebar', 'lx-landing'),
                 'type'    => \Elementor\Controls_Manager::TEXT,
                 'default' => __('DANH MỤC NỔI BẬT', 'lx-landing'),
             ]
         );

         $this->add_control(
             'related_sidebar_title',
             [
                 'label'   => __('Tiêu đề Bài viết liên quan (Sidebar)', 'lx-landing'),
                 'type'    => \Elementor\Controls_Manager::TEXT,
                 'default' => __('BÀI VIẾT MỚI NHẤT', 'lx-landing'),
             ]
         );

         $this->end_controls_section();

         // ── Author Section ───────────────────────────────────────────────────
         $this->start_controls_section(
             'section_author',
             [
                 'label' => __('Thông tin tác giả', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_name_custom',
             [
                 'label'       => __('Tên tác giả', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::TEXT,
                 'placeholder' => __('Ví dụ: Admin', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_image',
             [
                 'label' => __('Ảnh tác giả', 'lx-landing'),
                 'type'  => \Elementor\Controls_Manager::MEDIA,
             ]
         );

         $this->add_control(
             'author_bio_custom',
             [
                 'label'       => __('Mô tả tác giả', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::TEXTAREA,
                 'placeholder' => __('Nhập giới thiệu ngắn về tác giả...', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_facebook',
             [
                 'label'       => __('Link Facebook', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::URL,
                 'placeholder' => __('https://facebook.com/username', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_youtube',
             [
                 'label'       => __('Link Youtube', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::URL,
                 'placeholder' => __('https://youtube.com/channel', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_instagram',
             [
                 'label'       => __('Link Instagram', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::URL,
                 'placeholder' => __('https://instagram.com/username', 'lx-landing'),
             ]
         );

         $this->add_control(
             'author_tiktok',
             [
                 'label'       => __('Link Tiktok', 'lx-landing'),
                 'type'        => \Elementor\Controls_Manager::URL,
                 'placeholder' => __('https://tiktok.com/@username', 'lx-landing'),
             ]
         );

         $this->end_controls_section();

         // ── Bottom Section ───────────────────────────────────────────────────
         $this->start_controls_section(
             'section_bottom',
             [
                 'label' => __('Phần dưới bài viết', 'lx-landing'),
             ]
         );

         $this->add_control(
             'related_bottom_title',
             [
                 'label'   => __('Tiêu đề Bài viết liên quan (Dưới)', 'lx-landing'),
                 'type'    => \Elementor\Controls_Manager::TEXT,
                 'default' => __('BÀI VIẾT LIÊN QUAN', 'lx-landing'),
             ]
         );

         $this->end_controls_section();
     }

     protected function render(): void
     {
         $settings = $this->get_settings_for_display();

         if (!is_singular('post')) {
            echo '<div class="lx_alert">Widget này chỉ hoạt động trong trang chi tiết bài viết.</div>';
            return;
         }

         global $post;
         $featured_img = get_the_post_thumbnail_url($post->ID, 'full');

         // Author Data Logic (Custom ONLY)
         $author_name = !empty($settings['author_name_custom']) ? $settings['author_name_custom'] : '';
         $author_bio = !empty($settings['author_bio_custom']) ? $settings['author_bio_custom'] : '';
         $author_avatar = !empty($settings['author_image']['url']) ? $settings['author_image']['url'] : '';

         $post_date = get_the_date('d/m/Y');

         // Estimated reading time (rough)
         $content = get_post_field('post_content', $post->ID);
         $word_count = str_word_count(strip_tags($content));
         $reading_time = ceil($word_count / 200); // 200 wpm
         ?>

         <div class="lx_single_v1">
             <!-- ── Hero Section ─────────────────────────────────────────── -->
             <header class="lx_wrap lx_single_hero" style="background-image: url('<?php echo esc_url($featured_img); ?>');">
                 <div class="lx_con">
                     <div class="lx_hero_content">
                         <?php if (function_exists('lx_get_breadcrumbs')) echo lx_get_breadcrumbs(); ?>
                         <h1 class="lx_single_title"><?php the_title(); ?></h1>
                         <div class="lx_single_meta">
                             <?php if ($author_name) : ?>
                                 <span><?php _e('Tác giả:', 'lx-landing'); ?> <?php echo esc_html($author_name); ?></span>
                                 <span class="lx_meta_sep"></span>
                             <?php endif; ?>
                             <span><?php echo $reading_time; ?> <?php _e('Phút đọc', 'lx-landing'); ?></span>
                             <span class="lx_meta_sep"></span>
                             <span><?php _e('Ngày đăng:', 'lx-landing'); ?> <time datetime="<?php echo get_the_date('c'); ?>"><?php echo esc_html($post_date); ?></time></span>
                         </div>
                     </div>
                 </div>
             </header>

             <!-- ── Main Content Section ─────────────────────────────────────── -->
             <section class="lx_wrap lx_single_main_wrap">
                 <div class="lx_con">
                     <div class="row lx_g40">
                         <!-- Left: Content -->
                         <div class="col-12 col-lg-8">
                             <article class="lx_single_content_area">
                                 <?php if (has_excerpt()) : ?>
                                    <div class="lx_single_intro">
                                        <?php the_excerpt(); ?>
                                    </div>
                                 <?php endif; ?>

                                 <div class="lx_entry_content lx_text_editor">
                                     <?php the_content(); ?>
                                 </div>

                                 <!-- Author Box (Only show if name is set) -->
                                 <?php if ($author_name) : ?>
                                     <div class="lx_author_bio_box">
                                         <div class="lx_author_avatar">
                                             <?php if ($author_avatar) : ?>
                                                 <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                                             <?php else : ?>
                                                 <img src="<?php echo \Elementor\Utils::get_placeholder_image_src(); ?>" alt="Avatar">
                                             <?php endif; ?>
                                         </div>
                                         <div class="lx_author_info">
                                             <span class="lx_author_label"><?php _e('Tác giả', 'lx-landing'); ?></span>
                                             <?php if ($author_bio) : ?>
                                                 <p class="lx_author_desc"><?php echo nl2br(esc_html($author_bio)); ?></p>
                                             <?php endif; ?>
                                             <h4 class="lx_author_name"><?php echo esc_html($author_name); ?></h4>
                                             <div class="lx_author_social">
                                                 <?php if (!empty($settings['author_facebook']['url'])) : ?>
                                                     <a href="<?php echo esc_url($settings['author_facebook']['url']); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                                 <?php endif; ?>
                                                 <?php if (!empty($settings['author_youtube']['url'])) : ?>
                                                     <a href="<?php echo esc_url($settings['author_youtube']['url']); ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                                 <?php endif; ?>
                                                 <?php if (!empty($settings['author_instagram']['url'])) : ?>
                                                     <a href="<?php echo esc_url($settings['author_instagram']['url']); ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                                 <?php endif; ?>
                                                 <?php if (!empty($settings['author_tiktok']['url'])) : ?>
                                                     <a href="<?php echo esc_url($settings['author_tiktok']['url']); ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                                                 <?php endif; ?>
                                             </div>
                                         </div>
                                     </div>
                                 <?php endif; ?>
                             </article>
                         </div>

                         <!-- Right: Sidebar -->
                         <div class="col-12 col-lg-4">
                             <aside class="lx_single_sidebar">
                                 <!-- Category List -->
                                 <div class="lx_sidebar_widget">
                                     <h3 class="lx_sidebar_title"><?php echo esc_html($settings['sidebar_title']); ?></h3>
                                     <div class="lx_sidebar_body">
                                         <ul class="lx_sidebar_cat_list">
                                             <?php
                                             $categories = get_categories(['number' => 10]);
                                             foreach ($categories as $cat) :
                                             ?>
                                                 <li><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo esc_html($cat->name); ?></a></li>
                                             <?php endforeach; ?>
                                         </ul>
                                     </div>
                                 </div>

                                 <!-- Recent Posts Widget -->
                                 <div class="lx_sidebar_widget">
                                     <h3 class="lx_sidebar_title"><?php echo esc_html($settings['related_sidebar_title']); ?></h3>
                                     <div class="lx_sidebar_body">
                                         <div class="lx_sidebar_recent_posts">
                                             <?php
                                             $recent_sidebar = new WP_Query([
                                                 'post_type'      => 'post',
                                                 'posts_per_page' => 5,
                                                 'post__not_in'   => [$post->ID],
                                             ]);
                                             if ($recent_sidebar->have_posts()) :
                                                 while ($recent_sidebar->have_posts()) : $recent_sidebar->the_post();
                                             ?>
                                                     <div class="lx_recent_item">
                                                         <div class="lx_recent_thumb">
                                                             <a href="<?php the_permalink(); ?>">
                                                                 <?php if (has_post_thumbnail()) : ?>
                                                                     <?php the_post_thumbnail('thumbnail'); ?>
                                                                 <?php else : ?>
                                                                     <img src="<?php echo \Elementor\Utils::get_placeholder_image_src(); ?>" alt="<?php the_title_attribute(); ?>">
                                                                 <?php endif; ?>
                                                             </a>
                                                         </div>
                                                         <div class="lx_recent_info">
                                                             <h4 class="lx_recent_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                         </div>
                                                     </div>
                                             <?php endwhile; wp_reset_postdata(); endif; ?>
                                         </div>
                                     </div>
                                 </div>
                             </aside>
                         </div>
                     </div>
                 </div>
             </section>

             <!-- ── Bottom Related Posts ────────────────────────────────────── -->
             <section class="lx_wrap lx_single_related_bottom">
                 <div class="lx_con">
                     <h2 class="lx_bottom_title"><?php echo esc_html($settings['related_bottom_title']); ?></h2>
                     <div class="row lx_g32">
                         <?php
                         $related_bottom = new WP_Query([
                             'post_type'      => 'post',
                             'posts_per_page' => 3,
                             'post__not_in'   => [$post->ID],
                             'category__in'   => wp_get_post_categories($post->ID),
                         ]);
                         if ($related_bottom->have_posts()) :
                             while ($related_bottom->have_posts()) : $related_bottom->the_post();
                                 $post_terms = get_the_terms(get_the_ID(), 'category');
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
                         <?php endwhile; wp_reset_postdata(); endif; ?>
                     </div>
                 </div>
             </section>
         </div>
         <?php
     }
 }
