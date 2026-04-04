<?php

/**
 * The template for displaying all single posts
 *
 * @package Child_Theme
 */

get_header();
?>

<main class="lx_single_post_page section_box py_section">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>

            <!-- Breadcrumbs (Full Width) -->
            <div class="lx_single_post_breadcrumbs">
                <a href="<?php echo home_url('/'); ?>"><?php echo __('HOME', 'child-theme'); ?></a>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo ' <i class="fa-solid fa-chevron-right"></i> ';
                    echo '<a href="' . get_category_link($categories[0]->term_id) . '">' . strtoupper($categories[0]->name) . '</a>';
                }
                ?>
                <span class="lx_single_post_sep"> <i class="fa-solid fa-chevron-right"></i> </span>
                <span class="lx_single_post_current"><?php the_title(); ?></span>
            </div>

            <article id="post-<?php the_ID(); ?>" class="lx_single_post_article">

                <!-- Header (Full Width) -->
                <header class="lx_single_post_header">
                    <h1 class="lx_single_post_title"><?php the_title(); ?></h1>
                </header>

                <!-- Post Content Area (Narrow 800px) -->
                <div class="lx_single_post_content_narrow">
                    <div class="lx_single_post_meta_row">
                        <div class="lx_single_post_author_info">
                            <div class="lx_single_post_author_avatar">
                                <?php
                                $author_id = get_the_author_meta('ID');
                                $custom_avatar = get_field('lx_user_avatar', 'user_' . $author_id);
                                if ($custom_avatar) : ?>
                                    <img src="<?php echo $custom_avatar; ?>" alt="<?php the_author(); ?>" width="48" height="48">
                                <?php else : ?>
                                    <?php echo get_avatar($author_id, 48); ?>
                                <?php endif; ?>
                            </div>
                            <div class="lx_single_post_author_details">
                                <span class="lx_single_post_author_name"><?php the_author(); ?></span>
                            </div>
                        </div>
                        <div class="lx_single_post_published_date">
                            <span class="lx_single_post_date_label"><?php echo __('Ngày đăng', 'child-theme'); ?></span>
                            <span class="lx_single_post_date_value"><?php echo get_the_date('d/m/Y'); ?></span>
                        </div>
                    </div>

                    <div class="lx_single_post_entry_content">
                        <?php if (has_excerpt()) : ?>
                            <div class="lx_single_post_excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="lx_single_post_body editor">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

                <!-- Author Box (Full Width) -->
                <section class="lx_single_post_author_box_section">
                    <h3 class="lx_single_post_author_box_title"><?php echo __('Tác giả', 'child-theme'); ?></h3>
                    <div class="lx_single_post_author_box_content">
                        <div class="lx_single_post_author_box_avatar">
                            <?php
                            if ($custom_avatar) : ?>
                                <img src="<?php echo $custom_avatar; ?>" alt="<?php the_author(); ?>" width="150" height="150">
                            <?php else : ?>
                                <?php echo get_avatar($author_id, 150); ?>
                            <?php endif; ?>
                        </div>
                        <div class="lx_single_post_author_box_details">
                            <div class="lx_single_post_author_box_bio">
                                <?php the_author_meta('description'); ?>
                            </div>
                            <div class="lx_single_post_author_box_name">
                                <?php the_author(); ?>
                            </div>
                            <div class="lx_single_post_author_box_socials">
                                <?php
                                $facebook  = get_field('lx_user_facebook', 'user_' . $author_id);
                                $youtube   = get_field('lx_user_youtube', 'user_' . $author_id);
                                $zalo      = get_field('lx_user_zalo', 'user_' . $author_id);
                                ?>
                                <?php if ($facebook) : ?>
                                    <a href="<?php echo $facebook; ?>" target="_blank" class="lx_single_post_social_item lx_fb">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($youtube) : ?>
                                    <a href="<?php echo $youtube; ?>" target="_blank" class="lx_single_post_social_item lx_yt">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($zalo) : ?>
                                    <a href="<?php echo $zalo; ?>" target="_blank" class="lx_single_post_social_item lx_zalo">
                                        <span>Zalo</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>

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
        <section class="lx_related_posts_section py_section section_box">
            <div class="container">
                <div class="lx_related_posts_header">
                    <h2 class="lx_related_posts_title"><?php echo __('BÀI VIẾT LIÊN QUAN', 'child-theme'); ?></h2>
                </div>
                <div class="cs_post_grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                        $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $title = get_the_title();
                        $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                        $link = get_permalink();
                        $post_categories = get_the_category();
                    ?>
                        <div class="cs_post_item">
                            <?php if ($link) : ?>
                                <a href="<?php echo $link; ?>" class="cs_post_image_link">
                            <?php endif; ?>
                                <div class="cs_post_image_wrap">
                                    <?php if ($img) : ?>
                                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" width="400" height="300">
                                    <?php else : ?>
                                        <div class="cs_placeholder_img"></div>
                                    <?php endif; ?>
                                </div>
                            <?php if ($link) : ?>
                                </a>
                            <?php endif; ?>

                            <div class="cs_post_content">
                                <?php if (!empty($post_categories)) : ?>
                                    <a href="<?php echo get_category_link($post_categories[0]->term_id); ?>" class="fp_category_link">
                                        <span class="fp_category"><?php echo $post_categories[0]->name; ?></span>
                                    </a>
                                <?php endif; ?>

                                <?php if ($title) : ?>
                                    <h4 class="cs_post_title">
                                        <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                    </h4>
                                <?php endif; ?>

                                <?php if ($excerpt) : ?>
                                    <p class="cs_post_excerpt"><?php echo $excerpt; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
<?php
    endif;
endif;

get_footer();
?>
