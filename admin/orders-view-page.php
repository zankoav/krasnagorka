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
            )
        ),
        'orderby'  => [ 'sbc_order_start'=>'ASC' ]
    ));

    $result = [];

    $number = 1;

    $statuses = [
        'booked' => [
            'title' => 'Оплачен',
            'background' => '#e91e6320'
        ],
        'prepaid' => [
            'title' => 'Предоплачен',
            'background' => '#ffc10720'
        ],
        'reserved' => [
            'title' => 'Зарезервирован',
            'background' => '#65b2ed20'
        ]
    ];

    function get_food_by_order_id($orderId){
        $result = [];
        $breakfast = get_post_meta($orderId, 'sbc_order_food_breakfast', true);
        $lunch = get_post_meta($orderId, 'sbc_order_food_lunch', true);
        $dinner = get_post_meta($orderId, 'sbc_order_food_dinner', true);
        if(!empty($breakfast)){
            $result[] = "Завтраки: $breakfast";
        }
        if(!empty($lunch)){
            $result[] = "Обеды: $lunch";
        }
        if(!empty($dinner)){
            $result[] = "Ужины: $dinner";
        }
        return implode("<br>",  $result);
    }

    function get_additional_services_by_order_id($orderId){
        $result = [];
        
        $houseWhite = get_post_meta($orderId, 'sbc_order_bath_house_white', true);
        $houseBlack = get_post_meta($orderId, 'sbc_order_bath_house_black', true);
        $smallAnimlas = get_post_meta($orderId, 'sbc_order_small_animlas_count', true);
        $bigAnimlas = get_post_meta($orderId, 'sbc_order_big_animlas_count', true);
        $babyBed = get_post_meta($orderId, 'sbc_order_baby_bed', true);

        if(!empty($houseWhite)){
            $result[] = "Бани по белому: $breakfast";
        }
        if(!empty($houseBlack)){
            $result[] = "Бани по черному: $houseBlack";
        }
        if(!empty($smallAnimlas)){
            $result[] = "Мелкие животные: $smallAnimlas";
        }
        if(!empty($bigAnimlas)){
            $result[] = "Крупные животные: $bigAnimlas";
        }
        if($babyBed === 'on'){
            $result[] = "Детская кроватка";
        }
        return implode("<br>",  $result);
    }

    foreach($orders as $order){

        $orderId = $order->ID;
        $start = get_post_meta($orderId, 'sbc_order_start', true);
        $start = date("d.m.Y", strtotime($start));
        $end = get_post_meta($orderId, 'sbc_order_end', true);
        $end = date("d.m.Y", strtotime($end));
        $status = get_post_meta($orderId, 'sbc_order_select', true);
        $comment = get_post_meta($orderId, 'sbc_order_desc', true);
        $contactId = get_post_meta($orderId, 'sbc_order_client', true);
        $contact = get_the_title($contactId);
        $prepaid = get_post_meta($orderId, 'sbc_order_prepaid', true);
        $food = get_post_meta($orderId, 'sbc_order_food_price', true);
        $total_price = get_post_meta($orderId, 'sbc_order_price', true);
        $people = get_post_meta($orderId, 'sbc_order_count_people', true);
        $calendars  = get_the_terms($orderId, 'sbc_calendars');

        $foodInfo = get_food_by_order_id($orderId);
        $additionalServices = get_additional_services_by_order_id($orderId);

        $calendarsNames = [];

        foreach($calendars as $calendar){
            $calendarsNames[] = $calendar->name;
        }

        $result[] = [
            '#'         => $number,
            'calendars' => implode(", ", $calendarsNames),
            'start'     => $start,
            'end'       => $end,
            'people'   => $people,
            'comment'   => $comment,
            'contact'   => $contact,
            'food'   => empty($food) ? 0 : $food,
            'prepaid'   => empty($prepaid) ? 0 : $prepaid,
            'total_price'   => $total_price,
            'status'    => $statuses[$status]['title'],
            'background'    => $statuses[$status]['background'],
            'foodInfo'    => $foodInfo,
            'additionalServices'    => $additionalServices
        ];

        $number ++;
    }


    $today = date("d.m.Y", strtotime($dateStart));
    $tomorrow = date("d.m.Y", strtotime('+1 day', strtotime($today)));

?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<script>
    const orders = <?= json_encode($result)?>
</script>

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <div class="mt-4 d-flex">
        <div class="flex-grow-1">
            <p class="my-0">Даты: <b><?= date("d.m.Y", strtotime($dateStart))?></b> - <b><?= date("d.m.Y", strtotime($dateEnd))?></b></p>
            <p class="my-0 mb-4">Количество заказов: <b><?= count($orders);?></b></p>
        </div>
        <div class="container-filter">
            <style>
                .filter-button{
                    height: 30px;
                }
                .filter-row.row{
                    border-bottom: 0;
                    flex-wrap: initial;
                    width: initial;
                    padding-bottom: initial;
                    float: initial;
                }

            </style>
            <form class="filter-row row g-3 row-cols-auto needs-validation" novalidate>
                <div class="col">
                    <input type="date" placeholder="С" class="form-control form-control-sm" id="from" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col">
                    <input type="date" placeholder="По" class="form-control form-control-sm" id="to" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary btn-sm filter-button">Найти</button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-secondary btn-sm filter-button filter-button__default">По умолчанию</button>
                </div>
            </form>
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (() => {
                    'use strict'

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    const form = document.querySelector('.needs-validation');
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            console.log('find!!!');
                        }
                        event.preventDefault()
                        event.stopPropagation()
                        form.classList.add('was-validated')
                    }, false)

                    document.querySelector('.filter-button__default').addEventListener('click', event => {
                        console.log('reset!!!');
                        form.reset();
                    })
                })()
            </script>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="font-size: 14px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Дома</th>
                    <th scope="col">Заезд</th>
                    <th scope="col">Выезд</th>
                    <th scope="col">Человек</th>
                    <th scope="col">О питании</th>
                    <th scope="col">Доп. сервисы</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col">Контакты</th>
                    <th scope="col">Питание</th>
                    <th scope="col">Оплачено</th>
                    <th scope="col">Общая стоимость</th>
                    <th scope="col">Остаток</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($result as $res): ?>
                        <tr style="<?="background-color:" . $res['background']?>">
                            <th style="background-color:<?= in_array($res['start'], [$today, $tomorrow]) ? '#2ae166' : '#ffffff' ?>" scope="row"><?=$res['#']?></th>
                            <td><?=$res['calendars']?></td>
                            <td><?=$res['start']?></td>
                            <td><?=$res['end']?></td>
                            <td><?=$res['people']?></td>
                            <td><?=$res['foodInfo']?></td>
                            <td><?=$res['additionalServices']?></td>
                            <td><pre><?=$res['comment']?></pre></td>
                            <td><?=$res['contact']?></td>
                            <td><?=$res['food']?> <small class="text-secondary">руб.</small></td>
                            <td><?=$res['prepaid']?> <small class="text-secondary">руб.</small></td>
                            <td><?=$res['total_price']?> <small class="text-secondary">руб.</small></td>
                            <td><?=($res['total_price'] - $res['prepaid'])?> <small class="text-secondary">руб.</small></td>
                            <td><?=$res['status']?></td>
                        </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
