<?php
namespace LsFactory;

use LsFactory\Order;

class OrderFactory {

    public static function initOrderByRequest($data){
        $order = new Order();

        if(empty($data['id'])){
            throw new \Exception('Empty calendar id');
        }

        $order->calendarId = $data['id'];
        return $order;
    }
}
