<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Loi_Ich_V1_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_loi_ich_v1';
    }

    public function get_title() {
        return __('LX — Lợi ích V1', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-info-box';
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
                'default' => __('Home Care tự hào là người bạn đồng hành đáng tin cậy của hàng ngàn gia đình trên hành trình chăm sóc mẹ và bé.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Features List
        $this->start_controls_section(
            'section_features',
            [
                'label' => __('Danh sách tính năng', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Icon (Ảnh)', 'lx-landing'),
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
                'default' => __('Tiêu đề tính năng', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Mô tả chi tiết về tính năng hoặc lợi ích mà khách hàng nhận được.', 'lx-landing'),
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
                        'title' => __('Đội ngũ chuyên gia giàu kinh nghiệm', 'lx-landing'),
                        'description' => __('Các điều dưỡng, nữ hộ sinh và chuyên viên được đào tạo bài bản, giàu kinh nghiệm thực tế.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Quy trình chuẩn Y khoa', 'lx-landing'),
                        'description' => __('Mọi dịch vụ được thực hiện theo quy trình khoa học, an toàn và phù hợp với từng giai đoạn.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Chăm sóc tận tâm tại nhà', 'lx-landing'),
                        'description' => __('Tiết kiệm thời gian di chuyển, giúp mẹ và bé được chăm sóc ngay trong không gian quen thuộc.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Sản phẩm tự nhiên, an toàn', 'lx-landing'),
                        'description' => __('Sử dụng thảo dược thiên nhiên, lành tính và an toàn cho sức khỏe mẹ và bé.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Hỗ trợ nhanh chóng 24/7', 'lx-landing'),
                        'description' => __('Luôn sẵn sàng tư vấn, giải đáp và hỗ trợ khách hàng bất cứ khi nào cần.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Hơn 10.000+ Gia đình tin tưởng', 'lx-landing'),
                        'description' => __('Sự hài lòng và những phản hồi tích cực là minh chứng rõ ràng cho chất lượng dịch vụ.', 'lx-landing'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <section class="lx_wrap lx_why_choose_us">
            <div class="lx_con">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8 lx_text_center">
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

                <div class="row">
                    <?php foreach ($settings['features_list'] as $index => $item) : 
                        $count = $index + 1;
                        $number = ($count < 10) ? '0' . $count : $count;
                    ?>
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="lx_why_choose_us_card">
                                <div class="lx_why_choose_us_icon">
                                    <?php if (!empty($item['image']['url'])) : ?>
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="lx_why_choose_us_body">
                                    <div class="lx_why_choose_us_meta">
                                        <span class="lx_why_choose_us_number"><?php echo esc_html($number); ?></span>
                                        <h4 class="lx_why_choose_us_title"><?php echo esc_html($item['title']); ?></h4>
                                    </div>
                                    <div class="lx_why_choose_us_desc">
                                        <?php echo nl2br(esc_html($item['description'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }
}
