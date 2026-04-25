<?php
if (!defined('ABSPATH')) exit;

/**
 * Widget Văn bản (LX Text Editor)
 *
 * Cung cấp WYSIWYG editor đơn giản.
 * Toàn bộ typography (font-size, line-height, màu sắc) được kiểm soát
 * bằng CSS class lx_text_editor trong _style.scss.
 */
class LX_Text_Editor_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_text_editor';
    }

    public function get_title(): string
    {
        return __('Văn bản', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-text'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories(): array
    {
        return ['lx_text_editor'];
    }

    protected function _register_controls(): void
    {
        $this->start_controls_section(
            'section_noi_dung',
            [
                'label' => __('Nội dung', 'lx-landing'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'noi_dung',
            [
                'label'      => __('Nội dung văn bản', 'lx-landing'),
                'type'       => \Elementor\Controls_Manager::WYSIWYG,
                'default'    => __('Nhập nội dung văn bản tại đây...', 'lx-landing'),
                'show_label' => false,
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $noi_dung = $settings['noi_dung'] ?? '';

        if (empty($noi_dung)) {
            return;
        }

        echo '<div class="lx_text_editor">';
        echo wp_kses_post($noi_dung);
        echo '</div>';
    }
}
