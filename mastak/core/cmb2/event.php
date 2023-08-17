<?php


    function mastak_event_metabox() {
        $prefix = 'mastak_event_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'data',
            'title'        => esc_html__('Данные об акции', 'krasnagorka'),
            'object_types' => array('event'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name' => 'Подзаголово',
            'id'   => $prefix . 'subtitle',
            'type' => 'text'
        ));

        $sbc_client->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => __('Краткое описание', 'krasnagorka'),
            'desc' => __('Краткое описание', 'krasnagorka'),
            'id'   => $prefix . 'description',
            'type' => 'textarea',
        ));

        $sbc_client->add_field(array(
            'name'    => __('Цвет флажка', 'krasnagorka'),
            'desc'    => __('Цвет флажка', 'krasnagorka'),
            'id'      => $prefix . 'frame_color',
            'type'    => 'colorpicker',
            'default' => '#ffffff'
        ));

        $sbc_client->add_field(array(
            'name' => __('Иконка флажка', 'krasnagorka'),
            'desc' => __('Иконка флажка', 'krasnagorka'),
            'id'   => $prefix . 'icon',
            'type' => 'file'
        ));


        $sbc_client->add_field(array(
            'name' => 'Стоимость',
            'id'   => $prefix . 'price_title',
            'type' => 'title'
        ));

        $sbc_client->add_field(array(
            'name'         => 'Стоимость акции',
            'id'           => $prefix . 'price',
            'type'         => 'text',
            'before_field' => 'BYN'
        ));

        $sbc_client->add_field(array(
            'name' => __('Комментарий к цене', 'krasnagorka'),
            'id'   => $prefix . 'price_subtitle',
            'type' => 'textarea_small',
        ));

        $sbc_client->add_field(array(
            'name' => __('Разворачивать аккордион (мобильная версия)', 'krasnagorka'),
            'id'   => $prefix . 'accordion',
            'type' => 'checkbox',
        ));

        $sbc_client->add_field(array(
            'name' => 'Даты акции',
            'id'   => $prefix . 'date_title',
            'type' => 'title'
        ));

        $sbc_client->add_field(array(
            'name'            => 'Порядок',
            'id'              => $prefix . 'order',
            'description'     => __('Сортировка чем меньше - тем выше в списке', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*'
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint'
        ));

        $sbc_client->add_field(array(
            'name'        => 'Дата начала акции',
            'id'          => $prefix . 'date_start',
            'type'        => 'text_date_timestamp',
            'date_format' => 'd/m/Y',
        ));

        $sbc_client->add_field(array(
            'name'        => 'Дата окончания акции',
            'id'          => $prefix . 'date_finish',
            'type'        => 'text_date_timestamp',
            'date_format' => 'd/m/Y',
        ));

        $sbc_client->add_field(array(
            'name' => 'Не показывать в предстоящих акциях',
            'id'   => $prefix . 'hide_early',
            'type' => 'checkbox'
        ));

        $sbc_client->add_field(array(
            'name' => 'Открывать в новой вкладке',
            'id'   => 'new_page',
            'type' => 'checkbox'
        ));

        $sbc_client->add_field(array(
            'name' => 'Ссылка для кнопки забронировать',
            'id'   => $prefix .'link',
            'type' => 'text_url'
        ));
    }

    add_action('cmb2_admin_init', 'mastak_event_metabox');

    function mastak_event_tabs() {
        $prefix = 'mastak_event_tabs_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'data',
            'title'        => esc_html__('Табы', 'krasnagorka'),
            'object_types' => array('event'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));


        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . 'event_list',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество табов', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Таб {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Таб', 'krasnagorka'),
                'remove_button' => __('Удалить Таб', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Заголовок',
            'id'   => 'tab_name',
            'type' => 'text',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'             => 'Таб',
            'id'               => 'tab',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => 'custom',
            'options_cb'       => 'show_events_tabs_options',
            'attributes'       => array(
                'required' => 'required',
            ),
        ));

    }

    add_action('cmb2_admin_init', 'mastak_event_tabs');

    function mastak_event_submenu_page() {

        $prefix = 'mastak_event_submenu_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы акции', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_event_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=event',
            // Make options page a submenu item of the themes menu.
            // 'capability'      => 'manage_options', // Cap required to view options-page.
            // 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
            // 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
            // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
            // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
            // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
            // 'message_cb'      => 'yourprefix_options_page_message_callback',
        ));

        $cmb_options->add_field(array(
            'name' => __('Заголовок', 'krasnagorka'),
            'desc' => __('Заголовок на странице Услуги', 'krasnagorka'),
            'id'   => $prefix . 'header_title',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок №1', 'krasnagorka'),
            'desc' => __('Предстоящие акции', 'krasnagorka'),
            'id'   => 'subtitle_1',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок №2', 'krasnagorka'),
            'desc' => __('Прошедшие акции', 'krasnagorka'),
            'id'   => 'subtitle_2',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => __('Заголовок для тектовой области', 'krasnagorka'),
            'id'   => $prefix . 'big_text_title',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
        ));

        $cmb_options->add_field(array(
            'name'            => 'Скорость слайдера',
            'id'              => 'main_slider_delay',
            'description'     => __('В милисекундах (2000 = 2 сек)', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ));

        $group_field_event = $cmb_options->add_field(array(
            'id'          => 'special_events',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество акций в слайдер', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Слайд {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Слайд', 'krasnagorka'),
                'remove_button' => __('Удалить Слайд', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name' => 'Заголовок',
            'id'   => 'item_name',
            'type' => 'text',
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name' => 'Подзаголовок',
            'id'   => 'item_subtitle',
            'type' => 'text',
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name' => 'Баннер',
            'desc' => __('Баннер слайда (2736 x 710)', 'krasnagorka'),
            'id'   => 'item_banner',
            'type' => 'file'
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name' => 'Кнопка текст',
            'id'   => 'button_text',
            'type' => 'text'
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name' => 'Кнопка url',
            'id'   => 'button_url',
            'type' => 'text_url'
        ));

        $cmb_options->add_group_field($group_field_event, array(
            'name'        => 'Открывать в новой вкладе',
            'description' => __('Открывать в новой вкладе', 'krasnagorka'),
            'id'          => 'button_open_type',
            'type'        => 'checkbox',
        ));

        $cmb_options->add_field(array(
            'name' => __('Хлебные крошки', 'krasnagorka'),
            'id'   => 'breadcrumbs_title',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Хлебные крошки', 'krasnagorka'),
            'id'   => 'breadcrumbs',
            'type' => 'text'
        ));


        $cmb_options->add_field(array(
            'name' => __('СЕО Meta', 'krasnagorka'),
            'id'   => $prefix . 'seo',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Keywords', 'krasnagorka'),
            'id'   => $prefix . 'seo_keywords',
            'type' => 'textarea'
        ));
    }

    add_action('cmb2_admin_init', 'mastak_event_submenu_page');