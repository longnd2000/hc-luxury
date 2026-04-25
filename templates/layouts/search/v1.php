<?php
/**
 * Layout Version: v1 (Default)
 * Part: Search
 */
?>
<main class="lx_archive_page section_box py_section">
    <div class="container">

        <!-- Breadcrumbs -->
        <?php echo lx_get_breadcrumbs(); ?>


        <!-- Archive Main Section -->
        <div class="row">

            <!-- Main Content: Left Column -->
            <div class="col-lg-8">
                <header class="lx_archive_main_header mb-5">
                    <h1 class="lx_archive_main_title">
                        <?php
                        /* translators: %s: search query. */
                        printf(__('Kết quả tìm kiếm cho: "%s"', 'lx-landing'), '<span>' . get_search_query() . '</span>');
                        ?>
                    </h1>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="row">
                        <?php while (have_posts()) : the_post();
                            $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            $title = get_the_title();
                            $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                            $link = get_permalink();
                            $categories = get_the_category();
                        ?>
                            <div class="col-md-6 mb-4">
                                <?php include(get_stylesheet_directory() . '/templates/parts/post_card.php'); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="lx_archive_pagination mt-5">
                        <?php
                        echo paginate_links([
                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                            'type'      => 'list',
                        ]);
                        ?>
                    </div>

                <?php else : ?>
                    <p><?php echo __('Rất tiếc, không tìm thấy bài viết nào phù hợp với từ khóa của bạn.', 'lx-landing'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Sidebar: Right Column -->
            <div class="col-lg-4">
                <?php include(get_stylesheet_directory() . '/templates/parts/sidebar_latest_posts.php'); ?>
            </div>

        </div>
    </div>
</main>
