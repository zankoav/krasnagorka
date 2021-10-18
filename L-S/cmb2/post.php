<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }



add_action('cmb2_admin_init', function (){

    $prefix = 'post_settings_';
    $sbc_client = new_cmb2_box(array(
        'id'           => $prefix.'id',
        'title'        => esc_html__('Настройки статьи', 'krasnagorka'),
        'object_types' => array('post'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $sbc_client->add_field(array(
        'name' => __('Краткое описание', 'krasnagorka'),
        'desc' => __('Краткое описание', 'krasnagorka'),
        'id'   => $prefix . 'description',
        'type' => 'textarea',
    ));
});