<?php

	$border_color   = get_post_meta( get_the_ID(), "mastak_opportunity_frame_color", true );
	$isAdded        = "added" == get_post_meta( get_the_ID(), "mastak_opportunity_added_opportunity", true );
	$price_byn      = (int) get_post_meta( get_the_ID(), "mastak_opportunity_price", true );
	$price          = get_current_price( $price_byn );
	$price_subtitle = get_post_meta( get_the_ID(), "mastak_opportunity_price_subtitle", true );
	global $kgCooke;
	$currency_name = $kgCooke->getCurrnecy()["currency_selected"];

    $targetOpen = get_post_meta(get_the_ID(), "new_page", true) ? '_blank' : '_self';
    $size = wp_is_mobile() ? 'opportunity_small_iphone_5' : 'opportunity_small_laptop';
    $icon_id         = get_post_thumbnail_id();

?>

<a href="<?= get_permalink(); ?>"
   class="swiper-slide opportunity opportunity--b-lime"
   target="<?= $targetOpen; ?>"
   style="border-left-color:<?= $border_color; ?>; border-bottom-color:<?= $border_color; ?>">
    <div class="opportunity__text">
        <p class="opportunity__title"><?= get_the_title(); ?></p>
        <p class="opportunity__description"><?= get_post_meta( get_the_ID(), "mastak_opportunity_description", true ); ?></p>
		<?php if ( $isAdded and  $price > 0): ?>
            <p class="house-booking__info house-booking__info_opportunity house-booking__info_small">
                <span class="opportunity__price-title opportunity__price-title_small">Стоимость: </span>
                <span class="house-booking__price-per-men opportunity__price opportunity__price_small  js-currency"
                      data-currency="<?= $currency_name; ?>" data-byn="<?= $price_byn; ?>"><?= $price; ?></span>
				<?php if ( isset( $price_subtitle ) and ! empty( $price_subtitle ) ): ?>
                    <span class="opportunity__price-subtitle  opportunity__price-subtitle_small"> <?= $price_subtitle; ?></span>
				<?php endif; ?>
            </p>
		<?php endif; ?>
    </div>
    <div class="opportunity__image-wrapper opportunity__image-wrapper_small">
        <img class="object-fit-img"
             src="<?= wp_get_attachment_image_url( $icon_id, $size ); ?>"
             srcset="<?= wp_get_attachment_image_srcset(  $icon_id, $size ); ?>"
             sizes="<?= wp_get_attachment_image_sizes(  $icon_id, $size ); ?>">

    </div>
</a>