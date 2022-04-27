<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\MailException;

class MailFactory {

    public static function sendOrder(Order $order){
        
        
    }

    private static function getTemplatePath(Order $order){

    }

    private static function getTemplate(Order $order){
        $templatePath = self::getTemplatePath($order);
        ob_start();
        get_template_part(
            $templatePath, 
            null,
            ['data' => (array)$order]
        );
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }

}
