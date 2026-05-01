<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class LX_Footer_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_footer';
    }

    public function get_title()
    {
        return __('LX — Footer', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-footer';
    }

    public function get_categories()
    {
        return ['lx_footer'];
    }

    protected function _register_controls()
    {
        // ── SECTION 1: CỘT 1 (LOGO & GIỚI THIỆU) ───────────────────────────
        $this->start_controls_section(
            'section_col1',
            [
                'label' => __('Cột 1: Logo & Giới thiệu', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'logo',
            [
                'label' => __('Logo', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label' => __('Giới thiệu công ty', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Chúng tôi cung cấp các giải pháp chuyên nghiệp giúp doanh nghiệp của bạn phát triển mạnh mẽ.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // ── SECTION 2: CỘT 2 (LIÊN KẾT 1) ──────────────────────────────────
        $this->start_controls_section(
            'section_col2',
            [
                'label' => __('Cột 2: Liên kết 1', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'links_1_title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Dịch vụ', 'lx-landing'),
            ]
        );

        $repeater_1 = new \Elementor\Repeater();

        $repeater_1->add_control(
            'text',
            [
                'label' => __('Văn bản', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Liên kết', 'lx-landing'),
            ]
        );

        $repeater_1->add_control(
            'link',
            [
                'label' => __('URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://',
            ]
        );

        $this->add_control(
            'links_1_list',
            [
                'label' => __('Danh sách liên kết', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_1->get_controls(),
                'default' => [
                    ['text' => __('Thiết kế Web', 'lx-landing')],
                    ['text' => __('Marketing Online', 'lx-landing')],
                    ['text' => __('SEO Tổng thể', 'lx-landing')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        // ── SECTION 3: CỘT 3 (LIÊN KẾT 2) ──────────────────────────────────
        $this->start_controls_section(
            'section_col3',
            [
                'label' => __('Cột 3: Liên kết 2', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'links_2_title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Về chúng tôi', 'lx-landing'),
            ]
        );

        $repeater_2 = new \Elementor\Repeater();

        $repeater_2->add_control(
            'text',
            [
                'label' => __('Văn bản', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Liên kết', 'lx-landing'),
            ]
        );

        $repeater_2->add_control(
            'link',
            [
                'label' => __('URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://',
            ]
        );

        $this->add_control(
            'links_2_list',
            [
                'label' => __('Danh sách liên kết', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_2->get_controls(),
                'default' => [
                    ['text' => __('Giới thiệu', 'lx-landing')],
                    ['text' => __('Tuyển dụng', 'lx-landing')],
                    ['text' => __('Tin tức', 'lx-landing')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        // ── SECTION 4: CỘT 4 (THÔNG TIN LIÊN HỆ) ───────────────────────────
        $this->start_controls_section(
            'section_col4',
            [
                'label' => __('Cột 4: Thông tin liên hệ', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'contact_title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Liên hệ', 'lx-landing'),
            ]
        );

        $this->add_control(
            'phone',
            [
                'label' => __('Số điện thoại', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '0123 456 789',
            ]
        );

        $this->add_control(
            'email',
            [
                'label' => __('Email', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'contact@yourdomain.com',
            ]
        );

        $this->add_control(
            'address',
            [
                'label' => __('Địa chỉ', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '123 Đường ABC, Phường XYZ, Quận 1, TP. Hồ Chí Minh',
            ]
        );

        $this->add_control(
            'social_fb',
            [
                'label' => __('Facebook URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'https://facebook.com/...',
            ]
        );

        $this->add_control(
            'social_ig',
            [
                'label' => __('Instagram URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'https://instagram.com/...',
            ]
        );

        $this->add_control(
            'social_yt',
            [
                'label' => __('Youtube URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'https://youtube.com/...',
            ]
        );

        $this->add_control(
            'social_tt',
            [
                'label' => __('Tiktok URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'https://tiktok.com/@...',
            ]
        );

        $this->end_controls_section();

        // ── SECTION 5: COPYRIGHT ──────────────────────────────────────────
        $this->start_controls_section(
            'section_copyright',
            [
                'label' => __('Bản quyền (Copyright)', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'copyright_text',
            [
                'label' => __('Văn bản bản quyền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '© 2026 LX Landing. All Rights Reserved.',
            ]
        );

        $this->end_controls_section();

        // ── STYLE SECTION ────────────────────────────────────────────────
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Màu sắc', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Màu nền', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '', // Sẽ dùng CSS biến $primary nếu trống
                'selectors' => [
                    '{{WRAPPER}} .lx_footer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Màu chữ', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .lx_footer, {{WRAPPER}} .lx_footer a' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $logo_url = !empty($settings['logo']['url']) ? $settings['logo']['url'] : '';
        ?>
        <footer class="lx_wrap lx_footer">
            <div class="lx_con">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-xl-4 col-md-6 mb-4 mb-xl-0">
                        <?php if ($logo_url) : ?>
                            <div class="lx_footer_logo">
                                <img src="<?php echo esc_url($logo_url); ?>" alt="Footer Logo">
                            </div>
                        <?php endif; ?>
                        <div class="lx_footer_intro">
                            <?php echo $settings['intro_text']; ?>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-xl-2 col-md-6 mb-4 mb-xl-0">
                        <?php if ($settings['links_1_title']) : ?>
                            <h4 class="lx_footer_title"><?php echo esc_html($settings['links_1_title']); ?></h4>
                        <?php endif; ?>
                        <ul class="lx_footer_list">
                            <?php foreach ($settings['links_1_list'] as $item) : ?>
                                <li>
                                    <a href="<?php echo esc_url($item['link']['url']); ?>" <?php echo $item['link']['is_external'] ? 'target="_blank"' : ''; ?>>
                                        <?php echo esc_html($item['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                    <div class="col-xl-2 col-md-6 mb-4 mb-xl-0">
                        <?php if ($settings['links_2_title']) : ?>
                            <h4 class="lx_footer_title"><?php echo esc_html($settings['links_2_title']); ?></h4>
                        <?php endif; ?>
                        <ul class="lx_footer_list">
                            <?php foreach ($settings['links_2_list'] as $item) : ?>
                                <li>
                                    <a href="<?php echo esc_url($item['link']['url']); ?>" <?php echo $item['link']['is_external'] ? 'target="_blank"' : ''; ?>>
                                        <?php echo esc_html($item['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Column 4 -->
                    <div class="col-xl-4 col-md-6">
                        <?php if ($settings['contact_title']) : ?>
                            <h4 class="lx_footer_title"><?php echo esc_html($settings['contact_title']); ?></h4>
                        <?php endif; ?>
                        <ul class="lx_footer_contact_info">
                            <?php if ($settings['phone']) : ?>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $settings['phone'])); ?>">
                                        <?php echo esc_html($settings['phone']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($settings['email']) : ?>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <a href="mailto:<?php echo esc_attr($settings['email']); ?>">
                                        <?php echo esc_html($settings['email']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($settings['address']) : ?>
                                <li><i class="fas fa-map-marker-alt"></i> <?php echo nl2br(esc_html($settings['address'])); ?></li>
                            <?php endif; ?>
                        </ul>
                        <div class="lx_footer_socials">
                            <?php if ($settings['social_fb']) : ?>
                                <a href="<?php echo esc_url($settings['social_fb']); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($settings['social_ig']) : ?>
                                <a href="<?php echo esc_url($settings['social_ig']); ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ($settings['social_yt']) : ?>
                                <a href="<?php echo esc_url($settings['social_yt']); ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if ($settings['social_tt']) : ?>
                                <a href="<?php echo esc_url($settings['social_tt']); ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <?php if ($settings['copyright_text']) : ?>
                    <div class="lx_footer_bottom">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="lx_footer_copyright">
                                    <?php echo esc_html($settings['copyright_text']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </footer>
        <?php
    }
}
