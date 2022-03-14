<?php
use Ls\Wp\Log as Log;
use Spipu\Html2Pdf\Html2Pdf;

class LS_Mailer {

    public static function getTemplate($templatePath, $data){
        ob_start();
        get_template_part(
            $templatePath, 
            null,
            ['data' => $data]
        );
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }

    public static function sendMail($emailTo, $subject, $template, $checkType, $data){
        $checkType = 'ok';
        if(!empty($checkType) && $emailTo == 'zankoav@gmail.com'){

            $checkHTML = self::generateCheck($checkType, $data);

            $html2pdf = new Html2Pdf('P', 'A4', 'ru', true, 'UTF-8', array(5, 5, 5, 8));
            try {
                $html2pdf->writeHTML($checkHTML);
                $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
            
            } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
                $html2pdf->clean();
                Log::info('0', $e->getMessage());
            }
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        $result = wp_mail([$emailTo], $subject, $template, $headers, $attachments);
        unlink(WP_CONTENT_DIR . '/uploads/document.pdf');
        return $result;
    }

    private static function generateCheck($checkType, $data){
        $babyBed = '';
        $bathHouseWhite = '';
        $bathHouseBlack = '';
        if($data['babyBed']){
            $babyBed = "<tr>
            <td>Детская кроватка:</td>
            <td class='f-b'>Да</td>
            </tr>";
        }

        if(!empty($data['bathHouseWhite'])){
            $bathHouseWhite = "<tr>
            <td>Количество сеансов бани по-белому:</td>
            <td class='f-b'>".$data['bathHouseWhite']."</td>
            </tr>";
        }

        if(!empty($data['bathHouseBlack'])){
            $bathHouseBlack = "<tr>
            <td>Количество сеансов бани по-черному:</td>
            <td class='f-b'>".$data['bathHouseBlack']."</td>
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
        <td class='f-b'>".$data['leadId']."</td>
        </tr>
        <tr>
        <td>от</td>
        <td class='f-b'>".$data['created']."</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Ваши даты:</td>
        </tr>
        <tr>
        <td>Заселение:</td>
        <td class='f-b'>".$data['from']." 14:00 – 22:00</td>
        </tr>
        <tr>
        <td>Выселение:</td>
        <td class='f-b'>".$data['to']." 09:00 – 12:00</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Информация об объектах размещения:</td>
        </tr>
        <tr>
        <td>Объект размещения:</td>
        <td class='f-b'>".$data['calendarName']."</td>
        </tr>
        <tr>
        <td colspan='2' class='title'>Персональные данные клиента:</td>
        </tr>
        <tr>
        <td>ФИО:</td>
        <td class='f-b'>".$data['fio']."</td>
        </tr>
        <tr>
        <td>Паспорт ID:</td>
        <td class='f-b'>".$data['passport']."</td>
        </tr>
        <tr>
        <td>Контактный номер телефона:</td>
        <td class='f-b'>".$data['phone']."</td>
        </tr>
        <tr>
        <td>Число гостей:</td>
        <td class='f-b'>".$data['peopleCount']."</td>
        </tr>
        ".$babyBed."
        ".$bathHouseWhite."
        ".$bathHouseBlack."
        <tr>
        <td colspan='2' class='title'>Оплата:</td>
        </tr>
        <tr>
        <td>Общая стоимость:</td>
        <td class='f-b'>".$data['price']." белорусских рублей.</td>
        </tr>
        <tr>
        <td>Предоплата внесена в размере:</td>
        <td class='f-b'>".$data['subprice']." белорусских рублей.</td>
        </tr>
        </tbody>
        </table>
        </page>
        ";
        return $result;
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});