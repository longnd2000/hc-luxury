<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Why_Choose_Us_V2_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_why_choose_us_v2';
    }

    public function get_title() {
        return __('LX — Tại sao chọn tôi V2', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return ['lx_loi_ich'];
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
                'default' => __('VÌ SAO HÀNG NGÀN GIA ĐÌNH TIN CHỌN HOME CARE?', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Khác biệt đến từ chuyên môn vững vàng và sự tận tâm trong từng chi tiết', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Features List
        $this->start_controls_section(
            'section_features',
            [
                'label' => __('Danh sách Tính năng', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Ảnh minh họa', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('ĐƠN VỊ UY TÍN', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'desc',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Được cấp phép chăm sóc mẹ & bé tại nhà', 'lx-landing'),
            ]
        );

        $this->add_control(
            'features_list',
            [
                'label' => __('Danh sách Features', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('ĐƠN VỊ UY TÍN', 'lx-landing'),
                        'desc' => __('Được cấp phép chăm sóc mẹ & bé tại nhà', 'lx-landing'),
                    ],
                    [
                        'title' => __('PHƯƠNG PHÁP TAROSHI', 'lx-landing'),
                        'desc' => __('39+ liệu pháp giúp mẹ phục hồi, bé ngủ ngon', 'lx-landing'),
                    ],
                    [
                        'title' => __('KỸ THUẬT CHUYÊN MÔN', 'lx-landing'),
                        'desc' => __('Điều dưỡng, nữ hộ sinh đào tạo bài bản', 'lx-landing'),
                    ],
                    [
                        'title' => __('SẢN PHẨM AN TOÀN', 'lx-landing'),
                        'desc' => __('Thành phần lành tính, nguồn gốc rõ ràng', 'lx-landing'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $features = !empty($settings['features_list']) ? $settings['features_list'] : [];
        ?>

        <section class="lx_wrap lx_why_us_v2">
            <div class="lx_con">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 lx_text_center">
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

                <?php if (!empty($features)) : ?>
                    <div class="row g-4">
                        <?php 
                        $count = 1;
                        foreach ($features as $item) : 
                            $image_url = !empty($item['image']['url']) ? $item['image']['url'] : '';
                            $number = str_pad($count, 2, '0', STR_PAD_LEFT);
                        ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="lx_why_card_v2">
                                    <div class="lx_why_media_outer">
                                        <div class="lx_why_img_wrap">
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                                        </div>
                                        <div class="lx_why_number_badge">
                                            <span><?php echo $number; ?></span>
                                        </div>
                                    </div>
                                    <div class="lx_why_content_v2">
                                        <h3 class="lx_why_title_v2"><?php echo esc_html($item['title']); ?></h3>
                                        <p class="lx_why_desc_v2"><?php echo nl2br(esc_html($item['desc'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        $count++;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}
