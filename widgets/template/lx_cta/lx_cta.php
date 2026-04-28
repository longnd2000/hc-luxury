<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_CTA_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_cta';
    }

    public function get_title() {
        return __('LX — CTA', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return ['lx_cta'];
    }

    protected function _register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Nội dung', 'lx-landing'),
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __('Ảnh nền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('HÃY ĐỂ CHÚNG TÔI ĐỒNG HÀNH CÙNG BẠN!', 'lx-landing'),
                'placeholder' => __('Nhập tiêu đề CTA', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Liên hệ ngay hôm nay để nhận tư vấn miễn phí và tìm giải pháp phù hợp nhất.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => __('Chữ trên nút', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('ĐĂNG KÝ NGAY', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => __('Liên kết nút', 'lx-landing'),
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
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Bên trái', 'lx-landing'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Chính giữa', 'lx-landing'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Bên phải', 'lx-landing'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
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

        $align_class = 'text-' . $settings['alignment'];
        $justify_class = 'justify-content-center'; // Default col-6 is always centered in its container
        if ($settings['alignment'] === 'left') $justify_class = 'justify-content-start';
        if ($settings['alignment'] === 'right') $justify_class = 'justify-content-end';

        $btn_link = !empty($settings['btn_link']['url']) ? $settings['btn_link']['url'] : '#';
        $this->add_render_attribute('button', 'class', 'lx_btn lx_btn_primary'); // Using default primary button
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
