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

    $org = $prod;

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