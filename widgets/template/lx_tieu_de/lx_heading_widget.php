<?php
if (!defined('ABSPATH')) exit;

/**
 * Widget Tiêu đề (LX Heading)
 *
 * Cho phép chọn cấp tiêu đề h1–h6.
 * Kiểu chữ (font-weight 700, line-height 1.3, màu chủ đạo) được
 * kiểm soát hoàn toàn bằng CSS class lx_heading — không có style control.
 */
class LX_Heading_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_heading';
    }

    public function get_title(): string
    {
        return __('Tiêu đề', 'child-theme');
    }

    public function get_icon(): string
    {
        return 'eicon-heading'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories(): array
    {
        return ['lx_tieu_de'];
    }

    protected function _register_controls(): void
    {
        $this->start_controls_section(
            'section_noi_dung',
            [
                'label' => __('Nội dung', 'child-theme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'noi_dung',
            [
                'label'       => __('Nội dung tiêu đề', 'child-theme'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => __('Tiêu đề của bạn', 'child-theme'),
                'placeholder' => __('Nhập tiêu đề...', 'child-theme'),
            ]
        );

        $this->add_control(
            'cap_tieu_de',
            [
                'label'   => __('Cấp tiêu đề (HTML tag)', 'child-theme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
            ]
        );

        $this->add_control(
            'can_le',
            [
                'label'   => __('Căn lề', 'child-theme'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left'   => [
                        'title' => __('Trái', 'child-theme'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Giữa', 'child-theme'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Phải', 'child-theme'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings  = $this->get_settings_for_display();
        $tag       = in_array($settings['cap_tieu_de'], ['h1','h2','h3','h4','h5','h6'], true)
                        ? $settings['cap_tieu_de']
                        : 'h2';
        $can_le    = in_array($settings['can_le'], ['left','center','right'], true)
                        ? $settings['can_le']
                        : 'left';
        $noi_dung  = $settings['noi_dung'] ?? '';

        if (empty($noi_dung)) {
            return;
        }

        printf(
            '<%1$s class="lx_heading lx_heading_%1$s lx_heading_align_%2$s">%3$s</%1$s>',
            esc_attr($tag),
            esc_attr($can_le),
            wp_kses_post($noi_dung)
        );
    }
}
