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
                            <?php include(get_stylesheet_directory() . '/components/event_card.php'); ?>
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

            <?php include(get_stylesheet_directory() . '/components/sidebar_latest_posts.php'); ?>

        </div>
    </div>
</main>

<?php
get_footer();
