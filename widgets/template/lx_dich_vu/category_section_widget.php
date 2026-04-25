<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class category_section_widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'category_section_widget';
    }

    public function get_title()
    {
        return __('Category Section Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_categories()
    {
        return ['lx_dich_vu'];
    }

    private function get_all_categories()
    {
        $options = [];
        $categories = get_categories([
            'parent' => 0, // Only Level 1
            'hide_empty' => false,
        ]);
        foreach ($categories as $cat) {
            $options[$cat->term_id] = $cat->name;
        }
        return $options;
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
            'section_title',
            [
                'label' => __('Section Title', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Leave empty to use category name', 'child_theme'),
            ]
        );

        $this->add_control(
            'parent_category',
            [
                'label' => __('Select Parent Category', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_all_categories(),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $parent_id = $settings['parent_category'];

        if (empty($parent_id)) return;

        // Get subcategories (max 4)
        $sub_categories = get_categories([
            'parent' => $parent_id,
            'number' => 4,
            'hide_empty' => true,
        ]);

        if (empty($sub_categories)) return;

?>
        <div class="category_section_widget">
            <div class="cs_header">
                <div class="cs_title_wrap">
                    <?php
                    $display_title = $settings['section_title'];
                    if (empty($display_title)) {
                        $parent_term = get_term($parent_id, 'category');
                        $display_title = !is_wp_error($parent_term) && $parent_term ? $parent_term->name : '';
                    }
                    ?>
                    <?php if ($display_title): ?>
                        <h2 class="cs_section_title"><?php echo $display_title; ?></h2>
                    <?php endif; ?>
                </div>
                <div class="cs_tabs_wrap">
                    <ul class="cs_tabs">
                        <?php foreach ($sub_categories as $index => $cat): ?>
                            <li class="cs_tab_item <?php echo ($index === 0) ? 'active' : ''; ?>" data-tab="cat_<?php echo $cat->term_id; ?>">
                                <?php echo $cat->name; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="cs_content_wrap">
                <?php foreach ($sub_categories as $index => $cat):
                    $posts_query = new \WP_Query([
                        'cat' => $cat->term_id,
                        'posts_per_page' => 4,
                        'post_status' => 'publish',
                    ]);

                    if ($posts_query->have_posts()):
                ?>
                        <div class="cs_tab_content <?php echo ($index === 0) ? 'active' : ''; ?>" id="cat_<?php echo $cat->term_id; ?>">
                            <div class="cs_post_grid">
                                <?php while ($posts_query->have_posts()): $posts_query->the_post();
                                    $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                    $title = get_the_title();
                                    $excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
                                    $link = get_permalink();
                                    $categories = get_the_category();
                                ?>
                                    <?php include(get_stylesheet_directory() . '/components/post_card.php'); ?>
                                <?php endwhile;
                                wp_reset_postdata(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
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
            var custom_category_section_widget = function($scope, $) {
                $scope.on('click', '.cs_tab_item', function() {
                    var tabId = $(this).data('tab');

                    // Update Tabs
                    $scope.find('.cs_tab_item').removeClass('active');
                    $(this).addClass('active');

                    // Update Content
                    $scope.find('.cs_tab_content').removeClass('active');
                    $scope.find('#' + tabId).addClass('active');
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/category_section_widget.default',
                    custom_category_section_widget
                );
            });
        })(jQuery);
    </script>
<?php
});
