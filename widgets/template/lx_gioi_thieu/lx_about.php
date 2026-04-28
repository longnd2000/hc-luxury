<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_About_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_about';
    }

    public function get_title() {
        return __('LX — Giới thiệu', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return ['lx_gioi_thieu'];
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
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Chào mừng đến với chúng tôi', 'lx-landing'),
                'placeholder' => __('Nhập tiêu đề', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Chúng tôi cung cấp các giải pháp chuyên nghiệp để giúp doanh nghiệp của bạn phát triển.', 'lx-landing'),
                'placeholder' => __('Nhập mô tả chi tiết', 'lx-landing'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Hình ảnh', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => __('Chữ trên nút', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tìm hiểu thêm', 'lx-landing'),
                'placeholder' => __('Ví dụ: Xem chi tiết', 'lx-landing'),
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
            'image_position',
            [
                'label' => __('Vị trí hình ảnh', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Bên trái', 'lx-landing'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Bên phải', 'lx-landing'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => false,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute('wrapper', 'class', 'lx_wrap lx_about');
        $this->add_render_attribute('container', 'class', 'lx_con');
        
        $row_class = 'row align-items-center gx-60';
        if ($settings['image_position'] === 'left') {
            $row_class .= ' flex-row-reverse';
        }

        $image_url = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
        $image_alt = !empty($settings['image']['alt']) ? $settings['image']['alt'] : $settings['title'];
        
        // Get image dimensions for SEO
        $image_id = $settings['image']['id'];
        $image_size = 'full';
        $image_src = wp_get_attachment_image_src($image_id, $image_size);
        $width = $image_src ? $image_src[1] : '';
        $height = $image_src ? $image_src[2] : '';

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
            <div <?php echo $this->get_render_attribute_string('container'); ?>>
                <div class="<?php echo esc_attr($row_class); ?>">
                    <!-- Left Content -->
                    <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                        <div class="lx_about_content">
                            <?php if ($settings['title']) : ?>
                                <h2 class="lx_heading lx_heading_h2"><?php echo esc_html($settings['title']); ?></h2>
                            <?php endif; ?>

                            <?php if ($settings['description']) : ?>
                                <div class="lx_text_editor">
                                    <?php echo $settings['description']; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($settings['btn_text']) : ?>
                                <div class="lx_about_action">
                                    <a <?php echo $this->get_render_attribute_string('button'); ?>>
                                        <?php echo esc_html($settings['btn_text']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6 col-md-12">
                        <div class="lx_about_image">
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($image_alt); ?>" 
                                     width="<?php echo esc_attr($width); ?>" 
                                     height="<?php echo esc_attr($height); ?>"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}
