<?php

/**
 * Component: Post Card (cs_post_item)
 *
 * Reusable post card markup used across archive, search, single (related), and category section widget.
 *
 * Expected variables:
 * @var string $img        — Post thumbnail URL
 * @var string $title      — Post title
 * @var string $excerpt    — Trimmed excerpt
 * @var string $link       — Post permalink
 * @var array  $categories — Array of WP category objects (from get_the_category())
 */
?>

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
        <div class="fp_meta">
            <?php if (!empty($categories)):
                $cat_name = $categories[0]->name;
                $cat_link = get_category_link($categories[0]->term_id);
            ?>
                <?php if ($cat_link): ?>
                    <a href="<?php echo $cat_link; ?>" class="fp_category_link">
                    <?php endif; ?>
                    <span class="fp_category_pill"><?php echo $cat_name; ?></span>
                    <?php if ($cat_link): ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            <span class="fp_date"><?php echo get_the_date('d/m/Y'); ?></span>
        </div>

        <?php if ($title): ?>
            <h3 class="cs_post_title">
                <?php if ($link): ?>
                    <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                <?php else: ?>
                    <?php echo $title; ?>
                <?php endif; ?>
            </h3>
        <?php endif; ?>

        <?php if ($excerpt): ?>
            <p class="cs_post_excerpt"><?php echo $excerpt; ?></p>
        <?php endif; ?>

        <?php if ($link): ?>
            <div class="cs_post_footer">
                <a href="<?php echo $link; ?>" class="fp_read_more"><?php echo __('Xem thêm &rarr;', 'lx-landing'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>
