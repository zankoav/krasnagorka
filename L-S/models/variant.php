<?php

if (!defined('ABSPATH')) { exit; }


function register_variant() {
    register_post_type('variant', array(
        'labels'             => array(
            'name'               => 'Пакет услуг',
            'singular_name'      => __('Пакет услуг'),
            'add_new'            => __('Добавить Пакет услуг'),
            'add_new_item'       => __('Добавить новый пакет услуг'),
            'edit_item'          => __('Редактировать пакет услуг'),
            'new_item'           => __('Новая пакет услуг'),
            'view_item'          => __('Посмотреть пакет услуг'),
            'search_items'       => __('Найти пакет услуг'),
            'not_found'          => __('Пакет услуг не найдено'),
            'not_found_in_trash' => __('В корзине пакета услуг не найдено'),
            'menu_name'          => 'Пакет услуг',
            'items_archive'      => 'Пакет услуг архив',
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
    $prefix = 'variant_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $sbc_variant = new_cmb2_box(array(
        'id'           => $prefix . 'data',
        'title'        => esc_html__('Настройка пакета услуг', 'krasnagorka'),
        'object_types' => array('variant'), // Post type
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true, // Show field names on the left
    ));

    $sbc_variant->add_field( array(
        'name'             => esc_html__( 'Питание', 'sbc' ),
        'id'               => $prefix . '_food',
        'type'             => 'multicheck',
        'options'          => array(
            'breakfast'  => 'Завтраки',
            'lunch'   => 'Обеды',
            'dinner'   => 'Ужины',
        )
    ) );

    $sbc_variant->add_field( array(
        'name'             => esc_html__( 'Бани по белому', 'sbc' ),
        'id'               => $prefix . '_white_bath',
        'type'             => 'checkbox'
    ) );

    $sbc_variant->add_field( array(
        'name'             => esc_html__( 'Бани по черному', 'sbc' ),
        'id'               => $prefix . '_черному_bath',
        'type'             => 'checkbox'
    ) );
}

add_action('cmb2_admin_init', 'variant_metabox');