<?php
if (!defined('ABSPATH')) { exit; }

add_action( 'widgets_init', function () {
    register_sidebar( array(
        'name'          => 'Главная страница - текстовая область',
        'id'            => 'home-content',
        'before_widget' => '<div class="b-container content-text b-pb-2">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="header-title"><p class="header-title__subtitle">',
        'after_title'   => '</p></div>',
    ));
} );