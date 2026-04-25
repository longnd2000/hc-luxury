<?php
if (!defined('ABSPATH')) exit;

/**
 * Widget Nút (LX Button)
 *
 * Chỉ cho phép thay đổi văn bản và liên kết.
 * Toàn bộ kiểu dáng được kiểm soát 100% bằng Theme Settings (inc/theme-options.php).
 * 
 * @package LX_Landing
 */
class LX_Button_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_button';
    }

    public function get_title(): string
    {
        return __('LX — Nút', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-button';
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
                'label' => __('Nội dung', 'lx-landing'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'van_ban',
            [
                'label'       => __('Văn bản nút', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Tìm hiểu thêm', 'lx-landing'),
                'placeholder' => __('Nhập văn bản nút...', 'lx-landing'),
            ]
        );

        $this->add_control(
            'lien_ket',
            [
                'label'         => __('Liên kết', 'lx-landing'),
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

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings  = $this->get_settings_for_display();
        $van_ban   = $settings['van_ban'] ?? '';
        $lien_ket  = $settings['lien_ket'] ?? [];

        if (empty($van_ban)) {
            return;
        }

        $url      = !empty($lien_ket['url']) ? esc_url($lien_ket['url']) : '#';
        $target   = !empty($lien_ket['is_external']) ? ' target="_blank"' : '';
        $nofollow = !empty($lien_ket['nofollow'])    ? ' rel="nofollow"'  : '';

        // Luôn sử dụng class lx_btn lx_btn_primary để nhận style từ Theme Settings
        printf(
            '<div class="lx_btn_wrap"><a href="%1$s"%2$s%3$s class="lx_btn lx_btn_primary">%4$s</a></div>',
            $url,
            $target,
            $nofollow,
            esc_html($van_ban)
        );
    }
}
