<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Service V3 Widget
 * 
 * Display a grid of services with images, numbers, descriptions, and custom accent colors.
 * Following project rules: 8-column centered header, lx_g32 grid, and standard typography classes.
 */
class LX_Dich_Vu_V3_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_dich_vu_v3';
    }

    public function get_title(): string
    {
        return __('LX — Dịch vụ V3', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-info-box';
    }

    public function get_categories(): array
    {
        return ['lx_dich_vu'];
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
                'default'     => __('GIẢI PHÁP TOÀN DIỆN – HIỆU QUẢ VƯỢT TRỘI', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __('Mô tả ngắn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Chúng tôi cung cấp những dịch vụ chất lượng cao, được thiết kế để đáp ứng mọi nhu cầu và giúp bạn đạt được mục tiêu nhanh chóng.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // ── Service List ─────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_services',
            [
                'label' => __('Danh sách dịch vụ', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'       => __('Tiêu đề dịch vụ', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Thiết kế Website', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'   => __('Mô tả dịch vụ', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Thiết kế website chuyên nghiệp, hiện đại, chuẩn SEO, tối ưu trải nghiệm người dùng.', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'item_image',
            [
                'label'   => __('Hình ảnh', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'accent_color',
            [
                'label'   => __('Màu chủ đạo (Nút & Viền)', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#3B82F6', // Default blue
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label'       => __('Link xem chi tiết', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'item_link_text',
            [
                'label'   => __('Chữ trên nút', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Khám phá dịch vụ', 'lx-landing'),
            ]
        );

        $this->add_control(
            'service_list',
            [
                'label'       => __('Items', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_title'   => __('Thiết kế Website', 'lx-landing'),
                        'accent_color' => '#3B82F6',
                    ],
                    [
                        'item_title'   => __('Digital Marketing', 'lx-landing'),
                        'accent_color' => '#10B981',
                    ],
                    [
                        'item_title'   => __('SEO Tổng Thể', 'lx-landing'),
                        'accent_color' => '#8B5CF6',
                    ],
                    [
                        'item_title'   => __('Thiết kế Branding', 'lx-landing'),
                        'accent_color' => '#F59E0B',
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

        <div class="lx_dich_vu_v3">
            <div class="lx_wrap">
                <div class="lx_con">
                    
                    <!-- Section Header (Follow Rule: 8 columns centered + common classes) -->
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

                    <!-- Services Grid (Follow Rule: lx_g32) -->
                    <?php if (!empty($settings['service_list'])) : ?>
                        <div class="row lx_g32">
                            <?php 
                            $count = 0;
                            foreach ($settings['service_list'] as $item) : 
                                $count++;
                                $accent_color = $item['accent_color'];
                                $img_url = $item['item_image']['url'];
                                $link = $item['item_link']['url'];
                                $target = $item['item_link']['is_external'] ? ' target="_blank"' : '';
                                $nofollow = $item['item_link']['nofollow'] ? ' rel="nofollow"' : '';
                                $number = str_pad($count, 2, '0', STR_PAD_LEFT);
                            ?>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="lx_service_card" style="--item-accent: <?php echo esc_attr($accent_color); ?>; --item-bg: <?php echo esc_attr($this->hex2rgba($accent_color, 0.05)); ?>">
                                        
                                        <!-- Card Image -->
                                        <div class="lx_card_media">
                                            <?php if ($img_url) : ?>
                                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['item_title']); ?>">
                                            <?php endif; ?>
                                            <div class="lx_card_number"><?php echo esc_html($number); ?></div>
                                        </div>

                                        <!-- Card Content -->
                                        <div class="lx_card_body">
                                            <h3 class="lx_item_title"><?php echo esc_html($item['item_title']); ?></h3>
                                            
                                            <div class="lx_item_sep"></div>

                                            <div class="lx_item_desc">
                                                <?php echo nl2br(esc_html($item['item_description'])); ?>
                                            </div>

                                            <!-- Link -->
                                            <?php if ($link) : ?>
                                                <a href="<?php echo esc_url($link); ?>" class="lx_item_link" <?php echo $target . $nofollow; ?>>
                                                    <?php echo esc_html($settings['item_link_text']); ?>
                                                    <div class="lx_icon_arrow">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                </a>
                                            <?php endif; ?>
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

    /**
     * Convert Hex to RGBA
     */
    private function hex2rgba($color, $opacity = false): string
    {
        $default = 'rgb(0,0,0)';
        if (empty($color)) return $default;

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
        } elseif (strlen($color) == 3) {
            $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
        } else {
            return $default;
        }

        $rgb = array_map('hexdec', $hex);

        if ($opacity !== false) {
            if (abs($opacity) > 1) $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        return $output;
    }
}
