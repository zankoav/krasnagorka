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

            $html2pdf = new Html2Pdf('P', 'A4', 'ru', true);
            $html2pdf->setDefaultFont('Arial');
            try {
                
                    Log::info('1', '+');
                    $html2pdf->writeHTML($checkHTML);
                    $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
                    Log::info('2', '+');
            
            } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
                $html2pdf->clean();
                Log::info('0', $e->getMessage());
            }
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        $result = wp_mail([$emailTo],$subject, $template, $headers, $attachments);
        unlink(WP_CONTENT_DIR . '/uploads/document.pdf');
        return $result;
    }

    private static function generateCheck($checkType, $data){
        $result = `
            <style type="text/Css">
                .title {
                    padding-bottom: 8pt;
                    padding-top: 12pt;
                    font-size: 20pt;
                }
                .f-b {
                    font-weight: bold;
                }
            </style>
            <page style="font-size: 13pt; font-family: Arial">
                <table>
                <tbody>
                    <tr>
                        <td colspan="2" class="title">ПОДТВЕРЖДЕНИЕ БРОНИРОВАНИЯ</td>
                    </tr>
                    <tr>
                        <td>Номер бронирования:</td>
                        <td class="f-b">28557</td>
                    </tr>
                    <tr>
                        <td>от</td>
                        <td class="f-b">25.02.2021</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Ваши даты:</td>
                    </tr>
                    <tr>
                        <td>Заселение:</td>
                        <td class="f-b">04.04.2021 14:00 – 22:00</td>
                    </tr>
                    <tr>
                        <td>Выселение:</td>
                        <td class="f-b">05.04.2021 09:00 – 12:00</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">
                            Информация об объектах размещения:
                        </td>
                    </tr>
        
                    <tr>
                        <td>Объект размещения:</td>
                        <td class="f-b">Бабочка</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Персональные данные клиента:</td>
                    </tr>
                    <tr>
                        <td>ФИО:</td>
                        <td class="f-b">Александр</td>
                    </tr>
                    <tr>
                        <td>Паспорт ID:</td>
                        <td class="f-b">EGWEGWEHWE23523DDN</td>
                    </tr>
                    <tr>
                        <td>Контактный номер телефона:</td>
                        <td class="f-b">+375296259983</td>
                    </tr>
                    <tr>
                        <td>Число гостей:</td>
                        <td class="f-b">3</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Оплата:</td>
                    </tr>
                    <tr>
                        <td>Общая стоимость:</td>
                        <td class="f-b">120 белорусских рублей.</td>
                    </tr>
                    <tr>
                        <td>Предоплата внесена в размере:</td>
                        <td class="f-b">120 белорусских рублей.</td>
                    </tr>
                </tbody>
                </table>
            </page>
        `;
        return $result;
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});