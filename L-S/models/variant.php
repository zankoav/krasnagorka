<?php

if (!defined('ABSPATH')) { exit; }

function register_variant() {
    register_post_type('variant', array(
        'labels'             => array(
            'name'               => 'Пакет услуг (НГ)',
            'singular_name'      => __('Пакет услуг (НГ)'),
            'add_new'            => __('Добавить Пакет услуг (НГ)'),
            'add_new_item'       => __('Добавить новый пакет услуг (НГ)'),
            'edit_item'          => __('Редактировать пакет услуг (НГ)'),
            'new_item'           => __('Новая пакет услуг (НГ)'),
            'view_item'          => __('Посмотреть пакет услуг (НГ)'),
            'search_items'       => __('Найти пакет услуг (НГ)'),
            'not_found'          => __('Пакет услуг (НГ) не найдено'),
            'not_found_in_trash' => __('В корзине пакета услуг не найдено'),
            'menu_name'          => 'Пакеты услуг (НГ)',
            'items_archive'      => 'Пакет услуг (НГ) архив',
        ),
        'public'              => false,
        'publicly_queryable'  => true,
        // зависит от public
        'exclude_from_search' => true,
        // зависит от public
        'show_ui'             => true,
        // зависит от public
        'show_in_menu'        => null,
        // показывать ли в меню адмнки
        'show_in_admin_bar'   => null,
        // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => false,
        // зависит от public
        'show_in_rest'        => null,
        'rewrite'            => array('slug' => 'variant', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => true,
        'menu_position'      => 4,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title')
    ));
}

add_action('init', 'register_variant');

function variant_metabox() {
    /**
     * Sample metabox to demonstrate each field type included
     */
    $sbc_variant = new_cmb2_box(array(
        'id'           => 'variant_data',
        'title'        => esc_html__('Настройка пакета услуг', 'krasnagorka'),
        'object_types' => array('variant'), // Post type
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true, // Show field names on the left
    ));

    $sbc_variant->add_field( array(
        'name'             => esc_html__( 'Ежедневное', 'sbc' ),
        'id'               => 'variant_per_day',
        'type'             => 'title'
    ) );

    $sbc_variant->add_field(array(
        'name' => 'Описание услуги',
        'id'   => 'variant_description_per_day',
        'type'         => 'textarea_small'
    ));

    $sbc_variant->add_field(array(
        'name' => 'Цена в день',
        'id'   => 'variant_price_per_day',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

    $sbc_variant->add_field( array(
        'name'             => esc_html__( 'Разовое', 'sbc' ),
        'id'               => 'variant_single',
        'type'             => 'title'
    ) );

    $sbc_variant->add_field(array(
        'name' => 'Описание услуги',
        'id'   => 'variant_description_single',
        'type'         => 'textarea_small'
    ));

    $sbc_variant->add_field(array(
        'name' => 'Цена разовая',
        'id'   => 'variant_price_single',
        'type'         => 'text_money',
        'before_field' => 'BYN'
    ));

}

add_action('cmb2_admin_init', 'variant_metabox');