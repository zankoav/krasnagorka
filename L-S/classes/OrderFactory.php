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
        $order->houseId = $data['houseId'];
        $order->comment = $data['comment'];
        $order->paymentMethod = $data['paymentMethod'];
        $order->prepaidType = $data['prepaidType'];
        $order->childCount = $data['childCount'];
        $order->babyBed = $data['babyBed'];
        $order->bathHouseWhite = $data['bathHouseWhite'];
        $order->bathHouseBlack = $data['bathHouseBlack'];
        $order->smallAnimalCount = $data['smallAnimalCount'];
        $order->foodBreakfast = $data['foodBreakfast'];
        $order->foodLunch = $data['foodLunch'];
        $order->foodDinner = $data['foodDinner'];
        $order->isTerem = get_term_meta($order->calendarId, 'kg_calendars_terem', 1) == 'on';



        return $order;
    }
}
