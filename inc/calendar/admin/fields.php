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



add_action( 'cmb2_admin_init', 'sbc_orders_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function sbc_orders_metabox() {
    $prefix = 'sbc_order_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $sbc_order = new_cmb2_box( array(
        'id'            => $prefix . 'info',
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
        'id'               => $prefix . 'client',
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
        'id'               => $prefix . 'select',
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

    $sbc_order->add_field( array(
        'name'     => esc_html__( 'Выбрать календарь', 'sbc' ),
        'desc'     => esc_html__( 'выберите календарь для отображения', 'sbc' ),
        'id'       => $prefix . 'taxonomy_select',
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
                    <p class="select-helper__text">' . get_option('mastak_theme_options')['calendar_settings_message'] . 'Выделение свободных дат</p>    
                </div>
                </div></div>',
    ) );

    $sbc_order->add_field( array(
        'name'     => esc_html__( 'Выбрать номера для заезда', 'sbc' ),
        'id'       => $prefix . 'taxonomy_check',
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
        'name' => esc_html__( 'Дата заезда', 'sbc' ),
        'id'   => $prefix . 'start',
        'type' => 'text_date',
        'date_format' => 'Y-m-d',
        'column' => array(
            'position' => 3,
            'name'     => esc_html__( 'Дата заезда', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Дата выезда', 'sbc' ),
        'id'   => $prefix . 'end',
        'type' => 'text_date',
        'date_format' => 'Y-m-d',
        'column' => array(
            'position' => 4,
            'name'     => esc_html__( 'Дата выезда', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Общая стоимость', 'sbc' ),
        'id'   => $prefix . 'price',
        'type' => 'text',
        'after_field' => ' руб.', // override '$' symbol if needed
        // 'repeatable' => true,
        'column' => array(
            'name'     => esc_html__( 'Общая стоимость', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Оплачено', 'sbc' ),
        'id'   => $prefix . 'prepaid',
        'type' => 'text',
        'after_field' => ' руб.', // override '$' symbol if needed
        // 'repeatable' => true,
        'column' => array(
            'name'     => esc_html__( 'Оплачено', 'sbc' ),
        ),
    ) );

    $sbc_order->add_field( array(
        'name' => esc_html__( 'Комментарий к заказу', 'sbc' ),
        'id'   => $prefix . 'desc',
        'type' => 'textarea',
        'column' => array(
            'position' => 7,
            'name'     => esc_html__( 'Комментарий к заказу', 'sbc' ),
        ),
    ) );

}


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

//////

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB Taxonomy directory)
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jcchavezs/cmb2-taxonomy

add_filter('cmb2-taxonomy_meta_boxes', 'cmb2_taxonomy_sample_metaboxes');

 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array

function cmb2_taxonomy_sample_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_cmb2_';


    $meta_boxes['test_metabox'] = array(
        'id'            => 'test_metabox',
        'title'         => __( 'Test Metabox', 'cmb2' ),
        'object_types'  => array( 'sbc_calendars', ), // Taxonomy
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        'fields'        => array(
            array(
                'name'       => __( 'Test Text', 'cmb2' ),
                'desc'       => __( 'field description (optional)', 'cmb2' ),
                'id'         => $prefix . 'test_text',
                'type'       => 'text'
            ),
            array(
                'name' => __( 'Test Text Small', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textsmall',
                'type' => 'text_small',
                // 'repeatable' => true,
            ),
            array(
                'name' => __( 'Test Text Medium', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textmedium',
                'type' => 'text_medium',
                // 'repeatable' => true,
            ),
            array(
                'name' => __( 'Website URL', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'url',
                'type' => 'text_url',
                // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
                // 'repeatable' => true,
            ),
            array(
                'name' => __( 'Test Text Email', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'email',
                'type' => 'text_email',
                // 'repeatable' => true,
            ),
            array(
                'name' => __( 'Test Time', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_time',
                'type' => 'text_time',
            ),
            array(
                'name' => __( 'Time zone', 'cmb2' ),
                'desc' => __( 'Time zone', 'cmb2' ),
                'id'   => $prefix . 'timezone',
                'type' => 'select_timezone',
            ),
            array(
                'name' => __( 'Test Date Picker', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textdate',
                'type' => 'text_date',
            ),
            array(
                'name' => __( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textdate_timestamp',
                'type' => 'text_date_timestamp',
                // 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
            ),
            array(
                'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_datetime_timestamp',
                'type' => 'text_datetime_timestamp',
            ),
            // This text_datetime_timestamp_timezone field type
            // is only compatible with PHP versions 5.3 or above.
            // Feel free to uncomment and use if your server meets the requirement
            // array(
            // 	'name' => __( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
            // 	'desc' => __( 'field description (optional)', 'cmb2' ),
            // 	'id'   => $prefix . 'test_datetime_timestamp_timezone',
            // 	'type' => 'text_datetime_timestamp_timezone',
            // ),
            array(
                'name' => __( 'Test Money', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textmoney',
                'type' => 'text_money',
                // 'before_field' => '£', // override '$' symbol if needed
                // 'repeatable' => true,
            ),
            array(
                'name'    => __( 'Test Color Picker', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_colorpicker',
                'type'    => 'colorpicker',
                'default' => '#ffffff'
            ),
            array(
                'name' => __( 'Test Text Area', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textarea',
                'type' => 'textarea',
            ),
            array(
                'name' => __( 'Test Text Area Small', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textareasmall',
                'type' => 'textarea_small',
            ),
            array(
                'name' => __( 'Test Text Area for Code', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_textarea_code',
                'type' => 'textarea_code',
            ),
            array(
                'name' => __( 'Test Title Weeeee', 'cmb2' ),
                'desc' => __( 'This is a title description', 'cmb2' ),
                'id'   => $prefix . 'test_title',
                'type' => 'title',
            ),
            array(
                'name'    => __( 'Test Select', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_select',
                'type'    => 'select',
                'options' => array(
                    'standard' => __( 'Option One', 'cmb2' ),
                    'custom'   => __( 'Option Two', 'cmb2' ),
                    'none'     => __( 'Option Three', 'cmb2' ),
                ),
            ),
            array(
                'name'    => __( 'Test Radio inline', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_radio_inline',
                'type'    => 'radio_inline',
                'options' => array(
                    'standard' => __( 'Option One', 'cmb2' ),
                    'custom'   => __( 'Option Two', 'cmb2' ),
                    'none'     => __( 'Option Three', 'cmb2' ),
                ),
            ),
            array(
                'name'    => __( 'Test Radio', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_radio',
                'type'    => 'radio',
                'options' => array(
                    'option1' => __( 'Option One', 'cmb2' ),
                    'option2' => __( 'Option Two', 'cmb2' ),
                    'option3' => __( 'Option Three', 'cmb2' ),
                ),
            ),
            array(
                'name'     => __( 'Test Taxonomy Radio', 'cmb2' ),
                'desc'     => __( 'field description (optional)', 'cmb2' ),
                'id'       => $prefix . 'text_taxonomy_radio',
                'type'     => 'taxonomy_radio',
                'taxonomy' => 'category', // Taxonomy Slug
                // 'inline'  => true, // Toggles display to inline
            ),
            array(
                'name'     => __( 'Test Taxonomy Select', 'cmb2' ),
                'desc'     => __( 'field description (optional)', 'cmb2' ),
                'id'       => $prefix . 'text_taxonomy_select',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'category', // Taxonomy Slug
            ),
            array(
                'name'     => __( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
                'desc'     => __( 'field description (optional)', 'cmb2' ),
                'id'       => $prefix . 'test_multitaxonomy',
                'type'     => 'taxonomy_multicheck',
                'taxonomy' => 'post_tag', // Taxonomy Slug
                // 'inline'  => true, // Toggles display to inline
            ),
            array(
                'name' => __( 'Test Checkbox', 'cmb2' ),
                'desc' => __( 'field description (optional)', 'cmb2' ),
                'id'   => $prefix . 'test_checkbox',
                'type' => 'checkbox',
            ),
            array(
                'name'    => __( 'Test Multi Checkbox', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_multicheckbox',
                'type'    => 'multicheck',
                'options' => array(
                    'check1' => __( 'Check One', 'cmb2' ),
                    'check2' => __( 'Check Two', 'cmb2' ),
                    'check3' => __( 'Check Three', 'cmb2' ),
                ),
                // 'inline'  => true, // Toggles display to inline
            ),
            array(
                'name'    => __( 'Test wysiwyg', 'cmb2' ),
                'desc'    => __( 'field description (optional)', 'cmb2' ),
                'id'      => $prefix . 'test_wysiwyg',
                'type'    => 'wysiwyg',
                'options' => array( 'textarea_rows' => 5, ),
            ),
            array(
                'name' => __( 'Test Image', 'cmb2' ),
                'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
                'id'   => $prefix . 'test_image',
                'type' => 'file',
            ),
            array(
                'name'         => __( 'Multiple Files', 'cmb2' ),
                'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
                'id'           => $prefix . 'test_file_list',
                'type'         => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
            ),
            array(
                'name' => __( 'oEmbed', 'cmb2' ),
                'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'cmb2' ),
                'id'   => $prefix . 'test_embed',
                'type' => 'oembed',
            ),
        ),
    );

    return $meta_boxes;
}
 */