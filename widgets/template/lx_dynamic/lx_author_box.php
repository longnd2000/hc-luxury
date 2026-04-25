<?php
/**
 * Widget Name: LX Author Box
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;

class LX_Author_Box_Widget extends Widget_Base
{
    public function get_name() { return 'lx_author_box'; }
    public function get_title() { return __('LX — Author Box', 'lx-landing'); }
    public function get_icon() { return 'eicon-author-box'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function render()
    {
        $author_id = get_the_author_meta('ID');
        $custom_avatar = get_field('lx_user_avatar', 'user_' . $author_id);
?>
        <section class="lx_single_post_author_box_section pt-5 border-top">
            <h2 class="lx_single_post_author_box_title mb-4"><?php echo __('Tác giả', 'lx-landing'); ?></h2>
            <div class="lx_single_post_author_box_content row align-items-center">
                <div class="lx_single_post_author_box_avatar col-md-3 text-center mb-3 mb-md-0">
                    <?php if ($custom_avatar) : ?>
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
<?php
    }
}
