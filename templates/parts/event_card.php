<?php

/**
 * Component: Event Card (event_item)
 *
 * Reusable event card markup used in archive-event and event_widget.
 *
 * Expected variables:
 * @var string $img           — Event thumbnail URL
 * @var string $title         — Event title
 * @var string $link          — Event permalink
 * @var string $month_num     — Month number for badge (e.g., '01')
 * @var string $day_num       — Day number for badge (e.g., '15')
 * @var string $date_range    — Formatted date range string (e.g., '01/04/2026 - 05/04/2026')
 * @var string $location      — Event location (optional, from ACF)
 * @var string $status_text   — Status label (e.g., 'SẮP DIỄN RA')
 * @var string $status_class  — Status CSS class (upcoming|active|finished)
 */
?>

<div class="event_item">
    <div class="event_image_wrap">
        <?php if ($link): ?><a href="<?php echo $link; ?>"><?php endif; ?>
            <?php if ($img): ?>
                <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" width="400" height="300">
            <?php else: ?>
                <div class="event_placeholder_img"></div>
            <?php endif; ?>
            <?php if ($link): ?>
            </a><?php endif; ?>

        <div class="event_date_badge">
            <span class="eb_month"><?php echo __('TH', 'lx-landing') . ' ' . $month_num; ?></span>
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
