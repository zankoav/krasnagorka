<?php
if (!defined('ABSPATH')) { exit; }

add_action( 'widgets_init', function () {
    register_sidebar( array(
        'name'          => 'Страница цен - текстовая область',
        'id'            => 'prices-content',
        'before_widget' => '<div class="b-container content-text season-text">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
        'after_title'   => '</h2></div>',
    ));
} );