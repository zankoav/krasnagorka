<?php

/**
 *
 * Template Name: Prices (redesign)
 *
 */

// File Security Check
if (!defined('ABSPATH')) {
    exit;
}

$current_season_id = get_option('mastak_theme_options')['current_season'];
$seasons           = show_seasons_options();
$seasons_ids       = getSeasonsForPricePage();
$houses            = show_house_options();
$services          = show_service_options();
asort($services);

$price             = get_current_price($price_byn);

global $kgCooke;
$currency_name = $kgCooke->getCurrnecy()["currency_selected"];

get_header('mastak');
get_template_part("mastak/views/header", "small-view"); ?>

<style>
    .js-accordion .header-title__subtitle.header-title__subtitle_service {
        color: #6fb128;
    }

    .seasons__added,
    .season-text {
        order: initial;
    }

    .prices__terem-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 22px;
    }

    .prices__terem-show-more-button {
        cursor: pointer;
        width: 32px;
        height: 18px;
        transition: 0.4s;
        flex-shrink: 0;
        background: url('/wp-content/themes/krasnagorka/mastak/src/icons/accordion-arrow.svg') no-repeat 50% 0%
    }

    .prices__table {
        line-height: 1;
    }

    .prices__terem-rooms,
    .prices__terem-values {
        padding-top: .5rem;
    }

    .prices__room-value,
    .prices__room-title {
        height: 38px;
        padding: .5rem 0 .5rem .5rem;
        display: flex;
        font-size: 11px;
        align-items: center;
    }

    .house-booking__price-per-men_room {
        flex-shrink: 0;
        margin-right: 0.5rem;
    }


    @media (min-width: 1280px) {

        .prices__terem-wrapper {
            height: initial;
        }

        .prices__value {
            font-size: 16px;
            line-height: 1.125;
        }

        .prices__room-value,
        .prices__room-title {
            font-size: 14px;
            line-height: 1;
            padding: .5rem 0 .5rem 1rem;
            height: initial
        }

        .house-booking__price-per-men_room {
            margin-right: initial
        }
    }
</style>
<div class="seasons">
    <div class="season-item season-item__current">
        <section class="b-container header-title">
            <h2 class="header-title__subtitle"><?= $seasons[$current_season_id]; ?></h2>
            <span class="header-title__current-label">текущий период</span>
        </section>
        <div class="b-container js-accordion-content">
            <div class="prices">
                <table class="prices__table">
                    <tbody>
                        <?php

                        $houses_count    = count($houses);
                        $index_services  = 1;
                        foreach ($houses as $house_id => $house_title) :

                            $isTerem   = get_post_meta($house_id, "mastak_house_is_it_terem", true) == 'on';
                            $house_byn = (float)get_post_meta($current_season_id, "house_price_" . $house_id, true);
                            $house_price = get_current_price($house_byn);
                            if ($isTerem) {

                                $calendarsFromTerem = [
                                    'Терем 1' => 18,
                                    'Терем 2' => 19,
                                    'Терем 3' => 20,
                                    'Терем 4' => 21,
                                    'Терем 5' => 22,
                                    'Терем 6' => 23,
                                    'Терем 7' => 24,
                                    'Терем 8' => 25,
                                    'Терем 9' => 26,
                                    'Терем 10' => 27,
                                    'Терем 11' => 28,
                                    'Терем 12' => 29
                                ];

                                $calendars = [];
                                $minPriceRoom_byn = 100000000;
                                $maxPriceRoom_byn = 0;

                                foreach ($calendarsFromTerem as $room_name => $room_id) {
                                    $room_byn = (float)get_post_meta($current_season_id, 'room_price_' . $room_id, true);
                                    if ($minPriceRoom_byn >= $room_byn) {
                                        $minPriceRoom_byn = $room_byn;
                                    }
                                    if ($maxPriceRoom_byn <= $room_byn) {
                                        $maxPriceRoom_byn = $room_byn;
                                    }
                                    $room_price = get_current_price($room_byn);
                                    $calendars[] = [
                                        'room_name' => $room_name,
                                        'room_byn' => $room_byn,
                                        'room_price' => $room_price
                                    ];
                                }
                            }
                            $minPriceRoom = get_current_price($minPriceRoom_byn);
                            $maxPriceRoom = get_current_price($maxPriceRoom_byn);
                        ?>
                            <?php if ($isTerem) : ?>
                                <tr class="<?= $index_services == $houses_count ? "" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <div class="prices__terem-wrapper">
                                            <a class="prices__link" href="<?= get_permalink($house_id); ?>" target="_blank">
                                                <?= $house_title; ?>
                                            </a>
                                            <div class="prices__terem-show-more-button"></div>
                                        </div>
                                        <div class="prices__terem-rooms">
                                            <?php foreach ($calendars as $calendar) : ?>
                                                <div class="prices__room-title">
                                                    <?= $calendar['room_name']; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <div class="prices__value-wrapper">
                                            <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $minPriceRoom_byn; ?>">
                                                <?= $minPriceRoom; ?>
                                            </span>
                                            —
                                            <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $maxPriceRoom_byn; ?>">
                                                <?= $maxPriceRoom; ?>
                                            </span>
                                            с человека в сутки
                                        </div>
                                        <div class="prices__terem-values">
                                            <?php foreach ($calendars as $calendar) : ?>
                                                <div class="prices__room-value">
                                                    <span class="house-booking__price-per-men house-booking__price-per-men_room js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $calendar["room_byn"]; ?>">
                                                        <?= $calendar["room_price"]; ?>
                                                    </span>
                                                    с человека в сутки
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <tr class="<?= $index_services == $houses_count ? "" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <a class="prices__link" href="<?= get_permalink($house_id); ?>" target="_blank">
                                            <?= $house_title; ?>
                                        </a>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $house_byn; ?>">
                                            <?= $house_price; ?>
                                        </span>
                                        с человека в сутки
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php
                            $index_services++;
                        endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
    <div class="b-container content-text season-text">
        <div class="textwidget">
            <?= wpautop(get_option('mastak_price_appearance_options')['mastak_price_submenu_big_text']); ?>
        </div>
    </div>
    <?php foreach ($seasons_ids as $season_id) :
        if ($season_id == $current_season_id) {
            continue;
        }
        $season_title = $seasons[$season_id];
    ?>
        <div class="season-item js-accordion">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle"><?= $season_title; ?></h2>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                            <?php

                            $houses_count    = count($houses);
                            $index_services  = 1;
                            foreach ($houses as $house_id => $house_title) :
                                $house_byn = (float)get_post_meta($season_id, "house_price_" . $house_id, true);
                                $house_price = get_current_price($house_byn);

                            ?>
                                <tr class="<?= $index_services == $houses_count ? "" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <a class="prices__link" href="<?= get_permalink($house_id); ?>" target="_blank">
                                            <?= $house_title; ?>
                                        </a>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $house_byn; ?>">
                                            <?= $house_price; ?>
                                        </span>
                                        с человека в сутки
                                    </td>
                                </tr>
                            <?php
                                $index_services++;
                            endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="seasons__added">
        <div class="js-accordion">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle header-title__subtitle_service">Цены на услуги</h2>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                            <?php

                            $service_count  = count($services);
                            $index_services = 1;
                            foreach ($services as $service_id => $service_title) :
                                $service_byn = (int)get_post_meta($service_id, "mastak_opportunity_price", true);
                                if ($service_byn == 0) {
                                    $service_count--;
                                    continue;
                                }

                                $service_price    = get_current_price($service_byn);
                                $service_subtitle = get_post_meta($service_id, "mastak_opportunity_price_subtitle", true);

                                if ('Питание' == $service_title) {
                                    $bookingSettings = get_option('mastak_booking_appearance_options');

                                    $service_food_breackfast_byn = intval($bookingSettings['food_breakfast_price']);
                                    $service_food_breackfast_price    = get_current_price($service_food_breackfast_byn);

                                    $service_food_lunch_byn = intval($bookingSettings['food_lunch_price']);
                                    $service_food_lunch_price    = get_current_price($service_food_lunch_byn);

                                    $service_food_dinner_byn = intval($bookingSettings['food_dinner_price']);
                                    $service_food_dinner_price    = get_current_price($service_food_dinner_byn);
                                }

                            ?>
                                <tr class="<?= $index_services == $service_count ? "" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <a class="prices__link" href="<?= get_permalink($service_id); ?>" target="_blank"><?= $service_title; ?></a>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <?php if ('Питание' == $service_title) : ?>
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                                <span>Завтрак</span>
                                                <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_food_breackfast_byn; ?>"><?= $service_food_breackfast_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div>
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                                <span>Обед</span>
                                                <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_food_lunch_byn; ?>"><?= $service_food_lunch_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div>
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                                <span>Ужин</span>
                                                <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_food_dinner_byn; ?>"><?= $service_food_dinner_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_byn; ?>"><?= $service_price; ?>
                                            </span> <?= $service_subtitle ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                                $index_services++;
                            endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="js-accordion">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle header-title__subtitle_service">Цены на рыбалку</h2>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                            <?php

                            $fishing_services = get_option('mastak_price_appearance_options')['fishing_group'];
                            $fishing_services = array_sort($fishing_services, 'name', SORT_ASC);

                            // sort $fishing_services

                            $fishing_services_count = count($fishing_services);
                            $index_services         = 1;
                            $MAX_COUNT              = 8;
                            $BASE_MAX               = $fishing_services_count > $MAX_COUNT ? $MAX_COUNT : $fishing_services_count;

                            foreach ($fishing_services as $service) :

                                $service_byn = $service['price'];

                                if ($service_byn == 0) {
                                    $fishing_services_count--;
                                    continue;
                                }

                                $service_price    = get_current_price($service_byn);
                                $service_title    = $service['name'];
                                $service_subtitle = $service['subtitle'];
                            ?>
                                <tr class="<?= $index_services == $BASE_MAX ? "prices__row_last" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <span class="prices__link">
                                            <?= $service_title; ?>
                                        </span>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_byn; ?>">
                                            <?= $service_price; ?>
                                        </span> <?= $service_subtitle ?>
                                    </td>
                                </tr>

                            <?php
                                if ($index_services > $BASE_MAX - 1) {
                                    break;
                                }
                                $index_services++;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <div class="prices__table_hide">
                        <table class="prices__table">
                            <tbody>
                                <?php

                                $index_services         = 1;
                                $fishing_services_count = count($fishing_services);


                                foreach ($fishing_services as $service) :

                                    if ($fishing_services_count === $BASE_MAX) {
                                        break;
                                    }

                                    if ($index_services < $BASE_MAX + 1) {
                                        $index_services++;
                                        continue;
                                    }

                                    $service_byn = $service['price'];


                                    if ($service_byn == 0) {
                                        $fishing_services_count--;
                                        continue;
                                    }

                                    $service_price    = get_current_price($service_byn);
                                    $service_title    = $service['name'];
                                    $service_subtitle = $service['subtitle'];
                                ?>
                                    <tr class="<?= $index_services == $fishing_services_count ? "" : "prices__row"; ?>">
                                        <td class="prices__name prices__name_size_50per">
                                            <span class="prices__link">
                                                <?= $service_title; ?>
                                            </span>
                                        </td>
                                        <td class="prices__value prices__value_active">
                                            <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $service_byn; ?>">
                                                <?= $service_price; ?>
                                            </span> <?= $service_subtitle ?>
                                        </td>
                                    </tr>
                                <?php
                                    $index_services++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($fishing_services_count > $BASE_MAX) : ?>
                    <div class="price__table-more-block">
                        <a href="#" class="price__table-more">
                            <img class="price__arrow-more" src=<?= CORE_PATH ?>"src/icons/left-arrow-gray.e83982.svg" alt="arrow">
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="b-mt-1">
    <?php get_template_part("mastak/views/reviews", "view"); ?>
</div>
<?php
get_template_part("mastak/views/footer", "view");
get_footer('mastak');
?>