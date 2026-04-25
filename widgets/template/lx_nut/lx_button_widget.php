<?php
if (!defined('ABSPATH')) exit;

/**
 * Widget Nút (LX Button)
 *
 * Các biến thể nút đi theo màu chủ đạo (--lx-primary-color).
 * Chỉ cho phép thay đổi text, link, và biến thể.
 * Toàn bộ màu sắc, bo góc, padding được kiểm soát bằng CSS class lx_btn_*.
 */
class LX_Button_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_button';
    }

    public function get_title(): string
    {
        return __('Nút', 'child-theme');
    }

    public function get_icon(): string
    {
        return 'eicon-button'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories(): array
    {
        return ['lx_nut'];
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
            'van_ban',
            [
                'label'       => __('Văn bản nút', 'child-theme'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Tìm hiểu thêm', 'child-theme'),
                'placeholder' => __('Nhập văn bản nút...', 'child-theme'),
            ]
        );

        $this->add_control(
            'lien_ket',
            [
                'label'         => __('Liên kết', 'child-theme'),
                'type'          => \Elementor\Controls_Manager::URL,
                'placeholder'   => 'https://',
                'show_external' => true,
                'default'       => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

        $this->add_control(
            'bien_the',
            [
                'label'   => __('Biến thể', 'child-theme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'primary',
                'options' => [
                    'primary' => __('Đặc (Primary)', 'child-theme'),
                    'outline' => __('Viền (Outline)', 'child-theme'),
                    'ghost'   => __('Mờ (Ghost)', 'child-theme'),
                    'text'    => __('Chỉ text (Text)', 'child-theme'),
                ],
            ]
        );

        $this->add_control(
            'kich_thuoc',
            [
                'label'   => __('Kích thước', 'child-theme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'sm' => __('Nhỏ', 'child-theme'),
                    'md' => __('Vừa', 'child-theme'),
                    'lg' => __('Lớn', 'child-theme'),
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
        $van_ban   = $settings['van_ban'] ?? '';
        $lien_ket  = $settings['lien_ket'] ?? [];
        $bien_the  = in_array($settings['bien_the'], ['primary','outline','ghost','text'], true)
                        ? $settings['bien_the']
                        : 'primary';
        $kich_thuoc = in_array($settings['kich_thuoc'], ['sm','md','lg'], true)
                        ? $settings['kich_thuoc']
                        : 'md';
        $can_le    = in_array($settings['can_le'], ['left','center','right'], true)
                        ? $settings['can_le']
                        : 'left';

        if (empty($van_ban)) {
            return;
        }

        $url      = !empty($lien_ket['url']) ? esc_url($lien_ket['url']) : '#';
        $target   = !empty($lien_ket['is_external']) ? ' target="_blank"' : '';
        $nofollow = !empty($lien_ket['nofollow'])    ? ' rel="nofollow"'  : '';

        printf(
            '<div class="lx_btn_wrap lx_btn_wrap_%1$s"><a href="%2$s"%3$s%4$s class="lx_btn lx_btn_%5$s lx_btn_%6$s">%7$s</a></div>',
            esc_attr($can_le),
            $url,
            $target,
            $nofollow,
            esc_attr($bien_the),
            esc_attr($kich_thuoc),
            esc_html($van_ban)
        );
    }
}
