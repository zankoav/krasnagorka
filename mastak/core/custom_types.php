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
                'name'               => 'Мероприятие', // Основное название типа записи
                'singular_name'      => __('Мероприятие'), // отдельное название записи типа Book
                'add_new'            => __('Добавить мероприятие'),
                'add_new_item'       => __('Добавить новое мероприятие'),
                'edit_item'          => __('Редактировать мероприятие'),
                'new_item'           => __('Новое мероприятие'),
                'view_item'          => __('Посмотреть мероприятие'),
                'search_items'       => __('Найти мероприятие'),
                'not_found'          => __('Мероприятий не найдено'),
                'not_found_in_trash' => __('В корзине мероприятия не найдено'),
                'menu_name'          => get_option('mastak_event_appearance_options')['breadcrumbs'],
                'items_archive'      => 'Мероприятия архив',
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'meropriyatiya', 'with_front' => false),
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
                'name'               => 'Таб Мероприятия', // Основное название типа записи
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

    function mastak_register_theme_options_metabox() {

        $prefix = 'mastak_theme_options_';
        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки темы (mastak)', 'krasnagorka'),
            'object_types' => array('options-page'),

            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */

            'option_key' => 'mastak_theme_options',
            // The option key and admin menu page slug.
            'icon_url'   => 'dashicons-palmtree',
            // Menu icon. Only applicable if 'parent_slug' is left empty.
            // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
            // 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
            // 'capability'      => 'manage_options', // Cap required to view options-page.
            // 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
            // 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
            // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
            // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
            // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
            // 'message_cb'      => 'yourprefix_options_page_message_callback',
            // 'tab_group'       => '', // Tab-group identifier, enables options page tab navigation.
            // 'tab_title'       => null, // Falls back to 'title' (above).
            // 'autoload'        => false, // Defaults to true, the options-page option will be autloaded.
        ));

        /**
         * Options fields ids only need
         * to be unique within this box.
         * Prefix is not needed.
         */

        $cmb_options->add_field(array(
            'name' => __('Выберите Сезон', 'krasnagorka'),
            'id'   => 'season_title',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name'             => 'Текущий сезон',
            'id'               => 'current_season',
            'type'             => 'select',
            'show_option_none' => true,
            'default'          => 'custom',
            'options_cb'       => 'show_seasons_options',
        ));

        $cmb_options->add_field(array(
            'name' => __('Контактная информация', 'krasnagorka'),
            'id'   => 'contacts_title',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => __('Видео online', 'krasnagorka'),
            'desc' => __('Видео online', 'krasnagorka'),
            'id'   => $prefix . 'video',
            'type' => 'checkbox'
        ));

        $cmb_options->add_field(array(
            'name' => __('Велком', 'krasnagorka'),
            'desc' => __('Номер телефона', 'krasnagorka'),
            'id'   => $prefix . 'velcome',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Мтс', 'krasnagorka'),
            'desc' => __('Номер телефона', 'krasnagorka'),
            'id'   => $prefix . 'mts',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Лайф', 'krasnagorka'),
            'desc' => __('Номер телефона', 'krasnagorka'),
            'id'   => $prefix . 'life',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Email', 'krasnagorka'),
            'desc' => __('Электронный адрес', 'krasnagorka'),
            'id'   => $prefix . 'email',
            'type' => 'text_email'
        ));

        $cmb_options->add_field(array(
            'name' => __('Address', 'krasnagorka'),
            'desc' => __('Адерес компании', 'krasnagorka'),
            'id'   => $prefix . 'address',
            'type' => 'textarea_small'
        ));

        $cmb_options->add_field(array(
            'name' => __('Координаты', 'krasnagorka'),
            'desc' => __('Координаты компании', 'krasnagorka'),
            'id'   => $prefix . 'coordinate',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Время работы', 'krasnagorka'),
            'desc' => __('Время работы (8:00-23:00)', 'krasnagorka'),
            'id'   => $prefix . 'time',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Выходные', 'krasnagorka'),
            'desc' => __('Выходные (без выходных)', 'krasnagorka'),
            'id'   => $prefix . 'weekend',
            'type' => 'text'
        ));

        $cmb_options->add_field(array(
            'name' => __('Как доехать?', 'krasnagorka'),
            'desc' => __('Как доехать? (url)', 'krasnagorka'),
            'id'   => $prefix . 'location',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => __('Как забронировать?', 'krasnagorka'),
            'desc' => __('Как забронировать? (url)', 'krasnagorka'),
            'id'   => $prefix . 'booking',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => __('Популярные вопросы', 'krasnagorka'),
            'desc' => __('Популярные вопросы FAQ (url)', 'krasnagorka'),
            'id'   => $prefix . 'faq',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Instagram',
            'desc' => 'Instagram (url)',
            'id'   => $prefix . 'instagram',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Facebook',
            'desc' => 'Facebook (url)',
            'id'   => $prefix . 'facebook',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Odnoklassniki',
            'desc' => 'Odnoklassniki (url)',
            'id'   => $prefix . 'odnoklassniki',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Vkontakte',
            'desc' => 'Vkontakte (url)',
            'id'   => $prefix . 'vkontakte',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Youtube',
            'desc' => 'Youtube (url)',
            'id'   => $prefix . 'youtube',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Схема базы домов',
            'id'   => $prefix . 'schema',
            'type' => 'file'
        ));

        $cmb_options->add_field(array(
            'name' => 'Схема базы услуг',
            'id'   => $prefix . 'schema_2',
            'type' => 'file'
        ));

        $cmb_options->add_field(array(
            'name' => 'Способы оплаты',
            'desc' => 'Способы оплаты',
            'id'   => $prefix . 'paymants',
            'type' => 'file_list',
            // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
            // 'query_args' => array( 'type' => 'image' ), // Only images attachment
            // Optional, override default text strings
            'text' => array(
                'add_upload_files_text' => 'Добавит или загрузить логотип', // default: "Add or Upload Files"
                'remove_image_text'     => 'Удалить логотип', // default: "Remove Image"
                'file_text'             => 'Файл', // default: "File:"
                'file_download_text'    => 'Загрузить', // default: "Download"
                'remove_text'           => 'Удалить', // default: "Remove"
            ),
        ));

        $cmb_options->add_field(array(
            'name' => 'УНП',
            'desc' => 'УНП (optional)',
            'id'   => $prefix . 'unp',
            'type' => 'textarea_code'
        ));

        $cmb_options->add_field(array(
            'name' => __('Email комментариев', 'krasnagorka'),
            'desc' => __('При добавлении комментария сюда будет приходить оповещение', 'krasnagorka'),
            'id'   => $prefix . 'comment_email',
            'type' => 'text_email'
        ));

        $cmb_options->add_field(array(
            'name' => __('Доп. Email комментариев', 'krasnagorka'),
            'desc' => __('При добавлении комментария сюда будет приходить оповещение', 'krasnagorka'),
            'id'   => $prefix . 'comment_email_2',
            'type' => 'text_email'
        ));

        $cmb_options->add_field(array(
            'name' => __('Скрыть звезды в комментариях', 'krasnagorka'),
            'id'   => $prefix . 'hide_stars',
            'type' => 'checkbox'
        ));

        $cmb_options->add_field(array(
            'name'            => 'Скорость слайдера отзывов',
            'id'              => $prefix . 'slider_delay',
            'description'     => __('В милисекундах (2000 = 2 сек)', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ));

        $cmb_options->add_field(array(
            'name' => 'Страница 404',
            'id'   => 'title-404',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => 'Заголовок страницы',
            'id'   => 'title_404',
            'type' => 'textarea_small'
        ));

        $cmb_options->add_field(array(
            'name' => 'Подзаголовок страницы',
            'id'   => 'sub_title_404',
            'type' => 'textarea_small'
        ));

        $cmb_options->add_field(array(
            'name' => 'Картинка',
            'id'   => 'bgimage_404',
            'type' => 'file'
        ));

        $cmb_options->add_field(array(
            'name' => 'Логотип в подвале',
            'id'   => 'footer_logo',
            'type' => 'file'
        ));


        $cmb_options->add_field(array(
            'name' => __('Рекламный баннер в хлебных крошках', 'krasnagorka'),
            'id'   => 'breadcrumb_banner',
            'type' => 'title'
        ));

        $cmb_options->add_field(array(
            'name' => 'Включить баннер?',
            'id'   => 'breadcrumb_banner_is_open',
            'type' => 'checkbox'
        ));

        $cmb_options->add_field(array(
            'name' => 'Иконка баннера',
            'description' => 'Рекомендованно формат SVG, PNG',
            'id'   => 'breadcrumb_banner_img',
            'type' => 'file'
        ));

        $cmb_options->add_field(array(
            'name' => 'Текст баннера',
            'id'   => 'breadcrumb_banner_text',
            'type' => 'textarea_small'
        ));

        $cmb_options->add_field(array(
            'name' => 'Ссылка',
            'id'   => 'breadcrumb_banner_link',
            'type' => 'text_url'
        ));

        $cmb_options->add_field(array(
            'name' => 'Открывать в новом окне?',
            'id'   => 'breadcrumb_banner_is_target',
            'type' => 'checkbox'
        ));

        $cmb_options->add_field(array(
            'name'            => 'Задержка анимации',
            'id'              => 'breadcrumb_banner_animation_delay',
            'description'     => __('В милисекундах (1с = 1000мс)', 'krasnagorka'),
            'type'            => 'text',
            'attributes'      => array(
                'type'    => 'number',
                'pattern' => '\d*'
            ),
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint'
        ));

        $cmb_options->add_field(array(
            'name'    => __('Тип анимации', 'krasnagorka'),
            'desc'    => __('Выберите тип анимации', 'krasnagorka'),
            'id'      => 'breadcrumb_banner_animation_type',
            'type'    => 'select',
            'default' => 'fade',
            'options' => array(
                'fade'  => __('Плавное появление', 'krasnagorka'),
                'fade_blink_infinity' => __('Плавное появление и мерцание тексата', 'krasnagorka'),
                'fade_puls_icon' => __('Плавное появление и пульсация иконки', 'krasnagorka'),
            ),
        ));

    }

    add_action('cmb2_admin_init', 'mastak_register_theme_options_metabox');

    function mastak_house_metabox() {
        $prefix = 'mastak_house_';

        /**
         * Sample metabox to demonstrate each field type included
         */
        $sbc_client = new_cmb2_box(array(
            'id'           => $prefix . 'data',
            'title'        => esc_html__('Данные о доме', 'krasnagorka'),
            'object_types' => array('house',), // Post type
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
            'name' => 'Порядок проживание',
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
            'type' => 'textarea',
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
            'name' => 'Правила',
            'id'   => $prefix . 'residence',
            'type' => 'wysiwyg',
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
            'options_cb'       => 'show_seasons_options',
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

    function mastak_reviews_page() {

        $prefix = 'mastak_reviews_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы отзывов', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_reviews_appearance_options',
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
            'name' => __('Заголовок при успешной отправке комментария', 'krasnagorka'),
            'id'   => 'title_success',
            'type' => 'text',
        ));

        $cmb_options->add_field(array(
            'name' => __('Подзаголовок при успешной отправке комментария', 'krasnagorka'),
            'id'   => 'subtitle_success',
            'type' => 'textarea_small',
        ));

    }

    add_action('cmb2_admin_init', 'mastak_reviews_page');

    function mastak_booking_page() {

        $prefix = 'mastak_booking_';

        /**
         * Registers options page menu item and form.
         */
        $cmb_options = new_cmb2_box(array(
            'id'           => $prefix . 'page',
            'title'        => esc_html__('Настройки страницы бронирования', 'krasnagorka'),
            'object_types' => array('options-page'),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'mastak_booking_appearance_options',
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

    }

    add_action('cmb2_admin_init', 'mastak_booking_page');

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

    }

    add_action('cmb2_admin_init', 'mastak_map_page');


    function show_house_options() {

        $query = new WP_Query(array(
            'post_type'      => 'house',
            'posts_per_page' => -1
        ));

        $house = [];
        $posts = $query->get_posts();
        foreach ($posts as $post) {
            $house[$post->ID] = $post->post_title;
        }

        return $house;
    }

    function show_seasons_options() {

        $query = new WP_Query(array(
            'post_type'      => 'season',
            'posts_per_page' => -1
        ));

        $seasons = [];
        $posts   = $query->get_posts();
        foreach ($posts as $post) {
            $seasons[$post->ID] = $post->post_title;
        }

        return $seasons;
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