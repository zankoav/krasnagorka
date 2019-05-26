<?php
    $special_events    = get_option('mastak_event_appearance_options')['special_events'];
    $main_slider_delay = get_option('mastak_event_appearance_options')['main_slider_delay'];

?>
<section class="seson-slider">
    <div class="swiper-container main-slider">
        <div class="swiper-wrapper main-slider__wrapper">
            <?php foreach ($special_events as $event): ?>
                <div class="swiper-slide main-slider__slide" data-swiper-autoplay="<?= $main_slider_delay; ?>">
                    <div class="main-slider__slide-content" style="background-image: url(<?= $event["item_banner"] ?>)">
                        <p class="main-slider__slide-content-title"><?= $event["item_name"] ?></p>
                        <p class="main-slider__slide-content-sub-title"><?= $event["item_subtitle"] ?></p>
                        <a href="<?= $event["button_url"]; ?>"
                           class="main-slider__slide-content-button" target="<?= $event["button_open_type"] ? '_blank' : '_self';?>"><?= $event["button_text"]; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add Arrows -->
        <div class="main-slider__next-prev">
            <div class="b-container main-slider__next-prev-wrapper">
                <div class="swiper-button-next main-slider__button-next"></div>
                <div class="swiper-button-prev main-slider__button-prev"></div>
            </div>
        </div>
        <div class="swiper-pagination main-slider__pagination"></div>

    </div>
</section>