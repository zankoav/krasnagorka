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
