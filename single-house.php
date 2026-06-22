<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');

$current_season_id = get_option('mastak_theme_options')['current_season'];

$price_byn = (int) get_post_meta($current_season_id, "house_price_" . get_the_ID(), true);
$price     = get_current_price($price_byn);
$isTerem   = get_post_meta(get_the_ID(), "mastak_house_is_it_terem", true);
$subtitle  = get_post_meta(get_the_ID(), "mastak_house_subtitle", true);

if ($isTerem) {
    $terem_options = get_option('mastak_terem_appearance_options');
    $galleries     = $terem_options['gallary'];
    $kalendars     = $terem_options['kalendar'];
}

if (!$isTerem) {
    $calendarShortCode =  get_post_meta(get_the_ID(), "mastak_house_calendar", true);
    $calendarId = getCalendarId($calendarShortCode);
}

global $kgCooke;
$currency_name = $kgCooke->getCurrnecy()["currency_selected"];
$isEmployment  = isset($_GET['employment']);
$size          = wp_is_mobile() ? 'welcome_tab_iphone_5' : 'welcome_tab_laptop';

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php
        get_template_part("mastak/views/header", "small-view");
        $imageId = get_post_thumbnail_id(); ?>
        <div class="b-bgc-wrapper">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle"><?= $subtitle; ?></h2>
            </section>
            <div class="b-container b-p-sm-0">
                <div class="accordion-mixed">
                    
                    <footer class="house-booking">
                        <div class="house-booking__container">
                            <p class="house-booking__info">
                                <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>" data-byn="<?= $price_byn; ?>"><?= $price; ?></span>
                            </p>
                            <p class="added-info-price"><span class="added-info-price__star">*</span>Цена актуальна на текущий период, цены на другие даты смотрите в <a href="https://krasnagorka.by/tseny/" target="_blank">разделе цены</a>
                            </p>
                            <p class="added-info-price added-info-price_first">
                                <a class="added-info-price_location" href="https://krasnagorka.by/shema-proezda/" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="14px" viewBox="0 0 18 25" version="1.1">
                                        <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                                            <g id="t_g-contacts-footer" transform="translate(-568.000000, -63.000000)" fill-rule="nonzero" stroke="#23C4FC">
                                                <g id="punkt-02" transform="translate(569.000000, 64.000000)">
                                                    <path d="M8.01751783,24 C7.47433468,23.1891964 6.96279327,22.4992253 6.52508258,21.7619719 C5.06780482,19.3102979 3.59294831,16.8586239 2.21301702,14.3474092 C1.37802674,12.8308737 0.634445929,11.2512952 0.228376975,9.54913296 C-0.416762879,6.84003319 0.325060059,4.47066539 2.19895402,2.50757499 C4.35586574,0.243278931 7.06650785,-0.462452943 10.0882937,0.288810019 C13.8378395,1.22044614 16.3832414,4.87694279 15.9525622,8.65427195 C15.7767748,10.265372 15.1333928,11.7608931 14.3704754,13.1758593 C13.0221859,15.678318 11.6246758,18.1545087 10.2025555,20.6149387 C9.54511056,21.7427087 8.78922463,22.8091869 8.01751783,24 Z M7.99466546,4.0136033 C5.78273793,4.01554152 3.9905577,5.80222537 3.99023758,8.00575014 C3.98991746,10.2092749 5.78157848,11.9964755 7.99350536,11.9990515 C10.2054322,12.0016275 12.001283,10.218605 12.0061345,8.01508551 C12.0117714,6.95302637 11.5911159,5.93276629 10.8377474,5.18127342 C10.084379,4.42978054 9.06078147,4.00938315 7.99466546,4.0136033 Z" id="Shape" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    Браславские озёра (оз. Снуды), д. Красногорка
                                </a>
                            </p>
                        </div>
                        <?php if (!$isTerem) : ?>
                            <a href="/booking-form/?booking=<?= get_the_ID(); ?>&calendarId=<?= $calendarId; ?>" data-cd="<?= $calendarId; ?>" data-name="<?= get_the_title(); ?>" data-id="<?= get_the_ID(); ?>" target="_blank" class="house-booking__button">забронировать / рассчитать
                            </a>
                        <?php endif; ?>
                    </footer>
                </div>
            </div>
        </div>
        <section class="b-bgc-wrapper b-pt-3 b-d-block-md">
            <div class="b-container">
                <div class="b-light-line"></div>
            </div>
        </section>
        <?php
        get_template_part("mastak/views/reviews", "view");
        get_template_part("mastak/views/footer", "view");
        ?>
<?php endwhile;
endif; // end of the loop.
?>
<?php get_footer('mastak'); ?>