<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_404_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_404_section';
    }

    public function get_title() {
        return __('LX — 404 Page Section', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-error-404';
    }

    public function get_categories() {
        return ['lx_dynamic'];
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
            'number',
            [
                'label' => __('Số hiển thị', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('404', 'lx-landing'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Hình ảnh minh họa', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_stylesheet_directory_uri() . '/assets/images/lx_404_illustration.png',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Oops! Trang bạn tìm không tồn tại', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Có vẻ như liên kết đã bị thay đổi hoặc trang đã được di chuyển. Bạn có thể quay về trang chủ hoặc khám phá các nội dung hữu ích khác.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Buttons
        $this->start_controls_section(
            'section_buttons',
            [
                'label' => __('Nút bấm', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_1_text',
            [
                'label' => __('Nút 1 - Chữ', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Về trang chủ', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_1_link',
            [
                'label' => __('Nút 1 - Link', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default' => [
                    'url' => home_url('/'),
                ],
            ]
        );

        $this->add_control(
            'btn_2_text',
            [
                'label' => __('Nút 2 - Chữ', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Khám phá thêm', 'lx-landing'),
            ]
        );

        $this->add_control(
            'btn_2_link',
            [
                'label' => __('Nút 2 - Link', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <section class="lx_wrap lx_404_section">
            <div class="lx_con">
                <?php if ($settings['number']) : ?>
                    <div class="lx_404_number">
                        <?php echo esc_html($settings['number']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($settings['image']['url'])) : ?>
                    <div class="lx_404_image">
                        <img src="<?php echo esc_url($settings['image']['url']); ?>" alt="404 Illustration">
                    </div>
                <?php endif; ?>

                <div class="lx_404_content">
                    <?php if ($settings['title']) : ?>
                        <h1 class="lx_404_title">
                            <?php echo nl2br(esc_html($settings['title'])); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($settings['description']) : ?>
                        <p class="lx_404_desc">
                            <?php echo nl2br(esc_html($settings['description'])); ?>
                        </p>
                    <?php endif; ?>

                    <div class="lx_404_btns">
                        <?php if ($settings['btn_1_text']) : ?>
                            <a href="<?php echo esc_url($settings['btn_1_link']['url']); ?>" class="lx_btn lx_btn_primary" <?php echo $settings['btn_1_link']['is_external'] ? 'target="_blank"' : ''; ?>>
                                <i class="fas fa-home"></i>
                                <?php echo esc_html($settings['btn_1_text']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($settings['btn_2_text']) : ?>
                            <a href="<?php echo esc_url($settings['btn_2_link']['url'] ? $settings['btn_2_link']['url'] : '#'); ?>" class="lx_btn lx_btn_outline" <?php echo $settings['btn_2_link']['is_external'] ? 'target="_blank"' : ''; ?>>
                                <?php echo esc_html($settings['btn_2_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}
