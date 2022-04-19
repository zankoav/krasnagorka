<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\OrderException;

class OrderFactory {

    public static function initOrderByRequest($data){
        $order = new Order();

        if(empty($data['id'])){
            throw new OrderException('Empty calendar id');
        }

        $order->calendarId = $data['id'];
        return $order;
    }
}
