<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Our Process V2 Widget
 */
class LX_Quy_Trinh_V2_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'lx_quy_trinh_v2';
    }

    public function get_title()
    {
        return __('LX — Quy trình V2', 'lx-landing');
    }

    public function get_icon()
    {
        return 'eicon-ordered-list';
    }

    public function get_categories()
    {
        return array('lx_quy_trinh');
    }

    protected function _register_controls()
    {
        // ── Section Header ───────────────────────────────────────────────────
        $this->start_controls_section(
            'section_header',
            array(
                'label' => __('Đầu mục', 'lx-landing'),
            )
        );

        $this->add_control(
            'title',
            array(
                'label'       => __('Tiêu đề chính', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => __('Quy trình thực hiện chuyên nghiệp', 'lx-landing'),
                'label_block' => true,
            )
        );

        $this->add_control(
            'description',
            array(
                'label'   => __('Mô tả ngắn', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Chúng tôi áp dụng quy trình làm việc bài bản, tối ưu hóa thời gian và đảm bảo chất lượng cao nhất cho mọi sản phẩm.', 'lx-landing'),
            )
        );

        $this->end_controls_section();

        // ── Steps List ───────────────────────────────────────────────────
        $this->start_controls_section(
            'section_steps',
            array(
                'label' => __('Danh sách các bước', 'lx-landing'),
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_icon',
            array(
                'label'   => __('Icon', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::ICONS,
                'default' => array(
                    'value'   => 'fas fa-search',
                    'library' => 'solid',
                ),
            )
        );

        $repeater->add_control(
            'item_title',
            array(
                'label'       => __('Tên bước', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __('Tiếp nhận & tư vấn', 'lx-landing'),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'item_description',
            array(
                'label'   => __('Mô tả chi tiết', 'lx-landing'),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lắng nghe yêu cầu, khảo sát thị trường và tư vấn giải pháp tối ưu cho doanh nghiệp.', 'lx-landing'),
            )
        );

        $this->add_control(
            'step_list',
            array(
                'label'       => __('Items', 'lx-landing'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'item_title' => __('Tư vấn & Khảo sát', 'lx-landing'),
                        'item_description' => __('Lắng nghe yêu cầu, khảo sát thị trường và tư vấn giải pháp tối ưu cho doanh nghiệp.', 'lx-landing'),
                        'item_icon' => array('value' => 'fas fa-comments', 'library' => 'solid'),
                    ),
                    array(
                        'item_title' => __('Lên ý tưởng & Wireframe', 'lx-landing'),
                        'item_description' => __('Xây dựng cấu trúc logic, phác thảo sơ đồ trang web (Sitemap) và giao diện sơ bộ.', 'lx-landing'),
                        'item_icon' => array('value' => 'fas fa-pencil-ruler', 'library' => 'solid'),
                    ),
                    array(
                        'item_title' => __('Thiết kế UI/UX', 'lx-landing'),
                        'item_description' => __('Sáng tạo giao diện hiện đại, sang trọng, đảm bảo trải nghiệm người dùng mượt mà.', 'lx-landing'),
                        'item_icon' => array('value' => 'fas fa-palette', 'library' => 'solid'),
                    ),
                    array(
                        'item_title' => __('Lập trình & Phát triển', 'lx-landing'),
                        'item_description' => __('Hiện thực hóa thiết kế thành mã nguồn tối ưu, tốc độ tải trang nhanh và chuẩn SEO.', 'lx-landing'),
                        'item_icon' => array('value' => 'fas fa-code', 'library' => 'solid'),
                    ),
                    array(
                        'item_title' => __('Bàn giao & Vận hành', 'lx-landing'),
                        'item_description' => __('Kiểm thử kỹ lưỡng, hướng dẫn sử dụng, bàn giao và hỗ trợ kỹ thuật trọn đời.', 'lx-landing'),
                        'item_icon' => array('value' => 'fas fa-rocket', 'library' => 'solid'),
                    ),
                ),
                'title_field' => '{{{ item_title }}}',
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="lx_quy_trinh_v2">
            <div class="lx_wrap">
                <div class="lx_con">
                    
                    <!-- Section Header -->
                    <div class="row justify-content-center mb-5">
                        <div class="col-xl-8 col-lg-10 text-center">
                            <?php if (!empty($settings['title'])) : ?>
                                <h2 class="lx_heading lx_heading_h2 lx_heading_align_center mb-3">
                                    <?php echo esc_html($settings['title']); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if (!empty($settings['description'])) : ?>
                                <div class="lx_text_editor lx_text_editor_align_center">
                                    <?php echo nl2br(esc_html($settings['description'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Steps Timeline -->
                    <?php if (!empty($settings['step_list'])) : ?>
                        <div class="row lx_g32 justify-content-center">
                            <?php 
                            $count = 0;
                            $total = count($settings['step_list']);
                            foreach ($settings['step_list'] as $item) : 
                                $count++;
                                $number = str_pad($count, 2, '0', STR_PAD_LEFT);
                            ?>
                                <div class="col-12 col-md-6 col-xl-2 mb-4">
                                    <div class="lx_step_item">
                                        <div class="lx_step_visual">
                                            <div class="lx_step_number"><?php echo esc_html($number); ?></div>
                                            <div class="lx_step_icon_circle">
                                                <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], array('aria-hidden' => 'true')); ?>
                                            </div>
                                            <?php if ($count < $total) : ?>
                                                <div class="lx_step_arrow">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="#E2E8F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="4 4"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="lx_step_content">
                                            <h3 class="lx_step_title"><?php echo esc_html($item['item_title']); ?></h3>
                                            <?php if (!empty($item['item_description'])) : ?>
                                                <div class="lx_step_desc">
                                                    <?php echo nl2br(esc_html($item['item_description'])); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <?php
    }
}
