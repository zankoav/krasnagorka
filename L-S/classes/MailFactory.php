<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\MailException;

class MailFactory {

    public static function sendOrder(Order $order){

        if(empty($order->paymentMethod)) return;

        $mail = self::initMail($order);

        $order->mail = $mail;

    }

    private static function initMail(Order $order){

        $mail = (object)[];

        if($order->type === Order::TYPE_RESERVED) {
            if($order->paymentMethod == Order::METHOD_CARD_LAYTER){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = $order->prepaidType === 100 ? "L-S/mail/templates/tmpl-pay-full-confirm" : "L-S/mail/templates/tmpl-pay-partial-confirm";
            }else if($order->paymentMethod == Order::METHOD_OFFICE){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = "L-S/mail/templates/tmpl-office";
            } else {
                throw new MailException('Incorrect order type and method');
            }
        } else {
            $mail->subject = 'Подтверждение бронирования';
            $mail->checkType =  $order->prepaidType === 100 ? 'tmpl-pay-full' : 'tmpl-pay-partial';
            $mail->templatePath = "L-S/mail/templates/{$mail->checkType}";
        } 

        ob_start();
        get_template_part(
            $mail->templatePath, 
            null,
            ['data' => (array)$order]
        );
        $mail->template = ob_get_contents();
        ob_end_clean();

        return $mail;
    }
}
