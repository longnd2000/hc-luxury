<?php
/**
 * Widget Name: LX Post Content
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;

class LX_Post_Content_Widget extends Widget_Base
{
    public function get_name() { return 'lx_post_content'; }
    public function get_title() { return __('LX — Post Content', 'lx-landing'); }
    public function get_icon() { return 'eicon-post-content'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function render()
    {
        echo '<div class="lx_single_post_body editor">';
        the_content();
        echo '</div>';
    }
}
