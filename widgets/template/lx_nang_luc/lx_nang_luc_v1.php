<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Our Capabilities V1 Widget
 */
class LX_Nang_Luc_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_nang_luc_v1';
    }

    public function get_title()
    {
        return __('LX — Năng lực V1', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-skill-bar';
    }

    public function get_categories()
    {
        return ['lx_gioi_thieu'];
    }

    protected function _register_controls()
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
                'default'     => __('Năng lực của chúng tôi', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __('Mô tả ngắn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Chúng tôi sở hữu đa dạng kỹ năng và chuyên môn để mang đến những giải pháp hiệu quả và giá trị bền vững cho mọi dự án.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // ── Skills List ───────────────────────────────────────────────────
        $this->start_controls_section(
            'section_skills',
            [
                'label' => __('Danh sách năng lực', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_icon',
            [
                'label'   => __('Icon', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-lightbulb',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label'       => __('Tên năng lực', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Tư duy chiến lược', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_percent',
            [
                'label'   => __('Phần trăm (%)', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
                'default' => 90,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'   => __('Mô tả chi tiết', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Phân tích, định hướng và lập kế hoạch chiến lược hiệu quả.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'skill_list',
            [
                'label'       => __('Items', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_title' => __('Tư duy chiến lược', 'lx-landing'),
                        'item_percent' => 90,
                        'item_icon' => ['value' => 'fas fa-lightbulb', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Thiết kế sáng tạo', 'lx-landing'),
                        'item_percent' => 85,
                        'item_icon' => ['value' => 'fas fa-pen-nib', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Lập trình & Công nghệ', 'lx-landing'),
                        'item_percent' => 90,
                        'item_icon' => ['value' => 'fas fa-code', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Phân tích dữ liệu', 'lx-landing'),
                        'item_percent' => 80,
                        'item_icon' => ['value' => 'fas fa-chart-line', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Quản lý dự án', 'lx-landing'),
                        'item_percent' => 85,
                        'item_icon' => ['value' => 'fas fa-user-friends', 'library' => 'solid'],
                    ],
                    [
                        'item_title' => __('Đảm bảo chất lượng', 'lx-landing'),
                        'item_percent' => 90,
                        'item_icon' => ['value' => 'fas fa-shield-alt', 'library' => 'solid'],
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="lx_nang_luc_v1">
            <div class="lx_wrap">
                <div class="lx_con">
                    
                    <!-- Section Header -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-xl-8 col-lg-10 text-center">
                            <?php if (!empty($settings['title'])) : ?>
                                <h2 class="lx_heading lx_heading_h2 lx_heading_align_center mb-3">
                                    <?php echo esc_html($settings['title']); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if (!empty($settings['description'])) : ?>
                                <div class="lx_text_editor lx_text_editor_align_center">
                                    <?php echo nl2br(esc_html($settings['description'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Skills Grid -->
                    <?php if (!empty($settings['skill_list'])) : ?>
                        <div class="row lx_g32">
                            <?php foreach ($settings['skill_list'] as $item) : ?>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="lx_skill_item">
                                        <div class="lx_skill_icon_wrap">
                                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
                                        </div>
                                        <div class="lx_skill_content">
                                            <div class="lx_skill_header">
                                                <h3 class="lx_skill_title"><?php echo esc_html($item['item_title']); ?></h3>
                                            </div>
                                            
                                            <div class="lx_skill_bar_wrap">
                                                <div class="lx_skill_bar">
                                                    <div class="lx_skill_bar_inner" style="width: <?php echo esc_attr($item['item_percent']); ?>%;"></div>
                                                </div>
                                                <span class="lx_skill_percent"><?php echo esc_html($item['item_percent']); ?>%</span>
                                            </div>

                                            <div class="lx_skill_desc">
                                                <?php echo nl2br(esc_html($item['item_description'])); ?>
                                            </div>
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
