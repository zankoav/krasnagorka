<?php
if (!defined('ABSPATH')) { exit; }

add_action( 'widgets_init', function (){

    register_sidebar( array(
        'name'          => 'Страница Местоположения Дома - текстовая область',
        'id'            => 'map-content',
        'before_widget' => '<div class="big-text content-text">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
        'after_title'   => '</h2></div>',
    ) );

    register_sidebar( array(
        'name'          => 'Страница Местоположения Услуги - текстовая область',
        'id'            => 'map-2-content',
        'before_widget' => '<div class="big-text content-text">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
        'after_title'   => '</h2></div>',
    ));
});
