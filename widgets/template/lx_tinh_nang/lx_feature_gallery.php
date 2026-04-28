<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Feature_Gallery_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_feature_gallery';
    }

    public function get_title() {
        return __('LX — Gallery ảnh tính năng', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['lx_tinh_nang'];
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
                'default' => __('HOME CARE ĐỒNG HÀNH CÙNG MẸ BÉ TẠI HỘI THẢO TIỀN SẢN', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // Gallery List
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => __('Danh sách Hình ảnh', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Hình ảnh', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'caption',
            [
                'label' => __('Chú thích (tùy chọn)', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'gallery_list',
            [
                'label' => __('Bộ sưu tập', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['caption' => 'Image 1'],
                    ['caption' => 'Image 2'],
                    ['caption' => 'Image 3'],
                    ['caption' => 'Image 4'],
                    ['caption' => 'Image 5'],
                ],
                'title_field' => '{{{ caption }}}',
            ]
        );

        $this->end_controls_section();

        // Slider Settings
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Cài đặt Slider', 'lx-landing'),
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Tự động chạy', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Bật', 'lx-landing'),
                'label_off' => __('Tắt', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Tốc độ (ms)', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => __('Hiển thị mũi tên', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Bật', 'lx-landing'),
                'label_off' => __('Tắt', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $gallery = !empty($settings['gallery_list']) ? $settings['gallery_list'] : [];
        
        $autoplay = ($settings['autoplay'] === 'yes') ? 'true' : 'false';
        $autoplay_speed = !empty($settings['autoplay_speed']) ? $settings['autoplay_speed'] : 3000;
        $show_arrows = ($settings['show_arrows'] === 'yes') ? 'true' : 'false';

        if (empty($gallery)) return;

        $unique_id = 'lx_gallery_' . $this->get_id();
        ?>

        <section class="lx_wrap lx_feature_gallery">
            <div class="lx_con">
                <div class="row justify-content-center mb-5">
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

                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <div class="lx_gallery_container" id="<?php echo $unique_id; ?>">
                            <!-- Main Slider -->
                            <div class="lx_gallery_main">
                                <?php foreach ($gallery as $item) : ?>
                                    <div class="lx_gallery_main_item">
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['caption']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Thumbnails Slider -->
                            <div class="lx_gallery_thumbs_wrap">
                                <div class="lx_gallery_thumbs">
                                    <?php foreach ($gallery as $item) : ?>
                                        <div class="lx_gallery_thumb_item">
                                            <div class="lx_thumb_inner">
                                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['caption']); ?>">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            (function($) {
                var initGallery = function($scope) {
                    var $gallery = $scope.find('#<?php echo $unique_id; ?>');
                    if (!$gallery.length) return;

                    var $main = $gallery.find('.lx_gallery_main');
                    var $thumbs = $gallery.find('.lx_gallery_thumbs');

                    // Unslick if already initialized
                    if ($main.hasClass('slick-initialized')) $main.slick('unslick');
                    if ($thumbs.hasClass('slick-initialized')) $thumbs.slick('unslick');

                    // Tạo class định danh duy nhất cho asNavFor hoạt động chính xác
                    var mainClass = 'js-main-<?php echo $this->get_id(); ?>';
                    var thumbsClass = 'js-thumbs-<?php echo $this->get_id(); ?>';
                    $main.addClass(mainClass);
                    $thumbs.addClass(thumbsClass);

                    $main.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '.' + thumbsClass,
                        autoplay: <?php echo $autoplay; ?>,
                        autoplaySpeed: <?php echo $autoplay_speed; ?>,
                        infinite: true
                    });

                    $thumbs.slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        asNavFor: '.' + mainClass,
                        dots: false,
                        centerMode: false,
                        focusOnSelect: true,
                        arrows: <?php echo $show_arrows; ?>,
                        infinite: true,
                        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 4,
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                }
                            }
                        ]
                    });
                };

                var onInit = function() {
                    elementorFrontend.hooks.addAction('frontend/element_ready/lx_feature_gallery.default', initGallery);
                };

                if (window.elementorFrontend) {
                    onInit();
                } else {
                    $(window).on('elementor/frontend/init', onInit);
                }

                // Chạy thủ công nếu không phải trong editor và elementor chưa load
                $(document).ready(function() {
                    if (!window.elementorFrontend) {
                        initGallery($('body'));
                    }
                });
            })(jQuery);
        </script>

        <?php
    }
}
