<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 7/31/18
     * Time: 12:21 AM
     */

    function register_event_type() {
        register_post_type('event', array(
            'labels'             => array(
                'name'               => 'Акция', // Основное название типа записи
                'singular_name'      => __('Акция'), // отдельное название записи типа Book
                'add_new'            => __('Добавить акцию'),
                'add_new_item'       => __('Добавить новую акцию'),
                'edit_item'          => __('Редактировать акцию'),
                'new_item'           => __('Новая акция'),
                'view_item'          => __('Посмотреть акцию'),
                'search_items'       => __('Найти акцию'),
                'not_found'          => __('Акции не найдено'),
                'not_found_in_trash' => __('В корзине акций не найдено'),
                'menu_name'          => get_option('mastak_event_appearance_options')['breadcrumbs'],
                'items_archive'      => 'Акции архив',
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'stocks', 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 4,
            'menu_icon'          => 'dashicons-nametag',
            'supports'           => array('title', 'editor', 'thumbnail')
        ));
    }

    add_action('init', 'register_event_type');

    function register_event_tab_type() {
        register_post_type('event_tab', array(
            'labels'              => array(
                'name'               => 'Таб Акции', // Основное название типа записи
                'singular_name'      => __('Таб'), // отдельное название записи типа Book
                'add_new'            => __('Добавить Таб'),
                'add_new_item'       => __('Добавить новый Таб'),
                'edit_item'          => __('Редактировать Таб'),
                'new_item'           => __('Новый Таб'),
                'view_item'          => __('Посмотреть Таб'),
                'search_items'       => __('Найти Таб'),
                'not_found'          => __('Таб не найден'),
                'not_found_in_trash' => __('В корзине Таба не найдено'),
                'menu_name'          => 'Табы',
                'items_archive'      => 'Архив Табов',
            ),
            'description'         => '',
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
            // добавить в REST API. C WP 4.7
            //    'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => 4,
            //    'menu_icon'           => null,
            'menu_icon'           => 'dashicons-format-aside',
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            //'hierarchical'        => false,
            'supports'            => array('title'),
            // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            //'taxonomies'          => array(),
            'has_archive'         => false,
            'rewrite'             => false,
            'query_var'           => true,
        ));
    }

    add_action('init', 'register_event_tab_type');

    function register_opportunity_type() {

        register_post_type('opportunity', array(
            'labels'             => array(
                'name'               => 'Услуга', // Основное название типа записи
                'singular_name'      => __('Услуга'), // отдельное название записи типа Book
                'add_new'            => __('Добавить Услугу'),
                'add_new_item'       => __('Добавить новыю Услугу'),
                'edit_item'          => __('Редактировать Услугу'),
                'new_item'           => __('Новая Услуга'),
                'view_item'          => __('Посмотреть Услугу'),
                'search_items'       => __('Найти Услугу'),
                'not_found'          => __('Услуга не найдено'),
                'not_found_in_trash' => __('В корзине Услуги не найдено'),
                'menu_name'          => get_option('mastak_opportunities_appearance_options')['breadcrumbs'],
                'items_archive'      => 'Услуги архив',
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'otdyh-na-braslavah', 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-lightbulb',
            'supports'           => array('title', 'editor', 'thumbnail')
        ));
    }

    add_action('init', 'register_opportunity_type');

    function register_house_type() {
        register_post_type('house', array(
            'labels'             => array(
                'name'               => 'Дома', // Основное название типа записи
                'singular_name'      => __('Дом'), // отдельное название записи типа Book
                'add_new'            => __('Добавить новый'),
                'add_new_item'       => __('Добавить новый дом'),
                'edit_item'          => __('Редактировать дом'),
                'new_item'           => __('Новый дом'),
                'view_item'          => __('Посмотреть дом'),
                'search_items'       => __('Найти дом'),
                'not_found'          => __('Дома не найдено'),
                'not_found_in_trash' => __('В корзине дома не найдено'),
                'menu_name'          => get_option('mastak_houses_appearance_options')['breadcrumbs'],
                'items_archive'      => 'Дома архив',
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'dom-na-braslavskih-ozyorah', 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 4,
            'menu_icon'          => 'dashicons-admin-multisite',
            'supports'           => array('title', 'editor', 'thumbnail')
        ));
    }

    add_action('init', 'register_house_type');

    function mastak_house_metabox() {
        $prefix = 'mastak_house_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'data',
            'title'        => esc_html__('Данные о доме', 'krasnagorka'),
            'object_types' => array('house'), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ));

        $sbc_client->add_field(array(
            'name' => 'Подзаголовок',
            'id'   => $prefix . 'subtitle',
            'type' => 'text'
        ));

        $group_field_event = $sbc_client->add_field(array(
            'id'          => 'sale_days',
            'type'        => 'group',
            'description' => __('Скидки от количеаства дней', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Скидка {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Скидку', 'krasnagorka'),
                'remove_button' => __('Удалить Скидку', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Скидка',
            'id'   => 'sale',
            'after_field' => '%',
            'type' => 'text'
        ));

        $sbc_client->add_group_field($group_field_event, array(
            'name' => 'Количество дней',
            'id'   => 'dayes',
            'type' => 'text'
        ));

        $sbc_client->add_field(array(
            'name' => __('Это терем?', 'krasnagorka'),
            'desc' => __('При включении данной опции некоторые поля не будут отображаться. Для полной настройки дома терем перейдите на вкладку "Настройка Терема"', 'krasnagorka'),
            'id'   => $prefix . 'is_it_terem',
            'type' => 'checkbox',
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
            'name' => __('Календарь', 'krasnagorka'),
            'desc' => __('Календарь шорткод', 'krasnagorka'),
            'id'   => $prefix . 'calendar',
            'type' => 'text'
        ));

        $sbc_client->add_field(array(
            'name' => __('Шапка Заголовок', 'krasnagorka'),
            'desc' => __('Заготовок в шапке', 'krasnagorka'),
            'id'   => $prefix . 'header_title',
            'type' => 'text'
        ));

        $sbc_client->add_field(array(
            'name' => __('Краткое описание', 'krasnagorka'),
            'desc' => __('Краткое описание', 'krasnagorka'),
            'id'   => $prefix . 'small_description',
            'type' => 'textarea'
        ));

        $sbc_client->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => __('Фотогалерея', 'krasnagorka'),
            'desc' => __('Фотогалерея 900x690', 'krasnagorka'),
            'id'   => $prefix . 'gallery',
            'type' => 'file_list'
        ));

        $sbc_client->add_field(array(
            'name' => __('Карта', 'krasnagorka'),
            'desc' => __('Карта (1200 x 360)', 'krasnagorka'),
            'id'   => $prefix . 'map',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => 'Текст описание карты',
            'id'   => $prefix . 'text_map',
            'type' => 'wysiwyg'
        ));

        $sbc_client->add_field(array(
            'name' => __('Кол-во гостей', 'krasnagorka'),
            'desc' => __('Кол-во гостей', 'krasnagorka'),
            'id'   => $prefix . 'guests',
            'type' => 'text',
        ));

        $sbc_client->add_field(array(
            'name' => __('Мангальная зона', 'krasnagorka'),
            'desc' => __('Мангальная зона', 'krasnagorka'),
            'id'   => $prefix . 'barbecu',
            'type' => 'text',
        ));

        $sbc_client->add_field(array(
            'name' => __('Видео', 'krasnagorka'),
            'desc' => __('https://www.youtube.com/watch?v=cYjuu7C-_sk код <strong style="color:black;">cYjuu7C-_sk</strong>', 'krasnagorka'),
            'id'   => $prefix . 'video',
            'type' => 'text',
        ));

        $sbc_client->add_field(array(
            'name' => __('Включить планировку?', 'krasnagorka'),
            'id'   => $prefix . 'is_terem',
            'type' => 'checkbox'
        ));

        $sbc_client->add_field(array(
            'name' => __('Планировка 1', 'krasnagorka'),
            'desc' => __('Планировка (1200 x 360)', 'krasnagorka'),
            'id'   => $prefix . 'plan',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => __('Планировка 2', 'krasnagorka'),
            'desc' => __('Планировка (1200 x 360)', 'krasnagorka'),
            'id'   => $prefix . 'plan_2',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => __('Планировка 3', 'krasnagorka'),
            'desc' => __('Планировка (1200 x 360)', 'krasnagorka'),
            'id'   => $prefix . 'plan_3',
            'type' => 'file',
        ));


        $sbc_client->add_field(array(
            'name' => 'Условия и цены',
            'id'   => $prefix . 'residence',
            'type' => 'wysiwyg'
        ));

        // Icons description
        $sbc_client->add_field(array(
            'name'        => 'Свойства домика',
            'description' => 'Не распространяется на Терем',
            'id'          => 'icons_description_title',
            'type'        => 'title'
        ));

        // Icons description
        $sbc_client->add_field(array(
            'name' => 'Минимальное количество человек',
            'id'   => 'min_people',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Максимальное количество человек',
            'id'   => 'max_people',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество двухспальных кроватей',
            'id'   => 'double_bed',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество односпальных кроватей',
            'id'   => 'single_bed',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество сан. узлов с душем',
            'id'   => 'toilet_and_shower',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество сан. узлов',
            'id'   => 'toilet',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество спальных комнат',
            'id'   => 'bed_rooms',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Количество трех-спальных-двух-ярусных кроватей',
            'id'   => 'triple_bed',
            'type' => 'text_small'
        ));

        $sbc_client->add_field(array(
            'name' => 'Открывать в новой вкладке',
            'id'   => 'new_page',
            'type' => 'checkbox'
        ));
    }

    add_action('cmb2_admin_init', 'mastak_house_metabox');

    function mastak_house_rooms() {
        $prefix = 'mastak_house_';

        $cmb_master_page = new_cmb2_box(array(
            'id'           => $prefix . 'rooms',
            'title'        => esc_html__('Помещения', 'krasnagorka'),
            'object_types' => array('house'), // Post type
        ));


        $group_field_event = $cmb_master_page->add_field(array(
            'id'          => 'room',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество помещений на страницу', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Помещение {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Помещение', 'krasnagorka'),
                'remove_button' => __('Удалить Помещение', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_master_page->add_group_field($group_field_event, array(
            'name' => 'Помещение',
            'id'   => 'item',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

    }

    add_action('cmb2_admin_init', 'mastak_house_rooms');

    function mastak_house_conveniences() {
        $prefix = 'mastak_house_';

        $cmb_master_page = new_cmb2_box(array(
            'id'           => $prefix . 'conveniences',
            'title'        => esc_html__('Удобства', 'krasnagorka'),
            'object_types' => array('house'), // Post type
        ));


        $group_field_event = $cmb_master_page->add_field(array(
            'id'          => 'convenience',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество удобств на страницу', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Удобство {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Удобство', 'krasnagorka'),
                'remove_button' => __('Удалить Удобство', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_master_page->add_group_field($group_field_event, array(
            'name' => 'Удобство',
            'id'   => 'item',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));
    }

    add_action('cmb2_admin_init', 'mastak_house_conveniences');

    function mastak_house_kitchen() {
        $prefix = 'mastak_house_';

        $cmb_master_page = new_cmb2_box(array(
            'id'           => $prefix . 'kitchen',
            'title'        => esc_html__('Кухня', 'krasnagorka'),
            'object_types' => array('house'), // Post type
        ));


        $group_field_event = $cmb_master_page->add_field(array(
            'id'          => 'kitchen',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество удобств на страницу', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Удобство {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Удобство', 'krasnagorka'),
                'remove_button' => __('Удалить Удобство', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_master_page->add_group_field($group_field_event, array(
            'name' => 'Удобство',
            'id'   => 'item',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

    }

    add_action('cmb2_admin_init', 'mastak_house_kitchen');

    function mastak_house_bathroom() {
        $prefix = 'mastak_house_';

        $cmb_master_page = new_cmb2_box(array(
            'id'           => $prefix . 'bathroom',
            'title'        => esc_html__('Ванная', 'krasnagorka'),
            'object_types' => array('house'), // Post type
        ));


        $group_field_event = $cmb_master_page->add_field(array(
            'id'          => 'bathroom',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество удобств на страницу', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Удобство {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Удобство', 'krasnagorka'),
                'remove_button' => __('Удалить Удобство', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_master_page->add_group_field($group_field_event, array(
            'name' => 'Удобство',
            'id'   => 'item',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ));

    }

    add_action('cmb2_admin_init', 'mastak_house_bathroom');

    function mastak_opportunity_metabox() {
        $prefix = 'mastak_opportunity_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'data',
            'title'        => esc_html__('Настройка страницы', 'krasnagorka'),
            'object_types' => array('opportunity'), // Post type
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
            'name'         => 'Стоимость услуги',
            'id'           => $prefix . 'price',
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $sbc_client->add_field(array(
            'name'            => 'Порядок',
            'id'              => $prefix . 'order',
            'description'     => __('Сортировка чем меньше - тем выше в списке', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint'
        ));

        $sbc_client->add_field(array(
            'name' => 'Кнопка бронирования',
            'id'   => $prefix . 'add_order',
            'type' => 'checkbox'
        ));

        $sbc_client->add_field(array(
            'name' => __('Комментарий к цене', 'krasnagorka'),
            'id'   => $prefix . 'price_subtitle',
            'type' => 'textarea_small',
        ));

        $sbc_client->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name'    => __('Тип услуги', 'krasnagorka'),
            'desc'    => __('Дополнительная или основная услуга', 'krasnagorka'),
            'id'      => $prefix . 'added_opportunity',
            'type'    => 'select',
            'default' => 'main',
            'options' => array(
                'main'  => __('Основное', 'krasnagorka'),
                'added' => __('Дополнительное', 'krasnagorka'),
            ),
        ));

        $sbc_client->add_field(array(
            'name' => __('Краткое описание', 'krasnagorka'),
            'desc' => __('Краткое описание', 'krasnagorka'),
            'id'   => $prefix . 'description',
            // 'type' => 'textarea',
            'type' => 'wysiwyg'
        ));

        $sbc_client->add_field(array(
            'name'    => __('Цвет рамки', 'krasnagorka'),
            'desc'    => __('Цвет рамки', 'krasnagorka'),
            'id'      => $prefix . 'frame_color',
            'type'    => 'colorpicker',
            'default' => '#ffffff'
        ));

        $sbc_client->add_field(array(
            'name' => __('Фотогалерея', 'krasnagorka'),
            'desc' => __('Фотогалерея 900x690', 'krasnagorka'),
            'id'   => $prefix . 'gallery',
            'type' => 'file_list'
        ));

        $sbc_client->add_field(array(
            'name' => __('Видео', 'krasnagorka'),
            'desc' => __('https://www.youtube.com/watch?v=cYjuu7C-_sk код <strong style="color:black;">cYjuu7C-_sk</strong>', 'krasnagorka'),
            'id'   => $prefix . 'video',
            'type' => 'text',
        ));

        $sbc_client->add_field(array(
            'name' => __('Карта', 'krasnagorka'),
            'desc' => __('Карта (1200 x 360)', 'krasnagorka'),
            'id'   => $prefix . 'map',
            'type' => 'file',
        ));

        $sbc_client->add_field(array(
            'name' => 'Текст описание карты',
            'id'   => $prefix . 'text_map',
            'type' => 'wysiwyg'
        ));

        $sbc_client->add_field(array(
            'name' => 'Правила',
            'id'   => $prefix . 'residence',
            'type' => 'wysiwyg',
        ));

        $sbc_client->add_field(array(
            'name' => 'Включить таб "Цены" ?',
            'id'   => $prefix . 'price_tab_checkbox',
            'type' => 'checkbox'
        ));

        $sbc_client->add_field(array(
            'name' => 'Текст для таба "Цены"',
            'id'   => $prefix . 'price_tab_text',
            'type' => 'wysiwyg'
        ));

        $sbc_client->add_field(array(
            'name' => 'Открывать в новой вкладке',
            'id'   => 'new_page',
            'type' => 'checkbox'
        ));

    }

    add_action('cmb2_admin_init', 'mastak_opportunity_metabox');

    function mastak_opportunity_submenu_page() {

        $prefix = 'mastak_opportunity_submenu_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы услуг', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_opportunities_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=opportunity',
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
            'desc' => __('Подзаголовок на странице Услуги', 'krasnagorka'),
            'id'   => $prefix . 'header_sub_title_1',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок №2', 'krasnagorka'),
            'desc' => __('Подзаголовок на странице Услуги', 'krasnagorka'),
            'id'   => $prefix . 'header_sub_title_2',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710) на странице Услуги', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => 'Услуги текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
        ));

        $group_field_event = $cmb_options->add_field(array(
            'id'          => 'scope',
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество базовых услуг', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Базовые услуги {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Услугу', 'krasnagorka'),
                'remove_button' => __('Удалить Услугу', 'krasnagorka'),
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
            'name' => 'Иконка',
            'desc' => __('Картинка (300 x 300) белого цвета', 'krasnagorka'),
            'id'   => 'item_icon',
            'type' => 'file'
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

    add_action('cmb2_admin_init', 'mastak_opportunity_submenu_page');

    function mastak_house_submenu_page() {

        $prefix = 'mastak_house_submenu_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы домов', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_houses_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=house',
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
            'name' => __('Подзаголовок', 'krasnagorka'),
            'desc' => __('Аренда дома на Браславских озерах', 'krasnagorka'),
            'id'   => 'subtitle_1',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710) на странице Услуги', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок', 'krasnagorka'),
            'desc' => __('Под списком домов', 'krasnagorka'),
            'id'   => 'subtitle_2',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
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

    add_action('cmb2_admin_init', 'mastak_house_submenu_page');

    function mastak_price_submenu_page() {

        $prefix = 'mastak_price_submenu_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы цен', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_price_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=page',
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
            'name' => __('Шапка Баннер', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710) на странице Цены', 'krasnagorka'),
            'id'   => $prefix . 'header_image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
        ));


        $cmb_options->add_field(array(
            'name' => __('Прайс лист на рыбалку', 'krasnagorka'),
            'id'   => 'fishing_title',
            'type' => 'title',
        ));

        $group_field_fishing = $cmb_options->add_field(array(
            'id'          => 'fishing_group',
            'type'        => 'group',
            'description' => __('Прайс лист на рыбалку', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Услуга {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Услугу', 'krasnagorka'),
                'remove_button' => __('Удалить Услугу', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_options->add_group_field($group_field_fishing, array(
            'name' => 'Заголовок',
            'id'   => 'name',
            'type' => 'text',
        ));

        $cmb_options->add_group_field($group_field_fishing, array(
            'name' => 'Описание',
            'id'   => 'subtitle',
            'type' => 'text',
        ));

        $cmb_options->add_group_field($group_field_fishing, array(
            'name'         => 'Стоимость услуги',
            'id'           => 'price',
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $cmb_options->add_field(array(
            'name' => __('Прайс лист на рыбалку (Документ)', 'krasnagorka'),
            'id'   => 'fishing_doc_title',
            'type' => 'title',
        ));


        $cmb_options->add_field(array(
            'name' => __('Прайс на рыбалку', 'krasnagorka'),
            'desc' => __('Документ прайс на рыбалку', 'krasnagorka'),
            'id'   => $prefix . 'fishing_price',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => __('Прайс на охоту', 'krasnagorka'),
            'desc' => __('Документ прайс на охоту', 'krasnagorka'),
            'id'   => $prefix . 'hunting_price',
            'type' => 'file',
        ));
    }

    add_action('cmb2_admin_init', 'mastak_price_submenu_page');

    function mastak_home_page() {

        $prefix = 'mastak_home_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки домашней страницы', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_home_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=page',
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
            'name' => 'Секция слайдера',
            'id'   => 'slider_t',
            'type' => 'title'
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

        $main_banner_event = $cmb_options->add_field(array(
            'id'          => 'main_slider',
            'type'        => 'group',
            'description' => __('Главный баннер (можно добавлять любое количество слайдов)', 'krasnagorka'),
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

        $cmb_options->add_group_field($main_banner_event, array(
            'name' => 'Заголовок слайда',
            'id'   => 'slide_title',
            'type' => 'text'
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name' => 'Подзаголовок слайда',
            'id'   => 'slide_description',
            'type' => 'text'
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name' => 'Кнопка слайда (название)',
            'id'   => 'slide_button_title',
            'type' => 'text'
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name' => 'Url кнопки слайда (url)',
            'id'   => 'slide_button_url',
            'type' => 'text_url'
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name'        => 'Открывать в новой вкладе',
            'description' => __('Открывать в новой вкладе', 'krasnagorka'),
            'id'          => 'slide_button_open_type',
            'type'        => 'checkbox',
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name'        => 'Использовать видео',
            'description' => __('Использовать видео', 'krasnagorka'),
            'id'          => 'use_video',
            'type'        => 'checkbox',
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name'        => 'Картинка слайда',
            'description' => __('Картинка слайда (2700x1800)', 'krasnagorka'),
            'id'          => 'slide_image',
            'type'        => 'file'
        ));

        $cmb_options->add_group_field($main_banner_event, array(
            'name'        => 'Видео слайд',
            'description' => __('Видео слайд', 'krasnagorka'),
            'id'          => 'slide_video',
            'type'        => 'file',
        ));


        $cmb_options->add_field(array(
            'name' => 'Секция услуги',
            'id'   => 'opportunity_t',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок', 'krasnagorka'),
            'id'   => $prefix . 'subtitle_1',
            'type' => 'text',
        ));

        $opportunity_home = $cmb_options->add_field(array(
            'id'          => 'opportunity_home',
            'type'        => 'group',
            'description' => __('Услуги', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Услуга {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Услугу', 'krasnagorka'),
                'remove_button' => __('Удалить Услугу', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_options->add_group_field($opportunity_home, array(
            'name'             => 'Услуга',
            'id'               => 'main_opportunity',
            'type'             => 'select',
            'options_cb'       => 'show_service_options',
        ));

        $cmb_options->add_field(array(
            'name' => 'Секция слайдера "О нас"',
            'id'   => 'portfolio_t',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок', 'krasnagorka'),
            'id'   => $prefix . 'subtitle_2',
            'type' => 'text',
        ));


        $cmb_options->add_field(array(
            'name'            => 'Скорость слайдера',
            'id'              => 'portfolio_slider_delay',
            'description'     => __('В милисекундах (2000 = 2 сек)', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ));

        $portfolio_slider_event = $cmb_options->add_field(array(
            'id'          => 'portfolio_slider',
            'type'        => 'group',
            'description' => __('Слайдер "О нас" (картинки)', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Картинка {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Картинку', 'krasnagorka'),
                'remove_button' => __('Удалить Картинку', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_options->add_group_field($portfolio_slider_event, array(
            'name'        => 'Картинка',
            'description' => __('Картинка (2000x1400)', 'krasnagorka'),
            'id'          => 'portfolio_image',
            'type'        => 'file',
        ));

        $cmb_options->add_group_field($portfolio_slider_event, array(
            'name' => 'Описание',
            'id'   => 'portfolio_description',
            'type' => 'textarea',
        ));

        $cmb_options->add_field(array(
            'name' => __('Заголовок секции "Пройти тест"', 'krasnagorka'),
            'desc' => __('Заголовок секции пройти тест', 'krasnagorka'),
            'id'   => $prefix . 'get_test_title',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок секции "Пройти тест"', 'krasnagorka'),
            'desc' => __('Подзаголовок секции пройти тест', 'krasnagorka'),
            'id'   => $prefix . 'get_test_description',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Название кнопки секции "Пройти тест"', 'krasnagorka'),
            'desc' => __('Название кнопки секции пройти тест', 'krasnagorka'),
            'id'   => $prefix . 'get_test_button_name',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Ссылка кнопки секции "Пройти тест"', 'krasnagorka'),
            'desc' => __('Ссылка кнопки секции пройти тест', 'krasnagorka'),
            'id'   => $prefix . 'get_test_button_url',
            'type' => 'text_url',
        ));

        $cmb_options->add_field(array(
            'name' => __('Картинка на фоне секции "Пройти тест"', 'krasnagorka'),
            'desc' => __('Картинка на фоне секции пройти тест (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'parallax_image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => 'Секция "Хотите забронировать?"',
            'id'   => 'need_more_t',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Заголовок', 'krasnagorka'),
            'id'   => $prefix . 'need_more_title',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Описание', 'krasnagorka'),
            'id'   => $prefix . 'need_more_description',
            'type' => 'textarea',
        ));

        $cmb_options->add_field(array(
            'name' => __('Название кнопки', 'krasnagorka'),
            'id'   => $prefix . 'need_more_link_title',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Ссылка кнопки', 'krasnagorka'),
            'id'   => $prefix . 'need_more_link',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Картинка', 'krasnagorka'),
            'id'   => $prefix . 'need_more_img',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
        ));

    }

    add_action('cmb2_admin_init', 'mastak_home_page');

    /**
     * Gets a number of posts and displays them as options
     *
     * @param  array $query_args Optional. Overrides defaults.
     *
     * @return array             An array of options that matches the CMB2 options array
     */
    function cmb2_get_post_options($query_args) {

        $args = wp_parse_args($query_args, array(
            'post_type'   => 'post',
            'numberposts' => 10,
        ));

        $posts = get_posts($args);

        $post_options = array();
        if ($posts) {
            foreach ($posts as $post) {
                $post_options[$post->ID] = $post->post_title;
            }
        }

        return $post_options;
    }

    /**
     * Gets 5 posts for your_post_type and displays them as options
     * @return array An array of options that matches the CMB2 options array
     */
    function cmb2_get_opportunity_post_options() {
        return cmb2_get_post_options(array('post_type' => 'opportunity', 'numberposts' => -1));
    }


    add_action('cmb2_admin_init', 'mastak_price_submenu_page');

    function mastak_map_page() {

        $prefix = 'mastak_map_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы карты', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_map_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=page',
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
            'name' => __('Картинка в шапке', 'krasnagorka'),
            'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
            'id'   => $prefix . 'image',
            'type' => 'file',
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область для домов',
            'id'   => $prefix . 'big_text_houses',
            'type' => 'wysiwyg'
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область для услуг',
            'id'   => $prefix . 'big_text_opportunities',
            'type' => 'wysiwyg'
        ));

    }

    add_action('cmb2_admin_init', 'mastak_map_page');


    function news_page() {

        $prefix = 'news_page_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'settings',
            'title'        => esc_html__('Настройки страницы новостей', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'news_page_appearance_options',
            // The option key and admin menu page slug.
            // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            'parent_slug'  => 'edit.php?post_type=page',
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
            'name' => __('Заголовок для тектовой области', 'krasnagorka'),
            'id'   => $prefix . 'big_text_title',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => 'Текстовая область',
            'id'   => $prefix . 'big_text',
            'type' => 'wysiwyg'
        ));

    }

    add_action('cmb2_admin_init', 'news_page');

    function show_house_options() {

        $query = new WP_Query(array(
            'post_type'      => 'house',
            'posts_per_page' => -1,
            'post_status' => array("publish")
        ));

        $house = [];
        $posts = $query->get_posts();
        foreach ($posts as $post) {
            $house[$post->ID] = $post->post_title;
        }

        return $house;
    }

    function cmb2_get_term_options( $field ) {
        $args = $field->args( 'get_terms_args' );
        $args = is_array( $args ) ? $args : array();
    
        $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );
    
        $taxonomy = $args['taxonomy'];
    
        $terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
            ? get_terms( $args )
            : get_terms( $taxonomy, $args );
    
        // Initate an empty array
        $term_options = array();
        if ( ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                $term_options[ $term->term_id ] = $term->name;
            }
        }
    
        return $term_options;
    }

    function show_event_options() {

        $query = new WP_Query(array(
            'post_type'      => 'event',
            'posts_per_page' => -1
        ));

        $events = [];
        $posts = $query->get_posts();
        foreach ($posts as $post) {
            $events[$post->ID] = $post->post_title;
        }

        return $events;
    }

    function show_service_options() {

        $query = new WP_Query(array(
            'post_type'      => 'opportunity',
            'posts_per_page' => -1
        ));

        $services = [];
        $posts    = $query->get_posts();
        foreach ($posts as $post) {
            $services[$post->ID] = $post->post_title;
        }

        return $services;
    }

    function show_events_tabs_options() {

        $query = new WP_Query(array(
            'post_type'      => 'event_tab',
            'posts_per_page' => -1
        ));

        $services = [];
        $posts    = $query->get_posts();
        foreach ($posts as $post) {
            $services[$post->ID] = $post->post_title;
        }

        return $services;
    }


    require_once __DIR__ . '/cmb2/terem.php';
    require_once __DIR__ . '/cmb2/season.php';
    require_once __DIR__ . '/cmb2/event.php';
    require_once __DIR__ . '/cmb2/event_tabs.php';
    require_once __DIR__ . '/cmb2/calendars.php';