<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Featured Projects V1 Widget
 * 
 * Display a carousel of projects with categories, images, and descriptions.
 * Following project rules: lx_g32 grid, standard typography, and Slick slider.
 */
class LX_Du_An_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name(): string
    {
        return 'lx_du_an_v1';
    }

    public function get_title(): string
    {
        return __('LX — Dự án nổi bật V1', 'lx-landing');
    }

    public function get_icon(): string
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories(): array
    {
        return ['lx_du_an'];
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
            'subtitle',
            [
                'label'       => __('Tiêu đề phụ (Subtitle)', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('DỰ ÁN NỔI BẬT', 'lx-landing'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Tiêu đề chính', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => __('CÁC DỰ ÁN NỔI BẬT', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __('Mô tả ngắn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Những sản phẩm tiêu biểu thể hiện năng lực, tư duy và giá trị mà chúng tôi mang đến cho khách hàng.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // ── Projects List ───────────────────────────────────────────────────
        $this->start_controls_section(
            'section_projects',
            [
                'label' => __('Danh sách dự án', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_image',
            [
                'label'   => __('Hình ảnh dự án', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_tag',
            [
                'label'   => __('Nhãn (Tag)', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('WEB APP', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'item_tag_color',
            [
                'label'   => __('Màu nền nhãn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#3B82F6',
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label'       => __('Tên dự án', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Tên dự án mẫu', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'   => __('Mô tả ngắn dự án', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Mô tả ngắn về dự án để khách hàng hiểu rõ hơn về sản phẩm.', 'lx-landing'),
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
            'project_list',
            [
                'label'       => __('Items', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_title' => __('BizFlow Platform', 'lx-landing'),
                        'item_tag'   => __('WEB APP', 'lx-landing'),
                        'item_tag_color' => '#3B82F6',
                    ],
                    [
                        'item_title' => __('EatWell Mobile', 'lx-landing'),
                        'item_tag'   => __('MOBILE APP', 'lx-landing'),
                        'item_tag_color' => '#10B981',
                    ],
                    [
                        'item_title' => __('FurniShop', 'lx-landing'),
                        'item_tag'   => __('E-COMMERCE', 'lx-landing'),
                        'item_tag_color' => '#F59E0B',
                    ],
                    [
                        'item_title' => __('Natura Brand Identity', 'lx-landing'),
                        'item_tag'   => __('BRANDING', 'lx-landing'),
                        'item_tag_color' => '#8B5CF6',
                    ],
                    [
                        'item_title' => __('FinTech Dashboard', 'lx-landing'),
                        'item_tag'   => __('FINANCE', 'lx-landing'),
                        'item_tag_color' => '#EF4444',
                    ],
                    [
                        'item_title' => __('HealthCare App', 'lx-landing'),
                        'item_tag'   => __('HEALTH', 'lx-landing'),
                        'item_tag_color' => '#6366F1',
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // ── Footer Settings ─────────────────────────────────────────────────
        $this->start_controls_section(
            'section_footer',
            [
                'label' => __('Cài đặt chân trang', 'lx-landing'),
            ]
        );

        $this->add_control(
            'footer_button_text',
            [
                'label'   => __('Chữ trên nút chân trang', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Xem tất cả dự án', 'lx-landing'),
            ]
        );

        $this->add_control(
            'footer_button_link',
            [
                'label'       => __('Link nút chân trang', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $id = 'lx_du_an_' . $this->get_id();
        ?>

        <div class="lx_du_an_v1" id="<?php echo esc_attr($id); ?>">
            <div class="lx_wrap">
                <div class="lx_con">
                    
                    <!-- Section Header (Left aligned with arrows) -->
                    <div class="lx_header_container mb-5">
                        <div class="lx_header_left">
                            <?php if ($settings['subtitle']) : ?>
                                <div class="lx_subtitle_wrap">
                                    <div class="lx_subtitle_line"></div>
                                    <span class="lx_subtitle"><?php echo esc_html($settings['subtitle']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($settings['title']) : ?>
                                <h2 class="lx_heading lx_heading_h2"><?php echo esc_html($settings['title']); ?></h2>
                            <?php endif; ?>

                            <?php if ($settings['description']) : ?>
                                <div class="lx_text_editor">
                                    <p><?php echo nl2br(esc_html($settings['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="lx_header_right">
                            <div class="lx_slider_arrows"></div>
                        </div>
                    </div>

                    <!-- Project Slider -->
                    <?php if (!empty($settings['project_list'])) : ?>
                        <div class="lx_slider_wrap lx_g32">
                            <div class="lx_project_slider">
                                <?php foreach ($settings['project_list'] as $item) : 
                                    $img_url = $item['item_image']['url'];
                                    $link = $item['item_link']['url'];
                                    $target = $item['item_link']['is_external'] ? ' target="_blank"' : '';
                                    $nofollow = $item['item_link']['nofollow'] ? ' rel="nofollow"' : '';
                                ?>
                                    <div class="lx_project_slide">
                                        <div class="lx_project_card" style="--item-accent: <?php echo esc_attr($item['item_tag_color']); ?>;">
                                            <!-- Card Image -->
                                            <div class="lx_card_media">
                                                <?php if ($img_url) : ?>
                                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($item['item_title']); ?>">
                                                <?php endif; ?>
                                            </div>

                                            <!-- Card Body -->
                                            <div class="lx_card_body">
                                                <?php if ($item['item_tag']) : ?>
                                                    <span class="lx_item_tag" style="background-color: <?php echo esc_attr($this->hex2rgba($item['item_tag_color'], 0.1)); ?>; color: <?php echo esc_attr($item['item_tag_color']); ?>">
                                                        <?php echo esc_html($item['item_tag']); ?>
                                                    </span>
                                                <?php endif; ?>

                                                <h3 class="lx_item_title"><?php echo esc_html($item['item_title']); ?></h3>
                                                
                                                <div class="lx_item_desc">
                                                    <?php echo nl2br(esc_html($item['item_description'])); ?>
                                                </div>

                                                <?php if ($link) : ?>
                                                    <a href="<?php echo esc_url($link); ?>" class="lx_item_link" <?php echo $target . $nofollow; ?>>
                                                        <?php _e('Xem chi tiết', 'lx-landing'); ?>
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Footer Button (Standard Theme Button) -->
                    <?php if ($settings['footer_button_text']) : ?>
                        <div class="lx_btn_wrap lx_btn_wrap_center mt-5">
                            <a href="<?php echo esc_url($settings['footer_button_link']['url']); ?>" class="lx_btn lx_btn_outline">
                                <?php echo esc_html($settings['footer_button_text']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            var $slider = $('#<?php echo esc_attr($id); ?> .lx_project_slider');
            $slider.slick({
                dots: false,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 1,
                appendArrows: $('#<?php echo esc_attr($id); ?> .lx_slider_arrows'),
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
        </script>

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
