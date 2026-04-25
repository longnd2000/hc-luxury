<?php
/**
 * Widget Name: LX Post Title
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class LX_Post_Title_Widget extends Widget_Base
{
    public function get_name() { return 'lx_post_title'; }
    public function get_title() { return __('LX — Post Title', 'lx-landing'); }
    public function get_icon() { return 'eicon-post-title'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => __('Cấu hình', 'lx-landing')]);
        $this->add_control('tag', [
            'label' => __('HTML Tag', 'lx-landing'),
            'type' => Controls_Manager::SELECT,
            'default' => 'h1',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'div' => 'DIV',
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tag = $settings['tag'];
        echo sprintf('<%1$s class="lx_single_post_title">%2$s</%1$s>', $tag, get_the_title());
    }
}
