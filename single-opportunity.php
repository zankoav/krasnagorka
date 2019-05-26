<?php

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');

?>

<?php if (have_posts()) :
    while (have_posts()) : the_post();
        $price_byn      = (int)get_post_meta(get_the_ID(), "mastak_opportunity_price", true);
        $price          = get_current_price($price_byn);
        $price_subtitle = get_post_meta(get_the_ID(), "mastak_opportunity_price_subtitle", true);
        $subtitle       = get_post_meta(get_the_ID(), "mastak_opportunity_subtitle", true);
        global $kgCooke;
        $currency_name = $kgCooke->getCurrnecy()["currency_selected"];

        get_template_part("mastak/views/header", "small-view"); ?>

        <div class="b-bgc-wrapper">
            <section class="b-container header-title">
                <h2 class="header-title__subtitle"><?= $subtitle; ?></h2>
            </section>
            <div class="b-container b-p-sm-0">
                <div class="accordion-mixed">
                    <div data-mixed-tab="1" class="accordion-mixed__tab accordion-mixed__tab--active">
                        ОПИСАНИЕ
                    </div>
                    <div data-mixed-conent="1" class="accordion-mixed__content accordion-mixed__content--active">
                        <div class="accordion-mixed__content-inner">
                            <div class="house-description">
                                <div class="house-description__header">
                                    <?php
                                        the_post_thumbnail("full", array('class' => "house-description__image"));
                                        the_title('<p class="house-description__title">', '</p>');
                                    ?>
                                    <div class="house-description__text big-text content-text">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $gellaryItems = get_post_meta(get_the_ID(), 'mastak_opportunity_gallery', 1);
                        if (!empty($gellaryItems)): ?>
                            <div data-mixed-tab="2" class="accordion-mixed__tab">
                                ФОТОГАЛЕРЕЯ
                            </div>
                            <div data-mixed-conent="2" class="accordion-mixed__content">
                                <div class="swiper-container accordion-mixed__content-inner house-media-library__container">
                                    <div class="swiper-wrapper house-media-library">
                                        <?php get_model_gallary('medium', "mastak_opportunity_gallery"); ?>
                                    </div>
                                    <div class="house-media-library__container">
                                        <div class="b-container house-media-library__container-wrapper">
                                            <div class="swiper-button-next house-media-library__button-next"></div>
                                            <div class="swiper-button-prev house-media-library__button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <div data-mixed-tab="4" class="accordion-mixed__tab">
                        расположение
                    </div>
                    <div data-mixed-conent="4" class="accordion-mixed__content">
                        <div class="accordion-mixed__content-inner">
                            <div id="ex3" class="map-zoom">
                                <?php $map = get_post_meta(get_the_ID(), "mastak_opportunity_map", true); ?>
                                <img src="<?= $map; ?>"
                                     alt="map"
                                     class="map-zoom__image"
                                     data-big="<?= $map; ?>">
                                <p class="map-zoom__title">Кликни</p>
                            </div>
                        </div>
                    </div>
                    <?php
                        $video = get_post_meta(get_the_ID(), "mastak_opportunity_video", true);
                        if (!empty($video)): ?>
                            <div data-mixed-tab="5" class="accordion-mixed__tab">
                                ВИДЕО
                            </div>
                            <div data-mixed-conent="5" class="accordion-mixed__content">
                                <div class="accordion-mixed__content-inner">
                                    <div class="video_wrapper">
                                        <iframe src="https://www.youtube.com/embed/<?= $video; ?>"
                                                frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        <? endif; ?>
                    <div data-mixed-tab="6" class="accordion-mixed__tab">
                        Правила пользования
                    </div>
                    <div data-mixed-conent="6" class="accordion-mixed__content">
                        <div class="accordion-mixed__content-inner booking-houses__text">
                            <?= get_post_meta(get_the_ID(), "mastak_opportunity_residence", true); ?>
                        </div>
                    </div>
                    <?php if ($price != 0): ?>
                        <footer class="house-booking">
                            <p class="house-booking__info house-booking__info_opportunity">
                                <span class="opportunity__price-title">Стоимость услуги: </span>
                                <span class="house-booking__price-per-men opportunity__price js-currency"
                                      data-currency="<?= $currency_name; ?>"
                                      data-byn="<?= $price_byn; ?>"><?= $price; ?></span>

                                <?php if (isset($price_subtitle) and !empty($price_subtitle)): ?>
                                    <span class="opportunity__price-subtitle"> <?= $price_subtitle; ?></span>
                                <?php endif; ?>
                            </p>
                        </footer>
                    <?php endif; ?>
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

    <?php endwhile; endif; // end of the loop. ?>

<?php get_footer('mastak'); ?>