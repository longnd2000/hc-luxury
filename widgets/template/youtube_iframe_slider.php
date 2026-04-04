<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Youtube_Iframe_Slider_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'youtube_iframe_slider_widget';
    }

    public function get_title()
    {
        return __('Youtube Iframe Slider Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-slider-video'; // https://elementor.github.io/elementor-icons/
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
            'youtube_iframe',
            [
                'label' => __('Youtube Iframe', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'placeholder' => __('<iframe ...></iframe>', 'child_theme'),
            ]
        );

        $this->add_control(
            'youtube_items',
            [
                'label' => __('Youtube Items', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ youtube_iframe ? "Youtube Item" : "Empty Item" }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $youtube_items = !empty($settings['youtube_items']) ? $settings['youtube_items'] : [];
?>
        <div class="youtube_iframe_slider_widget">
            <div class="youtube_iframe_slider_widget_inner">
                <?php if (!empty($youtube_items)): ?>
                    <div class="youtube_iframe_slider">
                        <?php foreach ($youtube_items as $item): ?>
                            <div class="youtube_iframe_slider_item">
                                <div class="youtube_iframe_slider_item_inner">
                                    <?php if (!empty($item['youtube_iframe'])): ?>
                                        <div class="youtube_iframe_wrap">
                                            <?php echo $item['youtube_iframe']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function($) {
            var youtube_iframe_slider_widget = function($scope, $) {
                var $slider = $scope.find('.youtube_iframe_slider');

                if (!$slider.length) return;

                if ($slider.hasClass('slick-initialized')) {
                    $slider.slick('unslick');
                }

                $slider.slick({
                    slidesToShow: 4,
                    slidesToScroll: 2,
                    arrows: true,
                    dots: false,
                    infinite: true,
                    autoplay: false,
                    speed: 500,
                    adaptiveHeight: false,
                    responsive: [{
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/youtube_iframe_slider_widget.default',
                    youtube_iframe_slider_widget
                );
            });
        })(jQuery);
    </script>
<?php
});
