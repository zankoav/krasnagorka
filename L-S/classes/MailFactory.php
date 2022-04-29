<?php
namespace LsFactory;

use LsFactory\Order;
use LsFactory\MailException;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;


class MailFactory {

    public static function sendOrder(Order $order){

        if(
            $order->isBookedOnly() || 
            ( 
                $order->paymentMethod === Order::METHOD_CARD && 
                $order->type === Order::TYPE_RESERVED
            )
        ) return;

        
        $mail = self::initMail($order);

        $filePath = WP_CONTENT_DIR . '/uploads/document.pdf';

        if(!empty($mail->checkType)){

            $checkHTML = self::generateCheck($order);

            $html2pdf = new Html2Pdf('P', 'A4', 'ru', true, 'UTF-8', array(5, 5, 5, 8));
            try {
                $html2pdf->writeHTML($checkHTML);
                $html2pdf->output($filePath, 'F');
            
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
            }
        }

        $header = [
            'From: Краснагорка <info@krasnagorka.by>',
            'content-type: text/html',
            // 'bcc: order@krasnagorka.by'
        ];
        $result = wp_mail([$mail->email], $mail->subject, $mail->template, $header, [$filePath]);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $order->mail = $mail;

        if(!$result){
            throw new MailException('Mail is broken', 401);
        }
    }

    private static function initMail(Order $order){

        $mail = (object)[];
        $mail->email = $order->contact->email;

        if($order->type === Order::TYPE_RESERVED) {
            if($order->paymentMethod == Order::METHOD_CARD_LAYTER){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = $order->prepaidType === 100 ? "L-S/mail/templates/pay-full-confirm" : "L-S/mail/templates/pay-partial-confirm";
            }else if($order->paymentMethod == Order::METHOD_OFFICE){
                $mail->subject = 'Заявка на бронирование';
                $mail->templatePath = "L-S/mail/templates/office";
            } else {
                throw new MailException('Incorrect order type and method', 402);
            }
        } else {
            $mail->subject = 'Подтверждение бронирования';
            $mail->checkType =  $order->prepaidType === 100 ? 'pay-full' : 'pay-partial';
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

    private static function generateCheck(Order $order){

        $babyBed = '';
        $bathHouseWhite = '';
        $bathHouseBlack = '';
        $smallAnimalsCount = '';
        $bigAnimalsCount = '';
        $foodBreakfast = '';
        $foodLunch = '';
        $foodDinner = '';

        if($order->foodBreakfast > 0){
            $foodBreakfast = "<tr>
            <td>Количество завтраков:</td>
            <td class='f-b'>{$order->foodBreakfast}</td>
            </tr>";
        }

        if($order->foodLunch > 0){
            $foodLunch = "<tr>
            <td>Количество обедов:</td>
            <td class='f-b'>{$order->foodLunch}</td>
            </tr>";
        }

        if($order->foodDinner > 0){
            $foodDinner = "<tr>
            <td>Количество ужинов:</td>
            <td class='f-b'>{$order->foodDinner}</td>
            </tr>";
        }

        if($order->babyBed){
            $babyBed = "<tr>
            <td>Детская кроватка:</td>
            <td class='f-b'>Да</td>
            </tr>";
        }

        if(!empty($order->bathHouseWhite)){
            $bathHouseWhite = "<tr>
            <td>Количество сеансов бани по-белому:</td>
            <td class='f-b'>{$order->bathHouseWhite}</td>
            </tr>";
        }

        if(!empty($order->bathHouseBlack)){
            $bathHouseBlack = "<tr>
            <td>Количество сеансов бани по-черному:</td>
            <td class='f-b'>{$order->bathHouseBlack}</td>
            </tr>";
        }

        if($order->smallAnimalsCount > 0){
            $smallAnimalsCount = "<tr>
            <td>Кошки и собаки мелких пород (высота в холке до 40 см):</td>
            <td class='f-b'>{$order->smallAnimalsCount}</td>
            </tr>";
        }

        if($order->bigAnimalsCount > 0){
            $bigAnimalsCount = "<tr>
            <td>Собаки крупных пород (высота в холке более 40 см):</td>
            <td class='f-b'>{$order->bigAnimalsCount}</td>
            </tr>";
        }

        $result = "<style type='text/css'>
        .title{padding-bottom: 8pt;padding-top: 12pt;font-size: 20pt;}
        .f-b{font-weight: bold;}
        </style>
        <page style='font-size: 13pt;font-family:freeserif'>
        <table>
        <tbody>
        <tr>
        <td colspan='2' class='title'>ПОДТВЕРЖДЕНИЕ БРОНИРОВАНИЯ</td>
        </tr>
        <tr>
        <td>Номер бронирования:</td>
        <td class='f-b'>{$order->leadId}</td>
        </tr>
        <tr>
        <td>от</td>
        <td class='f-b'>".get_the_date("d.m.Y", $order->id)."</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Ваши даты:</td>
        </tr>
        <tr>
        <td>Заселение:</td>
        <td class='f-b'>".date("d.m.Y", strtotime($order->dateStart)) ." 14:00 – 22:00</td>
        </tr>
        <tr>
        <td>Выселение:</td>
        <td class='f-b'>".date("d.m.Y", strtotime($order->dateEnd)) ." 09:00 – 12:00</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Информация об объектах размещения:</td>
        </tr>
        <tr>
        <td>Объект размещения:</td>
        <td class='f-b'>{$order->calendarName}</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Персональные данные клиента:</td>
        </tr>
        <tr>
        <td>ФИО:</td>
        <td class='f-b'>{$order->contact->fio}</td>
        </tr>
        <tr>
        <td>Паспорт ID:</td>
        <td class='f-b'>{$order->contact->passport}</td>
        </tr>
        <tr>
        <td>Контактный номер телефона:</td>
        <td class='f-b'>{$order->contact->phone}</td>
        </tr>
        <tr>
        <td>Число гостей:</td>
        <td class='f-b'>{$order->peopleCount}</td>
        </tr>
        ".$babyBed."
        ".$bathHouseWhite."
        ".$bathHouseBlack."
        ".$smallAnimalsCount."
        ".$bigAnimalsCount."
        ".$foodBreakfast."
        ".$foodLunch."
        ".$foodDinner."
        <tr>
        <td colspan='2' class='title'>Оплата:</td>
        </tr>
        <tr>
        <td>Общая стоимость:</td>
        <td class='f-b'>{$order->price} белорусских рублей.</td>
        </tr>
        <tr>
        <td>Предоплата внесена в размере:</td>
        <td class='f-b'>{$order->subprice} белорусских рублей.</td>
        </tr>
        </tbody>
        </table>
        </page>
        ";
        return $result;
    }
}
