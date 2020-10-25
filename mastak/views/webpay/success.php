<?php 
    $order = $args['order'];
?>
<style>
    @media (max-width:768px){
        #check{
            width: 100% !important;
            font-size: 14px !important;
        }
    }
</style>
<table id="check" style="
    margin-left:auto;
    margin-right:auto;
    color:  #333;
    width: 500px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    border-spacing: 0;
    background-color: #fafafa;">
    <tbody>
        <tr>
            <td colspan="2" style="
                text-align:center;
                text-transform:uppercase;
                font-size:18px;
                background:#1498c6;
                color:#fff;
                padding: 16px;
                font-weight:600;
                border-top-left-radius:8px;
                border-top-right-radius:8px;">Информация о бронировании</td>
        </tr>
        <tr>
            <td style="
                border-bottom: 1px solid #ddd;
                padding: 12px;
                text-align: left;
                color: #555;">Домик</td>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                border-bottom: 1px solid #ddd;
                font-weight:600;"><?=$order['calendar']?></td>
        </tr>
        <tr>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                border-bottom: 1px solid #ddd;">Дата заезда</td>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                font-weight:600;
                border-bottom: 1px solid #ddd;"><?=$order['from']?></td>
        </tr>
        <tr>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                border-bottom: 1px solid #ddd;">Дата выезда</td>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                font-weight:600;
                border-bottom: 1px solid #ddd;"><?=$order['to']?></td>
        </tr>
        <tr>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                border-bottom:none;
                border-bottom-left-radius:8px;">Оплачено</td>
            <td style="
                padding: 12px;
                text-align: left;
                color: #555;
                font-weight:600;
                border-bottom:none;
                border-bottom-right-radius:8px;"><?=$order['price']?> руб.</td>
        </tr>
    </tbody>
</table>