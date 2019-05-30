<?php
	/**
	 * @var Type_1 $tab
	 */

    $size = wp_is_mobile() ? 'welcome_tab_iphone_5' : 'welcome_tab_laptop';

?>
<div class="accordion-mixed__content-inner">
    <div class="house-description">
        <div class="house-description__header">
            <img class="house-description__image"
                 src="<?= wp_get_attachment_image_url( $tab->getImageId(), $size ); ?>"
                 srcset="<?= wp_get_attachment_image_srcset(  $tab->getImageId(), $size ); ?>"
                 sizes="<?= wp_get_attachment_image_sizes(  $tab->getImageId(), $size ); ?>">
<!--            <img src="--><?//= $tab->getImage(); ?><!--" class="house-description__image" alt="image">-->
            <p class="house-description__title"><?= $tab->getTitle(); ?></p>
            <div class="house-description__text big-text content-text">
				<?= wpautop( $tab->getDescription() ); ?>
            </div>
        </div>
        <div class="house-description__apartments house-description__apartments_default events-added-items">
			<?php
				if ( $tab->getLists() ):
					foreach ( $tab->getLists() as $list ):?>
                        <div class="house-description__item">
                            <div class="apartment">
                                <div class="apartment__header">
                                    <img class="apartment__icon"
                                         src="<?= $list['item_icon']; ?>"
                                         alt="icon">
                                    <p class="apartment__title"><?= $list['item_title']; ?></p>
                                </div>
                                <ul class="apartment__items">
									<?php foreach ( $list['item_text'] as $item ): ?>
                                        <li class="apartment__item"><?= $item ?></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
					<?php
					endforeach;
				endif;
			?>
        </div>
    </div>
</div>