<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LX_FAQs_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lx_faqs';
    }

    public function get_title() {
        return __('LX — FAQs', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['lx_faqs'];
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
            'layout_style',
            [
                'label' => __('Kiểu hiển thị', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'center'      => __('Căn giữa (Tiêu chuẩn)', 'lx-landing'),
                    'two_columns' => __('Chia 2 cột (Tiêu đề bên trái)', 'lx-landing'),
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Tiêu đề', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('GIẢI ĐÁP THẮC MẮC LIÊN QUAN', 'lx-landing'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Mô tả', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Khác biệt đến từ chuyên môn vững vàng và sự tận tâm trong từng chi tiết', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // FAQs List
        $this->start_controls_section(
            'section_faqs',
            [
                'label' => __('Danh sách câu hỏi', 'lx-landing'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => __('Câu hỏi', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Câu hỏi thường gặp?', 'lx-landing'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => __('Câu trả lời', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Câu trả lời chi tiết cho thắc mắc của khách hàng.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'faqs_list',
            [
                'label' => __('Danh sách FAQs', 'lx-landing'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'question' => __('1. Dịch vụ chăm sóc mẹ sau sinh tại nhà bao gồm những gì?', 'lx-landing'),
                    ],
                    [
                        'question' => __('2. Dịch vụ có hỗ trợ chăm sóc bé không?', 'lx-landing'),
                    ],
                    [
                        'question' => __('3. Bao lâu sau sinh thì mẹ có thể sử dụng dịch vụ?', 'lx-landing'),
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <section class="lx_wrap lx_faqs">
            <div class="lx_con">
                <?php if ($settings['layout_style'] === 'center') : ?>
                    <!-- Style 1: Centered -->
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

                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-7">
                            <?php $this->render_accordion($settings); ?>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- Style 2: Two Columns -->
                    <div class="row gx-60 align-items-center">
                        <div class="col-lg-5">
                            <div class="lx_faqs_header_side mb-4 mb-lg-0">
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
                        <div class="col-md-10 col-lg-7">
                            <?php $this->render_accordion($settings); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    }

    /**
     * Helper to render the accordion list
     */
    protected function render_accordion($settings) {
        ?>
        <div class="lx_faq_accordion">
            <?php foreach ($settings['faqs_list'] as $index => $item) : ?>
                <div class="lx_faq_item">
                    <div class="lx_faq_header" aria-expanded="false">
                        <span class="lx_faq_question"><?php echo esc_html($item['question']); ?></span>
                        <span class="lx_faq_icon">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                        </span>
                    </div>
                    <div class="lx_faq_content_wrapper">
                        <div class="lx_faq_body">
                            <div class="lx_text_editor">
                                <?php echo $item['answer']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
