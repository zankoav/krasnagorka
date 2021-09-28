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

    $orgUrl = 'https://payment.webpay.by';
    if($isSandBoxEnabled and is_user_logged_in()){
        $orgUrl = 'https://securesandbox.webpay.by';
    }
    return $orgUrl;
}