<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }



add_action('cmb2_admin_init', function (){

    $prefix = 'page_posts_';
    $sbc_client = new_cmb2_box(array(
        'id'           => $prefix.'id',
        'title'        => esc_html__('Настройка страницы', 'krasnagorka'),
        'object_types' => array('page'),
        'show_on' => array( 
            'key' => 'page-template', 
            'value' => 'template-page-posts.php' 
        )
    ));

    $sbc_client->add_field(array(
        'name' => __('Заголовок блока новостей', 'krasnagorka'),
        'id'   => $prefix . 'news_title',
        'type' => 'text',
    ));
});