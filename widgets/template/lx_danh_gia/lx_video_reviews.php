<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Video_Reviews_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_video_reviews';
    }

    public function get_title() {
        return __('LX — Đánh giá Video', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-slider-video';
    }

    public function get_categories() {
        return ['lx_danh_gia'];
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
                'default' => __('ĐÁNH GIÁ TỪ KHÁCH HÀNG', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lắng nghe những chia sẻ thực tế từ các gia đình đã tin dùng dịch vụ của Home Care.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Videos List
        $this->start_controls_section(
            'section_videos',
            [
                'label' => __('Danh sách Video', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'video_iframe',
            [
                'label' => __('Iframe Video (Youtube/TikTok)', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'placeholder' => __('<iframe ...></iframe>', 'lx-landing'),
                'description' => __('Dán mã nhúng Iframe từ Youtube hoặc TikTok vào đây.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'video_list',
            [
                'label' => __('Danh sách Video', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                    ['video_iframe' => ''],
                ],
                'title_field' => 'Video Item',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $video_list = !empty($settings['video_list']) ? $settings['video_list'] : [];
        ?>

        <section class="lx_wrap lx_video_reviews">
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

                <?php if (!empty($video_list)) : ?>
                    <div class="lx_video_slider_wrapper">
                        <div class="lx_video_slider">
                            <?php foreach ($video_list as $item) : ?>
                                <div class="lx_video_item">
                                    <div class="lx_video_card">
                                        <?php if (!empty($item['video_iframe'])) : ?>
                                            <div class="lx_video_iframe_wrap">
                                                <?php echo $item['video_iframe']; ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="lx_video_placeholder">
                                                <i class="eicon-play"></i>
                                                <span><?php echo __('Chưa có video', 'lx-landing'); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function($) {
            var lx_video_reviews_handler = function($scope, $) {
                var $slider = $scope.find('.lx_video_slider');

                if (!$slider.length) return;

                if ($slider.hasClass('slick-initialized')) {
                    $slider.slick('unslick');
                }

                $slider.slick({
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    arrows: true,
                    dots: true,
                    infinite: true,
                    autoplay: false,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: true
                            }
                        }
                    ]
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/lx_video_reviews.default',
                    lx_video_reviews_handler
                );
            });
        })(jQuery);
    </script>
<?php
});
