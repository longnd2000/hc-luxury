<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Company_Highlight_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'company_highlight_widget';
    }

    public function get_title()
    {
        return __('Company Highlight Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-slider-push'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories()
    {
        return ['custom_widgets_theme'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_image',
            [
                'label' => __('Image', 'child_theme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => __('Title', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tiêu đề mẫu', 'child_theme'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_desc',
            [
                'label' => __('Description', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Mô tả mẫu', 'child_theme'),
                'rows' => 5,
            ]
        );

        $this->add_control(
            'highlight_slider',
            [
                'label' => __('Highlight Slider', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => 'Không gian nghỉ dưỡng chuẩn cao cấp',
                        'item_desc' => 'Thiết kế không gian tinh tế, sang trọng và mang lại cảm giác thư giãn tuyệt đối cho mẹ và bé.',
                    ],
                    [
                        'item_title' => 'Chăm sóc sau sinh chuyên biệt',
                        'item_desc' => 'Dịch vụ được xây dựng bài bản với quy trình chăm sóc chuyên sâu, đảm bảo sự phục hồi tối ưu.',
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $highlight_slider = !empty($settings['highlight_slider']) ? $settings['highlight_slider'] : [];

        if (empty($highlight_slider)) return;
?>
        <div class="company_highlight_widget">
            <div class="company_highlight_slider">
                <?php foreach ($highlight_slider as $item): ?>
                    <?php
                    $attachment_id = !empty($item['item_image']['id']) ? (int) $item['item_image']['id'] : 0;
                    $image_url = !empty($item['item_image']['url']) ? $item['item_image']['url'] : '';
                    $title = !empty($item['item_title']) ? $item['item_title'] : '';
                    $desc = !empty($item['item_desc']) ? $item['item_desc'] : '';

                    $image_alt = '';
                    $image_width = '';
                    $image_height = '';

                    if ($attachment_id) {
                        $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

                        $image_meta = wp_get_attachment_image_src($attachment_id, 'full');
                        if (!empty($image_meta)) {
                            $image_width = !empty($image_meta[1]) ? $image_meta[1] : '';
                            $image_height = !empty($image_meta[2]) ? $image_meta[2] : '';
                        }
                    }

                    if (empty($image_alt)) {
                        $image_alt = $title;
                    }
                    ?>
                    <div>
                        <div class="company_highlight_slide">
                            <div class="company_highlight_inner">
                                <div class="company_highlight_image_col">
                                    <?php if (!empty($image_url)): ?>
                                        <div class="company_highlight_image_wrap">
                                            <img
                                                src="<?php echo esc_url($image_url); ?>"
                                                alt="<?php echo esc_attr($image_alt); ?>"
                                                width="<?php echo esc_attr($image_width); ?>"
                                                height="<?php echo esc_attr($image_height); ?>"
                                                loading="lazy"
                                                decoding="async">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="company_highlight_content_col">
                                    <div class="company_highlight_content_box">
                                        <?php if (!empty($title)): ?>
                                            <h3 class="company_highlight_title"><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>

                                        <?php if (!empty($desc)): ?>
                                            <div class="company_highlight_desc"><?php echo nl2br(esc_html($desc)); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function($) {
            var custom_company_highlight_widget = function($scope, $) {
                var $slider = $scope.find('.company_highlight_slider');

                if (!$slider.length) return;

                if ($slider.hasClass('slick-initialized')) {
                    $slider.slick('unslick');
                }

                $slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    infinite: true,
                    autoplay: false,
                    autoplaySpeed: 5000,
                    pauseOnHover: false,
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/company_highlight_widget.default',
                    custom_company_highlight_widget
                );
            });
        })(jQuery);
    </script>
<?php
});
