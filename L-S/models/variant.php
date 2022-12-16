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
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'variant', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
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