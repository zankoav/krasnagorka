<?php


    if (!defined('ABSPATH')) {
        exit;
    }

    require __DIR__ . '/backend/Assets.php';
    require __DIR__ . '/backend/Model.php';

    $assets = new Assets();
    $model  = new Model();

    add_action( 'admin_enqueue_scripts', 'load_admin_style' );
    function load_admin_style() {
        wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
    }


    // for delete

    if (!isset($content_width)) {
            $content_width = 1200; /* pixels */
        }
        require __DIR__ . '/inc/calendar/init.php';
        require __DIR__ . '/mastak/init.php';

    //    add_filter('wpseo_schema_graph_pieces', function ($pieces, $context) {
    //
    //        if (get_the_ID() == 10188) {
    //            var_dump($pieces[0]);
    //            $pieces[0]['aggregateRating'] = [
    //                '@type'       => 'AggregateRating',
    //                'ratingValue' => 4.5,
    //                'ratingCount' => 120
    //            ];
    //            unset($pieces[0]);
    //            unset($pieces[2]);
    //            unset($pieces[3]);
    //            unset($pieces[4]);
    //            unset($pieces[5]);
    //        }
    //
    //        return $pieces;
    //    }, 20, 2);