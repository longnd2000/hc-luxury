<?php
/**
 * Widget Name: LX Archive Title
 * Category: lx_dynamic
 *
 * @package LX_Landing
 */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class LX_Archive_Title_Widget extends Widget_Base
{
    public function get_name() { return 'lx_archive_title_widget'; }
    public function get_title() { return __('LX — Archive Title', 'lx-landing'); }
    public function get_icon() { return 'eicon-archive-title'; }
    public function get_categories() { return ['lx_dynamic']; }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', ['label' => __('Cấu hình', 'lx-landing')]);
        $this->add_control('show_description', [
            'label' => __('Hiển thị mô tả', 'lx-landing'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        if (is_search()) {
            echo '<h1 class="lx_archive_main_title">' . sprintf(__('Kết quả tìm kiếm cho: %s', 'lx-landing'), '<span>' . get_search_query() . '</span>') . '</h1>';
        } else {
            the_archive_title('<h1 class="lx_archive_main_title">', '</h1>');
            if ($settings['show_description'] === 'yes') {
                the_archive_description('<div class="lx_archive_main_desc">', '</div>');
            }
        }
    }
}
