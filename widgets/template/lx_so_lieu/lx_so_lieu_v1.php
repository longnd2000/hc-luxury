<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class LX_So_Lieu_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_so_lieu_v1';
    }

    public function get_title()
    {
        return __('LX — Số liệu V1', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-counter';
    }

    public function get_categories()
    {
        return ['lx_so_lieu'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'number',
            [
                'label' => __('Con số', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '50',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'suffix',
            [
                'label' => __('Hậu tố (ví dụ: +, %)', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '+',
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label' => __('Nhãn', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Dự án', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'stats_items',
            [
                'label' => __('Danh sách con số', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'number' => '5',
                        'suffix' => '+',
                        'label' => __('kinh nghiệm', 'lx-landing'),
                    ],
                    [
                        'number' => '50',
                        'suffix' => '+',
                        'label' => __('dự án', 'lx-landing'),
                    ],
                    [
                        'number' => '100',
                        'suffix' => '%',
                        'label' => __('bảo mật', 'lx-landing'),
                    ],
                    [
                        'number' => '24/7',
                        'suffix' => '',
                        'label' => __('sẵn sàng', 'lx-landing'),
                    ],
                ],
                'title_field' => '{{{ number }}}{{{ suffix }}} {{{ label }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Màu nền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lx_stats_wrapper' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __('Màu con số', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lx_stats_number' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __('Màu nhãn', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lx_stats_label' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['stats_items'])) {
            return;
        }
        ?>
        <div class="lx_stats_wrapper lx_wrap">
            <div class="lx_con">
                <div class="lx_stats_grid">
                    <?php foreach ($settings['stats_items'] as $item) : ?>
                        <div class="lx_stats_item">
                            <div class="lx_stats_number">
                                <span class="lx_stats_value"><?php echo $item['number']; ?></span><?php if ($item['suffix']) : ?><span class="lx_stats_suffix"><?php echo $item['suffix']; ?></span><?php endif; ?>
                            </div>
                            <?php if ($item['label']) : ?>
                                <div class="lx_stats_label"><?php echo $item['label']; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
