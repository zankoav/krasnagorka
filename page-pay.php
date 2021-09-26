<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    $source = $_GET['source'];
    $ID;
    $formData;

    if(empty( $source)){
        exit;
    }

    $args = array(
        'post_type'  => 'sbc_orders',
        'meta_query' => array(
            array(
                'key'     => 'sbc_order_prepaid_source',
                'value'   =>  $source,
                'compare' => '=',
            ),
        ),
    );

    $query = new WP_Query( $args );
    while ( $query->have_posts() ) {
        $query->the_post();
        $ID = get_the_ID();
        var_dump('OK', $ID);
        break;
    }

    if(isset($ID)){
        $formData = get_post_meta($ID, 'sbc_order_prepaid_value', 1);
    }

    if(empty($formData)){
        exit;
    }

?>

<script>
    const params = <?=$formData?>;
    console.log('params', params);
</script>