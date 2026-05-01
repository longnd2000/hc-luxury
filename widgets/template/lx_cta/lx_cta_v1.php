<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Cta_V1_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_cta_v1';
    }

    public function get_title() {
        return __('LX — CTA V1', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return ['lx_cta'];
    }

    protected function _register_controls() {
        // Section Content
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Nội dung', 'lx-landing'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('BẠN ĐÃ SẴN SÀNG ĐỂ BẮT ĐẦU?', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Liên hệ với chúng tôi ngay hôm nay để nhận được tư vấn chi tiết nhất về dịch vụ.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => __('Chữ trên nút', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('LIÊN HỆ NGAY', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => __('Link nút', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => __('Căn lề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'left'   => __('Trái', 'lx-landing'),
                    'center' => __('Giữa', 'lx-landing'),
                    'right'  => __('Phải', 'lx-landing'),
                ],
            ]
        );

        $this->end_controls_section();

        // Section Background
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Hình nền', 'lx-landing'),
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Chọn ảnh nền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $bg_image = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : '';
        
        $this->add_render_attribute('wrapper', 'class', 'lx_wrap lx_cta');
        $this->add_render_attribute('wrapper', 'class', 'lx_cta_' . $settings['alignment']);
        
        if ($bg_image) {
            $this->add_render_attribute('wrapper', 'style', 'background-image: url(' . esc_url($bg_image) . ');');
        }

        $justify_class = 'justify-content-center';
        if ($settings['alignment'] === 'left') $justify_class = 'justify-content-start';
        if ($settings['alignment'] === 'right') $justify_class = 'justify-content-end';

        $btn_link = !empty($settings['btn_link']['url']) ? $settings['btn_link']['url'] : '#';
        $this->add_render_attribute('button', 'class', 'lx_btn lx_btn_primary');
        $this->add_render_attribute('button', 'href', esc_url($btn_link));
        
        if (!empty($settings['btn_link']['is_external'])) {
            $this->add_render_attribute('button', 'target', '_blank');
        }
        if (!empty($settings['btn_link']['nofollow'])) {
            $this->add_render_attribute('button', 'rel', 'nofollow');
        }
        ?>

        <section <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div class="lx_cta_overlay"></div>
            <div class="lx_con">
                <div class="row <?php echo esc_attr($justify_class); ?>">
                    <div class="col-lg-6 col-md-10">
                        <div class="lx_cta_content">
                            <?php if ($settings['title']) : ?>
                                <h2 class="lx_heading lx_heading_h2 lx_cta_title">
                                    <?php echo nl2br(esc_html($settings['title'])); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if ($settings['description']) : ?>
                                <div class="lx_text_editor lx_cta_desc">
                                    <?php echo $settings['description']; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($settings['btn_text']) : ?>
                                <div class="lx_cta_action">
                                    <a <?php echo $this->get_render_attribute_string('button'); ?>>
                                        <?php echo esc_html($settings['btn_text']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}
