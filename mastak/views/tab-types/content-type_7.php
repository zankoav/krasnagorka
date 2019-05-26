<?php
	/**
	 * @var Type_7 $tab
	 */
?>
<div class="accordion-mixed__content-inner">
    <div class="item-tab-row">
		<?php
			foreach ( $tab->getItems() as $item ) :?>
                <div class="item-tab-col">
                    <div class="item-block">
                        <header class="item-block__header">
                            <img src="<?= $item['image'] ?>" alt="icon" class="item-block__image">
                            <p class="item-block__title"><?= $item['title']; ?></p>
                        </header>
                        <div class="item-block__text">
							<?= wpautop( $item['description'] ); ?>
                        </div>
                    </div>
                </div>
			<?php endforeach; ?>
    </div>
</div>
