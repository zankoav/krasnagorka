<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\OrderException;

class OrderFactory {

    public static function initOrderByRequest($data){
        $order = new Order();

        if(empty($data['id'])){
            throw new OrderException('Empty calendar id');
        }else if(!term_exists($data['id'])){
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
        }

        $order->calendarId = $data['id'];
        $order->dateStart = $data['dateStart'];
        $order->dateEnd = $data['dateEnd'];
        $order->houseId = $data['houseId'];
        $order->isTerem = get_term_meta($order->calendarId, 'kg_calendars_terem', 1) == 'on';

        return $order;
    }
}
