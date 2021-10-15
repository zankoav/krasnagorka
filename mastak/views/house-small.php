<?php

$isTerem    = get_post_meta(get_the_ID(), "mastak_house_is_it_terem", true);
$targetOpen = get_post_meta(get_the_ID(), "new_page", true) ? '_blank' : '_self';
$icon_id    = get_post_thumbnail_id();
$size       = wp_is_mobile() ? 'houses_last_iphone_5' : 'houses_last_laptop';

if (!$isTerem) {
    $calendarShortCode =  get_post_meta(get_the_ID(), "mastak_house_calendar", true);
    $calendarId = getCalendarId($calendarShortCode);
}

$current_season_id = get_option('mastak_theme_options')['current_season'];

$price_byn = (int) get_post_meta($current_season_id, "house_price_" . get_the_ID(), true);
$price     = get_current_price($price_byn);

global $kgCooke;
$currency_name = $kgCooke->getCurrnecy()["currency_selected"];

?>

<div class="our-house">
    <div class="our-house__header-image">
        <a href="<?= get_the_permalink(); ?>" target="_blank" class="our-house__header-image-wrap">
            <img class="object-fit-img" src="<?= wp_get_attachment_image_url($icon_id, $size); ?>" srcset="<?= wp_get_attachment_image_srcset($icon_id, $size); ?>" sizes="<?= wp_get_attachment_image_sizes($icon_id, $size); ?>">
            <?php if (!$isTerem or true) : ?>
                <div class="our-house__price js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $price_byn; ?>"><?= $price; ?></div>
            <?php endif; ?>
        </a>
    </div>
    <div class="our-house__content <?= $isTerem ? 'our-house__content_terem' : ''; ?>">
        <div class="our-house__apartments">
            <div class="our-house__header">
                <a href="<?= get_the_permalink(); ?>" target="_blank" class="our-house__title">
                    <h3><?= get_the_title(); ?></h3>
                </a>
                <p class="our-house__text"><?= get_post_meta(get_the_ID(), "mastak_house_small_description", true); ?></p>
                <a href="<?= get_the_permalink(); ?>" target="<?= $targetOpen; ?>" class="our-house__more">подробнее</a>
            </div>
            <div class="our-house__items">
                <div class="our-house__item">
                    <div class="apartment__wrapper">
                        <div class="apartment apartment_width_50">
                            <div class="apartment__header">
                                <img class="apartment__icon" src="<?= CORE_PATH; ?>assets/icons/teamwork.svg" alt="icon">
                                <p class="apartment__title">Кол-во гостей</p>
                            </div>
                            <ul class="apartment__items">
                                <li class="apartment__item apartment__item_font_11">
                                    <?= get_post_meta(get_the_ID(), "mastak_house_guests", true); ?>
                                </li>
                            </ul>
                        </div>
                        <div class="apartment apartment_width_50">
                            <div class="apartment__header">
                                <img class="apartment__icon" src="<?= CORE_PATH; ?>assets/icons/grill.svg" alt="icon">
                                <p class="apartment__title">Мангал</p>
                            </div>
                            <ul class="apartment__items">
                                <li class="apartment__item apartment__item_font_11">
                                    <?php
                                    $barbecu = get_post_meta(get_the_ID(), "mastak_house_barbecu", true);
                                    echo empty($barbecu) ? 'нет' : $barbecu;
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="our-house__item our-house__item_width_50">
                    <div class="apartment">
                        <div class="apartment__header">
                            <img class="apartment__icon" src="<?= CORE_PATH; ?>assets/icons/double-king-size-bed.svg" alt="icon">
                            <p class="apartment__title">Комнаты</p>
                        </div>

                        <ul class="apartment__items">

                            <?php $rooms = mastak_get_house_rooms();
                            foreach ($rooms as $room) : ?>
                                <li class="apartment__item"><?= $room; ?></li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
                <div class="our-house__item our-house__item_width_50">
                    <div class="apartment">
                        <div class="apartment__header">
                            <img class="apartment__icon" src="<?= CORE_PATH; ?>assets/icons/sofa.svg" alt="icon">
                            <p class="apartment__title">Удобства</p>
                        </div>

                        <ul class="apartment__items">

                            <?php $conveniences = mastak_get_house_conveniences();
                            foreach ($conveniences as $convenience) : ?>
                                <li class="apartment__item"><?= $convenience; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="our-house__buttons">
                <a href="<?= get_the_permalink(); ?>" target="<?= $targetOpen; ?>" class="our-house__button our-house__button--gray">
                    подробнее
                </a>

                <?php if ($isTerem) : ?>
                    <a href="<?= get_the_permalink() . '?employment'; ?>" target="<?= $targetOpen; ?>" class="our-house__button b-ml-2">
                        забронировать
                    </a>
                    <a href="<?= get_the_permalink() . '?employment'; ?>" target="<?= $targetOpen; ?>" class="our-house__button our-house__button--gray b-ml-2">
                        занятость номеров
                    </a>
                <?php else : ?>
                    <a href="/booking-form/?booking=<?= get_the_ID(); ?>&calendarId=<?= $calendarId; ?>" data-name="<?= get_the_title(); ?>" data-id="<?= get_the_ID(); ?>" data-cd="<?= $calendarId; ?>" class="our-house__button b-ml-2" target="_blank">
                        забронировать
                    </a>
                    <a href="#" data-calendar='<?= get_post_meta(get_the_ID(), "mastak_house_calendar", true); ?>' class="our-house__button our-house__button--green booking-houses__calendars-button b-ml-2">
                        Показать календарь
                    </a>
                <?php endif; ?>
            </div>
            <p class="added-info-price added-info-price_first">Цена актуальна на текущий период, цены на другие даты смотрите в <a href="https://krasnagorka.by/tseny/" target="_blank">разделе цены</a>
            </p>
        </div>
        <?php if (!$isTerem) : ?>
            <div class="our-house__date">
                <a href="#" class="our-house__button-booking" data-calendar='<?= get_post_meta(get_the_ID(), "mastak_house_calendar", true); ?>'>
                    календарь бронирования
                </a>
                <div class="our-house__calendar">
                    <div class="booking-houses__calendars-inner"></div>
                </div>
                <a href="/booking-form/?booking=<?= get_the_ID() ?>&calendarId=<?= $calendarId; ?>" data-cd="<?= $calendarId; ?>" data-name="<?= get_the_title(); ?>" data-id="<?= get_the_ID(); ?>" class="our-house__button our-house__button_media_xs" target="_blank">
                    забронировать
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>