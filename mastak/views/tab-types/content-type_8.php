<style>
    .tab-house__from-top{
        text-align: center;
        margin-bottom: 1rem;
    }

    .tab-house__button-wrapper{
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .tab-house__reserved{
        text-align: center;
        font-weight: bold;
    }

    .table-tab-house__img{
        border-radius: 6px;
    }

    @media (min-width: 768px){
        div.table-tab-col .house-booking__info_event{
            align-items: flex-end;
            text-align: right;
        }

        .table-tab-price{
            align-self: flex-start;
        }
    }
</style>

<?php
    /**
     * @var Type_8 $tab
     */

    global $currency_name;
    $teremItemsIds = array(18,19,20,21,22,23,24,25,26,27,28,29);
?>
<div class="accordion-mixed__content-inner">
    <?php 
    $items = $tab->getItems();

    function sort_nested_arrays( $array, $args = array('from' => 'asc', 'to' => 'asc', 'new_price'=>'asc') ){
        usort( $array, function( $a, $b ) use ( $args ){
            $res = 0;
    
            $a = (object) $a;
            $b = (object) $b;
    
            foreach( $args as $k => $v ){
                if( $a->$k == $b->$k ) continue;
    
                $res = ( $a->$k < $b->$k ) ? -1 : 1;
                if( $v=='desc' ) $res= -$res;
                break;
            }
    
            return $res;
        } );
    
        return $array;
    }
    
    $items = sort_nested_arrays($items);

    foreach ($items as $item) :

        $from = $item['from'];

        if(date("Ymd", strtotime($from)) <  date("Ymd")){
            continue;
        }

        $to = $item['to'];
        $calendarId = $item['calendar'];

        $orderStatus = getOrderStatus($calendarId, $from, $to);
        if($orderStatus == 'prepaid' || $orderStatus == 'booked'){
            continue;
        }


        $house_title = get_the_title($item['house']);
        $house_link = get_the_permalink($item['house']);
        $house_img = $item['image'];
        if(empty($house_img)){
            $house_img = get_the_post_thumbnail_url($item['house'], 'houses_last_iphone_5');
        }

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

        $season_id = $item['current_season'];
        if (empty($season_id)) {
            $season_id = get_option('mastak_theme_options')['current_season'];
        }
        $price_byn      = (int)get_post_meta($season_id, "house_price_" . $item['house'], true);
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
                <a href="<?= $house_link ?>" class="table-tab-house">
                    <img src="<?= $house_img; ?>" alt="<?= $house_title ?>" class="table-tab-house__img">
                    <p class="table-tab-house__link"><?= $house_title; ?></p>
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
                <div class="tab-house__from-top">c <?=date("d.m", strtotime($from))?> по <?=date("d.m", strtotime($to))?></div>
                <?php 
                    $term = get_term( $calendarId, 'sbc_calendars' );
                    $teremName = in_array($calendarId, $teremItemsIds) ? "&terem=$term->name": ''; 
                if( $orderStatus === false):?>
                    <div class="tab-house__button-wrapper">
                        <a href="/booking-form/?eventTabId=<?=$tab->getId();?>&booking=<?= $item['house']; ?>&calendarId=<?= $calendarId; ?>&from=<?= date("Y-m-d", strtotime($from))?>&to=<?=date("Y-m-d", strtotime($to))?><?= $teremName;?>" 
                            class="our-house__button" 
                            target="_blank">
                            забронировать
                        </a>
                    </div>
                <?php else:?>
                    <div class="tab-house__reserved">Зарезервировано</div>
                <?php endif;?>
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

