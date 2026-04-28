<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Contact_Form_Image_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_contact_form_image';
    }

    public function get_title() {
        return __('LX — Liên hệ Form & Ảnh', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_categories() {
        return ['lx_lien_he'];
    }

    private function get_contact_forms() {
        $forms = [0 => __('Chọn một form', 'lx-landing')];
        if (post_type_exists('wpcf7_contact_form')) {
            $posts = get_posts([
                'post_type' => 'wpcf7_contact_form',
                'posts_per_page' => -1,
            ]);
            if ($posts) {
                foreach ($posts as $post) {
                    $forms[$post->ID] = $post->post_title;
                }
            }
        }
        return $forms;
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
                'default' => __('ĐĂNG KÝ TRẢI NGHIỆM!', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('TẶNG VIDEO: Tắm bé không khó, thao tác massage toàn thân cho bé...', 'lx-landing'),
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Màu nền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '', // Trống để dùng màu mặc định trong CSS (Primary)
            ]
        );

        $this->end_controls_section();

        // Content
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Nội dung', 'lx-landing'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Hình ảnh bên trái', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => __('Tiêu đề Form', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Nhận tư vấn 1 - 1 Miễn phí', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'cf7_form',
            [
                'label' => __('Chọn Contact Form 7', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_contact_forms(),
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_style = !empty($settings['bg_color']) ? ' style="background-color: ' . esc_attr($settings['bg_color']) . ';"' : '';
        ?>

        <section class="lx_wrap lx_contact_form_image"<?php echo $bg_style; ?>>
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

                <div class="row align-items-center lx_contact_row">
                    <!-- Left Image -->
                    <div class="col-md-12 col-xl-6 d-none d-xl-block">
                        <div class="lx_contact_image">
                            <?php if (!empty($settings['image']['url'])) : ?>
                                <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_attr($settings['title']); ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right Form Box -->
                    <div class="col-md-12 col-xl-6">
                        <div class="lx_form_box">
                            <?php if ($settings['form_title']) : ?>
                                <h3 class="lx_form_title">
                                    <?php echo esc_html($settings['form_title']); ?>
                                </h3>
                            <?php endif; ?>

                            <div class="lx_form_content">
                                <?php 
                                if ($settings['cf7_form'] != 0) {
                                    echo do_shortcode('[contact-form-7 id="' . $settings['cf7_form'] . '"]');
                                } else {
                                    echo '<p class="lx_text_center">' . __('Vui lòng chọn một form liên hệ.', 'lx-landing') . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}
