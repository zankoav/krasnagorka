<?php
namespace Ls\Factory;

use Ls\Factory\Order;

class OrderFactory {

    public static function initOrderByRequest($data){
        $order = new Order();
        
        return $order;
    }
}
