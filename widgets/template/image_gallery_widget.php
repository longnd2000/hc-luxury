<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Image_Gallery_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Image_Gallery_Widget';
    }

    public function get_title()
    {
        return __('Image Gallery Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['lx_media'];
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

        $this->add_control(
            'gallery_images',
            [
                'label' => __('Chọn ảnh', 'child_theme'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    private function get_image_alt($attachment_id)
    {
        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

        if (empty($alt)) {
            $alt = get_the_title($attachment_id);
        }

        return esc_attr($alt);
    }

    private function get_image_dimensions($attachment_id, $size = 'large')
    {
        $image_data = wp_get_attachment_image_src($attachment_id, $size);

        if (!empty($image_data) && isset($image_data[1], $image_data[2])) {
            return [
                'width'  => (int) $image_data[1],
                'height' => (int) $image_data[2],
            ];
        }

        return [
            'width'  => '',
            'height' => '',
        ];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $gallery_images = !empty($settings['gallery_images']) ? $settings['gallery_images'] : [];

        if (empty($gallery_images)) return;
?>
        <div class="image_gallery_widget">
            <div class="image_gallery_widget_main">
                <?php foreach ($gallery_images as $image): ?>
                    <?php
                    $attachment_id = !empty($image['id']) ? (int) $image['id'] : 0;
                    $main_image = wp_get_attachment_image_url($attachment_id, 'large');

                    if (!$main_image && !empty($image['url'])) {
                        $main_image = $image['url'];
                    }

                    $main_dimensions = $this->get_image_dimensions($attachment_id, 'large');
                    $main_alt = $this->get_image_alt($attachment_id);
                    ?>
                    <div>
                        <div class="image_gallery_widget_main_item">
                            <img
                                src="<?php echo esc_url($main_image); ?>"
                                alt="<?php echo $main_alt; ?>"
                                width="<?php echo esc_attr($main_dimensions['width']); ?>"
                                height="<?php echo esc_attr($main_dimensions['height']); ?>"
                                loading="lazy"
                                decoding="async">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="image_gallery_widget_thumbs">
                <?php foreach ($gallery_images as $image): ?>
                    <?php
                    $attachment_id = !empty($image['id']) ? (int) $image['id'] : 0;
                    $thumb_image = wp_get_attachment_image_url($attachment_id, 'medium');

                    if (!$thumb_image && !empty($image['url'])) {
                        $thumb_image = $image['url'];
                    }

                    $thumb_dimensions = $this->get_image_dimensions($attachment_id, 'medium');
                    $thumb_alt = $this->get_image_alt($attachment_id);
                    ?>
                    <div>
                        <div class="image_gallery_widget_thumb_item">
                            <img
                                src="<?php echo esc_url($thumb_image); ?>"
                                alt="<?php echo $thumb_alt; ?>"
                                width="<?php echo esc_attr($thumb_dimensions['width']); ?>"
                                height="<?php echo esc_attr($thumb_dimensions['height']); ?>"
                                loading="lazy"
                                decoding="async">
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
            var custom_image_gallery_widget = function($scope, $) {
                var $wrapper = $scope.find('.image_gallery_widget');

                if (!$wrapper.length) return;

                $wrapper.each(function() {
                    var $this = $(this);
                    var $main = $this.find('.image_gallery_widget_main');
                    var $thumbs = $this.find('.image_gallery_widget_thumbs');

                    if (!$main.length || !$thumbs.length) return;

                    // tránh init lại nhiều lần trong Elementor
                    if ($main.hasClass('slick-initialized')) {
                        $main.slick('unslick');
                    }

                    if ($thumbs.hasClass('slick-initialized')) {
                        $thumbs.slick('unslick');
                    }

                    // Slider main
                    $main.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        infinite: true,
                        asNavFor: $thumbs
                    });

                    // Slider thumbs
                    $thumbs.slick({
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        arrows: false,
                        infinite: true,
                        focusOnSelect: true,
                        asNavFor: $main
                    });
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/Image_Gallery_Widget.default',
                    custom_image_gallery_widget
                );
            });
        })(jQuery);
    </script>
<?php
});
