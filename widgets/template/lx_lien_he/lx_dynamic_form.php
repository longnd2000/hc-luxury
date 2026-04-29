<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class LX_Dynamic_Form_Widget extends Widget_Base
{
    public function get_name() {
        return 'lx_dynamic_form';
    }

    public function get_title() {
        return __('LX — Form Năng Động', 'lx-landing');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['lx_lien_he'];
    }

    protected function register_controls() {
        // Tab: Nội dung
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Cấu hình Form', 'lx-landing'),
            ]
        );

        $this->add_control(
            'source',
            [
                'label' => __('Nguồn dữ liệu', 'lx-landing'),
                'type' => Controls_Manager::SELECT,
                'default' => 'manual',
                'options' => [
                    'manual' => __('Nhập thủ công tại đây', 'lx-landing'),
                    'admin'  => __('Chọn form từ Quản trị (LX Forms)', 'lx-landing'),
                ],
            ]
        );

        $this->add_control(
            'selected_form',
            [
                'label' => __('Chọn Form', 'lx-landing'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_lx_forms(),
                'condition' => [
                    'source' => 'admin',
                ],
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => __('Tiêu đề Form', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => __('NHẬN TƯ VẤN CÁ NHÂN HÓA', 'lx-landing'),
                'condition' => [
                    'source' => 'manual',
                ],
            ]
        );

        $this->add_control(
            'form_description',
            [
                'label' => __('Ghi chú dưới form', 'lx-landing'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('(*) Home Care cam kết bảo mật thông tin của mẹ và bé. Bằng việc đăng ký, mẹ đồng ý để chúng mình liên hệ hỗ trợ tư vấn tốt nhất.', 'lx-landing'),
                'condition' => [
                    'source' => 'manual',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'field_label',
            [
                'label' => __('Nhãn trường (Label)', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Họ và tên', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'field_type',
            [
                'label' => __('Loại trường', 'lx-landing'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text'     => __('Văn bản (Text)', 'lx-landing'),
                    'tel'      => __('Số điện thoại (Tel)', 'lx-landing'),
                    'email'    => __('Email', 'lx-landing'),
                    'select'   => __('Danh sách thả (Select)', 'lx-landing'),
                    'textarea' => __('Đoạn văn (Textarea)', 'lx-landing'),
                ],
            ]
        );

        $repeater->add_control(
            'field_placeholder',
            [
                'label' => __('Gợi ý (Placeholder)', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nhập nội dung...', 'lx-landing'),
            ]
        );

        $repeater->add_control(
            'field_options',
            [
                'label' => __('Các tùy chọn (Mỗi dòng một mục)', 'lx-landing'),
                'type' => Controls_Manager::TEXTAREA,
                'condition' => [
                    'field_type' => 'select',
                ],
            ]
        );

        $repeater->add_control(
            'field_required',
            [
                'label' => __('Bắt buộc nhập?', 'lx-landing'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Có', 'lx-landing'),
                'label_off' => __('Không', 'lx-landing'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'fields_list',
            [
                'label' => __('Danh sách các trường', 'lx-landing'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'field_label' => 'Họ và tên',
                        'field_type' => 'text',
                        'field_placeholder' => 'Nhập tên của bạn',
                    ],
                    [
                        'field_label' => 'Số điện thoại',
                        'field_type' => 'tel',
                        'field_placeholder' => 'Nhập số điện thoại hoặc Zalo',
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
                'condition' => [
                    'source' => 'manual',
                ],
            ]
        );

        $this->add_control(
            'submit_text',
            [
                'label' => __('Chữ trên nút gửi', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nhận tư vấn ngay', 'lx-landing'),
            ]
        );

        $this->end_controls_section();

        // Tab: Cài đặt (Email)
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Cài đặt Email & Thông báo', 'lx-landing'),
                'condition' => [
                    'source' => 'manual',
                ],
            ]
        );

        $this->add_control(
            'email_to',
            [
                'label' => __('Gửi đến Email', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => get_option('admin_email'),
                'description' => __('Mặc định gửi về email quản trị viên.', 'lx-landing'),
            ]
        );

        $this->add_control(
            'email_subject',
            [
                'label' => __('Tiêu đề Email', 'lx-landing'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Thông tin tư vấn mới từ website', 'lx-landing'),
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label' => __('Thông báo gửi thành công', 'lx-landing'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Cảm ơn bạn! Chúng tôi đã nhận được thông tin và sẽ liên hệ sớm nhất.', 'lx-landing'),
            ]
        );

        $this->end_controls_section();
    }

    private function get_lx_forms() {
        $forms = get_posts([
            'post_type' => 'lx_form',
            'numberposts' => -1,
        ]);

        $options = ['' => __('Chọn một form...', 'lx-landing')];

        foreach ($forms as $form) {
            $options[$form->ID] = $form->post_title;
        }

        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $source = $settings['source'];
        
        $cf7_id = 0;

        if ($source === 'admin' && !empty($settings['selected_form'])) {
            $cf7_id = get_post_meta($settings['selected_form'], 'lx_linked_cf7_id', true);
        }

        if ($cf7_id) {
            echo do_shortcode('[contact-form-7 id="' . $cf7_id . '"]');
        } else {
            // Fallback to manual rendering (previous logic) or message
            if ($source === 'admin') {
                echo '<p class="lx_text_center">' . __('Chưa có form CF7 nào được đồng bộ.', 'lx-landing') . '</p>';
                return;
            }
            
            // Manual Rendering Logic (Simplified for brevity or keep the previous one)
            $form_title = $settings['form_title'];
            $form_description = $settings['form_description'];
            $fields = $settings['fields_list'];
            ?>
            <div class="lx_form_personalized">
                <h3 class="lx_form_title"><?php echo esc_html($form_title); ?></h3>
                <form class="lx_manual_form">
                    <?php foreach ($fields as $index => $field) : ?>
                        <div class="lx_form_field">
                            <label><?php echo esc_html($field['field_label']); ?></label>
                            <input type="<?php echo esc_attr($field['field_type']); ?>" placeholder="<?php echo esc_attr($field['field_placeholder']); ?>">
                        </div>
                    <?php endforeach; ?>
                    <div class="lx_form_submit">
                        <input type="submit" value="<?php echo esc_attr($settings['submit_text']); ?>">
                    </div>
                </form>
            </div>
            <?php
        }
    }
}
