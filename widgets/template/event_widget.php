<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class event_widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'event_widget';
    }

    public function get_title()
    {
        return __('Event Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-calendar';
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

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Sự kiện', 'child_theme'),
                'placeholder' => __('Enter title', 'child_theme'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = [
            'post_type'      => 'event',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'orderby'        => 'meta_value',
            'meta_key'       => 'event_start_date',
            'order'          => 'DESC', // Show latest events first
        ];

        $query = new \WP_Query($args);

        if (!$query->have_posts()) return;

        $now = current_time('timestamp');

        ?>
        <div class="event_widget">
            <?php if ($settings['title']): ?>
                <div class="event_header">
                    <h2 class="event_section_title"><?php echo $settings['title']; ?></h2>
                </div>
            <?php endif; ?>
            <div class="event_grid">
                <?php while ($query->have_posts()): $query->the_post(); 
                    $start_date_raw = get_field('event_start_date');
                    $end_date_raw = get_field('event_end_date');
                    $location = get_field('event_location');
                    
                    if (!$start_date_raw || !$end_date_raw) continue;

                    // Parse d/m/Y format from ACF Return Format
                    $start_dt = DateTime::createFromFormat('d/m/Y', $start_date_raw);
                    $end_dt   = DateTime::createFromFormat('d/m/Y', $end_date_raw);
                    
                    if (!$start_dt || !$end_dt) continue;

                    $start_ts = $start_dt->getTimestamp();
                    $end_ts   = $end_dt->getTimestamp();
                    
                    // MONTH/DAY for badge
                    $month_num = $start_dt->format('m');
                    $day_num   = $start_dt->format('d');
                    $date_range = $start_date_raw . ' - ' . $end_date_raw;

                    // Status Logic
                    $status_text = '';
                    $status_class = '';
                    if ($now < $start_ts) {
                        $status_text = __('SẮP DIỄN RA', 'child_theme');
                        $status_class = 'upcoming';
                    } elseif ($now >= $start_ts && $now <= $end_ts) {
                        $status_text = __('ĐĂNG KÝ NGAY', 'child_theme');
                        $status_class = 'active';
                    } else {
                        $status_text = __('ĐÃ KẾT THÚC', 'child_theme');
                        $status_class = 'finished';
                    }

                    $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $title = get_the_title();
                    $link = get_permalink();
                ?>
                    <div class="event_item">
                        <div class="event_image_wrap">
                            <?php if ($link): ?><a href="<?php echo $link; ?>"><?php endif; ?>
                                <?php if ($img): ?>
                                    <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" width="400" height="300">
                                <?php else: ?>
                                    <div class="event_placeholder_img"></div>
                                <?php endif; ?>
                            <?php if ($link): ?></a><?php endif; ?>

                            <div class="event_date_badge">
                                <span class="eb_month"><?php echo __('TH', 'child_theme') . ' ' . $month_num; ?></span>
                                <span class="eb_day"><?php echo $day_num; ?></span>
                            </div>

                            <div class="event_status_badge <?php echo $status_class; ?>">
                                <?php echo $status_text; ?>
                            </div>
                        </div>

                        <div class="event_content">
                            <?php if ($title): ?>
                                <h3 class="event_title">
                                    <?php if ($link): ?>
                                        <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                    <?php else: ?>
                                        <?php echo $title; ?>
                                    <?php endif; ?>
                                </h3>
                            <?php endif; ?>

                            <div class="event_meta">
                                <div class="em_row">
                                    <i class="fa-regular fa-clock"></i>
                                    <span><?php echo $date_range; ?></span>
                                </div>
                                <?php if ($location): ?>
                                    <div class="em_row">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span><?php echo $location; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
    }
}
