<?php 
    $order = $args['order'];
?>
<style>
    #check{
        margin-left: auto; 
        margin-right: auto;
        color:  #333;
        width: 500px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        border-spacing: 0;
        background-color: #fafafa;
    }

    @media (max-width:768px){
        #check{
            width: 100%;
            font-size: 14px;
        }
    }

    #check tr:first-child td{
        background: #1498c6;
        color: #fff;
        font-weight: 600;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    #check td:last-child{
        font-weight: 600;
    }

    #check td {
        border-bottom: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        color: #555;
    }

    #check tr:last-child td {
        border-bottom: none;
    }

    #check tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    
    #check tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
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