<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Core Values V1 Widget
 * 
 * Display a grid of core values with icons, numbers, and descriptions.
 * Following project rules: 8-column centered header, lx_g32 grid.
 */
class LX_Gia_Tri_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_gia_tri_v1';
    }

    public function get_title(): string
    {
        return __('LX — Giá trị cốt lõi V1', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-skill-bar';
    }

    public function get_categories(): array
    {
        return ['lx_gia_tri'];
    }

    protected function register_controls(): void
    {
        // ── Section Header ───────────────────────────────────────────────────
        $this->start_controls_section(
            'section_header',
            [
                'label' => __('Đầu mục', 'lx-landing'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Tiêu đề chính', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => __('NHỮNG GIÁ TRỊ TẠO NÊN BẢN SẮC CỦA CHÚNG TÔI', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __('Mô tả ngắn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Chúng tôi kiên định với những giá trị cốt lõi – nền tảng cho mọi quyết định, hành động và sự phát triển bền vững.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // ── Values List ──────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_values',
            [
                'label' => __('Danh sách giá trị', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'       => __('Tiêu đề giá trị', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Chất lượng hàng đầu', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'   => __('Mô tả giá trị', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Cam kết mang đến sản phẩm và dịch vụ chất lượng cao nhất, vượt trên sự mong đợi của khách hàng.', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => __('Icon', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-gem',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'value_list',
            [
                'label'       => __('Items', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_title' => __('Chất lượng hàng đầu', 'lx-landing'),
                        'item_icon'  => ['value' => 'fas fa-gem', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Uy tín & minh bạch', 'lx-landing'),
                        'item_icon'  => ['value' => 'fas fa-shield-alt', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Đổi mới & sáng tạo', 'lx-landing'),
                        'item_icon'  => ['value' => 'fas fa-lightbulb', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Hợp tác & tôn trọng', 'lx-landing'),
                        'item_icon'  => ['value' => 'fas fa-users', 'library' => 'solid'],
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="lx_gia_tri_v1">
            <div class="lx_wrap">
                <div class="lx_con">
                    
                    <!-- Section Header (Rule: 8 columns centered) -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-xl-8 lx_text_center">
                            <?php if ($settings['title']) : ?>
                                <h2 class="lx_heading lx_heading_h2 lx_heading_align_center mb-3">
                                    <?php echo esc_html($settings['title']); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if ($settings['description']) : ?>
                                <div class="lx_text_editor">
                                    <?php echo nl2br(esc_html($settings['description'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Values Grid (Rule: lx_g32 + 4 columns on PC) -->
                    <?php if (!empty($settings['value_list'])) : ?>
                        <div class="row lx_g32">
                            <?php 
                            $count = 0;
                            foreach ($settings['value_list'] as $item) : 
                                $count++;
                                $number = str_pad($count, 2, '0', STR_PAD_LEFT);
                            ?>
                                <div class="col-12 col-md-6 col-xl-3 mb-4">
                                    <div class="lx_value_card">
                                        <div class="lx_value_number"><?php echo esc_html($number); ?></div>
                                        
                                        <div class="lx_value_icon_wrap">
                                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
                                        </div>

                                        <h3 class="lx_value_title"><?php echo esc_html($item['item_title']); ?></h3>
                                        
                                        <div class="lx_value_sep"></div>

                                        <div class="lx_value_desc">
                                            <?php echo nl2br(esc_html($item['item_description'])); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
    }
}
