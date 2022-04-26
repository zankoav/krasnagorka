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
        $order->calendarName = get_term($order->calendarId)->name;
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

        $post_data = array(
            'post_title'   => date("Y-m-d H:i:s"),
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => 23,
            'post_type'    => 'sbc_orders'
        );

        $post_id = wp_insert_post(wp_slash($post_data));

        if (is_wp_error($post_id)) {
            throw new OrderException($post_id->get_error_message());
        }

        $order->id = $post_id;

        $contactTemplate = ContactFactory::getTemplete($order->contact);

        update_post_meta($order->id, 'sbc_order_client', $contactTemplate);
        update_post_meta($order->id, 'sbc_order_select', $order->type);
        update_post_meta($order->id, 'sbc_order_start', $order->dateStart);
        update_post_meta($order->id, 'sbc_order_end', $order->dateEnd);
        update_post_meta($order->id, 'sbc_order_price', $order->price);
        update_post_meta($order->id, 'sbc_order_people_count', $order->peopleCount);
        wp_set_object_terms($order->id, [$order->calendarId], 'sbc_calendars');

        $comment = [
            $order->comment,
            "Количество человек: {$order->peopleCount}"
        ];

        if($order->smallAnimalsCount > 0){
            $comment[] = "Кошки и собаки мелких пород (высота в холке до 40 см): {$order->smallAnimalsCount}";
            update_post_meta($order->id, 'sbc_order_small_animlas_count', $order->smallAnimalsCount);
        }

        if($order->bigAnimalsCount > 0){
            $comment[] = "Собаки крупных пород (высота в холке более 40 см): {$order->bigAnimalsCount}";
            update_post_meta($order->id, 'sbc_order_big_animlas_count', $order->bigAnimalsCount);
        }

        if($order->foodBreakfast > 0){
            $comment[] = "Завтраки: {$order->foodBreakfast}";
            update_post_meta($order->id, 'sbc_order_food_breakfast', $order->foodBreakfast);
        }

        if($order->foodLunch > 0){
            $comment[] = "Обеды: {$order->foodLunch}";
            update_post_meta($order->id, 'sbc_order_food_lunch', $order->foodLunch);
        }

        if($order->foodDinner > 0){
            $comment[] = "Ужины: {$order->foodDinner}";
            update_post_meta($order->id, 'sbc_order_food_dinner', $order->foodDinner);
        }

        if($order->babyBed){
            $comment[] = "Детская кроватка: Да";
            update_post_meta($order->id, 'sbc_order_baby_bed', 'on');
        }

        if($order->bathHouseWhite > 0){
            $comment[] = "Количество сеансов бани по-белому: {$order->bathHouseWhite}";
            update_post_meta($order->id, 'sbc_order_bath_house_white', $order->bathHouseWhite);
        }

        if($order->bathHouseBlack > 0){
            $comment[] = "Количество сеансов бани по-черному: {$order->bathHouseBlack}";
            update_post_meta($order->id, 'sbc_order_bath_house_black', $order->bathHouseBlack);
        }

        if($order->childCount > 0){
            $comment[] = "Количество детей без спальных мест: {$order->childCount}";
            update_post_meta($order->id, 'sbc_order_childs', $order->childCount);
        }

        if($order->childCount > 0){
            $comment[] = "Количество детей без спальных мест: {$order->childCount}";
            update_post_meta($order->id, 'sbc_order_childs', $order->childCount);
        }

        if (!empty($comment)) {
            update_post_meta($order->id, 'sbc_order_desc', implode("\n", $comment));
        }

        if (!empty($order->contact->passport)) {
            update_post_meta($order->id, 'sbc_order_passport', $order->contact->passport);
        }

        if (!empty($order->paymentMethod)) {
            update_post_meta($order->id, 'sbc_order_payment_method', $order->paymentMethod);
        }

        if (!empty($order->prepaidType)) {
            update_post_meta($order->id, 'sbc_order_prepaid_percantage', $order->prepaidType); 
        }

        if($order->paymentMethod === 'card_layter' || $order->paymentMethod === 'card'){

            $sandbox = get_webpay_sandbox();

            $secret_key = '2091988';
            $wsb_seed = strtotime("now");
            $wsb_storeid = $sandbox['wsb_storeid'];
            $wsb_order_num = $order->id;
            $wsb_test = $sandbox['wsb_test'];
            $wsb_currency_id = 'BYN';
            $wsb_prepaid_type = intval($order->prepaidType);
            $wsb_total = (int)($order->price * $wsb_prepaid_type / 100);
            if($wsb_prepaid_type == 100){
                $wsb_total = $order->price;
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
                    'wsb_invoice_item_name[0]' => $order->calendarName,
                    'wsb_invoice_item_quantity[0]' => '1',
                    'wsb_invoice_item_price[0]' => $wsb_total,
                    'wsb_total' => $wsb_total,
                    'wsb_notify_url' => 'https://krasnagorka.by/wp-json/krasnagorka/v1/pay-success',
                    'wsb_return_url' => "https://krasnagorka.by/payed-success",
                ]
            ];

            $solt = "lightning-soft";
            $source = md5($order->id . $solt);
            update_post_meta($order->id, 'sbc_order_prepaid_source', $source);
            update_post_meta($order->id, 'sbc_order_prepaid_value', json_encode($sourceValue, JSON_UNESCAPED_UNICODE));
            $order->sourceValue = $sourceValue;
        }
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
