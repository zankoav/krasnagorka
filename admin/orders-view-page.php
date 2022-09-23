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
        ),
        'orderby'  => [ 'sbc_order_start'=>'ASC' ]
    ));

    $result = [];

    $number = 1;

    $statuses = [
        'booked' => 'Оплачен',
        'prepaid' => 'Предоплачен'
    ];

    foreach($orders as $order){

        $orderId = $order->ID;
        $start = get_post_meta($orderId, 'sbc_order_start', true);
        $start = date("d.m.Y", strtotime($start));
        $end = get_post_meta($orderId, 'sbc_order_end', true);
        $end = date("d.m.Y", strtotime($start));
        $status = get_post_meta($orderId, 'sbc_order_select', true);
        $comment = get_post_meta($orderId, 'sbc_order_desc', true);
        $calendars  = get_the_terms($orderId, 'sbc_calendars');

        $calendarsNames = [];

        
        foreach($calendars as $calendar){
            $calendarsNames[] = $calendar->name;
        }

        $result[] = [
            '#'         => $number,
            'calendars' => implode(", ", $calendarsNames),
            'start'     => $start,
            'end'       => $end,
            'comment'   => $comment,
            'status'    => $statuses[$status]
        ];

        $number ++;
    }

?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <p>Даты: <b><?= date("d.m.Y", strtotime($dateStart))?></b> - <b><?= date("d.m.Y", strtotime($dateEnd))?></b></p>
    <p>Количество заказов: <b><?= count($orders);?></b></p>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Дома</th>
                <th scope="col">Дата заезда</th>
                <th scope="col">Дата выезда</th>
                <th scope="col">Комментарий</th>
                <th scope="col">Статус заказа</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($result as $res): ?>
                    <tr>
                        <th scope="row"><?=$res['#']?></th>
                        <td><?=$res['calendars']?></td>
                        <td><?=$res['start']?></td>
                        <td><?=$res['end']?></td>
                        <td><?=$res['comment']?></td>
                        <td><?=$res['status']?></td>
                    </tr>
                <?php endforeach;?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
