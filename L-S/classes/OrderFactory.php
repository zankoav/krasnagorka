<?php
namespace LsFactory;

use LsFactory\ContactException;
use LsFactory\ContactFactory;

use LsFactory\Order;
use LsFactory\OrderException;


class OrderFactory {

    public const TYPE_RESERVED = 'reserved';

    public static function initOrderByRequest($data): Order{
        
        $order = new Order();

        $order->type = self::TYPE_RESERVED;
        $order->calendarId = $data['calendarId'];
        $order->dateStart = $data['dateStart'];
        $order->dateEnd = $data['dateEnd'];
        $order->houseId = $data['houseId'];
        $order->peopleCount = $data['count'];
        $order->contact = ContactFactory::initContactByRequest($data['contact']);

        self::validateOrder($order);

        $order->comment = strval($data['comment']);
        $order->paymentMethod = strval($data['paymentMethod']);
        $order->prepaidType = strval($data['prepaidType']);
        $order->childCount = intval($data['childCount']);
        $order->babyBed = boolval($data['babyBed']);
        $order->bathHouseWhite = intval($data['bathHouseWhite']);
        $order->bathHouseBlack = intval($data['bathHouseBlack']);
        $order->smallAnimalCount = intval($data['smallAnimalCount']);
        $order->foodBreakfast = intval($data['foodBreakfast']);
        $order->foodLunch = intval($data['foodLunch']);
        $order->foodDinner = intval($data['foodDinner']);
        $order->isTerem = get_term_meta($order->calendarId, 'kg_calendars_terem', 1) == 'on';
        $order->price = \LS_Booking_Form_Controller::calculateResult((array)$order)['total_price'];

        return $order;
    }

    public static function isAvailableOrder(Order $order){
        self::validateOrder($order);
        $result = true;

        $ordersQuery = new \WP_Query;
        $orders = $ordersQuery->query(array(
            'post_type' => 'sbc_orders',
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'sbc_calendars',
                    'terms' => [$order->calendarId]
                ]
            ],
            'meta_query' => array(
                array(
                    'key'     => 'sbc_order_end',
                    'value'   => $order->dateStart,
                    'compare' => '>=',
                )
            )
        ));

        $parseResult = [];

        foreach ($orders  as $item) {
            $orderId = $item->ID;
            $start = get_post_meta($orderId, 'sbc_order_start', true);
            $startTime = strtotime($start);
            $start = date('Y-m-d', $startTime);
            $end = get_post_meta($orderId, 'sbc_order_end', true);
            $endTime = strtotime($end);
            $end = date('Y-m-d', $endTime);
            $parseResult[] = [$start, $end, $orderId];
        }
        
        foreach ($parseResult as $r) {
            $from = $r[0];
            $to = $r[1];
            $orId = $r[2];

            if ($order->dateStart >= $from and $order->dateStart < $to) {
                $result = false;
            }

            if ($order->dateEnd > $from and $order->dateEnd <= $to) {
                $result = false;
            }

            if ($order->dateStart < $from and $order->dateEnd > $to) {
                $result = false;
            }
        }   

        if(!$result){
            throw new OrderException('Order not available');
        }
    }

    public static function insert(Order $order){
        ContactFactory::insert($order->contact);
    }

    private function insertWPLead($request)
    {
        $type     = $request['type'];
        $orderId  = $request['orderId'];
        $leadId  = $request['leadId'];
        $request['dateFrom'] = is_numeric($request['dateFrom']) ? $request['dateFrom'] : strtotime($request['dateFrom']);
        $request['dateTo'] = is_numeric($request['dateTo']) ? $request['dateTo'] : strtotime($request['dateTo']);
        $dateFrom = date("Y-m-d", $request['dateFrom']);
        $dateTo = date("Y-m-d", $request['dateTo']);
        $objectIds  = $request['objectIds'];

        if ($type != 'remove') {

            $kalendars = array_map('intval', $objectIds);
            $kalendars = array_unique($kalendars);
            $result = $this->isAvailableOrder($kalendars[0], $dateFrom, $dateTo, $orderId);
            if (!$result) {
                $response['status'] = 'busy';
                return $response;
            } else {
                $this->removeOrder($orderId);
            }

            $totalPrice = $request['totalPrice'];
            $havePayed  = $request['havePayed'];
            

            $contactName   = $request['contactName'];
            $contactPhone  = $request['contactPhone'];
            $contactEmail  = $request['contactEmail'];
            $contactStatus = $request['contactStatus'];
            $childs = $request['childs'];
            $peopleCount = $request['peopleCount'];
            $comment  = empty($request['comment']) ? "Количество человек: $peopleCount" : $request['comment']."\nКоличество человек: $peopleCount";
            $babyBed = $request['babyBed'] == 'true';
            $bathHouseWhite = $request['bathHouseWhite'];
            $bathHouseBlack = $request['bathHouseBlack'];
            $foodBreakfast = intval($request['foodBreakfast']);
            $foodLunch = intval($request['foodLunch']);
            $foodDinner = intval($request['foodDinner']);
            $smallAnimalsCount = intval($request['smallAnimalCount'] ?? 0);
            $bigAnimalsCount = intval($request['bigAnimalCount'] ?? 0);
            $client   = $this->get_client_by_meta(['meta_key' => 'sbc_client_phone', 'meta_value' => $contactPhone]);
            $clientId = null;
            $addedName   = empty($contactPhone) ? (empty($contactEmail) ? '' : $contactEmail) : $contactPhone;

            if (empty($client)) {
                $client_data = array(
                    'post_title'   => $contactName . ' ' . $addedName,
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => 23,
                    'post_type'    => 'sbc_clients'
                );
                // Вставляем данные в БД
                $clientId = wp_insert_post(wp_slash($client_data));
            } else {
                $clientPostArr = array();
                $clientPostArr['ID'] = $client->ID;
                $clientPostArr['post_title'] = $contactName . ' ' . $addedName;

                // Обновляем данные в БД
                wp_update_post(wp_slash($clientPostArr));
                $clientId = $client->ID;
            }

            if (!empty($contactEmail)) {
                update_post_meta($clientId, 'sbc_client_email', $contactEmail);
            }

            if (!empty($contactPhone)) {
                update_post_meta($clientId, 'sbc_client_phone', $contactPhone);
            }

            if (!empty($contactStatus)) {
                $contactStatusIds = [$contactStatus];
                $contactStatusIds = array_map('intval', $contactStatusIds);
                wp_set_object_terms($clientId, $contactStatusIds, 'sbc_clients_type');
            }

            $post_data = array(
                'post_title'   => date("Y-m-d H:i:s"),
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => 23,
                'post_type'    => 'sbc_orders'
            );

            // Вставляем данные в БД
            $post_id = wp_insert_post(wp_slash($post_data));

            if (is_wp_error($post_id)) {
                $response['message'] = $post_id->get_error_message();
            } else {
                if (!empty($contactName)) {
                    $contactTemplate = $clientId . " " . $contactName . " " . $contactPhone . " " . $contactEmail . " <a href='https://krasnagorka.by/wp-admin/post.php?post=" . $clientId . "&action=edit' target='_blank' class='edit-link'>Редактировать</a>";

                    update_post_meta($post_id, 'sbc_order_client', $contactTemplate);
                    $this->update_all_clients_orders($clientId, $contactTemplate);
                }
                if (!empty($type)) {
                    update_post_meta($post_id, 'sbc_order_select', $type);
                }
                if (!empty($dateFrom)) {
                    update_post_meta($post_id, 'sbc_order_start', $dateFrom);
                }
                if (!empty($dateTo)) {
                    update_post_meta($post_id, 'sbc_order_end', $dateTo);
                }

                if (!empty($totalPrice)) {
                    update_post_meta($post_id, 'sbc_order_price', $totalPrice);
                }
                if (!empty($havePayed)) {
                    update_post_meta($post_id, 'sbc_order_prepaid', $havePayed);
                }

                if($smallAnimalsCount > 0){
                    $comment .= "\nКошки и собаки мелких пород (высота в холке до 40 см): $smallAnimalsCount";
                    update_post_meta($post_id, 'sbc_order_small_animlas_count', $smallAnimalsCount);
                }

                if($bigAnimalsCount > 0){
                    $comment .= "\nСобаки крупных пород (высота в холке более 40 см): $bigAnimalsCount";
                    update_post_meta($post_id, 'sbc_order_big_animlas_count', $bigAnimalsCount);
                }


                if($foodBreakfast > 0){
                    $comment .= "\nЗавтраки: $foodBreakfast";
                    update_post_meta($post_id, 'sbc_order_food_breakfast', $foodBreakfast);
                }

                if($foodLunch > 0){
                    $comment .= "\nОбеды: $foodLunch";
                    update_post_meta($post_id, 'sbc_order_food_lunch', $foodLunch);
                }

                if($foodDinner > 0){
                    $comment .= "\nУжины: $foodDinner";
                    update_post_meta($post_id, 'sbc_order_food_dinner', $foodDinner);
                }

                if ($babyBed) {
                    $comment .= "\nДетская кроватка: Да";
                    update_post_meta($post_id, 'sbc_order_baby_bed', 'on');
                }

                if (!empty($bathHouseWhite)) {
                    $comment .= "\nКоличество сеансов бани по-белому: $bathHouseWhite";
                    update_post_meta($post_id, 'sbc_order_bath_house_white', $bathHouseWhite);
                }

                if (!empty($bathHouseBlack)) {
                    $comment .= "\nКоличество сеансов бани по-черному: $bathHouseBlack";
                    update_post_meta($post_id, 'sbc_order_bath_house_black', $bathHouseBlack);
                }

                if ($childs > 0) {
                    $comment .= "\nКоличество детей без спальных мест: $childs";
                    update_post_meta($post_id, 'sbc_order_childs', $childs);
                }

                if (!empty($comment)) {
                    update_post_meta($post_id, 'sbc_order_desc', $comment);
                }
                if (!empty($peopleCount)) {
                    update_post_meta($post_id, 'sbc_order_people_count', $peopleCount);
                    update_post_meta($post_id, 'sbc_order_count_people', $peopleCount);
                }

                if (!empty($request['passport'])) {
                    update_post_meta($post_id, 'sbc_order_passport', $request['passport']);
                }
                    
                if (!empty($leadId)) {
                    update_post_meta($post_id, 'sbc_lead_id', $leadId);
                }

                $paymentMethod  = $request['paymentMethod'];
                if (!empty($paymentMethod)) {
                    update_post_meta($post_id, 'sbc_order_payment_method', $paymentMethod);
                }

                $prepaidType  = $request['prepaidType'];
                $sandbox = get_webpay_sandbox($request['wsb_test']);

                if (!empty($prepaidType)) {
                    $prepaidType = intval($prepaidType);
                    update_post_meta($post_id, 'sbc_order_prepaid_percantage', $prepaidType);

                    if($paymentMethod == 'card_layter' || $paymentMethod == 'card'){

                        $secret_key = '2091988';
                        $wsb_seed = strtotime("now");
                        $wsb_storeid = $sandbox['wsb_storeid'];
                        $wsb_order_num = $post_id;
                        $wsb_test = $sandbox['wsb_test'];
                        $wsb_currency_id = 'BYN';
                        $wsb_total = (int)($totalPrice * $prepaidType / 100);
                        if($prepaidType == 100){
                            $wsb_total = $totalPrice;
                        }
                        $wsb_signature = sha1($wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $secret_key);

                        $sourceValue = [
                            "names" => [
                                '*scart'
                            ],
                            "values" => [
                                'wsb_storeid' => $wsb_storeid,
                                'wsb_store' => 'ИП Терещенко Иван Игоревич', 
                                'wsb_order_num' => $wsb_order_num,
                                'wsb_currency_id' => $wsb_currency_id,
                                'wsb_version' => "2",
                                'wsb_language_id' => "russian",
                                'wsb_seed' => $wsb_seed,
                                'wsb_test' => $wsb_test,
                                'wsb_signature' => $wsb_signature,
                                'wsb_invoice_item_name[0]' => $request['orderTitle'],
                                'wsb_invoice_item_quantity[0]' => '1',
                                'wsb_invoice_item_price[0]' => $wsb_total,
                                'wsb_total' => $wsb_total,
                                'wsb_notify_url' => 'https://krasnagorka.by/wp-json/krasnagorka/v1/pay-success',
                                'wsb_return_url' => "https://krasnagorka.by/payed-success",
                            ]
                        ];
                        $solt = "lightning-soft";
                        $source = md5($post_id . $solt);
                        update_post_meta($post_id, 'sbc_order_prepaid_source', $source);
                        update_post_meta($post_id, 'sbc_order_prepaid_value', json_encode($sourceValue, JSON_UNESCAPED_UNICODE));
                        if($paymentMethod == 'card') { 
                            $response['redirect'] = $sourceValue;
                        }
                    }
                }

                if (!empty($objectIds)) {
                    $objectIds = array_map('intval', $objectIds);
                    $objectIds = array_unique($objectIds);
                    wp_set_object_terms($post_id, $objectIds, 'sbc_calendars');
                }

                $response['orderId'] = $post_id;
            }
        } else {
            $this->removeOrder($orderId);
        }

        $response['status'] = 'success';

        return $response;
    }

    public static function validateOrder(Order $order){
        if(empty($order->calendarId)){
            throw new OrderException('Empty calendar id');
        }else if(!get_term($order->calendarId)){
            throw new OrderException('Calendar id not exists');
        }

        if(empty($order->dateStart)){
            throw new OrderException('Empty date start');
        }

        if(empty($order->dateEnd)){
            throw new OrderException('Empty date end');
        }

        if(empty($order->houseId)){
            throw new OrderException('Empty house id');
        }else if(!get_post($order->houseId)){
            throw new OrderException('House id not exists');
        }

        if(empty($order->peopleCount)){
            throw new OrderException('Empty people');
        }else if($order->peopleCount < 1){
            throw new OrderException('Invalid people value');
        }
    }
}
