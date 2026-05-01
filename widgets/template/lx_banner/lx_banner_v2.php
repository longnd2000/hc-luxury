<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Banner_V2_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_banner_v2';
    }

    public function get_title() {
        return __('LX — Banner V2', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-image-rollover';
    }

    public function get_categories() {
        return ['lx_banner'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Nội dung', 'lx-landing'),
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => __('Bộ sưu tập ảnh', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $gallery = !empty($settings['gallery']) ? $settings['gallery'] : [];

        if (empty($gallery)) return;
        ?>

        <section class="lx_wrap lx_image_slider_section">
            <div class="lx_con">
                <div class="lx_image_slider">
                    <?php foreach ($gallery as $image) : ?>
                        <div class="lx_image_slider_item">
                            <div class="lx_image_slider_inner">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="Gallery Image" loading="lazy">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function($) {
            var lx_image_slider_handler = function($scope, $) {
                var $slider = $scope.find('.lx_image_slider');

                if (!$slider.length) return;

                if ($slider.hasClass('slick-initialized')) {
                    $slider.slick('unslick');
                }

                $slider.slick({
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    arrows: true,
                    dots: true,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                arrows: true
                            }
                        }
                    ]
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/lx_banner_v2.default',
                    lx_image_slider_handler
                );
            });
        })(jQuery);
    </script>
<?php
});
