<?php

if (!defined('ABSPATH')) { exit; }

function show_seasons_options() {

    $query = new WP_Query(array(
        'post_type'      => 'season',
        'posts_per_page' => -1
    ));

    $seasons = [];
    $posts   = $query->get_posts();
    foreach ($posts as $post) {
        $seasons[$post->ID] = $post->post_title;
    }

    return $seasons;
}

function get_webpay_sandbox($orgType = null){
    $bookingSettings = get_option('mastak_booking_appearance_options');
    $isSandBoxEnabled =  $bookingSettings['is_sand_box_enabled'] == 'on';

    $prod = [
        'url'=>'https://payment.webpay.by',
        'wsb_storeid' => '320460709',
        'wsb_test' => '0',
    ];
    $sandbox = [
        'url'=>'https://securesandbox.webpay.by',
        'wsb_storeid' => '515854557',
        'wsb_test' => '1',
    ];

    $org = $prod;
    
    if($orgType === '0'){
        $org = $prod;
    }else if($orgType === '1'){
        $org = $sandbox;
    }else if($isSandBoxEnabled and is_user_logged_in()){
        $org = $sandbox;
    }

    return $org;
}

function get_order_data($orderId){
    $created = get_the_date("d.m.Y", $orderId);
    $start = get_post_meta($orderId, 'sbc_order_start', 1);
    $end = get_post_meta($orderId, 'sbc_order_end', 1);
    $price = get_post_meta($orderId, 'sbc_order_price', 1);
    $eventTabId = get_post_meta($orderId, 'sbc_order_is_event', 1);
    $leadId = get_post_meta($orderId, 'sbc_lead_id', 1);
    $calendars  = get_the_terms($orderId, 'sbc_calendars');
    $client = get_post_meta($orderId, 'sbc_order_client', 1);
    $pieces = explode(" ", $client);
    $clientId = $pieces[0];
    $phone = get_post_meta($clientId, 'sbc_client_phone', 1);
    $fio = get_the_title($clientId);
    $fio = explode("+", $fio);

    $passport = get_post_meta($orderId, 'sbc_order_passport', 1);
    $peopleCount = get_post_meta($orderId, 'sbc_order_count_people', 1);
    $babyBed = get_post_meta($orderId, 'sbc_order_baby_bed', 1);

    $bathHouseWhite = get_post_meta($orderId, 'sbc_order_bath_house_white', 1);
    $bathHouseBlack = get_post_meta($orderId, 'sbc_order_bath_house_black', 1);

    $smallAnimalsCount = get_post_meta($orderId, 'sbc_order_small_animlas_count', 1) ?? 0;
    $bigAnimalsCount = get_post_meta($orderId, 'sbc_order_big_animlas_count', 1) ?? 0;
    
    $foodBreakfast = get_post_meta($orderId, 'sbc_order_food_breakfast', 1) ?? 0;
    $foodLunch = get_post_meta($orderId, 'sbc_order_food_lunch', 1) ?? 0;
    $foodDinner = get_post_meta($orderId, 'sbc_order_food_dinner', 1) ?? 0;

    $calendarSlug = $calendars[0]->slug;
    $calendarId = $calendars[0]->term_id;
    $calendarShortCode = '[sbc_calendar id="' . $calendarId . '" slug="' . $calendarSlug . '"]';
    $houseLink = getHouseLinkByShortCode($calendarShortCode);
    $paymentMethod = get_post_meta($orderId, 'sbc_order_payment_method', 1);
    $prepaidPercantage = (int) get_post_meta($orderId, 'sbc_order_prepaid_percantage', 1);
    $prepaidPercantage = $prepaidPercantage == 0 ? 100 : $prepaidPercantage;
    $paymentMethod = empty($paymentMethod) ? 'card' : $paymentMethod;
    $email = getEmailFromOrder($orderId);
    $subprice = 0;

    if(!empty($paymentMethod) and !empty($prepaidPercantage)){
        $subprice = intval($price * $prepaidPercantage / 100);
    }
        
    return [
        'orderId' => $orderId,
        'created' => $created,
        'babyBed' => $babyBed == 'on',
        'eventTabId' => $eventTabId == 'on',
        'bathHouseWhite' => $bathHouseWhite,
        'bathHouseBlack' => $bathHouseBlack,
        'smallAnimalsCount' => $smallAnimalsCount,
        'bigAnimalsCount' => $bigAnimalsCount,
        'foodBreakfast' => intval($foodBreakfast),
        'foodLunch' => intval($foodLunch),
        'foodDinner' => intval($foodDinner),
        'from' => date("d.m.Y", strtotime($start)),
        'to' => date("d.m.Y", strtotime($end)),
        'price' => $price,
        'subprice' => $subprice,
        'passport' => $passport ?? '-',
        'fio' => $fio[0],
        'leadId' => $leadId,
        'peopleCount' => $peopleCount,
        'phone' => $phone,
        'email' => $email,
        'paymentMethod' => $paymentMethod,
        'prepaidType' => $prepaidPercantage,
        'calendarName' => $calendars[0]->name,
        'calendarLink' => $houseLink
    ];
}