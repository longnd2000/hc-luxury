<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Banner_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_banner_v1';
    }

    public function get_title()
    {
        return __('LX — Banner V1', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-slideshow';
    }

    public function get_categories()
    {
        return ['lx_banner'];
    }

    protected function _register_controls()
    {
        // ── CONTENT SECTION ──────────────────────────────────────────────
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Slides', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'bg_image',
            [
                'label' => __('Background Image', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Dịch vụ chuyên nghiệp cho doanh nghiệp của bạn', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Chúng tôi cung cấp các giải pháp tối ưu giúp tăng nhận diện thương hiệu và doanh thu bền vững.', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'btn_text',
            [
                'label' => __('Button Text', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tìm hiểu ngay', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'btn_link',
            [
                'label' => __('Button Link', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://',
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides List', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Sáng tạo & Đột phá', 'lx-landing'),
                        'description' => __('Mang lại giá trị thực cho khách hàng thông qua các chiến dịch marketing sáng tạo.', 'lx-landing'),
                    ],
                    [
                        'title' => __('Chuyên nghiệp & Tận tâm', 'lx-landing'),
                        'description' => __('Đội ngũ chuyên gia giàu kinh nghiệm sẵn sàng đồng hành cùng bạn.', 'lx-landing'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // ── SETTINGS SECTION ─────────────────────────────────────────────
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Slider Settings', 'lx-landing'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label' => __('Show Dots', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'lx-landing'),
                'label_off' => __('No', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => __('Show Arrows', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'lx-landing'),
                'label_off' => __('No', 'lx-landing'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'lx-landing'),
                'label_off' => __('No', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];

        if (empty($slides)) return;

        $slider_options = [
            'dots' => ($settings['show_dots'] === 'yes'),
            'arrows' => ($settings['show_arrows'] === 'yes'),
            'autoplay' => ($settings['autoplay'] === 'yes'),
            'autoplaySpeed' => 5000,
            'infinite' => true,
            'speed' => 500,
            'fade' => true,
            'cssEase' => 'linear'
        ];

        $this->add_render_attribute('slider_wrapper', [
            'class' => 'lx_hero_slider',
            'data-settings' => json_encode($slider_options),
        ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('slider_wrapper'); ?>>
            <?php foreach ($slides as $index => $slide) : 
                $bg_url = !empty($slide['bg_image']['url']) ? $slide['bg_image']['url'] : '';
                
                $btn_key = 'btn_' . $index;
                $this->add_render_attribute($btn_key, [
                    'class' => 'lx_btn lx_btn_primary',
                    'href' => !empty($slide['btn_link']['url']) ? esc_url($slide['btn_link']['url']) : '#',
                ]);
                if (!empty($slide['btn_link']['is_external'])) {
                    $this->add_render_attribute($btn_key, 'target', '_blank');
                }
                ?>
                <div class="lx_hero_slider_item">
                    <div class="lx_hero_slide lx_wrap">
                        <div class="lx_hero_slide_bg" style="background-image: url('<?php echo esc_url($bg_url); ?>');"></div>
                        <div class="lx_hero_slide_overlay"></div>
                        
                        <div class="lx_hero_slide_content lx_con">
                            <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <div class="lx_hero_slide_inner">
                                    <?php if ($slide['title']) : ?>
                                        <h2 class="lx_hero_slide_title"><?php echo esc_html($slide['title']); ?></h2>
                                    <?php endif; ?>
                                    
                                    <?php if ($slide['description']) : ?>
                                        <div class="lx_hero_slide_desc">
                                            <?php echo nl2br(esc_html($slide['description'])); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($slide['btn_text']) : ?>
                                        <div class="lx_hero_slide_action">
                                            <a <?php echo $this->get_render_attribute_string($btn_key); ?>>
                                                <?php echo esc_html($slide['btn_text']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php
    }
}

add_action('wp_footer', function () {
?>
    <script>
        (function($) {
            var lx_hero_slider_handler = function($scope, $) {
                var $slider = $scope.find('.lx_hero_slider');
                if (!$slider.length) return;

                var settings = $slider.data('settings');

                if ($slider.hasClass('slick-initialized')) {
                    $slider.slick('unslick');
                }

                $slider.slick(settings);
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/lx_banner_v1.default',
                    lx_hero_slider_handler
                );
            });
        })(jQuery);
    </script>
<?php
});
