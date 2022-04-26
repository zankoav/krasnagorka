<?php
namespace LsFactory;

use LsFactory\ContactException;
use LsFactory\ContactFactory;

use LsFactory\Order;
use LsFactory\OrderException;


class OrderFactory {

    public const TYPE_RESERVED = 'reserved';

    public static function initOrderByRequest($data){
        
        $order = new Order();

        $order->contact = ContactFactory::initContactByRequest($data);
        $order->type = self::TYPE_RESERVED;
        $order->calendarId = $data['calendarId'];
        $order->dateStart = $data['dateStart'];
        $order->dateEnd = $data['dateEnd'];
        $order->houseId = $data['houseId'];
        $order->people = $data['count'];

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

        return $order;
    }

    public static function getOrderData(Order $order){
        self::validateOrder($order);
        $order->isTerem = get_term_meta($order->calendarId, 'kg_calendars_terem', 1) == 'on';
        $order->days = self::getDaysPeriod(
            $order->dateStart, 
            $order->dateEnd
        );
        return $order;
    }

    public static function getDaysPeriod($from, $to){
        $toDT = new \DateTime($to);
        $fromDT = new \DateTime($from);
        
        $period = new \DatePeriod(
            $fromDT,
            new \DateInterval('P1D'),
            $toDT->modify( '+1 day' )
        );

        $days = [];

        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');    
        }
        
        return $days;
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

        if(empty($order->people)){
            throw new OrderException('Empty people');
        }else if($order->people < 1){
            throw new OrderException('Invalid people value');
        }
    }
}
