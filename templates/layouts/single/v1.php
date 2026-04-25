<?php
/**
 * Layout Version: v1 (Default)
 * Part: Single Post
 */
?>
<main class="lx_single_post_page section_box py_section">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>

            <!-- Breadcrumbs -->
            <?php echo lx_get_breadcrumbs(); ?>


            <article id="post-<?php the_ID(); ?>" class="lx_single_post_article">

                <!-- Header (Full Width) -->
                <header class="lx_single_post_header mb-5 pb-4">
                    <h1 class="lx_single_post_title"><?php the_title(); ?></h1>
                </header>

                <!-- Post Content Area -->
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="lx_single_post_meta_row d-flex justify-content-between align-items-center mb-5">
                            <div class="lx_single_post_author_info d-flex align-items-center gap-3">
                                <div class="lx_single_post_author_avatar">
                                    <?php
                                    $author_id = get_the_author_meta('ID');
                                    $custom_avatar = get_field('lx_user_avatar', 'user_' . $author_id);
                                    if ($custom_avatar) : ?>
                                        <img src="<?php echo $custom_avatar; ?>" alt="<?php the_author(); ?>" width="48" height="48" class="rounded-circle">
                                    <?php else : ?>
                                        <?php echo get_avatar($author_id, 48, '', '', ['class' => 'rounded-circle']); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="lx_single_post_author_details">
                                    <span class="lx_single_post_author_name fw-bold"><?php the_author(); ?></span>
                                </div>
                            </div>
                            <div class="lx_single_post_published_date text-end">
                                <span class="lx_single_post_date_label d-block text-muted small text-uppercase"><?php echo __('Ngày đăng', 'child-theme'); ?></span>
                                <span class="lx_single_post_date_value"><?php echo get_the_date('d/m/Y'); ?></span>
                            </div>
                        </div>

                        <div class="lx_single_post_entry_content">
                            <?php if (has_excerpt()) : ?>
                                <div class="lx_single_post_excerpt border-start border-primary ps-4 mb-4 font-italic">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="lx_single_post_body editor">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- Author Box -->
                        <section class="lx_single_post_author_box_section mt-5 pt-5 border-top">
                            <h2 class="lx_single_post_author_box_title mb-4"><?php echo __('Tác giả', 'child-theme'); ?></h2>
                            <div class="lx_single_post_author_box_content row align-items-center">
                                <div class="lx_single_post_author_box_avatar col-md-3 text-center mb-3 mb-md-0">
                                    <?php
                                    if ($custom_avatar) : ?>
                                        <img src="<?php echo $custom_avatar; ?>" alt="<?php the_author(); ?>" width="120" height="120" class="rounded-circle bg-light">
                                    <?php else : ?>
                                        <?php echo get_avatar($author_id, 120, '', '', ['class' => 'rounded-circle bg-light']); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="lx_single_post_author_box_details col-md-9">
                                    <div class="lx_single_post_author_box_bio mb-3 text-muted">
                                        <?php the_author_meta('description'); ?>
                                    </div>
                                    <div class="lx_single_post_author_box_name fw-bold mb-3 h5">
                                        <?php the_author(); ?>
                                    </div>
                                    <div class="lx_single_post_author_box_socials d-flex gap-3">
                                        <?php
                                        $facebook  = get_field('lx_user_facebook', 'user_' . $author_id);
                                        $youtube   = get_field('lx_user_youtube', 'user_' . $author_id);
                                        $zalo      = get_field('lx_user_zalo', 'user_' . $author_id);
                                        ?>
                                        <?php if ($facebook) : ?>
                                            <a href="<?php echo $facebook; ?>" target="_blank" class="text-secondary"><i class="fa-brands fa-facebook-f"></i></a>
                                        <?php endif; ?>
                                        <?php if ($youtube) : ?>
                                            <a href="<?php echo $youtube; ?>" target="_blank" class="text-secondary"><i class="fa-brands fa-youtube"></i></a>
                                        <?php endif; ?>
                                        <?php if ($zalo) : ?>
                                            <a href="<?php echo $zalo; ?>" target="_blank" class="text-secondary small">Zalo</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </article>

        <?php endwhile; ?>
    </div>
</main>

<!-- Related Posts Section (Full Width) -->
<?php
$categories = get_the_category();
if ($categories) :
    $cat_ids = array();
    foreach ($categories as $cat) {
        $cat_ids[] = $cat->term_id;
    }

    $related_args = array(
        'category__in'        => $cat_ids,
        'post__not_in'        => array(get_the_ID()),
        'posts_per_page'      => 4,
        'ignore_sticky_posts' => 1,
        'post_status'         => 'publish',
    );

    $related_query = new WP_Query($related_args);

    if ($related_query->have_posts()) :
?>
        <section class="lx_related_posts_section py_section section_box bg-light">
            <div class="container">
                <div class="lx_related_posts_header mb-4">
                    <h2 class="lx_related_posts_title"><?php echo __('BÀI VIẾT LIÊN QUAN', 'child-theme'); ?></h2>
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
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
<?php
    endif;
endif;
