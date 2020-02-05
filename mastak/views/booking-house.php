<?php

$min_people        = get_post_meta(get_the_ID(), 'min_people', 1);
$max_people        = get_post_meta(get_the_ID(), 'max_people', 1);
$double_bed        = get_post_meta(get_the_ID(), 'double_bed', 1);
$single_bed        = get_post_meta(get_the_ID(), 'single_bed', 1);
$toilet_and_shower = get_post_meta(get_the_ID(), 'toilet_and_shower', 1);
$toilet            = get_post_meta(get_the_ID(), 'toilet', 1);
$bed_rooms         = get_post_meta(get_the_ID(), 'bed_rooms', 1);
$triple_bed        = get_post_meta(get_the_ID(), 'triple_bed', 1);
$calendarShortCode =  get_post_meta(get_the_ID(), "mastak_house_calendar", true);
$calendarId = getCalendarId($calendarShortCode);
?>

<div class="booking-houses__wrapper">
    <div class="booking-houses__item">
        <div class="booking-houses__header">
            <p class="booking-houses__title our-house__title"><?= get_the_title(); ?></p>
        </div>
        <a href="<?= get_the_permalink(); ?>" target="_blank" class="booking-houses__image-wrapper">
            <img class="booking-houses__image" src="<?= get_the_post_thumbnail_url(get_the_ID(), 'calendar-thumb'); ?>" alt="<?= get_the_title(); ?>">
        </a>
        <div class="booking-houses__header">
            <p class="booking-houses__description">
                <?php if (!empty($min_people)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $min_people; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/min-01.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($max_people)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $max_people; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/max-01.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($double_bed)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $double_bed; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/double-king-size-bed.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($single_bed)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $single_bed; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/single-king-size-bed.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($toilet_and_shower)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $toilet_and_shower; ?>">
                        <img class="apartment__icon apartment__icon_mr--4px" src="<?= CORE_PATH ?>assets/icons/toilet.svg" alt="icon">
                        <img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/shower.svg" alt="icon">
                        x</span>
                <?php endif;
                if (!empty($toilet)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $toilet; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/toilet.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($bed_rooms)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $bed_rooms; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/br-01.svg" alt="icon">x</span>
                <?php endif;
                if (!empty($triple_bed)) : ?>
                    <span class="booking-houses__description-item" data-info="<?= $triple_bed; ?>"><img class="apartment__icon apartment__icon_mr-4px" src="<?= CORE_PATH ?>assets/icons/triple-bed.svg" alt="icon">x</span>
                <?php endif; ?>
            </p>
        </div>
        <div class="booking-houses__calendars">
            <div class="booking-houses__calendars-inner">
                <a href="#" data-calendar='<?= get_post_meta(get_the_ID(), "mastak_house_calendar", true); ?>' class="our-house__button our-house__button--green booking-houses__calendars-button">Показать
                    календарь
                </a>
            </div>
            <a href="/booking-form/?booking=<?= get_the_ID(); ?>&calendarId=<?= $calendarId; ?>" data-cd="<?= $calendarId; ?>" data-name="<?= get_the_title(); ?>" data-id="<?= get_the_ID(); ?>" target="_blank" class="our-house__button our-house__button_media_xs our-house__button-hidden our-house__button_mt_15">
                забронировать
            </a>
        </div>
    </div>
</div>