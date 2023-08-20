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
    $houses            = show_house_options();
    $services          = show_service_options();
    $price             = get_current_price($price_byn);

    global $kgCooke;
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view"); ?>

<div class="seasons">
    <?php foreach ($seasons as $season_id => $season_title) :
        $hide_season = get_post_meta($season_id, "hide_season_checkbox", true);
        if($hide_season == 'on'){
            continue;
        }
        $order_data = get_post_meta($season_id, "season_order", true);
        $season_order = -1*(int)(empty($order_data) ? 0 : $order_data);
        ?>
        <div <?= $current_season_id != $season_id ? "style=\"order:$season_order;\"" : ''; ?> class="season-item <?= $current_season_id == $season_id ? 'season-item__current' : 'js-accordion' ?>">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle"><?= $season_title; ?></h2>
                <?php if ($current_season_id == $season_id): ?>
                    <span class="header-title__current-label">текущий период</span>
                <?php endif; ?>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                        <?php

                            $houses_count    = count($houses);
                            $index_services  = 1;
                            foreach ($houses as $house_id => $house_title):
                                $house_byn = (float)get_post_meta($season_id, "house_price_" . $house_id, true);
                                $house_price = get_current_price($house_byn);

                                ?>
                                <tr class="<?= $index_services == $houses_count ? "" : "prices__row"; ?>">
                                    <td class="prices__name prices__name_size_50per">
                                        <a class="prices__link" href="<?= get_permalink($house_id); ?>"
                                           target="_blank">
                                            <?= $house_title; ?>
                                        </a>
                                    </td>
                                    <td class="prices__value prices__value_active">
                            <span class="house-booking__price-per-men js-currency"
                                  data-currency="<?= $currency_name; ?>"
                                  data-byn="<?= $house_byn; ?>">
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

        <?php if($current_season_id == $season_id):?>
            <div class="b-container content-text season-text">
            <div class="textwidget">
                <?= wpautop(get_option( 'mastak_price_appearance_options' )['mastak_price_submenu_big_text']);?>
            </div>
        </div>
        <?php endif;?>
    <?php endforeach; ?>
    <div class="seasons__added">
        <div class="js-accordion">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle">Цены на услуги</h2>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                        <?php

                            $service_count  = count($services);
                            $index_services = 1;
                            foreach ($services as $service_id => $service_title):
                                $service_byn = (int)get_post_meta($service_id, "mastak_opportunity_price", true);
                                if ($service_byn == 0) {
                                    $service_count--;
                                    continue;
                                }

                                $service_price    = get_current_price($service_byn);
                                $service_subtitle = get_post_meta($service_id, "mastak_opportunity_price_subtitle", true);
                                
                                if('Питание' == $service_title){
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
                                        <a class="prices__link" href="<?= get_permalink($service_id); ?>"
                                           target="_blank"><?= $service_title; ?></a>
                                    </td>
                                    <td class="prices__value prices__value_active">
                                        <?php if('Питание' == $service_title):?> 
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                                <span style="display: inline-block;width: 50px;">Завтрак</span>
                                                <span class="house-booking__price-per-men js-currency"
                                                    data-currency="<?= $currency_name; ?>"
                                                    data-byn="<?= $service_food_breackfast_byn; ?>"><?= $service_food_breackfast_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div> 
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                            <span style="display: inline-block;width: 50px;">Обед</span>
                                                <span class="house-booking__price-per-men js-currency"
                                                    data-currency="<?= $currency_name; ?>"
                                                    data-byn="<?= $service_food_lunch_byn; ?>"><?= $service_food_lunch_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div> 
                                            <div class="house-booking__price-per-men-wrapp" style="margin: 4px 0;">
                                                <span style="display: inline-block;width: 50px;">Ужин</span>
                                                <span class="house-booking__price-per-men js-currency"
                                                    data-currency="<?= $currency_name; ?>"
                                                    data-byn="<?= $service_food_dinner_byn; ?>"><?= $service_food_dinner_price; ?>
                                                </span> <?= $service_subtitle ?>
                                            </div> 
                                        <?php else :?>
                                            <span class="house-booking__price-per-men js-currency"
                                                data-currency="<?= $currency_name; ?>"
                                                data-byn="<?= $service_byn; ?>"><?= $service_price; ?>
                                            </span> <?= $service_subtitle ?>
                                        <?php endif;?>
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
                <h2 class="header-title__subtitle">Цены на рыбалку</h2>
            </section>
            <div class="b-container js-accordion-content">
                <div class="prices">
                    <table class="prices__table">
                        <tbody>
                        <?php

                            $fishing_services       = get_option('mastak_price_appearance_options')['fishing_group'];
                            $fishing_services_count = count($fishing_services);
                            $index_services         = 1;
                            $MAX_COUNT              = 8;
                            $BASE_MAX               = $fishing_services_count > $MAX_COUNT ? $MAX_COUNT : $fishing_services_count;

                            foreach ($fishing_services as $service):

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
                                    <span class="house-booking__price-per-men js-currency"
                                          data-currency="<?= $currency_name; ?>"
                                          data-byn="<?= $service_byn; ?>">
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


                                foreach ($fishing_services as $service):

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
                                    <span class="house-booking__price-per-men js-currency"
                                          data-currency="<?= $currency_name; ?>"
                                          data-byn="<?= $service_byn; ?>">
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
                <?php if ($fishing_services_count > $BASE_MAX): ?>
                    <div class="price__table-more-block">
                        <a href="#" class="price__table-more">
                            <img class="price__arrow-more"
                                 src=<?= CORE_PATH ?>"src/icons/left-arrow-gray.e83982.svg" alt="arrow">
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
