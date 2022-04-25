<?php
namespace LsFactory;

use LsFactory\ContactException;
use LsFactory\ContactFactory;

use LsFactory\Order;
use LsFactory\OrderException;


class OrderFactory {

    public static function initOrderByRequest($data){
        
        $order = new Order();

        $order->contact = ContactFactory::initContactByRequest($data);

        if(empty($data['calendarId'])){
            throw new OrderException('Empty calendar id');
        }else if(!get_term($data['calendarId'])){
            throw new OrderException('Calendar id not exists');
        }

        if(empty($data['dateStart'])){
            throw new OrderException('Empty date start');
        }

        if(empty($data['dateEnd'])){
            throw new OrderException('Empty date end');
        }

        if(empty($data['houseId'])){
            throw new OrderException('Empty house id');
        }else if(!get_post($data['houseId'])){
            throw new OrderException('House id not exists');
        }

        $order->calendarId = $data['calendarId'];
        $order->dateStart = $data['dateStart'];
        $order->dateEnd = $data['dateEnd'];
        $order->days = self::getDaysPeriod(
            $order->dateStart, 
            $order->dateEnd
        );
        $order->houseId = $data['houseId'];
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

        return $order;
    }

    public static function getDaysPeriod($from, $to){

        $toDT = new DateTime($to);

        $period = new DatePeriod(
            new DateTime($from),
            new DateInterval('P1D'),
            $toDT->modify( '+1 day' )
        );

        $days = [];

        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');    
        }
        
        return $days;
    }
}
