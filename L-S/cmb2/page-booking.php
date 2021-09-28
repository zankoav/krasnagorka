<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }

function cmb2_booking_page() {

    $cmb_options = new_cmb2_box(array(
        'id'           => 'mastak_booking_page',
        'title'        => esc_html__('Настройки страницы бронирования', 'krasnagorka'),
        'object_types' => array('options-page'),
        'option_key'   => 'mastak_booking_appearance_options',
        'parent_slug'  => 'edit.php?post_type=page'
    ));

    $cmb_options->add_field(array(
        'name' => __('Картинка в шапке', 'krasnagorka'),
        'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
        'id'   => 'mastak_booking_pageimage',
        'type' => 'file',
    ));

    $cmb_options->add_field(array(
        'name' => 'Показывать калькулятор цен',
        'id'   => 'booking_price_show',
        'type' => 'checkbox',
    ));

    $cmb_options->add_field(array(
        'name' => 'Cпособы оплаты',
        'id'   => 'booking_payments_show_title',
        'type' => 'title',
    ));

    $cmb_options->add_field(array(
        'name' => 'Показывать способы оплаты',
        'id'   => 'booking_payments_show',
        'type' => 'checkbox',
    ));

    $cmb_options->add_field(array(
        'name' => 'Минимальная стоимость для предоплаты',
        'id'   => 'booking_payments_min_price',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

    $cmb_options->add_field(array(
        'name' => 'Предоплата',
        'id'   => 'booking_payments_type_percentage',
        'type'         => 'text_small',
        'before_field' => '%'
    ));

    $cmb_options->add_field(array(
        'name' => 'Включить тестовый Webpay Sandbox',
        'id'   => 'is_sand_box_enabled',
        'type' => 'checkbox',
    ));

}

add_action('cmb2_admin_init', 'cmb2_booking_page');