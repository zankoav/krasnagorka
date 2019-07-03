<?php

    add_action('cmb2_admin_init', 'mastak_event_tab_tabs');

    function mastak_event_tab_tabs() {
        $prefix = 'mastak_event_tab_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'base',
            'title'        => esc_html__('Тип таба', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'side',
            'priority'     => 'low',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name'             => 'Тип Таба',
            'id'               => 'tab_type',
            'type'             => 'select',
            'show_option_none' => true,
            'options'          => array(
                'type_1' => __('Фото/Текст/Иконки', 'cmb2'),
                'type_2' => __('Фотогаллерея', 'cmb2'),
                'type_3' => __('Картинки (на всю ширину)', 'cmb2'),
                'type_4' => __('Текст', 'cmb2'),
                'type_5' => __('Слайдер', 'cmb2'),
                'type_6' => __('Видео (несколько)', 'cmb2'),
                'type_7' => __('Иконка/Заголовок/Текст (несколько)', 'cmb2'),
                'type_8' => __('Таблица', 'cmb2'),
            ),
            'attributes'       => array(
                'required' => 'required',
            ),
            'column'           => array(
                'position' => 2,
                'name'     => 'Тип',
            ),
        ));

    }

    $postId = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);
    if ($postId) {
        $type = get_post_meta($postId, 'tab_type', 1);
        if ($type) {
            add_action('cmb2_admin_init', 'mastak_event_tab_' . $type);
        }
    }

    function mastak_event_tab_type_1() {

        $prefix = 'mastak_event_tab_type_1';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Фото/Текст/Иконки', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name'         => __('Картинка', 'krasnagorka'),
            'desc'         => __('Картинка 600x600', 'krasnagorka'),
            'id'           => $prefix . '_image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'preview_size' => array(200, 200)
        ));

        $sbc_client->add_field(array(
            'name' => __('Заголовок', 'krasnagorka'),
            'desc' => __('Заголовок', 'krasnagorka'),
            'id'   => $prefix . '_title',
            'type' => 'text'
        ));

        $sbc_client->add_field(array(
            'name' => __('Текст', 'krasnagorka'),
            'desc' => __('Текст', 'krasnagorka'),
            'id'   => $prefix . '_description',
            'type' => 'wysiwyg'
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . '_icons',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество списков', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Список {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Список', 'krasnagorka'),
                'remove_button' => __('Удалить Список', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Иконка',
            'id'           => 'item_icon',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'preview_size' => array(100, 100)
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Заголовок',
            'id'   => 'item_title',
            'type' => 'text',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'       => 'Строка',
            'id'         => 'item_text',
            'type'       => 'text',
            'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

    }

    function mastak_event_tab_type_2() {

        $prefix = 'mastak_event_tab_type_2';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client_photo = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Фотогалерея', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client_photo->add_field(array(
            'name' => __('Фотогалерея', 'krasnagorka'),
            'desc' => __('Фотогалерея 900x690', 'krasnagorka'),
            'id'   => $prefix . '_gallery',
            'type' => 'file_list'
        ));
    }

    function mastak_event_tab_type_3() {
        $prefix = 'mastak_event_tab_type_3';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Картинки (на всю ширину)', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name' => __('Картинки', 'krasnagorka'),
            'desc' => __('Картинки 900x690', 'krasnagorka'),
            'id'   => $prefix . '_gallery',
            'type' => 'file_list'
        ));
    }

    function mastak_event_tab_type_4() {
        $prefix = 'mastak_event_tab_type_4';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Текст', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name' => 'Текст',
            'id'   => $prefix . '_text',
            'type' => 'wysiwyg'
        ));
    }

    function mastak_event_tab_type_5() {
        $prefix = 'mastak_event_tab_type_5';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Слайдер', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . '_slides',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество слайдов', 'krasnagorka'),
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

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Картинка',
            'id'           => 'image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'attributes'   => array(
                'required' => 'required',
            ),
            'preview_size' => array(400, 200)
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Заголовок',
            'id'   => 'title',
            'type' => 'text',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Описание',
            'id'   => 'description',
            'type' => 'textarea_small',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Кнопка заголовок',
            'id'   => 'button_title',
            'type' => 'text',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Кнопка url',
            'id'   => 'url',
            'type' => 'text_url',
        ));
    }

    function mastak_event_tab_type_6() {
        $prefix = 'mastak_event_tab_type_6';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Видео (несколько)', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . '_videos',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество видео', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Видео {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Видео', 'krasnagorka'),
                'remove_button' => __('Удалить Видео', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Видео',
            'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
            'id'   => 'video',
            'type' => 'oembed',
        ));
    }

    function mastak_event_tab_type_7() {
        $prefix = 'mastak_event_tab_type_7';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Иконка/Заголовок/Текст (несколько)', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . '_items',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество блоков', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Блок {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Блок', 'krasnagorka'),
                'remove_button' => __('Удалить Блок', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Иконка',
            'id'           => 'image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'attributes'   => array(
                'required' => 'required',
            ),
            'preview_size' => array(100, 100)
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Заголовок',
            'id'   => 'title',
            'type' => 'text',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Текст',
            'id'   => 'description',
            'type' => 'wysiwyg',
        ));
    }

    function mastak_event_tab_type_8() {
        $prefix = 'mastak_event_tab_type_8';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Таблица', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => $prefix . '_items',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество домов', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Дом {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Дом', 'krasnagorka'),
                'remove_button' => __('Удалить Дом', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
            'after_group' => 'add_js_for_repeatable_titles',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'             => 'Дом',
            'id'               => 'house',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => 'custom',
            'options_cb'       => 'show_house_options',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Новая цена',
            'id'           => 'new_price',
            'type'         => 'text_small',
            'before_field' => 'BYN',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Старая цена',
            'id'           => 'old_price',
            'type'         => 'text_small',
            'before_field' => 'BYN',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Цена без скидок',
            'id'           => 'one_price',
            'type'         => 'text_small',
            'before_field' => 'BYN',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Скидка',
            'id'           => 'sale',
            'type'         => 'text_money',
            'before_field' => '%',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'             => 'Цена из сезон',
            'id'               => 'current_season',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => 'custom',
            'options_cb'       => 'show_seasons_options',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Описание цены',
            'id'   => 'sale_text',
            'type' => 'text'
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Текст',
            'id'   => 'description',
            'type' => 'wysiwyg',
        ));
    }

    function add_js_for_repeatable_titles() {
        add_action('admin_footer', 'add_js_for_repeatable_titles_to_footer');
    }

    function add_js_for_repeatable_titles_to_footer() {
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                var $box = $(document.getElementById('mastak_event_tab_type_8'));
                $box.on('cmb2_shift_rows_complete', function (event) {
                    let isDownPressed = event.currentTarget.classList.indexOf("move-down") > -1;
                    let index = $(event.currentTarget).closest('.postbox.cmb-row.cmb-repeatable-grouping').data('iterator');
                    console.log('isDownPressed', isDownPressed);
                    console.log('index', index);
                })
            });
        </script>
        <?php
    }
