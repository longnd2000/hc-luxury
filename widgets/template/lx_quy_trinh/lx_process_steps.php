<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_Process_Steps_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_process_steps';
    }

    public function get_title() {
        return __('LX — Quy trình thực hiện', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-ordered-list';
    }

    public function get_categories() {
        return ['lx_quy_trinh'];
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
                'default' => __('QUY TRÌNH CHĂM SÓC MẸ VÀ BÉ SAU SINH TẠI NHÀ CHUẨN TAROSHI', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Tại Home Care, chúng tôi không chỉ làm đẹp bên ngoài mà tập trung phục hồi sâu bên trong', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Steps Repeater
        $this->start_controls_section(
            'section_steps',
            [
                'label' => __('Danh sách các bước', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'step_title',
            [
                'label' => __('Tên bước', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Đón bé và Mẹ', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'step_image',
            [
                'label' => __('Ảnh minh họa', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'steps',
            [
                'label' => __('Danh sách các bước', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['step_title' => __('Đón bé và Mẹ', 'lx-landing')],
                    ['step_title' => __('Massage cho bé', 'lx-landing')],
                    ['step_title' => __('Tắm bé', 'lx-landing')],
                    ['step_title' => __('Chăm sóc rốn', 'lx-landing')],
                ],
                'title_field' => '{{{ step_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $steps = !empty($settings['steps']) ? $settings['steps'] : [];
        ?>

        <section class="lx_wrap lx_process_steps">
            <div class="lx_con">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10 lx_text_center">
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

                <?php if (!empty($steps)) : ?>
                    <div class="row g-4">
                        <?php 
                        $count = 1;
                        foreach ($steps as $item) : 
                            $image_url = !empty($item['step_image']['url']) ? $item['step_image']['url'] : '';
                        ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="lx_step_card">
                                    <div class="lx_step_image_wrap">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['step_title']); ?>" loading="lazy">
                                        <div class="lx_step_badge">
                                            <span><?php echo sprintf(__('Bước %d: %s', 'lx-landing'), $count, esc_html($item['step_title'])); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        $count++;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }
}
