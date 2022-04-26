<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */






add_action( 'cmb2_admin_init', 'sbc_clients_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function sbc_clients_metabox() {
    $prefix = 'sbc_client_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $sbc_client = new_cmb2_box( array(
        'id'            => $prefix . 'info',
        'title'         => esc_html__( 'Ифонрмация о клиенте', 'sbc' ),
        'object_types'  => array( 'sbc_clients', ), // Post type
        // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
        // 'context'    => 'normal',
        'priority'   => 'high',
        // 'show_names' => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
        // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
        // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
    ) );

    $sbc_client->add_field( array(
        'name' => esc_html__( 'Номер телефона', 'sbc' ),
        'id'   => $prefix . 'phone',
        'type' => 'text',
        'column' => array(
            'position' => 2,
            'name'     => esc_html__( 'Номер телефона', 'sbc' ),
        ),
    ) );

    $sbc_client->add_field( array(
        'name' => esc_html__( 'Email', 'sbc' ),
        'id'   => $prefix . 'email',
        'type' => 'text_email',
        'column' => array(
            'position' => 3,
            'name'     => esc_html__( 'Email', 'sbc' ),
        ),
    ) );

    $sbc_client->add_field( array(
        'name' => esc_html__( 'Комментарий', 'sbc' ),
        'id'   => $prefix . 'desc',
        'type' => 'textarea',
        'column' => array(
            'position' => 4,
            'name'     => esc_html__( 'Комментарий', 'sbc' ),
        ),
    ) );

    $sbc_client->add_field( array(
        'name'     => esc_html__( 'Статус клиента', 'sbc' ),
        'id'       => $prefix . 'taxonomy_select',
        'type'     => 'taxonomy_select',
        'show_names' => true,
        'taxonomy' => 'sbc_clients_type',
        'column' => array(
            'position' => 5,
            'name'     => esc_html__( 'Статус клиента', 'sbc' ),
        ),
    ) );

    $sbc_client->add_field( array(
        'name' => esc_html__( 'Заказы клиента', 'cmb2' ),
        'id'   => $prefix . 'orders',
        'type' => 'title',
        'show_on_cb' => 'render_client_orders'
    ) );


}