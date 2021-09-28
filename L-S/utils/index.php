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

function get_webpay_sandbox(){
    $bookingSettings = get_option('mastak_booking_appearance_options');
    $isSandBoxEnabled =  $bookingSettings['is_sand_box_enabled'] == 'on';

    $org = [
        'url'=>'https://payment.webpay.by',
        'wsb_storeid' => '320460709',
        'wsb_test' => '0',
    ];
    if($isSandBoxEnabled and is_user_logged_in()){
        $org['url'] = 'https://securesandbox.webpay.by';
        $org['wsb_storeid'] = '515854557';
        $org['wsb_test'] = '1';
    }
    return $org;
}