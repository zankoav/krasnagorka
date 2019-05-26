<?php
	/**
	 * @var Type_2 $tab
	 */
?>

<div class="swiper-container accordion-mixed__content-inner house-media-library__container event-media-library__container event-media-library__container-<?=$tab->tab_id;?>">
    <div class="swiper-wrapper house-media-library">
		<?php $tab->viewGallary(); ?>
    </div>
    <div class="house-media-library__container">
        <div class="b-container house-media-library__container-wrapper">
            <div class="swiper-button-next house-media-library__button-next"></div>
            <div class="swiper-button-prev house-media-library__button-prev"></div>
        </div>
    </div>
</div>