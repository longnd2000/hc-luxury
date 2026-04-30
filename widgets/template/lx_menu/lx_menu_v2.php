<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class LX_Menu_V2_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_menu_v2';
    }

    public function get_title()
    {
        return __('LX — Menu V2', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['lx_menu'];
    }

    private function get_available_menus()
    {
        $menus = wp_get_nav_menus();
        $options = [];
        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }
        return $options;
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'lx-landing'),
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

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'menu',
                [
                    'label' => __('Menu', 'lx-landing'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys($menus)[0],
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __('There are no menus in your site.', 'lx-landing') . '</strong><br>' .
                        sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'lx-landing'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['menu'])) {
            return;
        }

        $logo_url = !empty($settings['logo']['url']) ? $settings['logo']['url'] : '';
        ?>
        <div class="lx_header_wrapper lx_header_v2">
            <div class="lx_con">
                <?php if ($logo_url) : ?>
                    <div class="lx_header_logo">
                        <a href="<?php echo home_url('/'); ?>">
                            <img src="<?php echo $logo_url; ?>" alt="<?php echo get_bloginfo('name'); ?>">
                        </a>
                    </div>
                <?php endif; ?>

                <div class="lx_header_nav">
                    <div class="lx_menu_container">
                        <button class="lx_menu_toggler" aria-label="Toggle Menu">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="lx_menu_offcanvas">
                            <div class="lx_menu_offcanvas_header">
                                <button class="lx_menu_close" aria-label="Close Menu">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <nav class="lx_menu_nav">
                                <?php
                                wp_nav_menu([
                                    'menu' => $settings['menu'],
                                    'container' => false,
                                    'menu_class' => 'lx_menu_list',
                                    'fallback_cb' => false,
                                ]);
                                ?>
                            </nav>
                        </div>
                        <div class="lx_menu_backdrop"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
