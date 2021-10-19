<?php
if (!defined('ABSPATH')) { exit; }

if(is_admin()){
    require __DIR__ . '/opportunities-page.php';
    require __DIR__ . '/houses-page.php';
    require __DIR__ . '/events-page.php';
    require __DIR__ . '/price-page.php';
    require __DIR__ . '/home-page.php';
    require __DIR__ . '/place-page.php';
    require __DIR__ . '/news-page.php';
}