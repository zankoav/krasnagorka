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