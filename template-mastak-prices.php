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
    <?php foreach ($seasons as $season_id => $season_title) : ?>
        <div class="season-item <?= $current_season_id == $season_id ? 'season-item__current' : '' ?>">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle"><?= $season_title; ?></h2>
                <?php if ($current_season_id == $season_id): ?>
                    <span class="header-title__current-label">текущий период</span>
                <?php endif; ?>
            </section>
            <div class="b-container">
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
        <?php
            if (is_active_sidebar('prices-content') and $current_season_id == $season_id) {
                dynamic_sidebar('prices-content');
            }
        ?>
    <?php endforeach; ?>
    <div class="seasons__added">
        <section class="b-container header-title">
            <h2 class="header-title__subtitle">Цены на услуги</h2>
        </section>
        <div class="b-container">
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

                            ?>
                            <tr class="<?= $index_services == $service_count ? "" : "prices__row"; ?>">
                                <td class="prices__name prices__name_size_50per">
                                    <a class="prices__link" href="<?= get_permalink($service_id); ?>"
                                       target="_blank">
                                        <?= $service_title; ?>
                                    </a>
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
        <section class="b-container header-title">
            <h2 class="header-title__subtitle">Цены на рыбалку</h2>
        </section>
        <div class="b-container">
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

<?php
    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>
