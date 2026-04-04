<?php

/**
 * The template for displaying event archives
 *
 * @package Child_Theme
 */

get_header();
?>

<main class="lx_archive_page section_box py_section">
    <div class="container">

        <!-- Breadcrumbs -->
        <nav class="lx_archive_breadcrumbs">
            <a href="<?php echo home_url('/'); ?>"><?php echo __('Trang chủ', 'child-theme'); ?></a>
            <i class="fa-solid fa-chevron-right"></i>
            <span><?php echo __('Sự kiện', 'child-theme'); ?></span>
        </nav>

        <!-- Archive Main Section -->
        <div class="lx_archive_container">

            <!-- Main Content: Left Column -->
            <div class="lx_archive_main_col">
                <header class="lx_archive_main_header">
                    <h1 class="lx_archive_main_title"><?php echo __('Sự kiện', 'child-theme'); ?></h1>
                </header>

                <?php if (have_posts()) :
                    $now = current_time('timestamp');
                ?>
                    <div class="lx_archive_grid">
                        <?php while (have_posts()) : the_post();
                            $start_date_raw = get_field('event_start_date');
                            $end_date_raw = get_field('event_end_date');
                            $location = get_field('event_location');

                            if (!$start_date_raw || !$end_date_raw) {
                                // Default placeholders if forgot to fill
                                $start_date_raw = date('d/m/Y');
                                $end_date_raw = date('d/m/Y');
                            }

                            // Parse d/m/Y format from ACF Return Format
                            $start_dt = DateTime::createFromFormat('d/m/Y', $start_date_raw);
                            $end_dt   = DateTime::createFromFormat('d/m/Y', $end_date_raw);

                            $start_ts = $start_dt ? $start_dt->getTimestamp() : $now;
                            $end_ts   = $end_dt ? $end_dt->getTimestamp() : $now;

                            // MONTH/DAY for badge
                            $month_num = $start_dt ? $start_dt->format('m') : date('m');
                            $day_num   = $start_dt ? $start_dt->format('d') : date('d');
                            $date_range = $start_date_raw . ' - ' . $end_date_raw;

                            // Status Logic
                            $status_text = '';
                            $status_class = '';
                            if ($now < $start_ts) {
                                $status_text = __('SẮP DIỄN RA', 'child-theme');
                                $status_class = 'upcoming';
                            } elseif ($now >= $start_ts && $now <= $end_ts) {
                                $status_text = __('ĐĂNG KÝ NGAY', 'child-theme');
                                $status_class = 'active';
                            } else {
                                $status_text = __('ĐÃ KẾT THÚC', 'child-theme');
                                $status_class = 'finished';
                            }

                            $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $title = get_the_title();
                            $link = get_permalink();
                        ?>
                            <div class="event_item">
                                <div class="event_image_wrap">
                                    <?php if ($link): ?><a href="<?php echo $link; ?>"><?php endif; ?>
                                        <?php if ($img): ?>
                                            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" width="400" height="300">
                                        <?php else: ?>
                                            <div class="event_placeholder_img"></div>
                                        <?php endif; ?>
                                        <?php if ($link): ?>
                                        </a><?php endif; ?>

                                    <div class="event_date_badge">
                                        <span class="eb_month"><?php echo __('THÁNG', 'child-theme') . ' ' . $month_num; ?></span>
                                        <span class="eb_day"><?php echo $day_num; ?></span>
                                    </div>

                                    <div class="event_status_badge <?php echo $status_class; ?>">
                                        <?php echo $status_text; ?>
                                    </div>
                                </div>

                                <div class="event_content">
                                    <?php if ($title): ?>
                                        <h4 class="event_title">
                                            <?php if ($link): ?>
                                                <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                            <?php else: ?>
                                                <?php echo $title; ?>
                                            <?php endif; ?>
                                        </h4>
                                    <?php endif; ?>

                                    <div class="event_meta">
                                        <div class="em_row">
                                            <i class="fa-regular fa-clock"></i>
                                            <span><?php echo $date_range; ?></span>
                                        </div>
                                        <?php if ($location): ?>
                                            <div class="em_row">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span><?php echo $location; ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="lx_archive_pagination">
                        <?php
                        echo paginate_links([
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                            'type'      => 'list',
                        ]);
                        ?>
                    </div>

                <?php else : ?>
                    <p><?php echo __('Rất tiếc, chưa có sự kiện nào.', 'child-theme'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Sidebar: Right Column -->
            <aside class="lx_archive_sidebar_col">
                <div class="lx_archive_sidebar_widget">
                    <h3 class="lx_archive_sidebar_title"><?php echo __('Bài viết mới nhất', 'child-theme'); ?></h3>

                    <div class="lx_archive_sidebar_list">
                        <?php
                        $latest_query = new WP_Query([
                            'post_type'           => 'post',
                            'posts_per_page'      => 5,
                            'post_status'         => 'publish',
                            'ignore_sticky_posts' => 1,
                        ]);

                        if ($latest_query->have_posts()) :
                            while ($latest_query->have_posts()) : $latest_query->the_post();
                                $side_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                $side_title = get_the_title();
                                $side_link = get_permalink();
                                $side_cats = get_the_category();
                                $side_excerpt = wp_trim_words(get_the_excerpt(), 15, '...');
                        ?>
                                <div class="fp_side_post">
                                    <?php if ($side_link): ?>
                                    <a href="<?php echo $side_link; ?>" class="fp_side_image_link">
                                    <?php endif; ?>
                                        <div class="fp_side_image_wrap">
                                            <?php if ($side_img): ?>
                                                <img src="<?php echo $side_img; ?>" alt="<?php echo $side_title; ?>">
                                            <?php else: ?>
                                                <div class="lx_placeholder_thumb"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php if ($side_link): ?>
                                    </a>
                                    <?php endif; ?>

                                    <div class="fp_side_content">
                                        <h3 class="fp_title">
                                            <?php if ($side_link): ?>
                                                <a href="<?php echo $side_link; ?>"><?php echo $side_title; ?></a>
                                            <?php else: ?>
                                                <?php echo $side_title; ?>
                                            <?php endif; ?>
                                        </h3>
                                        <p class="fp_meta">
                                            <?php if (!empty($side_cats)): 
                                                $side_cat_name = $side_cats[0]->name;
                                            ?>
                                                <span class="fp_category_pill"><?php echo $side_cat_name; ?></span>
                                            <?php endif; ?>
                                            <span class="fp_date"><?php echo get_the_date('d/m/Y'); ?></span>
                                        </p>
                                    </div>
                                </div>
                        <?php endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</main>

<?php
get_footer();
