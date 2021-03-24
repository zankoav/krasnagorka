<?php
$order = $args['order'];
?>

<table bgcolor="#f8f8f8" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="table-layout:fixed;width:100%">
    <tbody>
        <tr>
            <td valign="top" style="padding:25px 0 25px 0">
                <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="600" style="background:#fff;border:1px solid #f8f8f8;color:#999;font-family:'arial','helvetica',sans-serif !important;font-size:14px !important;font-style:normal !important;font-variant:normal !important;font-weight:400 !important;line-height:normal !important;table-layout:fixed;width:600px">
                    <tbody>
                        <tr>
                            <td valign="middle" style="padding: 30px;">
                                <img width="60" src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/logo.png" alt="Krasnagorka">
                            </td>
                            <td colspan="5" valign="middle" style="padding: 30px; color:#000;text-transform:uppercase; font-size: 18px; font-weight: 400;">
                                Подтверждение бронирования
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px; color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;margin-bottom:5px;">Номер
                                    бронирования: <strong>
                                        <?= $order['leadId'] ?>
                                    </strong>
                                    <div style="font-size:14px;">
                                        от
                                        <?= $order['created'] ?>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="6" style="color:#000; padding: 0 30px 20px;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">База
                                    отдыха «Красногорка»</div>
                                <div>Витебская область, Браславский район, озеро Снуды</div>
                                <table border="0" cellpadding="0" cellspacing="0" style="margin-top:8px;">
                                    <tr>
                                        <td valign="top" style="padding-right:24px;">
                                            <div>Контакты:</div>
                                            <div>+375 29 320 19 19</div>
                                            <div>+375 29 701 19 19</div>
                                            <div>+375 25 920 19 19</div>
                                        </td>
                                        <td valign="top">
                                            <div>Координаты:</div>
                                            <div>55°46'07.3"N 27°05'13.7"E</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Ваши
                                    даты:</div>
                                <div>Заселение: <strong>
                                        <?= $order['from'] ?>
                                    </strong> 14:00 – 22:00</div>
                                <div>Выселение: <strong>
                                        <?= $order['to'] ?>
                                    </strong> 09:00 – 12:00</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
                                    Информация об объектах размещения:</div>
                                <div>Объект размещения: <a style="color: #1498c6; text-decoration: underline;" href="<?= $order['calendarLink'] ?>">
                                        <?= $order['calendarName'] ?>
                                    </a></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
                                    Персональные данные клиента:</div>
                                <div>ФИО: <strong>
                                        <?= $order['fio'] ?>
                                    </strong></div>
                                <div>Паспорт ID: <strong>
                                        <?= $order['passport'] ?>
                                    </strong></div>
                                <div>Контактный номер телефона: <strong>
                                        <?= $order['phone'] ?>
                                    </strong></div>
                                <div>Число гостей: <strong>
                                        <?= $order['peopleCount'] ?>
                                    </strong></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
                                    Оплата:</div>
                                <div>Общая стоимость: <strong>
                                        <?= $order['price'] ?>
                                    </strong> белорусских рублей.</div>
                                <div>В стоимость уже включены комиссии платежных систем, туристический сбор не
                                    требуется.
                                    <div>Предоплата вносится в размере
                                        <strong>
                                            <?= $order['subprice'] ?>
                                        </strong> белорусских рублей
                                    </div>
                                    <div style="
											line-height: 1;"><small style="color:#999;"><span style="color:#f00;">*</span>
                                            Оставшаяся часть стоимости (если таковая имеется) вносится в полном
                                            объеме перед заселением наличными денежными средствами в белорусских
                                            рублях.</small></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
                                    Дополнительная информация:</div>
                                <div>Данное подтверждение свидетельствует о том, что Вы внесли
                                    предоплату на основании заявки на бронирование, оставленной
                                    через сайт <a style="color: #1498c6; text-decoration: underline;" href="https://krasnagorka.by">krasnagorka.by</a> и приняли условия договора
                                    присоединения,
                                    прикрепленного к форме бронирования. Подробнее с договором можно
                                    ознакомиться повторно по ссылке далее: <a style="color: #1498c6; text-decoration: underline;" href="https://krasnagorka.by/dogovor-prisoedineniya/">Договор
                                        присоединения</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
                                <div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
                                    Порядок отмены бронирования:</div>
                                <div>При отмене бронирования либо сокращении срока проживания внесенная
                                    предоплата не возвращается.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>