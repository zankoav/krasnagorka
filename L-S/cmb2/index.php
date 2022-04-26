<?php
if (!defined('ABSPATH')) { exit; }

if(is_admin()){
    require __DIR__ . '/theme-settings.php';
    require __DIR__ . '/page-booking.php';
    require __DIR__ . '/page-reviews.php';
    require __DIR__ . '/order/index.php';
    require __DIR__ . '/post.php';
    require __DIR__ . '/page-posts.php';
}