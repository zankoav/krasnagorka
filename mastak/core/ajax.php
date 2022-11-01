<?php
    function calendar_action() {
        if (isset($_POST['id'], $_POST['slug'])) {
            $id   = $_POST['id'];
            $slug = $_POST['slug'];
            echo do_shortcode("[sbc_calendar id=\"$id\" slug=\"$slug\"]");
        }
        wp_die();
    }

    add_action('wp_ajax_calendar_action', 'calendar_action');
    add_action('wp_ajax_nopriv_calendar_action', 'calendar_action');

    function comments_action() {
        if (isset($_POST['range'])) {

            $range = $_POST['range'];

            $comments = get_comments(array(
                'post_id'      => 9105,
                'status'       => 'approve',
                'number'       => 20,
                'offset'       => $range,
                'hierarchical' => 'threaded'
            ));

            $result = [];
            /**
             * @var WP_Comment $comment
             */
            foreach ($comments as $comment) {
                $date     = date_create($comment->comment_date);
                $children = $comment->get_children();
                $item     = [
                    'id'              => $comment->comment_ID,
                    'rating'          => get_comment_meta($comment->comment_ID, 'rating_reviews', 1),
                    'comment_content' => $comment->comment_content,
                    'comment_author'  => $comment->comment_author,
                    'comment_date'    => date_format($date, 'd.m.Y'),
                    'children'        => $comment->get_children()
                ];

                if (count($children) > 0) {
                    foreach ($children as $child) {
                        $children_date = $child->comment_date;
                        $item['child'] = [
                            'content' => $child->comment_content,
                            'date'    => date_format(date_create($children_date), 'd.m.Y')
                        ];
                        break;
                    }

                }
                $result[] = $item;
            }

            echo json_encode(['comments' => $result, 'status' => 1]);
        }
        wp_die();
    }

    add_action('wp_ajax_comments_action', 'comments_action');
    add_action('wp_ajax_nopriv_comments_action', 'comments_action');


    function load_orders() {

        $dateStart = date("Y-m-d");
        $dateEnd = date("Y-m-d", strtotime('+10 days', strtotime($dateStart)));

        if($_POST['default'] != true){
            $dateStart =  date("Y-m-d", strtotime($_POST['from']));
            $dateEnd = date("Y-m-d", strtotime($_POST['to']));
        }
        


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

        function ajax_get_food_by_order_id($orderId){
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
    
        function ajax_get_additional_services_by_order_id($orderId){
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
    
            $foodInfo = ajax_get_food_by_order_id($orderId);
            $additionalServices = ajax_get_additional_services_by_order_id($orderId);
    
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
            'to' => date("d.m.Y", strtotime($dateEnd)),
            'today' => $today,
            'tomorrow' => $tomorrow
        ];

        echo json_encode($model);
        wp_die();
    }

    add_action('wp_ajax_load_orders', 'load_orders');
    add_action('wp_ajax_nopriv_load_orders', 'load_orders');