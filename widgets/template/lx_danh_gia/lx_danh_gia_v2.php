<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Danh_Gia_V2_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_danh_gia_v2';
    }

    public function get_title() {
        return __('LX — Đánh giá V2', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['lx_danh_gia'];
    }

    protected function _register_controls() {
        // Section Header
        $this->start_controls_section(
            'section_header',
            [
                'label' => __('Tiêu đề Section', 'lx-landing'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('REVIEW DỊCH VỤ CHĂM SÓC SAU SINH TẠI NHÀ HOME CARE', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // Featured Video
        $this->start_controls_section(
            'section_featured_video',
            [
                'label' => __('Video Chính (Ngang)', 'lx-landing'),
            ]
        );

        $this->add_control(
            'featured_iframe',
            [
                'label' => __('Iframe Video Ngang', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'placeholder' => __('<iframe ...></iframe>', 'lx-landing'),
                'description' => __('Dán mã nhúng Iframe từ Youtube (thường là 16:9) vào đây.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Vertical Videos List
        $this->start_controls_section(
            'section_vertical_videos',
            [
                'label' => __('Danh sách Video Dọc (Dưới)', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'video_iframe',
            [
                'label' => __('Iframe Video Dọc', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'placeholder' => __('<iframe ...></iframe>', 'lx-landing'),
                'description' => __('Dán mã nhúng Iframe từ TikTok hoặc Youtube Shorts (9:16) vào đây.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'video_list',
            [
                'label' => __('Danh sách Video Dọc (Tối đa 4)', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                ],
                'title_field' => 'Video Dọc',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $video_list = !empty($settings['video_list']) ? array_slice($settings['video_list'], 0, 4) : [];
        ?>

        <section class="lx_wrap lx_video_grid">
            <div class="lx_con">
                <div class="row justify-content-center mb-4">
                    <div class="col-xl-8 lx_text_center">
                        <?php if ($settings['title']) : ?>
                            <h2 class="lx_heading lx_heading_h2 mb-3">
                                <?php echo nl2br(esc_html($settings['title'])); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($settings['description']) : ?>
                            <p class="lx_text_editor">
                                <?php echo nl2br(esc_html($settings['description'])); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Featured Horizontal Video -->
                <div class="row justify-content-center mb-4">
                    <div class="col-xl-12">
                        <div class="lx_video_grid_featured">
                            <?php if (!empty($settings['featured_iframe'])) : ?>
                                <div class="lx_video_iframe_horizontal">
                                    <?php echo $settings['featured_iframe']; ?>
                                </div>
                            <?php else : ?>
                                <div class="lx_video_placeholder horizontal">
                                    <i class="eicon-play"></i>
                                    <span><?php echo __('Chưa có video ngang', 'lx-landing'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Vertical Videos Grid -->
                <?php if (!empty($video_list)) : ?>
                    <div class="row lx_g32">
                        <?php foreach ($video_list as $item) : ?>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="lx_video_grid_item">
                                    <?php if (!empty($item['video_iframe'])) : ?>
                                        <div class="lx_video_iframe_vertical">
                                            <?php echo $item['video_iframe']; ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="lx_video_placeholder vertical">
                                            <i class="eicon-play"></i>
                                            <span><?php echo __('Trống', 'lx-landing'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}
