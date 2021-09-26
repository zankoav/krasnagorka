<?php
	$data = $args['data'];
	$source = get_post_meta($data['orderId'], 'sbc_order_prepaid_source', 1);
?>
<table bgcolor="#f8f8f8"
		border="0"
		cellpadding="0"
		cellspacing="0"
		height="100%"
		width="100%"
		style="table-layout:fixed;width:100%">
	<tbody>
		<tr>
			<td valign="top"
				style="padding:25px 0 25px 0">
				<table align="center"
						bgcolor="#fff"
						border="0"
						cellpadding="0"
						cellspacing="0"
						width="600"
						style="background:#fff;border:1px solid #f8f8f8;color:#999;font-family:'arial','helvetica',sans-serif !important;font-size:14px !important;font-style:normal !important;font-variant:normal !important;font-weight:400 !important;line-height:normal !important;table-layout:fixed;width:600px">
					<tbody>
						<tr>
							<td valign="middle"
								style="padding: 30px;">
								<img width="60"
										src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/logo.png"
										alt="Krasnagorka">
							</td>
							<td colspan="5"
								valign="middle"
								style="padding: 30px; color:#000;text-transform:uppercase; font-size: 18px; font-weight: 400;">
								Иструкция по оплате (Частичная оплата)
							</td>
						</tr>
						<tr>
							<td colspan="6"
								style="padding: 0 30px 20px;color:#000;font:400 14px/21px 'arial' , 'helvetica' , sans-serif">
								<div>Для оплаты перейдите по ссылке: <a style="color: #1498c6; text-decoration: underline;"
										href=<?="https://krasnagorka.by/pay/?source=$source"?>>
										Оплатить
									</a>
								</div>							
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>