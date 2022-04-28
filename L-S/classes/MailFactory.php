<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\MailException;

class MailFactory {

    public static function sendOrder(Order $order){

        if(empty($order->paymentMethod)) return;

        $mail = self::initMail($order);

        if(!empty($mail->checkType)){

            // $checkHTML = self::generateCheck($mail->checkType, $data);

            // $html2pdf = new Html2Pdf('P', 'A4', 'ru', true, 'UTF-8', array(5, 5, 5, 8));
            // try {
            //     $html2pdf->writeHTML($checkHTML);
            //     $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
            
            // } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
            //     $html2pdf->clean();
            //     Log::info('0', $e->getMessage());
            // }
        }
        $filePath = WP_CONTENT_DIR . '/uploads/document.pdf';
        $attachments = array($filePath);
        $header = [
            'From: Краснагорка <info@krasnagorka.by>',
            'content-type: text/html',
            // 'bcc: order@krasnagorka.by'
        ];
        $result = wp_mail([$mail->email], $mail->subject, $mail->template, $header, $attachments);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if(!$result){
            throw new MailException('Mail is broken');
        }
    }

    private static function initMail(Order $order){

        $mail = (object)[];
        $mail->email = $order->contact->email;

        if($order->type === Order::TYPE_RESERVED) {
            if($order->paymentMethod == Order::METHOD_CARD_LAYTER){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = $order->prepaidType === 100 ? "L-S/mail/templates/tmpl-pay-full-confirm" : "L-S/mail/templates/tmpl-pay-partial-confirm";
            }else if($order->paymentMethod == Order::METHOD_OFFICE){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = "L-S/mail/templates/office";
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
            ['order' => $order]
        );
        $mail->template = ob_get_contents();
        ob_end_clean();

        return $mail;
    }
}
