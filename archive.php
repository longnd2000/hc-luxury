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
                            <?php include(get_stylesheet_directory() . '/components/post_card.php'); ?>
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

            <?php include(get_stylesheet_directory() . '/components/sidebar_latest_posts.php'); ?>

        </div>
    </div>
</main>

<?php
get_footer();
