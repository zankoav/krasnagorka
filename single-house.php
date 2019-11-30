<?php

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');

    $current_season_id = get_option('mastak_theme_options')['current_season'];

    $price_byn = (int)get_post_meta($current_season_id, "house_price_" . get_the_ID(), true);
    $price     = get_current_price($price_byn);
    $isTerem   = get_post_meta(get_the_ID(), "mastak_house_is_it_terem", true);
    $subtitle  = get_post_meta(get_the_ID(), "mastak_house_subtitle", true);

    if ($isTerem) {
        $terem_options = get_option('mastak_terem_appearance_options');
        $galleries     = $terem_options['gallary'];
        $kalendars     = $terem_options['kalendar'];
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
                <div data-mixed-tab="1"
                     class="accordion-mixed__tab <?= $isEmployment ? '' : 'accordion-mixed__tab--active' ?>">
                    ОПИСАНИЕ
                </div>
                <div data-mixed-conent="1"
                     class="accordion-mixed__content <?= $isEmployment ? '' : 'accordion-mixed__content--active' ?>">
                    <div class="accordion-mixed__content-inner">
                        <div class="house-description">
                            <div class="house-description__header">
                                <img class="house-description__image"
                                     src="<?= wp_get_attachment_image_url($imageId, $size); ?>"
                                     srcset="<?= wp_get_attachment_image_srcset($imageId, $size); ?>"
                                     sizes="<?= wp_get_attachment_image_sizes($imageId, $size); ?>">
                                <?php the_title('<h3 class="house-description__title">', '</h3>'); ?>
                                <div class="house-description__text big-text content-text">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="house-description__apartments">
                                <div class="house-description__item house-description__item_width_100">
                                    <div class="apartment__wrapper">

                                        <div class="apartment apartment_width_50">
                                            <div class="apartment__header">
                                                <img class="apartment__icon"
                                                     src="<?= CORE_PATH ?>assets/icons/teamwork.svg" alt="icon">
                                                <h3 class="apartment__title">Кол-во гостей</h3>
                                            </div>

                                            <ul class="apartment__items">
                                                <li class="apartment__item">
                                                    <?= get_post_meta(get_the_ID(), "mastak_house_guests", true); ?>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="apartment apartment_width_50">
                                            <div class="apartment__header">
                                                <img class="apartment__icon"
                                                     src="<?= CORE_PATH ?>assets/icons/grill.svg" alt="icon">
                                                <h3 class="apartment__title">Мангал</h3>
                                            </div>

                                            <ul class="apartment__items">
                                                <li class="apartment__item">
                                                    <?php
                                                        $barbecu = get_post_meta(get_the_ID(), "mastak_house_barbecu", true);
                                                        echo empty($barbecu) ? 'нет' : $barbecu;
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="house-description__item">
                                    <div class="apartment">
                                        <div class="apartment__header">
                                            <img class="apartment__icon"
                                                 src="<?= CORE_PATH ?>assets/icons/double-king-size-bed.svg"
                                                 alt="icon">
                                            <h3 class="apartment__title">Комнаты</h3>
                                        </div>

                                        <ul class="apartment__items">
                                            <?php $rooms = mastak_get_house_rooms();
                                                foreach ($rooms as $room) : ?>
                                                    <li class="apartment__item"><?= $room; ?></li>
                                                <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="house-description__item">
                                    <div class="apartment">
                                        <div class="apartment__header">
                                            <img class="apartment__icon"
                                                 src="<?= CORE_PATH ?>assets/icons/sofa.svg" alt="icon">
                                            <h3 class="apartment__title">Удобства</h3>
                                        </div>

                                        <ul class="apartment__items">
                                            <?php $conveniences = mastak_get_house_conveniences();
                                                foreach ($conveniences as $convenience) : ?>
                                                    <li class="apartment__item"><?= $convenience; ?></li>
                                                <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="house-description__item">
                                    <div class="apartment">
                                        <div class="apartment__header">
                                            <img class="apartment__icon"
                                                 src="<?= CORE_PATH ?>assets/icons/restaurant-cutlery.svg"
                                                 alt="icon">
                                            <h3 class="apartment__title">Кухня</h3>
                                        </div>

                                        <ul class="apartment__items">

                                            <?php $kitchens = mastak_get_house_kitchen();
                                                foreach ($kitchens as $kitchen) : ?>
                                                    <li class="apartment__item"><?= $kitchen; ?></li>
                                                <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="house-description__item">
                                    <div class="apartment">
                                        <div class="apartment__header">
                                            <img class="apartment__icon apartment__icon_clear"
                                                 src="<?= CORE_PATH ?>assets/icons/shower.svg" alt="shower">
                                            <img class="apartment__icon" src="<?= CORE_PATH ?>assets/icons/toilet.svg"
                                                 alt="toilet">
                                            <h3 class="apartment__title">Ванная</h3>
                                        </div>

                                        <ul class="apartment__items">

                                            <?php $bathrooms = mastak_get_house_bathroom();
                                                foreach ($bathrooms as $bathroom) : ?>
                                                    <li class="apartment__item"><?= $bathroom; ?></li>
                                                <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-mixed-tab="2" class="accordion-mixed__tab">
                    ФОТОГАЛЕРЕЯ
                </div>
                <div data-mixed-conent="2" class="accordion-mixed__content">
                    <?php if (!$isTerem) : ?>
                        <div class="swiper-container accordion-mixed__content-inner house-media-library__container">
                            <div class="swiper-wrapper house-media-library">
                                <?php get_model_gallary('medium', "mastak_house_gallery"); ?>
                            </div>
                            <div class="house-media-library__container">
                                <div class="b-container house-media-library__container-wrapper">
                                    <div class="swiper-button-next house-media-library__button-next"></div>
                                    <div class="swiper-button-prev house-media-library__button-prev"></div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php
                        foreach ($galleries as $gallery) : ?>
                            <p class="terem__gallery-title"><?= $gallery['subtitle']; ?></p>
                            <div class="swiper-container accordion-mixed__content-inner house-media-library__container">
                                <div class="swiper-wrapper house-media-library">
                                    <?php get_terem_gallary($gallery['gallary']); ?>
                                </div>
                                <div class="house-media-library__container">
                                    <div class="b-container house-media-library__container-wrapper">
                                        <div class="swiper-button-next house-media-library__button-next"></div>
                                        <div class="swiper-button-prev house-media-library__button-prev"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div data-mixed-tab="3"
                     class="accordion-mixed__tab js-add-public-calendar <?= $isTerem ? '' : ' js-add-public-calendar-single'; ?> <?= $isEmployment ? 'accordion-mixed__tab--active' : '' ?>">
                    <?= $isTerem ? 'КАЛЕНДАРИ БРОНИРОВАНИЯ' : 'КАЛЕНДАРЬ БРОНИРОВАНИЯ'; ?>
                </div>
                <div data-mixed-conent="3"
                     class="accordion-mixed__content <?= $isEmployment ? 'accordion-mixed__content--active' : '' ?>">
                    <?php if (!$isTerem) : ?>
                        <div class="accordion-mixed__content-inner">
                            <div class="booking-houses__calendars-inner">
                                <a href="#"
                                   data-calendar='<?= get_post_meta(get_the_ID(), "mastak_house_calendar", true); ?>'
                                   class="our-house__button our-house__button--green booking-houses__calendars-button">
                                    Показать календарь
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="booking-houses">
                            <div class="booking-houses__icons-description">
                                <?php get_template_part('mastak/views/icons-description'); ?>
                                <div class="select-helper select-helper_header">
                                    <img src="/wp-content/themes/krasnagorka/mastak/assets/icons/date-clicking-selecting.png" class="select-helper__img" alt="Выделение дат заезда и выезда">
                                    <p class="select-helper__text"><?=get_option('mastak_theme_options')['calendar_settings_message_before'];?></p>
                                </div>
                            </div>
                            <?php foreach ($kalendars as $kalendar) : ?>
                                <div class="booking-houses__wrapper">
                                    <div class="booking-houses__item">
                                        <p class="booking-houses__title"><?= $kalendar['title']; ?></p>
                                        <div class="booking-houses__image-wrapper">
                                            <img class="booking-houses__image" src="<?= $kalendar['picture']; ?>"
                                                 alt="<?= $kalendar['title']; ?>">
                                        </div>
                                        <div class="booking-houses__header">
                                            <p class="booking-houses__description">
                                                <?php if (!empty($kalendar['min_people'])): ?>
                                                    <span class="booking-houses__description-item"
                                                          data-info="<?= $kalendar['min_people']; ?>"><img
                                                                class="apartment__icon apartment__icon_mr-4px"
                                                                src="<?= CORE_PATH ?>assets/icons/min-01.svg"
                                                                alt="icon">x</span>
                                                <?php endif;
                                                    if (!empty($kalendar['max_people'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['max_people']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/max-01.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['double_bed'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['double_bed']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/double-king-size-bed.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['single_bed'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['single_bed']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/single-king-size-bed.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['toilet_and_shower'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['toilet_and_shower']; ?>">
                                                    <img class="apartment__icon apartment__icon_mr--4px"
                                                         src="<?= CORE_PATH ?>assets/icons/toilet.svg"
                                                         alt="icon">
                                                    <img class="apartment__icon apartment__icon_mr-4px"
                                                         src="<?= CORE_PATH ?>assets/icons/shower.svg"
                                                         alt="icon">
                                                    x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['toilet'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['toilet']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/toilet.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['bed_rooms'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['bed_rooms']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/br-01.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif;
                                                    if (!empty($kalendar['triple_bed'])):?>
                                                        <span class="booking-houses__description-item"
                                                              data-info="<?= $kalendar['triple_bed']; ?>"><img
                                                                    class="apartment__icon apartment__icon_mr-4px"
                                                                    src="<?= CORE_PATH ?>assets/icons/br-01.svg"
                                                                    alt="icon">x</span>
                                                    <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="booking-houses__calendars">
                                            <div class="booking-houses__calendars-inner">
                                                <a href="#" data-calendar='<?= $kalendar['calendar']; ?>'
                                                   class="our-house__button our-house__button--green booking-houses__calendars-button">
                                                    Показать календарь
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div data-mixed-tab="4" class="accordion-mixed__tab">
                    расположение
                </div>
                <div data-mixed-conent="4" class="accordion-mixed__content">
                    <div class="accordion-mixed__content-inner">
                        <div class="base-place b-mb-2">
                            <div class="base-place__image">
                                <img src="<?= get_post_meta(get_the_ID(), "mastak_house_map", true); ?>" alt="map"
                                     class="base-place__image-inner">
                            </div>
                            <div class="base-place__content">
                                <div class="big-text content-text">
                                    <?= wpautop(get_post_meta(get_the_ID(), "mastak_house_text_map", true)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $video = get_post_meta(get_the_ID(), "mastak_house_video", true);
                    if (!empty($video)): ?>
                        <div data-mixed-tab="5" class="accordion-mixed__tab">
                            ВИДЕО
                        </div>
                        <div data-mixed-conent="5" class="accordion-mixed__content">
                            <div class="accordion-mixed__content-inner">
                                <div class="video_wrapper">
                                    <script>
                                        setTimeout(function () {
                                            jQuery('.video_wrapper').append('<iframe src="https://www.youtube.com/embed/<?= $video; ?>" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>');
                                        }, 3000);
                                    </script>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                <?php
                    if (get_post_meta(get_the_ID(), "mastak_house_is_terem", true)): ?>
                        <div data-mixed-tab="6" class="accordion-mixed__tab">
                            Планировка
                        </div>
                        <div data-mixed-conent="6" class="accordion-mixed__content">
                            <div class="accordion-mixed__content-inner">
                                <div class="map-zooming">
                                    <?php
                                        $plan_1 = get_post_meta(get_the_ID(), "mastak_house_plan", true);
                                        if (isset($plan_1) and !empty($plan_1)):?>
                                            <div id="ex4" class="map-zoom">
                                                <img src="<?= $plan_1; ?>" alt="map"
                                                     class="map-zoom__image" data-big="<?= $plan_1; ?>">
                                                <p class="map-zoom__title">Кликни</p>
                                            </div>
                                        <?php endif;
                                        $plan_2 = get_post_meta(get_the_ID(), "mastak_house_plan_2", true);
                                        if (isset($plan_2) and !empty($plan_2)):?>
                                            <div id="ex5" class="map-zoom">
                                                <img src="<?= $plan_2; ?>" alt="map"
                                                     class="map-zoom__image" data-big="<?= $plan_2; ?>">
                                                <p class="map-zoom__title">Кликни</p>
                                            </div>
                                        <?php endif;
                                        $plan_3 = get_post_meta(get_the_ID(), "mastak_house_plan_3", true);
                                        if (isset($plan_3) and !empty($plan_3)):?>
                                            <div id="ex6" class="map-zoom">
                                                <img src="<?= $plan_3; ?>" alt="map"
                                                     class="map-zoom__image" data-big="<?= $plan_3; ?>">
                                                <p class="map-zoom__title">Кликни</p>
                                            </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                <div data-mixed-tab="7" class="accordion-mixed__tab">
                    Проживание
                </div>
                <div data-mixed-conent="7" class="accordion-mixed__content">
                    <div class="accordion-mixed__content-inner booking-houses__text">
                        <?= wpautop(get_post_meta(get_the_ID(), "mastak_house_residence", true)); ?>
                    </div>
                </div>
                <footer class="house-booking">
                    <p class="house-booking__info">
                        <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>"
                              data-byn="<?= $price_byn; ?>"><?= $price; ?></span>
                    </p>
                    <a href="/booking-form/?booking=<?= get_the_ID() ?>"
                       data-name="<?=get_the_title();?>"
                       data-id="<?=get_the_ID();?>"
                       target="_blank"
                       class="<?= $isTerem? 'is-terem-js': ''?> house-booking__button terem-button">забронировать
                    </a>
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
<?php endwhile; endif; // end of the loop.?>
<?php get_footer('mastak'); ?>