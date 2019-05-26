<?php
	/**
	 * @var Type_5 $tab
	 */
?>
<div class="accordion-mixed__content-inner accordion-mixed__content-inner_type_5">
    <div class="swiper-container event-container event-container-swiper-<?=$tab->getId();?>">
        <div class="swiper-wrapper main-slider__wrapper">
			<?php foreach ( $tab->getEvents() as $event ): ?>
                <div class="swiper-slide event-tab">
                    <div class="event-tab__slide-img-wrapper">
                        <img class="event-tab__slide-img" src="<?= $event["image"] ?>" alt="slide">
                    </div>
                    <div class="main-slider__slide-content">
                        <p class="main-slider__slide-content-title"><?= $event["title"] ?></p>
                        <p class="main-slider__slide-content-sub-title"><?= $event["description"] ?></p>
                        <a href="<?= $event["url"]; ?>"
                           class="main-slider__slide-content-button "><?= $event["button_title"]; ?></a>
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

</div>
