<?php
namespace LsFactory;

use LsFactory\ContactException;
use LsFactory\ContactFactory;

use LsFactory\Order;
use LsFactory\OrderException;


class OrderFactory {

    public static function initOrderByRequest($data){
        
        $order = new Order();

        try{
            $order->contact = ContactFactory::initContactByRequest($data);
        }catch(ContactException $e){
            throw $e;
        }

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
        }else if(!get_post($data['houseId'])){
            throw new OrderException('House id not exists');
        }

        $order->calendarId = $data['id'];
        $order->dateStart = $data['dateStart'];
        $order->dateEnd = $data['dateEnd'];
        $order->houseId = $data['houseId'];
        $order->comment = $data['comment'];
        $order->isTerem = get_term_meta($order->calendarId, 'kg_calendars_terem', 1) == 'on';



        return $order;
    }
}
