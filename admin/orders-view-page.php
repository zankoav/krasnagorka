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
        $foodBreakfast = get_post_meta($orderId, 'sbc_order_food_breakfast', true);
        $foodLunch = get_post_meta($orderId, 'sbc_order_food_lunch', true);
        $foodDinner = get_post_meta($orderId, 'sbc_order_food_dinner', true);
        
        $services = [];
        $houseWhite = get_post_meta($orderId, 'sbc_order_bath_house_white', true);
        $services['bath_house_white'] = empty($houseWhite) ?  0 : $houseWhite;

        $houseBlack = get_post_meta($orderId, 'sbc_order_bath_house_black', true);
        $services['bath_house_black'] = empty($houseBlack) ?  0 : $houseBlack;

        $smallAnimlas = get_post_meta($orderId, 'sbc_order_small_animlas_count', true);
        $services['small_animlas_count'] = empty($smallAnimlas) ?  0 : $smallAnimlas;

        $bigAnimlas = get_post_meta($orderId, 'sbc_order_big_animlas_count', true);
        $services['big_animlas_count'] = empty($bigAnimlas) ?  0 : $bigAnimlas;

        $babyBed = get_post_meta($orderId, 'sbc_order_baby_bed', true);
        $services['baby_bed'] = $babyBed === 'on' ? 'Да' : 'Нет';

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
            'foodBreakfast'   => empty($foodBreakfast) ? 0 : $foodBreakfast,
            'foodLunch'   => empty($foodLunch) ? 0 : $foodLunch,
            'foodDinner'   => empty($foodDinner) ? 0 : $foodDinner,
            'prepaid'   => empty($prepaid) ? 0 : $prepaid,
            'total_price'   => $total_price,
            'status'    => $statuses[$status]['title'],
            'background'    => $statuses[$status]['background'],
            'foodInfo'    => $foodInfo,
            'additionalServices'    => $additionalServices,
            'services' => $services
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
                        return model.orders.map((order, index) => {
                            const border = [model.today, model.tomorrow].indexOf(order.start) > -1 ? 'border:1px solid #009420;' : '';
                            const comment = order.comment || '-';
                            return `
                                <div class="order" style="background:${order.background}; ${border}">
                                    <div class="order__title">№${index + 1}. ${order.calendars}</div>
                                    <div class="order__block-wrapper">
                                        <div class="order__block-wrapper-main">
                                            <div class="order__block order__block_main">
                                                <div class="order-item">
                                                    <div class="order-item__title">Бронь</div>
                                                    <div class="order-item__list">
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Заезд:</div>
                                                            <div class="order-item__list-item-value">${order.start}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Выезд:</div>
                                                            <div class="order-item__list-item-value">${order.end}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Человек:</div>
                                                            <div class="order-item__list-item-value">${order.people}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Статус:</div>
                                                            <div class="order-item__list-item-value">${order.status}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order__block order__block_main">
                                                <div class="order-item">
                                                    <div class="order-item__title">Оплата</div>
                                                    <div class="order-item__list">
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Общая сумма:</div>
                                                            <div class="order-item__list-item-value">${order.total_price} руб.</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Питание:</div>
                                                            <div class="order-item__list-item-value">${order.food} руб.</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Оплачено:</div>
                                                            <div class="order-item__list-item-value">${order.prepaid} руб.</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Остаток:</div>
                                                            <div class="order-item__list-item-value">${order.total_price - order.prepaid} руб.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order__block order__block_main">
                                                <div class="order-item">
                                                    <div class="order-item__title">Питание</div>
                                                    <div class="order-item__list">
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Завтраки:</div>
                                                            <div class="order-item__list-item-value">${order.foodBreakfast}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Обеды</div>
                                                            <div class="order-item__list-item-value">${order.foodLunch}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Ужины:</div>
                                                            <div class="order-item__list-item-value">${order.foodDinner}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order__block order__block_contacts">
                                                <div class="order-contact-line">
                                                    <div class="order-contact-line__label">Контакт:</div>
                                                    <div class="order-contact-line__value">${order.contact}</div>
                                                </div>
                                                <div class="order-contact-line">
                                                    <div class="order-contact-line__label">Комментарий:</div>
                                                    <div class="order-contact-line__value">${comment}</div>
                                                </div>
                                            </div>
                                            <div class="order__line"></div>
                                        </div>
                                        <div class="order__block-wrapper-added">
                                            <div class="order__block">
                                                <div class="order-item">
                                                    <div class="order-item__title">Дополнительные услуги</div>
                                                    <div class="order-item__list">
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Бани по белому:</div>
                                                            <div class="order-item__list-item-value">${order.services.bath_house_white}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Бани по черному:</div>
                                                            <div class="order-item__list-item-value">${order.services.bath_house_black}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Мелкие животные:</div>
                                                            <div class="order-item__list-item-value">${order.services.small_animlas_count}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Крупные животные:</div>
                                                            <div class="order-item__list-item-value">${order.services.big_animlas_count}</div>
                                                        </div>
                                                        <div class="order-item__list-item">
                                                            <div class="order-item__list-item-label">Детская кроватка:</div>
                                                            <div class="order-item__list-item-value">${order.services.baby_bed}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            color: #212E35;
            font-family: "Comic Sans MS", "Comic Sans", cursive;
        }
        .order{
            font-size: 12px;
            border-radius: .5rem;
            margin: 1rem 0;
            padding: .5rem .75rem 1.25rem;
            box-shadow: 2px 4px 4px #999;
        }
        @media (min-width:1280px) {
            .order{
                margin: 1.5rem 0;
                font-size: 14px;
                padding: .75rem 1.5rem 1.25rem;
            }
        }
        .order__title{
            font-size: 16px;
        }
        @media (min-width:1280px) {
            .order__block-wrapper{
                display: flex;
                max-width:initial;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
            }
            .order__block-wrapper-main{
                padding: 0 .75rem;
                max-width: 75%;
                flex: 1 0 75%;
                display:flex;
                max-width: initial;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
                flex-wrap: wrap;
            }
            .order__block-wrapper-added{
                padding: 0 .75rem;
                max-width: 25%;
                flex: 1 0 25%;
            }
        }
        .order__line{
            border-bottom: 1px dashed #A7ACAF;
            margin-top: 20px;
        }
        @media (min-width:1280px) {
            .order__line{
                display: none;
            }
        }
        .order__block{
            margin-top: 20px;
        }
        @media (min-width:1280px) {
            .order__block_main{
                flex: 1 0 33.333%;
                max-width: 33.333%;
                padding-left:.75rem;
                padding-right:.75rem;
            }
            .order__block_contacts{
                padding-left:.75rem;
                padding-right:.75rem;
            }
        }
        .order-item__title{
            text-align: center;
        }
        @media (min-width:1280px) {
            .order-item__title{
                margin-bottom: .5rem;
            }
        }
        .order-item__list-item{
            display: flex;
            margin-top: .5rem;
            justify-content: space-between;
            border-bottom: 1px dashed #A7ACAF;
        }
        @media (min-width:1280px) {
            .order-item__list-item{
                display: flex;
                margin-top: .25rem;
            }
        }
        .order-contact-line__label,.order-item__list-item-label{
            color: #4D575C;
        }
        @media (min-width:1280px) {
            .order-contact-line__label{
                margin-right: .5rem;
            }
        }
        @media (min-width:1280px) {
            .order-contact-line{
                display: flex;
            }
        }
        .order-contact-line:last-child{
            margin-top: .75rem;
        }
    </style>
    <div id="orders" class="orders">
        <div class="order" style="background:#E3F3FF; border:1px solid #009420;">
            <div class="order__title">№1 Божья коровка</div>
            <div class="order__block-wrapper">
                <div class="order__block-wrapper-main">
                    <div class="order__block order__block_main">
                        <div class="order-item">
                            <div class="order-item__title">Бронь</div>
                            <div class="order-item__list">
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Заезд:</div>
                                    <div class="order-item__list-item-value">25.10.2022</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Выезд:</div>
                                    <div class="order-item__list-item-value">25.10.2022</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Человек:</div>
                                    <div class="order-item__list-item-value">4</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Статус:</div>
                                    <div class="order-item__list-item-value">Зарезервирован</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order__block order__block_main">
                        <div class="order-item">
                            <div class="order-item__title">Оплата</div>
                            <div class="order-item__list">
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Общая сумма:</div>
                                    <div class="order-item__list-item-value">280 руб.</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Питание:</div>
                                    <div class="order-item__list-item-value">0 руб.</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Оплачено:</div>
                                    <div class="order-item__list-item-value">0 руб.</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Остаток:</div>
                                    <div class="order-item__list-item-value">280 руб.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order__block order__block_main">
                        <div class="order-item">
                            <div class="order-item__title">Питание</div>
                            <div class="order-item__list">
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Завтраки:</div>
                                    <div class="order-item__list-item-value">1</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Обеды</div>
                                    <div class="order-item__list-item-value">2</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Ужины:</div>
                                    <div class="order-item__list-item-value">1</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order__block order__block_contacts">
                        <div class="order-contact-line">
                            <div class="order-contact-line__label">Контакт:</div>
                            <div class="order-contact-line__value">Купреев Александр Михайлович +375 33 381-77-99</div>
                        </div>
                        <div class="order-contact-line">
                            <div class="order-contact-line__label">Комментарий:</div>
                            <div class="order-contact-line__value">Добрый день. Нас будет двое рыбаков.</div>
                        </div>
                    </div>
                    <div class="order__line"></div>
                </div>
                <div class="order__block-wrapper-added">
                    <div class="order__block">
                        <div class="order-item">
                            <div class="order-item__title">Дополнительные услуги</div>
                            <div class="order-item__list">
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Бани по белому:</div>
                                    <div class="order-item__list-item-value">1</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Бани по черному:</div>
                                    <div class="order-item__list-item-value">1</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Мелкие животные:</div>
                                    <div class="order-item__list-item-value">1</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Крупные животные:</div>
                                    <div class="order-item__list-item-value">0</div>
                                </div>
                                <div class="order-item__list-item">
                                    <div class="order-item__list-item-label">Детская кроватка:</div>
                                    <div class="order-item__list-item-value">Да</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
