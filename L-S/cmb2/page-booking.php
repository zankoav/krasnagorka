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
        'name' => 'Предоплата',
        'id'   => 'booking_payments_type_percentage',
        'type'         => 'text_small',
        'before_field' => '%'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой 100% (Текст)',
        'id'   => 'text_full_card',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой Частично (Текст)',
        'id'   => 'text_part_card',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой 100% Позже (Текст)',
        'id'   => 'text_full_later_card',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой Частично Позже (Текст)',
        'id'   => 'text_part_later_card',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой 100% в Офисе (Текст)',
        'id'   => 'text_full_office',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картой Частично в Офисе (Текст)',
        'id'   => 'text_part_office',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Включить тестовый Webpay Sandbox для админов',
        'id'   => 'is_sand_box_enabled',
        'type' => 'checkbox',
    ));

    $cmb_options->add_field(array(
        'name' => 'Настройки по надбавкам',
        'id'   => 'remove_increase_from_short_order_title',
        'type' => 'title',
    ));

    $cmb_options->add_field(array(
        'name' => 'Отключить надбавки для заказов-окошек',
        'id'   => 'remove_increase_from_short_order',
        'type' => 'checkbox',
    ));

    $cmb_options->add_field(array(
        'name' => 'Настройки по заказам с окнами по сторонам',
        'id'   => 'order_with_windows_title',
        'type' => 'title',
    ));

    $cmb_options->add_field(array(
        'name' => 'Отключить возможность оплаты брони с окнами по сторонам',
        'id'   => 'order_with_windows_enabled',
        'type' => 'checkbox',
    ));

    $cmb_options->add_field(array(
        'name' => 'Длинна окошка',
        'id'   => 'number_of_days',
        'type' => 'text_small',
    ));

    $cmb_options->add_field(array(
        'name' => 'Сообщение',
        'id'   => 'order_with_windows_message',
        'type' => 'textarea_small',
    ));

    $cmb_options->add_field(array(
        'name' => 'Цена на детскую кроватку',
        'id'   => 'baby_bed_price',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

    $cmb_options->add_field(array(
        'name' => 'Количество допустимых детских кроваток',
        'id'   => 'baby_bed_count',
        'type'         => 'text_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Цена на баню по-черному 2 часа',
        'id'   => 'bath_house_black_price',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

    $cmb_options->add_field(array(
        'name' => 'Цена на баню по-белому 2 часа',
        'id'   => 'bath_house_white_price',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

}

add_action('cmb2_admin_init', 'cmb2_booking_page');