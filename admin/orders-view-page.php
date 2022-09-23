<?php 
    
    $dateStart = date("Y-m-d");
    $dateEnd = date("Y-m-d", strtotime('+10 days', strtotime($dateStart)));
    $ordersQuery = new WP_Query;
    $orders = $ordersQuery->query(array(
        'post_type' => 'sbc_orders',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'sbc_order_start',
                'value'   => $dateStart,
                'compare' => '>=',
            ),
            array(
                'key'     => 'sbc_order_start',
                'value'   => $dateEnd,
                'compare' => '<='
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'sbc_order_select',
                    'value' => 'prepaid',
                    'compare' => '='
                ),
                array(
                    'key' => 'sbc_order_select',
                    'value' => 'booked',
                    'compare' => '='
                )
            )
        )
    ));

?>

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?> </h1>
    <p>Даты: <b><?= date("d.m.Y", strtotime($dateStart))?></b> - <b><?= date("d.m.Y", strtotime($dateEnd))?></b></p>
    <p>Количество заказов: <b><?= count($orders);?></b></p>
</div>