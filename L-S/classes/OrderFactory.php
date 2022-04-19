<?php
namespace LsFactory;

use LsFactory\Order;

class OrderFactory {

    public static function initOrderByRequest($data){
        $order = new Order();

        return $order;
    }
}
