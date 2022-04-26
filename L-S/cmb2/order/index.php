<?php
if (!defined('ABSPATH')) { exit; }

if(is_admin()){
    require __DIR__ . '/order-amocrm.php';
    require __DIR__ . '/order-info.php';
    require __DIR__ . '/order-payment.php';
}