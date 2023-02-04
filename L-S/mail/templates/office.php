<?php
	$order = $args['order'];
?>
<table bgcolor="#f8f8f8" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"
	style="table-layout:fixed;width:100%">
	<tbody>
		<tr>
			<td valign="top" style="padding:25px 0 25px 0">
				<table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="600"
					style="background:#fff;border:1px solid #f8f8f8;color:#999;font-family:'arial','helvetica',sans-serif !important;font-size:14px !important;font-style:normal !important;font-variant:normal !important;font-weight:400 !important;line-height:normal !important;table-layout:fixed;width:600px">
					<tbody>
						<tr>
							<td valign="middle" w80 style="padding: 30px;">
								<img width="60"
									src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/logo.png"
									alt="Krasnagorka">
							</td>
							<td colspan="5" valign="middle"
								style="padding: 30px; color:#000;text-transform:uppercase; font-size: 18px; font-weight: 400;">
								ЗАЯВКА НА БРОНИРОВАНИЕ
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px; color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;margin-bottom:5px;">Номер бронирования:
									<strong><?= $order->leadId ?></strong>
									<div style="font-size:14px;">
										от
										<?= get_the_date("d.m.Y", $order->id) ?>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="color:#000; padding: 0 30px 20px;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">База
									отдыха «Красногорка»</div>
								<div>Витебская область, Браславский район, озеро Снуды</div>
								<table border="0" cellpadding="0" cellspacing="0" style="margin-top:8px;">
									<tr>
										<td valign="top" style="padding-right:24px; width: 148px;">
											<strong>Контакты:</strong>
											<div>+375 29 320 19 19</div>
											<div>+375 29 701 19 19</div>
										</td>
										<td valign="top">
											<strong>Координаты:</strong>
											<div>55°46'07.3"N 27°05'13.7"E</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px; color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:14px">
									<div style="margin-bottom:12px;"><strong>Адрес офиса:</strong><br>г. Минск, 1-ый
										Твёрдый пер. д.13.</div>
									<div style="margin-bottom:12px;"><strong>Время работы:</strong><br>10:00 – 17:00
										(сб, вскр – выходной)</div>
									<div><span style="color:#f00;">*</span> перед визитом необходимо предупредить за
										час по телефонам, указанным выше</div>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">Ваши
									даты:</div>
								<div>Заселение: <strong>
										<?= date("d.m.Y", strtotime($order->dateStart)) ?>
									</strong> 14:00 – 22:00</div>
								<div>Выселение: <strong>
										<?= date("d.m.Y", strtotime($order->dateEnd)) ?>
									</strong> 09:00 – 12:00</div>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
									Информация об объектах размещения:</div>
								<div>Объект размещения: <a style="color: #1498c6; text-decoration: underline;" href=<?=$order->getHouseLink()?>><?= $order->calendarName ?></a></div>
                                <?php if(!empty($order->eventId)):?>
                                    <div>Мероприятие: <a style="color: #1498c6; text-decoration: underline;" href=<?=$order->getEventLink()?>><?= $order->getEventTitle() ?></a></div>
                                    <?php
                                        $variant = $order->eventVariant();
                                    ?>
                                    <div>Пакет: <?= $variant['title'] ?></div>
                                    <div style="color:#999;"><?= $variant['description'] ?></div>
                                <?php endif;?>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
									Персональные данные клиента:</div>
								<div>ФИО: <strong>
									<?= $order->contact->fio ?>
									</strong></div>
								<div>Паспорт ID: <strong>
									<?= $order->contact->passport ?>
									</strong></div>
								<div>Контактный номер телефона: <strong>
									<?= $order->contact->phone ?>
									</strong></div>
								<div>Число гостей: <strong><?= $order->peopleCount ?></strong></div>
                                <?php if($order->babyBed):?>
                                    <div>Детская кроватка: <strong>Да</strong></div>
                                <?php endif;?>
                                <?php if(!empty($order->bathHouseWhite)):?>
                                    <div>Количество сеансов бани по-белому: <strong><?=$order->bathHouseWhite?></strong></div>
                                <?php endif;?>
                                <?php if(!empty($order->bathHouseBlack)):?>
                                    <div>Количество сеансов бани по-черному: <strong><?=$order->bathHouseBlack?></strong></div>
                                <?php endif;?>
                                <?php if($order->smallAnimalCount > 0):?>
                                    <div>Кошки и собаки мелких пород (высота в холке до 40 см): <strong><?=$order->smallAnimalCount?></strong></div>
                                <?php endif;?>
                                <?php if($order->bigAnimalCount > 0):?>
                                    <div>Собаки крупных пород (высота в холке более 40 см): <strong><?=$order->bigAnimalCount?></strong></div>
                                <?php endif;?>
                                <?php if(!empty($order->foodVariant)):?>
                                    <div>Пакет питания: <strong><?=$order->getFoodVariant()?></strong></div>
                                <?php endif;?>
                                <?php if($order->foodBreakfast > 0):?>
                                    <div>Количество завтраков: <strong><?=$order->foodBreakfast?></strong></div>
                                <?php endif;?>
                                <?php if($order->foodLunch > 0):?>
                                    <div>Количество обедов: <strong><?=$order->foodLunch?></strong></div>
                                <?php endif;?>
                                <?php if($order->foodDinner > 0):?>
                                    <div>Количество ужинов: <strong><?=$order->foodDinner?></strong></div>
                                <?php endif;?>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
									Оплата:</div>
								<div>Общая стоимость: <strong><?= $order->price ?></strong> белорусских рублей.</div>
								<div>В стоимость уже включены комиссии платежных систем, туристический сбор не
									требуется.
									<div>Предоплата вносится в размере
										<strong><?= $order->subprice ?></strong> белорусских рублей наличными денежными средствами в
										офисе в Минске в течение двух календарных дней с момента бронирования.
									</div>
									<div style="line-height: 1; margin-top:12px;"><small style="color:#999;"><span
												style="color:#f00;">*</span>
											Оставшаяся часть стоимости (если таковая имеется) вносится в полном
											объеме перед заселением наличными денежными средствами в белорусских
											рублях.</small></div>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
									Дополнительная информация:</div>
								<div>Данная заявка свидетельствует о том, что Вы совершили бронирование через сайт
									<a style="color: #1498c6; text-decoration: underline;"
										href="https://krasnagorka.by">krasnagorka.by</a> и приняли условия
									договора присоединения,
									прикрепленного к форме бронирования. Подробнее с договором можно
									ознакомиться повторно по ссылке далее: <a
										style="color: #1498c6; text-decoration: underline;"
										href="https://krasnagorka.by/dogovor-prisoedineniya/">Договор
										присоединения</a></div>
								<div>Бронирование будет действительно в течение двух календарных дней. В случае
									неоплаты по истечению указанного периода – бронирование считается
									аннулированным.</div>
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div style="font-size:18px;text-decoration: underline;margin-bottom:5px;">
									Порядок отмены бронирования:</div>
								<div>
									Для отмены бронирования просьба позвонить или отправить сообщение по контактам,
									указанным выше, спасибо!
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>