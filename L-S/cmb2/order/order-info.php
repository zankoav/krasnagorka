<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }

function sbc_order_info_metabox() {

    /**
     * Sample metabox to demonstrate each field type included
     */
    $sbc_order = new_cmb2_box( array(
        'id'            => 'sbc_order_info',
        'title'         => esc_html__( 'Информация о заказе', 'sbc' ),
        'object_types'  => array( 'sbc_orders', ), // Post type
        // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
        // 'context'    => 'normal',
        'priority'   => 'high',
        // 'show_names' => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
        // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
        // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
    ) );

    $sbc_order->add_field( array(
        'name'      	=> __( 'Клиент', 'sbc' ),
        'id'               => 'sbc_order_client',
        'type'      	=> 'post_search_ajax',
        'desc'			=> __( '(Начните вводить ФИО)', 'sbc' ),
        // Optional :
        'limit'      	=> 1, 		// Limit selection to X items only (default 1)
        'sortable' 	 	=> false, 	// Allow selected items to be sortable (default false)
        'query_args'	=> array(
            'post_type'			=> array( 'sbc_clients' ),
            'post_status'		=> array( 'publish' ),
            'posts_per_page'	=> -1
        ),
        //'display_cb' => 'order_show_uer_info',
        'column' => array(
            'position' => 6,
            'name'     => esc_html__( 'Клиент', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name'             => esc_html__( 'Статус заказа', 'sbc' ),
        'id'               => 'sbc_order_select',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            'reserved' => esc_html__( 'Зарезервирован', 'sbc' ),
            'prepaid'  => esc_html__( 'Предоплачен', 'sbc' ),
            'booked'   => esc_html__( 'Оплачен', 'sbc' ),
        ),
        'column' => array(
            'position' => 2,
            'name'     => esc_html__( 'Статус заказа', 'sbc' ),
        ),
    ) );

    $mastak_theme_options = get_option('mastak_theme_options');
    $calendar_settings_message =  isset($mastak_theme_options['calendar_settings_message']) ? $mastak_theme_options['calendar_settings_message'] : '';
    $calendar_settings_message_after =  isset($mastak_theme_options['calendar_settings_message_after']) ? $mastak_theme_options['calendar_settings_message_after'] : '';

    $sbc_order->add_field( array(
        'name'     => esc_html__( 'Выбрать календарь', 'sbc' ),
        'desc'     => esc_html__( 'выберите календарь для отображения', 'sbc' ),
        'id'       => 'sbc_order_taxonomy_select',
        'type'     => 'taxonomy_select',
        'show_names' => false,
        'classes' => 'select-calendar',
        'taxonomy' => 'sbc_calendars',
        'after'       => '<div class="calendar_block"><div id="calendar"></div>
                <div class="calendar_legend">
                <ul>
                <li><b class="reserved"></b>Зарезервировано</li>
                <li><b class="prepaid"></b>Предоплачено</li>
                <li><b class="booked"></b>Оплачено</li>
                </ul>
                <div class="select-helper">
                    <img src="/wp-content/themes/krasnagorka/mastak/assets/icons/date-clicking-selecting.png" class="select-helper__img" alt="Выделение дат заезда и выезда">
                    <p class="select-helper__text" data-helper-start="'.$calendar_settings_message.'" data-helper="'.$calendar_settings_message_after.'">' . $calendar_settings_message.'</p>    
                </div>
                </div></div>',
    ) );

    $sbc_order->add_field( array(
        'name'     => esc_html__( 'Выбрать номера для заезда', 'sbc' ),
        'id'       => 'sbc_order_taxonomy_check',
        'type'     => 'taxonomy_multicheck',
        'show_names' => false,
        'classes' => 'select-calendar',
        'taxonomy' => 'sbc_calendars',
        'column' => array(
            'position' => 5,
            'name'     => esc_html__( 'Куда въезжают', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => 'Горящее предложение',
        'id'   => 'sbc_order_is_event',
        'attributes' => array(
            'readonly' => 'readonly'
        ),
        'type' => 'checkbox'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Дата заезда', 'sbc' ),
        'id'   => 'sbc_order_start',
        'type' => 'text_date',
        'date_format' => 'Y-m-d',
        'column' => array(
            'position' => 3,
            'name'     => esc_html__( 'Дата заезда', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Дата выезда', 'sbc' ),
        'id'   => 'sbc_order_end',
        'type' => 'text_date',
        'date_format' => 'Y-m-d',
        'column' => array(
            'position' => 4,
            'name'     => esc_html__( 'Дата выезда', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Общая стоимость', 'sbc' ),
        'id'   => 'sbc_order_price',
        'type' => 'text',
        'after_field' => ' руб.', // override '$' symbol if needed
        // 'repeatable' => true,
        'column' => array(
            'name'     => esc_html__( 'Общая стоимость', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Предоплата', 'sbc' ),
        'id'   => 'sbc_order_prepaid',
        'type' => 'text',
        'after_field' => ' руб.', // override '$' symbol if needed
        // 'repeatable' => true,
        'column' => array(
            'name'     => esc_html__( 'Предоплата', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Стоимость проживания', 'sbc' ),
        'id'   => 'sbc_order_accommodation_price',
        'type' => 'text',
        'attributes' => array(
            'readonly' => 'readonly'
        ),
        'after_field' => ' руб.'
    ));

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Стоимость питания', 'sbc' ),
        'id'   => 'sbc_order_food_price',
        'type' => 'text',
        'after_field' => ' руб.',
        'attributes' => array(
            'readonly' => 'readonly'
        ),
        'column' => array(
            'name'     => esc_html__( 'Питание', 'sbc' ),
        ),
    ));

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Комментарий к заказу', 'sbc' ),
        'id'   => 'sbc_order_desc',
        'type' => 'textarea',
        'column' => array(
            'position' => 7,
            'name'     => esc_html__( 'Комментарий к заказу', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Количество спальных мест', 'sbc' ),
        'id'   => 'sbc_order_people_count',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Количество детей без спальных мест', 'sbc' ),
        'id'   => 'sbc_order_childs',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Количество сеансов бани по-белому', 'sbc' ),
        'id'   => 'sbc_order_bath_house_white',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Количество сеансов бани по-черному', 'sbc' ),
        'id'   => 'sbc_order_bath_house_black',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Кошки и собаки мелких пород (высота в холке до 40 см)', 'sbc' ),
        'id'   => 'sbc_order_small_animlas_count',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Собаки крупных пород (высота в холке более 40 см)', 'sbc' ),
        'id'   => 'sbc_order_big_animlas_count',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => 'Детская кроватка',
        'id'   => 'sbc_order_baby_bed',
        'attributes' => array(
            'readonly' => 'readonly'
        ),
        'type' => 'checkbox'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Завтраки', 'sbc' ),
        'id'   => 'sbc_order_food_breakfast',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Обеды', 'sbc' ),
        'id'   => 'sbc_order_food_lunch',
        'type' => 'text'
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Ужины', 'sbc' ),
        'id'   => 'sbc_order_food_dinner',
        'type' => 'text'
    ) );

}

add_action( 'cmb2_admin_init', 'sbc_order_info_metabox' );
