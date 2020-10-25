<?php 
    $order = $args['order'];
?>
<style>
    #check{
        margin-left: auto; 
        margin-right: auto;
        color:  #333;
        width: 400px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 16px;
    }
    #check th, #check td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
</style>
<table id="check">
    <tbody>
        <tr>
            <td colspan="2" style="text-align:center;text-transform:uppercase;font-size:18px;">Информация о бронировании</td>
        </tr>
        <tr>
            <td>Домик</td>
            <td><?=$order['calendar']?></td>
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