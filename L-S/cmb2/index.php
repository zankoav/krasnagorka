<?php
if (!defined('ABSPATH')) { exit; }

if(is_admin()){
    require __DIR__ . '/theme-settings.php';
    require __DIR__ . '/page-booking.php';
    require __DIR__ . '/order-amocrm.php';
    require __DIR__ . '/order-payment.php';
}