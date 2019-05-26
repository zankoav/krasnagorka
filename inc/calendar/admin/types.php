<?php
function sbc_register_post_type() {

    register_post_type(
        'sbc_orders',
        array(
            'labels' => array(
                'name' => __( 'Заказы', 'sbc' ),
                'singular_name' => __( 'Заказы', 'sbc' ),
                'add_new' => __( 'Добавить', 'sbc' ),
                'add_new_item' => __( 'Добавить', 'sbc' ),
                'edit' => __( 'Редактировать', 'sbc' ),
                'edit_item' => __( 'Редактировать', 'sbc' ),
                'new_item' => __( 'Добавить', 'sbc' ),
                'view' => __( 'Просмотреть', 'sbc' ),
                'view_item' => __( 'Просмотреть', 'sbc' ),
                'search_items' => __( 'Искать', 'sbc' ),
                'not_found' => __( 'Не найдено', 'sbc' ),
                'not_found_in_trash' => __( 'Не найдено', 'sbc' ) ),

            'description'         => __( 'Здесь вы можете добавить новый заказ.', 'sbc' ),
            'public'              => true,
            'menu_icon' 		  => 'dashicons-portfolio',
            'show_ui'             => true,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'rewrite'             => array( 'slug' => 'sbc_orders', 'with_front' => false ),
            'query_var'           => true,
            'supports' 			  => array('title'),
            'has_archive'         => true,
            'show_in_nav_menus'   => true,
            'delete_with_user'	  => true,
            'can_export' 		  => true) );
    register_post_type(
        'sbc_clients',
        array(
            'labels' => array(
                'name' => __( 'Клиенты', 'sbc' ),
                'singular_name' => __( 'Клиент', 'sbc' ),
                'menu_name' => __( 'Клиенты', 'sbc' ),
                'all_items' => __( 'Клиенты', 'sbc' ),
                'add_new' => __( 'Добавить', 'sbc' ),
                'add_new_item' => __( 'Добавить', 'sbc' ),
                'edit' => __( 'Редактировать', 'sbc' ),
                'edit_item' => __( 'Редактировать', 'sbc' ),
                'new_item' => __( 'Добавить', 'sbc' ),
                'view' => __( 'Просмотреть', 'sbc' ),
                'view_item' => __( 'Просмотреть', 'sbc' ),
                'search_items' => __( 'Искать', 'sbc' ),
                'not_found' => __( 'Не найдено', 'sbc' ),
                'not_found_in_trash' => __( 'Не найдено', 'sbc' )
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-businessman',
            'show_admin_column' => true,
            'rewrite' => array( 'slug' => 'sbc_clients', 'with_front' => false ),
            'supports' => array(
                'title',
            ),
        )
    );
    register_taxonomy(
        'sbc_calendars',
        'sbc_orders',
        array(
            'labels' => array(
                'name' => __( 'Календари', 'sbc' ),
                'add_new_item' => __( 'Добавить', 'sbc' ),
                'new_item_name' => __( 'Добавить', 'sbc' ) ),
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => _x('sbc_calendars', 'slug', 'sbc') )
        )
    );
    register_taxonomy(
        'sbc_clients_type',
        'sbc_clients',
        array(
            'labels' => array(
                'name' => __( 'Статус клиента', 'sbc' ),
                'add_new_item' => __( 'Добавить', 'sbc' ),
                'new_item_name' => __( 'Добавить', 'sbc' ) ),
            'hierarchical' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => _x('sbc_clients_type', 'slug', 'sbc') )
        )
    );
}
add_action( 'init', 'sbc_register_post_type', 0 );