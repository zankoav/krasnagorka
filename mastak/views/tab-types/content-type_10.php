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
     * @var Type_10 $tab
     */

    global $currency_name;
    $teremItemsIds = array(18,19,20,21,22,23,24,25,26,27,28,29);

    $items = $tab->getItems();
    $interval = $tab->getInterval();
    $from =  $interval[0];
    $to =  $interval[1];

?>
<div class="accordion-mixed__content-inner">
    <?php 

    echo $from ;
    echo $to ;
    


    foreach ($items as $item) :

        // $from = $item['from'];

        // if(date("Ymd", strtotime($from)) <  date("Ymd")){
        //     continue;
        // }

        // $to = $item['to'];
        // $calendarId = $item['calendar'];

        // $orderStatus = getOrderStatus($calendarId, $from, $to);
        // if($orderStatus == 'prepaid' || $orderStatus == 'booked'){
        //     continue;
        // }


        // $house_title = get_the_title($item['house']);
        // $house_link = get_the_permalink($item['house']);
        // $house_img = $item['image'];
        // if(empty($house_img)){
        //     $house_img = get_the_post_thumbnail_url($item['house'], 'houses_last_iphone_5');
        // }

        // /**
        //  * First Step
        //  */
        // $new_price = $item['new_price'];
        // $old_price = $item['old_price'];

        // /**
        //  * Second Step
        //  */
        // $sale;

        // $season_id = $item['current_season'];
        // if (empty($season_id)) {
        //     $season_id = get_option('mastak_theme_options')['current_season'];
        // }
        // $price_byn      = (int)get_post_meta($season_id, "house_price_" . $item['house'], true);
        // $price_byn_sale = null;
        // $price_sale     = null;

        // if (!empty($new_price) and !empty($old_price) and $old_price != 0) {

        //     $sale           = (int)(100 - $new_price * 100 / $old_price);
        //     $price_byn_sale = $old_price;
        //     $price_sale     = get_current_price($price_byn_sale);
        //     $price_byn      = (int)$new_price;

        // } else if (!empty($new_price)) {

        //     if ($price_byn != 0) {
        //         $sale           = (int)(100 - $new_price * 100 / $price_byn);
        //         $price_byn_sale = $price_byn;
        //         $price_sale     = get_current_price($price_byn_sale);
        //     }

        //     $price_byn = (int)$new_price;

        // }

        // $price = get_current_price($price_byn);

        ?>
        <div class="table-tab-row">
            gg
        </div>
    <?php endforeach; ?>
</div>

