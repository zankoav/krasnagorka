<?php
    if (!defined('ABSPATH')) {
        exit;
    }
    if (!isset($content_width)) {
        $content_width = 1200; /* pixels */
    }
    require __DIR__ . '/inc/calendar/init.php';
    require __DIR__ . '/mastak/init.php';

    add_filter( 'disable_wpseo_json_ld_search', '__return_true' );
