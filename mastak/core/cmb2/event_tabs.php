<?php
    use Ls\Wp\Log as Log;

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
                'type_8' => __('Горящее Предложение', 'cmb2'),
                'type_9' => __('Таблица Акций', 'cmb2'),
                'type_10' => __('Мероприятие', 'cmb2'),
            ),
            'attributes'       => array(
                'data-validation' => 'required',
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
                'data-validation' => 'required',
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
                'data-validation' => 'required',
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
            )
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'           => 'Календарь',
            'desc'           => 'Выберите к какому календарю соответствует Домик',
            'id'             => 'calendar',
            // 'taxonomy'       => 'sbc_calendars', //Enter Taxonomy Slug
            'type'           => 'select',
            'options_cb'     => 'cmb2_get_term_options',
            'get_terms_args' => array(
                'taxonomy'   => 'sbc_calendars',
                'hide_empty' => false,
            ),
            'attributes' => array(
                'data-validation' => 'required',
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Дата с',
            'id'   => 'from',
            'type' => 'text_date',
            'attributes' => array(
                'data-validation' => 'required',
            ),
            // 'timezone_meta_key' => 'wiki_test_timezone',
            // 'date_format' => 'l jS \of F Y',
        ) );

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Дата до',
            'id'   => 'to',
            'type' => 'text_date',
            'attributes' => array(
                'data-validation' => 'required',
            ),
            // 'timezone_meta_key' => 'wiki_test_timezone',
            // 'date_format' => 'l jS \of F Y',
        ) );

        $sbc_client->add_group_field($group_field_event, array(
            'name'    => __( ' Просчитать цену', 'cmb2' ),
            'id'      => 'calculate',
            'type'    => 'calculate',
            'options' => array(
                "empty_calendar" => __("Выберите календарь", 'cmb2'),
                "empty_date_from" => __("Выберите дату заезда", 'cmb2'),
                "empty_date_to" => __("Выберите дату выезда", 'cmb2'),
                "booking_unavailable" => __("Даты заняты", 'cmb2')           
            ),
            'default' => 'none',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Текущая',
            'id'           => 'old_price',
            'type'         => 'text_small',
            'before_field' => 'BYN'
        ));


        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Новая цена',
            'id'           => 'new_price',
            'type'         => 'text_small',
            'before_field' => 'BYN',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'    => __( 'Скидка', 'cmb2' ),
            'id'      => 'cpercent',
            'type'    => 'cpercent'
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Картинка',
            'id'           => 'image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'preview_size' => array(100, 100)
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


    function cmb2_render_calculate( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		
        $view = '<div class="calculate-field"><div><button type="button" class="js-calculate button-secondary">Расчитать</button><span class="spinner"></span></div><input type="hidden" name="GG"><p class="cmb2-metabox-description"></p></div>';
        $view .= $field_type_object->_desc( true );
        echo $view;
    }
    
    add_action( 'cmb2_render_calculate', 'cmb2_render_calculate', 10, 5 );

    function cmb2_render_cpercent( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
        $view = '<div class="calculate-field calculate-percent"></div>';
        $view .= $field_type_object->_desc( true );
        echo $view;
    }
    
    add_action( 'cmb2_render_cpercent', 'cmb2_render_cpercent', 10, 6 );

    function mastak_event_tab_type_9() {
        $prefix = 'mastak_event_tab_type_9';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Таблица Акций', 'krasnagorka'),
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
                'group_title'   => __('Акция {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Акцию', 'krasnagorka'),
                'remove_button' => __('Удалить Акцию', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            )
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'             => 'Акция',
            'id'               => 'event',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => 'custom',
            'options_cb'       => 'show_event_options',
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

    function mastak_event_tab_type_10() {
        $prefix = 'mastak_event_tab_type_10';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix,
            'title'        => esc_html__('Мероприятие', 'krasnagorka'),
            'object_types' => array('event_tab'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name' => 'Сезонный интервал',
            'id'   => $prefix . '_interval',
            'type'             => 'select',
            'options_cb'       => 'show_interval_options',
        ));


        // $sbc_client->add_field(array(
        //     'name' => 'Дата с',
        //     'id'   => $prefix . '_from',
        //     'type' => 'text_date',
        //     'attributes' => array(
        //         'data-validation' => 'required',
        //     )
        // ));

        // $sbc_client->add_field(array(
        //     'name' => 'Дата до',
        //     'id'   => $prefix . '_to',
        //     'type' => 'text_date',
        //     'attributes' => array(
        //         'data-validation' => 'required',
        //     )
        // ));

        $sbc_client->add_field(array(
            'name' => 'Питание',
            'id'   => $prefix . '_food',
            'type'    => 'multicheck',
            'options' => array(
                'food_empty' => 'Без питания',
                'food_breakfast' => 'Завтраки',
                'food_lunch' => 'Обеды',
                'food_dinner' => 'Ужины',
                'food_breakfast_lunch' => 'Завтраки и обеды',
                'food_breakfast_dinner' => 'Завтраки и ужины',
                'food_lunch_dinner' => 'Обеды и ужины',
                'food_full' => '3-х разовое питание',
            )
        ));

        
        $postId = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);
        if ($postId) {
            $foods = get_post_meta($postId, 'mastak_event_tab_type_10_food', 1);
            if(!empty($foods)){
                foreach ((array)$foods as $food) {
                    Log::info('food!', $food);
                }
            }
            
        }


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
            )
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'           => 'Календарь',
            'desc'           => 'Выберите к какому календарю соответствует Домик',
            'id'             => 'calendar',
            // 'taxonomy'       => 'sbc_calendars', //Enter Taxonomy Slug
            'type'           => 'select',
            'options_cb'     => 'cmb2_get_term_options',
            'get_terms_args' => array(
                'taxonomy'   => 'sbc_calendars',
                'hide_empty' => false,
            ),
            'attributes' => array(
                'data-validation' => 'required',
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Минимальное число спальных мест',
            'id'   => 'peopleCount',
            'type'             => 'select',
            'default'          => 1,
            'options'       => [1,2,3,4,5,6,7,8],
        ) );

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Группа',
            'id'   => 'group',
            'show_option_none' => true,
            'type'             => 'select',
            'options'       => ['I','II','III','IV','V','VI','VII','VIII','IX', 'X'],
        ) );

        $sbc_client->add_group_field($group_field_event, array(
            'name'    => 'Просчитать цену за одного человека',
            'id'      => 'calculate',
            'type'    => 'calculate',
            'options' => array(
                "empty_calendar" => __("Выберите календарь", 'cmb2'),
                "empty_date_from" => __("Выберите дату заезда", 'cmb2'),
                "empty_date_to" => __("Выберите дату выезда", 'cmb2'),
                "booking_unavailable" => __("Даты заняты", 'cmb2')           
            ),
            'default' => 'none',
        ));


        

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Текущая за одного человека',
            'id'           => 'old_price',
            'type'         => 'text_small',
            'before_field' => 'BYN'
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Новая цена за одного человека',
            'id'           => 'new_price',
            'type'         => 'text_small',
            'before_field' => 'BYN',
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'    => __( 'Скидка', 'cmb2' ),
            'id'      => 'cpercent',
            'type'    => 'cpercent'
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name'         => 'Картинка',
            'id'           => 'image',
            'type'         => 'file',
            'options'      => array(
                'url' => false,
            ),
            'preview_size' => array(100, 100)
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

    function show_interval_options() {

        $query = new WP_Query(array(
            'post_type'      => 'season_interval',
            'posts_per_page' => -1,
            'post_status' => array("publish"),
            'meta_query' => [
                [
                    'key'     => 'season_from',
                    'value'   => date("Y-m-d"),
                    'type'    => 'DATE',
                    'compare' => '<='
                    
                ]
            ]
        ));

        $intervals = [];
        $posts = $query->get_posts();
        foreach ($posts as $post) {
            $intervals[$post->ID] = $post->post_title;
        }

        return $intervals;
    }
