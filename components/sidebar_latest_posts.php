<?php

/**
 * Component: Sidebar Latest Posts
 *
 * Self-contained sidebar widget block displaying recent posts.
 * Includes its own WP_Query — no external data required.
 *
 * Used in: archive.php, archive-event.php, search.php
 */
?>

<aside class="lx_archive_sidebar_col">
    <div class="lx_archive_sidebar_widget">
        <h2 class="lx_archive_sidebar_title"><?php echo __('Bài viết mới nhất', 'child-theme'); ?></h2>

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
            ?>
                    <div class="fp_side_post">
                        <?php if ($side_link): ?>
                            <a href="<?php echo $side_link; ?>" class="fp_side_image_link">
                            <?php endif; ?>
                            <div class="fp_side_image_wrap">
                                <?php if ($side_img): ?>
                                    <img src="<?php echo $side_img; ?>" alt="<?php echo $side_title; ?>" width="400" height="300">
                                <?php else: ?>
                                    <div class="fp_placeholder_img"></div>
                                <?php endif; ?>
                            </div>
                            <?php if ($side_link): ?>
                            </a>
                        <?php endif; ?>

                        <div class="fp_side_content">
                            <div class="fp_meta">
                                <?php if ($side_link): ?>
                                    <span class="fp_date"><?php echo get_the_date('d/m/Y'); ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if ($side_title): ?>
                                <h3 class="fp_title">
                                    <?php if ($side_link): ?>
                                        <a href="<?php echo $side_link; ?>"><?php echo $side_title; ?></a>
                                    <?php else: ?>
                                        <?php echo $side_title; ?>
                                    <?php endif; ?>
                                </h3>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</aside>
