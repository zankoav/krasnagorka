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

    $model = [
        'orders' => $result,
        'from' => date("d.m.Y", strtotime($dateStart)),
        'to' => date("d.m.Y", strtotime($dateEnd))
    ];
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <div class="mt-4 d-flex g-2 g-lg-3 flex-wrap flex-md-nowrap">
        <div class="flex-grow-1">
            <p class="my-0">Даты: <b id="date-from"></b> - <b id="date-to"></b></p>
            <p class="my-0 mb-4">Количество заказов: <b id="order-count"></b></p>
        </div>
        <div class="container-filter">
            <style>
                .filter-button{
                    height: 30px;
                }
                .filter-row.row{
                    border-bottom: 0;
                    width: initial;
                    padding-bottom: initial;
                    float: initial;
                    margin-bottom: 0;
                }

            </style>
            <form class="filter-row row g-2 g-lg-3 row-cols-auto needs-validation flex-wrap flex-md-nowrap mb-4" novalidate>
                <div class="col-12 col-md">
                    <input type="date" placeholder="С" class="form-control form-control-sm" id="from" aria-describedby="validationServerFrom" required>
                    <div id="validationServerFrom" class="invalid-feedback">
                        Укажите корректную дату
                    </div>
                </div>
                <div class="col-12 col-md">
                    <input type="date" placeholder="По" class="form-control form-control-sm" id="to" aria-describedby="validationServerTo" required>
                    <div id="validationServerTo" class="invalid-feedback">
                        Укажите корректную дату
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary btn-sm filter-button">Найти</button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-secondary btn-sm filter-button filter-button__default">По умолчанию</button>
                </div>
                
            </form>
            <div id="liveAlertPlaceholder"></div>
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (($) => {
                    'use strict'

                    let model = <?= json_encode($model)?>

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    const form = document.querySelector('.needs-validation');
                    form.addEventListener('submit', event => {
                        clearAlert();
                        const houndriedDayes = 1000 * 60 * 60 * 24 * 100;
                        if (form.checkValidity()) {
                            const dateOneValue = document.querySelector('#from').value;
                            const dateTwoValue = document.querySelector('#to').value;
                            const dateOne = new Date(dateOneValue)
                            const dateTwo = new Date(dateTwoValue)
                            if(dateOne.getTime() >= dateTwo.getTime()){
                                alert('Вторая дата должна быть позже первой', 'danger')
                            }else if(dateTwo.getTime() - dateOne.getTime() > houndriedDayes) { //
                                alert('Интервал не может превышать 100 дней', 'danger')
                            }else {
                                sendRequest({from: dateOneValue, to: dateTwoValue});
                            }
                        }
                        event.preventDefault()
                        event.stopPropagation()
                        form.classList.add('was-validated')
                    }, false)

                    document.querySelector('.filter-button__default').addEventListener('click', event => {
                        form.reset();
                        clearAlert();
                        form.classList.remove('was-validated');
                        sendRequest({default: true});
                    })


                    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
                    const clearAlert = () => {
                        alertPlaceholder.innerHTML = '';
                    }
                    const alert = (message, type) => {
                        const wrapper = document.createElement('div')
                        wrapper.innerHTML = [
                            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                            `   <div>${message}</div>`,
                            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                            '</div>'
                        ].join('')

                        alertPlaceholder.append(wrapper)
                    }

                    const startSpinner = ()=>{
                        console.log('spinner start ...');
                    }

                    const stopSpinner = ()=>{
                        console.log('spinner stop ...');
                    }

                    const sendRequest = (requestData) => {
                        console.log('requestData', requestData);
                        startSpinner();
                        requestData.action = 'load_orders',
                        $.ajax(ajaxurl, {
                            data: requestData,
                            dataType: "json",
                            method: 'post',
                            success: function(response) {
                                model = response;
                                stopSpinner();
                                render();
                            },
                            error: function(x, y, z) {
                                stopSpinner();
                                alert(x,'danger');
                            }
                        });
                    }

                    function render(){
                        $('#date-from').html(model.from)
                        $('#date-to').html(model.to)
                        $('#order-count').html(model.orders.length)
                        $('#orders').html(ordersView());
                    }



                    function ordersView(){
                        return model.orders.map(order => {
                            return `
                                <div class="order">${order.calendars}</div>
                            `;
                        }).join('');
                    }

                    sendRequest({default: true});

                })(jQuery)
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
    <style>
        #orders {
            display: none;
        }
    </style>
    <div id="orders" class="orders"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
