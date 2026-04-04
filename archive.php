<?php
/**
 * The template for displaying archive pages
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
            <span><?php the_archive_title(); ?></span>
        </nav>

        <!-- Archive Main Section -->
        <div class="lx_archive_container">
            
            <!-- Main Content: Left Column -->
            <div class="lx_archive_main_col">
                <header class="lx_archive_main_header">
                    <?php
                    the_archive_title('<h1 class="lx_archive_main_title">', '</h1>');
                    the_archive_description('<div class="lx_archive_main_desc">', '</div>');
                    ?>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="lx_archive_grid">
                        <?php while (have_posts()) : the_post(); 
                            $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $title = get_the_title();
                            $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                            $link = get_permalink();
                            $categories = get_the_category();
                        ?>
                            <!-- Main List Item: following EXACT format of category_section_widget.php (cs_post_item) -->
                            <div class="cs_post_item">
                                <?php if ($link): ?>
                                <a href="<?php echo $link; ?>" class="cs_post_image_link">
                                <?php endif; ?>
                                    <div class="cs_post_image_wrap">
                                        <?php if ($img): ?>
                                            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" width="400" height="300">
                                        <?php else: ?>
                                            <div class="cs_placeholder_img"></div>
                                        <?php endif; ?>
                                    </div>
                                <?php if ($link): ?>
                                </a>
                                <?php endif; ?>

                                <div class="cs_post_content">
                                    <?php if (!empty($categories)):
                                        $cat_name = $categories[0]->name;
                                        $cat_link = get_category_link($categories[0]->term_id);
                                    ?>
                                        <?php if ($cat_link): ?>
                                            <a href="<?php echo $cat_link; ?>" class="fp_category_link">
                                        <?php endif; ?>
                                            <span class="fp_category"><?php echo $cat_name; ?></span>
                                        <?php if ($cat_link): ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if ($title): ?>
                                        <h4 class="cs_post_title">
                                            <?php if ($link): ?>
                                                <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                            <?php else: ?>
                                                <?php echo $title; ?>
                                            <?php endif; ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if ($excerpt): ?>
                                        <p class="cs_post_excerpt"><?php echo $excerpt; ?></p>
                                    <?php endif; ?>
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
                    <p><?php echo __('Rất tiếc, không tìm thấy bài viết nào.', 'child-theme'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Sidebar: Right Column -->
            <aside class="lx_archive_sidebar_col">
                <div class="lx_archive_sidebar_widget">
                    <h3 class="lx_archive_sidebar_title"><?php echo __('Bài viết mới nhất', 'child-theme'); ?></h3>
                    
                    <div class="lx_archive_sidebar_list">
                        <?php
                        $latest_query = new WP_Query([
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
                            <div class="lx_archive_side_post">
                                <div class="lx_archive_side_post_thumb">
                                    <?php if ($side_img): ?>
                                        <a href="<?php echo $side_link; ?>">
                                            <img src="<?php echo $side_img; ?>" alt="<?php echo $side_title; ?>" width="100" height="75">
                                        </a>
                                    <?php else: ?>
                                        <div class="lx_placeholder_thumb"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="lx_archive_side_post_content">
                                    <div class="lx_archive_side_post_meta">
                                        <?php if (!empty($side_cats)): 
                                            $side_cat_name = $side_cats[0]->name;
                                            $side_cat_link = get_category_link($side_cats[0]->term_id);
                                        ?>
                                            <a href="<?php echo $side_cat_link; ?>" class="fp_category_link">
                                                <span class="fp_category"><?php echo $side_cat_name; ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h5 class="lx_archive_side_post_title">
                                        <a href="<?php echo $side_link; ?>"><?php echo $side_title; ?></a>
                                    </h5>
                                    
                                    <?php if ($side_excerpt): ?>
                                        <p class="lx_archive_side_post_excerpt"><?php echo $side_excerpt; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</main>

<?php
get_footer();
