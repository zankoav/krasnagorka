<?php
use Ls\Wp\Log as Log;

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

    public static function sendMail($emailTo, $subject, $template){
        if(class_exists('Spipu\Html2Pdf\Html2Pdf')){
            $html2pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'ru', true, 'UTF-8');
            $html2pdf->setDefaultFont('Arial');
            try {
                if($emailTo == 'zankoav@gmail.com'){
                    Log::info('1', '+');
                    $html2pdf->writeHTML(`<table bgcolor="#f8f8f8" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"style="table-layout:fixed;width:100%"><tbody><tr><td valign="top" style="padding:25px 0 25px 0"><table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="600"style="background:#fff;border:1px solid #f8f8f8;color:#999;font-family:'arial','helvetica',sans-serif !important;font-size:14px !important;font-style:normal !important;font-variant:normal !important;font-weight:400 !important;line-height:normal !important;table-layout:fixed;width:600px"><tbody><tr><td valign="middle" w80 style="padding: 30px;"><img width="60"src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/logo.png"alt="Krasnagorka"></td><td colspan="5" valign="middle"style="padding: 30px; color:#000;text-transform:uppercase; font-size: 18px; font-weight: 400;">ЗАЯВКА НА БРОНИРОВАНИЕ</td></tr><tr><td colspan="6"style="padding: 0 30px 20px; color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;margin-bottom:5px;">Номер бронирования:<strong>29645559</strong><div style="font-size:14px;">от 10.03.2022</div></div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px; color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;">Ссылка на оплату:<strong><a style="color: #1498c6; text-decoration: underline; text-transform: uppercase;" href="https://krasnagorka.by/pay/?source=33d82a39c1e902366c2438914dc4636d" target="_blank">оплатить</a></strong></div><div style="line-height: 1;margin-top: 4px;"><small style="color:#999;"><span style="color:#f00;">*</span>Действительна до 12.03.2022 12:00</small></div></td></tr><tr><td colspan="6"style="color:#000; padding: 0 30px 20px;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Базаотдыха «Красногорка»</div><div>Витебская область, Браславский район, озеро Снуды</div><table border="0" cellpadding="0" cellspacing="0" style="margin-top:8px;"><tr><td valign="top" style="padding-right:24px; width: 148px;"><strong>Контакты:</strong><div>+375 29 320 19 19</div><div>+375 29 701 19 19</div></td><td valign="top"><strong>Координаты:</strong><div>55°46'07.3"N 27°05'13.7"E</div></td></tr></table></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Вашидаты:</div><div>Заселение: <strong>30.03.2022</strong> 14:00 – 22:00</div><div>Выселение: <strong>07.04.2022</strong> 09:00 – 12:00</div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Информация об объектах размещения:</div><div>Объект размещения: <a style="color: #1498c6; text-decoration: underline;"href="https://krasnagorka.by/dom-na-braslavskih-ozyorah/rybatskij/">Рыбацкий</a></div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Персональные данные клиента:</div><div>ФИО: <strong>Zanko </strong></div><div>Паспорт ID: <strong>TTSSAA</strong></div><div>Контактный номер телефона: <strong>+375295558386</strong></div><div>Число гостей: <strong>2</strong></div><div>Детская кроватка: <strong>Да</strong></div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Оплата:</div><div>Общая стоимость: <strong>1116</strong> белорусских рублей.</div><div>В стоимость уже включены комиссии платежных систем, туристический сбор нетребуется.<div>Предоплата вносится в размере<strong>1116</strong> белорусских рублей <strong>онлайн по ссылке, отправленной на e-mail в течение двух календарных дней с момента бронирования.</strong></div><div style="line-height: 1; margin-top:12px;"><small style="color:#999;"><spanstyle="color:#f00;">*</spanstyle=>Оставшаяся часть стоимости (если таковая имеется) вносится в полномобъеме перед заселением наличными денежными средствами в белорусскихрублях.</small></div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Дополнительная информация:</div><div>Данная заявка свидетельствует о том, что Вы совершили бронирование через сайт<a style="color: #1498c6; text-decoration: underline;"href="https://krasnagorka.by">krasnagorka.by</a> и приняли условиядоговора присоединения,прикрепленного к форме бронирования. Подробнее с договором можноознакомиться повторно по ссылке далее: <astyle="color: #1498c6; text-decoration: underline;"href="https://krasnagorka.by/dogovor-prisoedineniya/">Договорприсоединения</astyle=></div><div>Бронирование будет действительно в течение двух календарных дней. В случае неоплаты по истечению указанного периода – бронирование считается аннулированным.</div></td></tr><tr><td colspan="6"style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif"><div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Порядок отмены бронирования:</div><div>Для отмены бронирования просьба позвонить или отправить сообщение по контактам, указанным выше, спасибо!</div></td></tr></tbody></table></td></tr></tbody></table>`);
                    $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
                    Log::info('2', '+');
                }
            } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
                $html2pdf->clean();
                Log::info('0', $e->getMessage());
            }
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        return wp_mail([$emailTo],$subject, $template, $headers, $attachments);
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});