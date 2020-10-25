<?php 
    $order = $args['order'];
    $order['house'] = 'Рыбацкий';
?>
<table>
    <tbody>
        <tr>
            <td colspan="2">Информация о бронировании</td>
        </tr>
        <tr>
            <td>Домик</td>
            <td><?=$order['house']?></td>
        </tr>
        <tr>
            <td>Дата заезда</td>
            <td><?=$order['from']?></td>
        </tr>
        <tr>
            <td>Дата выезда</td>
            <td><?=$order['to']?></td>
        </tr>
        <tr>
            <td>Оплачено</td>
            <td><?=$order['price']?> руб.</td>
        </tr>
    </tbody>
</table>