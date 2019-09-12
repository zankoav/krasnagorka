<?php
    if (!defined('ABSPATH')) {
        exit;
    }
    if (!isset($content_width)) {
        $content_width = 1200; /* pixels */
    }
    require __DIR__ . '/inc/calendar/init.php';
    require __DIR__ . '/mastak/init.php';

    function bybe_remove_yoast_json($data){
//        $data = array();
        var_dump($data);
        return $data;
    }
    add_filter('wpseo_json_ld_output', 'bybe_remove_yoast_json', 10, 1);
