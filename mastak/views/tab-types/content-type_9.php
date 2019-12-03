<?php
    /**
     * @var Type_8 $tab
     */

    global $currency_name;

?>
<div class="accordion-mixed__content-inner">
    <?php foreach ($tab->getItems() as $item) :
        $event_title = get_the_title($item['event']);
        $event_link = get_the_permalink($item['event']);
        $event_img = get_the_post_thumbnail_url($item['event'], 'full');


        /**
         * First Step
         */
        $new_price = $item['new_price'];
        $old_price = $item['old_price'];
        $one_price = $item['one_price'];

        /**
         * Second Step
         */
        $sale = absint($item['sale']);

        $price_byn      = (int)get_post_meta($item['event'], "mastak_event_price", true);
        $price_byn_sale = null;
        $price_sale     = null;

        if (!empty($one_price)) {
            $sale      = null;
            $price_byn = (int)$one_price;

        } else if (!empty($new_price) and !empty($old_price) and $old_price != 0) {

            $sale           = (int)(100 - $new_price * 100 / $old_price);
            $price_byn_sale = $old_price;
            $price_sale     = get_current_price($price_byn_sale);
            $price_byn      = (int)$new_price;

        } else if (!empty($new_price)) {

            if ($price_byn != 0) {
                $sale           = (int)(100 - $new_price * 100 / $price_byn);
                $price_byn_sale = $price_byn;
                $price_sale     = get_current_price($price_byn_sale);
            }

            $price_byn = (int)$new_price;

        } else if (!empty($sale)) {
            $price_byn_sale = $price_byn;
            $price_sale     = get_current_price($price_byn_sale);
            $price_byn      = (int)($price_byn * (100 - $sale) / 100);
        }

        $price = get_current_price($price_byn);

        ?>
        <div class="table-tab-row">
            <div class="table-tab-col">
                <a href="<?= $event_link ?>" class="table-tab-house">
                    <img src="<?= $event_img; ?>" alt="<?= $event_title ?>" class="table-tab-house__img">
                    <p class="table-tab-house__link"><?= $event_title; ?></p>
                    <?php if (isset($sale) and !empty($sale)): ?>
                        <div class="opportunity__flag flag flag--b-red flag--b " style="--bg-color:#d0021b;">
                            <div class="flag__inner"><?= "-$sale%"; ?></div>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <div class="table-tab-col">
                <div class="table-tab-text big-text content-text">
                    <?= wpautop($item['description']); ?>
                </div>
            </div>
            <div class="table-tab-col">
                <div class="table-tab-price">
                    <p class="house-booking__info house-booking__info_event">
                        <span class="house-booking__price-per-men js-currency"
                              data-currency="<?= $currency_name; ?>"
                              data-byn="<?= $price_byn; ?>">
                            <?= $price; ?>
                        </span>
                        <?php if (!empty($price_byn_sale)): ?>
                            <span class="house-booking__price-per-men house-booking__price-per-men_sale js-currency"
                                  data-currency="<?= $currency_name; ?>"
                                  data-byn="<?= $price_byn_sale; ?>">
                            <?= $price_sale; ?>
                        </span>
                        <?php endif; ?>
                        <span class="opportunity__price-subtitle opportunity__price-subtitle_event opportunity__price-subtitle_sale">
						<?= $item['sale_text']; ?></span>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
