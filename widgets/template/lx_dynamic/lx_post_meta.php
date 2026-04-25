<?php
/**
 * Widget Name: LX Post Meta
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;

class LX_Post_Meta_Widget extends Widget_Base
{
    public function get_name() { return 'lx_post_meta'; }
    public function get_title() { return __('LX — Post Meta', 'lx-landing'); }
    public function get_icon() { return 'eicon-post-info'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function render()
    {
?>
        <div class="lx_single_post_meta_row d-flex justify-content-between align-items-center mb-4">
            <div class="lx_single_post_author_info d-flex align-items-center gap-3">
                <div class="lx_single_post_author_avatar">
                    <?php
                    $author_id = get_the_author_meta('ID');
                    $custom_avatar = get_field('lx_user_avatar', 'user_' . $author_id);
                    if ($custom_avatar) : ?>
                        <img src="<?php echo $custom_avatar; ?>" alt="<?php the_author(); ?>" width="40" height="40" class="rounded-circle">
                    <?php else : ?>
                        <?php echo get_avatar($author_id, 40, '', '', ['class' => 'rounded-circle']); ?>
                    <?php endif; ?>
                </div>
                <div class="lx_single_post_author_details">
                    <span class="lx_single_post_author_name fw-bold"><?php the_author(); ?></span>
                </div>
            </div>
            <div class="lx_single_post_published_date text-end">
                <span class="lx_single_post_date_label d-block text-muted small text-uppercase"><?php echo __('Ngày đăng', 'lx-landing'); ?></span>
                <span class="lx_single_post_date_value"><?php echo get_the_date('d/m/Y'); ?></span>
            </div>
        </div>
<?php
    }
}
