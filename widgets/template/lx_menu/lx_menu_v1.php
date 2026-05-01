<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class LX_Menu_V1_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_menu_v1';
    }

    public function get_title()
    {
        return __('LX — Menu V1', 'lx-landing');
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

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Liên hệ', 'lx-landing'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __('Button URL', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'lx-landing'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['menu'])) {
            return;
        }

        $logo_url = !empty($settings['logo']['url']) ? $settings['logo']['url'] : '';
        $button_text = !empty($settings['button_text']) ? $settings['button_text'] : '';
        
        $this->add_render_attribute('button', 'class', ['lx_btn', 'lx_btn_primary']);
        if (!empty($settings['button_url']['url'])) {
            $this->add_link_attributes('button', $settings['button_url']);
        }
        ?>
        <div class="lx_header_wrapper">
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
                            
                            <?php if ($button_text) : ?>
                                <div class="lx_menu_action_mobile">
                                    <a <?php $this->print_render_attribute_string('button'); ?>>
                                        <?php echo $button_text; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="lx_menu_backdrop"></div>
                    </div>
                </div>

                <?php if ($button_text) : ?>
                    <div class="lx_header_action">
                        <a <?php $this->print_render_attribute_string('button'); ?>>
                            <?php echo $button_text; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
