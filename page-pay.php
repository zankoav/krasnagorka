<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    $source = $_GET['source'];
    if(empty( $source)){
        exit;
    }

    $args = array(
        'meta_key'   => 'sbc_order_prepaid_source',
        'meta_value' => $source
    );
    $query = new WP_Query( $args );
    var_dump($query);

?>