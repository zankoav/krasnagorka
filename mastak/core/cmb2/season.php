<?php

add_action('init', 'register_post_type_team_member');
function register_post_type_team_member()
{
    register_post_type(
        'season',
        array(
            'label'               => null,
            'labels'              => array(
                'name'               => 'Сезоны', // основное название для типа записи
                'singular_name'      => 'Сезон', // название для одной записи этого типа
                'add_new'            => 'Добавить Сезон', // для добавления новой записи
                'add_new_item'       => 'Добавить Сезон', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактировать Сезон', // для редактирования типа записи
                'new_item'           => 'Новый Сезон', // текст новой записи
                'view_item'          => 'Посмотреть Сезон', // для просмотра записи этого типа.
                'search_items'       => 'Искать Сезон', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Сезоны', // название меню
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
            'menu_position'       => 6,
            //    'menu_icon'           => null,
            'menu_icon'           => 'dashicons-admin-customizer',
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
        )
    );

    register_post_type(
        'season_interval',
        array(
            'label'               => null,
            'labels'              => array(
                'name'               => 'Сезонный интервал', // основное название для типа записи
                'singular_name'      => 'Сезонный интервал', // название для одной записи этого типа
                'add_new'            => 'Добавить Сезонный интервал', // для добавления новой записи
                'add_new_item'       => 'Добавить Сезонный интервал', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактировать Сезонный интервал', // для редактирования типа записи
                'new_item'           => 'Новый Сезонный интервал', // текст новой записи
                'view_item'          => 'Посмотреть Сезонный интервал', // для просмотра записи этого типа.
                'search_items'       => 'Искать Сезонный интервал', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Сезонные интервалы', // название меню
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
            'menu_position'       => 7,
            //    'menu_icon'           => null,
            'menu_icon'           => 'dashicons-sticky',
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            //'hierarchical'        => false,
            'supports'            => ['page-attributes'],
            // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            //'taxonomies'          => array(),
            'has_archive'         => false,
            'rewrite'             => false,
            'query_var'           => true,
        )
    );
}

add_action('cmb2_admin_init', 'mastak_season');

function mastak_season()
{
    $houses = show_house_options();

    $calendarsFromTerem = [
        'Терем 1' => 18,
        'Терем 2' => 19,
        'Терем 3' => 20,
        'Терем 4' => 21,
        'Терем 5' => 22,
        'Терем 6' => 23,
        'Терем 7' => 24,
        'Терем 8' => 25,
        'Терем 9' => 26,
        'Терем 10' => 27,
        'Терем 11' => 28,
        'Терем 12' => 29
    ];

    $cmb_season_main = new_cmb2_box(array(
        'id'           => 'season_option',
        'title'        => esc_html__('Настройка Сезона', 'krasnagorka'),
        'object_types' => array('season'), // Post type
    ));

    $cmb_season_main->add_field(array(
        'name'          => 'Цвет сезона',
        'id'            => 'season_color',
        'type'          => 'colorpicker',
        'attributes'    => array(
            'readonly' => 'readonly'
        )
    ));

    $cmb_season_main->add_field(array(
        'name'          => 'Отключить функционал день в день',
        'id'            => 'season_day_per_day_off',
        'type'          => 'checkbox'
    ));


    $cmb_season = new_cmb2_box(array(
        'id'           => 'seasons_option',
        'title'        => esc_html__('Настройка Цен Сезона', 'krasnagorka'),
        'object_types' => array('season'), // Post type
    ));

    foreach ($houses as $house_id => $house_title) {
        $cmb_season->add_field(array(
            'name' => $house_title,
            'id'   =>  'house_title_id_' . $house_id,
            'type'            => 'title',
        ));
        $cmb_season->add_field(array(
            'name' => __("$house_title (Базовая стоимость в день)", 'krasnagorka'),
            'id'   =>  'house_price_' . $house_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));
        $cmb_season->add_field(array(
            'name' => "$house_title (мин. кол-во людей)",
            'id'   =>  'house_min_people_' . $house_id,
            'type'            => 'text_small',
        ));

        // $cmb_season->add_field(array(
        //     'name' => "$house_title (мин. кол-во дней без надбавки)",
        //     'id'   =>  'house_min_days_' . $house_id,
        //     'type'            => 'text_small',
        // ));

        // $cmb_season->add_field(array(
        //     'name' => "$house_title (надбавка на меньшее кол-во дней)",
        //     'id'   =>  'house_min_percent_' . $house_id,
        //     'type'            => 'text_small',
        //     'after_field' => '%'
        // ));

        $cmb_season->add_field(array(
            'name' => "$house_title (Кошки и собаки мелких пород (высота в холке до 40 см))",
            'description' => '<= 30см в холке',
            'id'   =>  'house_small_animal_price_' . $house_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $cmb_season->add_field(array(
            'name' => "$house_title (Собаки крупных пород (высота в холке более 40 см))",
            'description' => '> 30см в холке',
            'id'   =>  'house_big_animal_price_' . $house_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));


        $group_field_event = $cmb_season->add_field(array(
            'id'          => 'house_people_for_sale_' . $house_id,
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество скидок от количества ЧЕЛОВЕК', 'krasnagorka'),
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

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Мин. кол-во человек',
            'id'   => 'sale_people',
            'type' => 'text_small',
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Скидка',
            'id'   => 'sale_percent',
            'type' => 'text_small',
            'after_field' => '%'
        ));

        $group_field_event = $cmb_season->add_field(array(
            'id'          => 'house_days_count_upper_' . $house_id,
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество надбавок от количества НОЧЕЙ', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Надбавка {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Надбавку', 'krasnagorka'),
                'remove_button' => __('Удалить Надбавку', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Мин. кол-во ночей',
            'id'   => 'sale_day',
            'type' => 'text_small',
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Надбавка',
            'id'   => 'upper_percent',
            'type' => 'text_small',
            'after_field' => '%'
        ));
    }


    foreach ($calendarsFromTerem as $room_name => $room_id) {

        $cmb_season->add_field(array(
            'name' => $room_name,
            'id'   =>  'room_title_id_' . $room_id,
            'type'            => 'title',
        ));

        $cmb_season->add_field(array(
            'name' => __("$room_name (Базовая стоимость в день)", 'krasnagorka'),
            'id'   =>  'room_price_' . $room_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $cmb_season->add_field(array(
            'name' => "$room_name (мин. кол-во людей)",
            'id'   =>  'room_min_people_' . $room_id,
            'type'            => 'text_small',
        ));

        // $cmb_season->add_field(array(
        //     'name' => "$room_name (мин. кол-во дней без надбавки)",
        //     'id'   =>  'room_min_days_' . $room_id,
        //     'type'            => 'text_small',
        // ));

        // $cmb_season->add_field(array(
        //     'name' => "$room_name (надбавка на меньшее кол-во дней)",
        //     'id'   =>  'room_min_percent_' . $room_id,
        //     'type'            => 'text_small',
        //     'after_field' => '%'
        // ));

        $cmb_season->add_field(array(
            'name' => "$room_name (Кошки и собаки мелких пород (высота в холке до 40 см))",
            'description' => '<= 30см в холке',
            'id'   =>  'room_small_animal_price_' . $room_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $cmb_season->add_field(array(
            'name' => "$room_name (Собаки крупных пород (высота в холке более 40 см))",
            'description' => '> 30см в холке',
            'id'   =>  'room_big_animal_price_' . $room_id,
            'type'         => 'text_money',
            'before_field' => 'BYN'
        ));

        $group_field_event = $cmb_season->add_field(array(
            'id'          => 'room_people_for_sale_' . $room_id,
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество скидок от количества человек', 'krasnagorka'),
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

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Мин. кол-во человек',
            'id'   => 'sale_people',
            'type' => 'text_small',
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Скидка',
            'id'   => 'sale_percent',
            'type' => 'text_small',
            'after_field' => '%'
        ));

        $group_field_event = $cmb_season->add_field(array(
            'id'          => 'room_days_count_upper_' . $room_id,
            'type'        => 'group',
            'description' => __('Можно добавлять любое количество надбавок от количества НОЧЕЙ', 'krasnagorka'),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __('Надбавка {#}', 'krasnagorka'),
                // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __('Добавить Надбавку', 'krasnagorka'),
                'remove_button' => __('Удалить Надбавку', 'krasnagorka'),
                'sortable'      => true,
                // beta
                'closed'        => true, // true to have the groups closed by default
            ),
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Мин. кол-во ночей',
            'id'   => 'sale_day',
            'type' => 'text_small',
        ));

        $cmb_season->add_group_field($group_field_event, array(
            'name' => 'Надбавка',
            'id'   => 'upper_percent',
            'type' => 'text_small',
            'after_field' => '%'
        ));
    }


    $cmb_season->add_field(array(
        'name'            => 'Порядок',
        'id'              => 'season_order',
        'description'     => __('Сортировка чем больше - тем выше в списке (0 до 100). Тольео для страницы форма бронирования', 'krasnagorka'),
        'type'            => 'text',
        'attributes'      => array(
            'type'    => 'number',
            'pattern' => '\d*'
        ),
        'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint'
    ));
}

add_action('cmb2_admin_init', 'mastak_season_interval');

function mastak_season_interval()
{

    $cmb_season = new_cmb2_box(array(
        'id'           => 'seasons_interval_option',
        'title'        => esc_html__('Сезонный Интервал', 'krasnagorka'),
        'object_types' => array('season_interval'), // Post type
    ));

    $cmb_season->add_field(array(
        // 'name'          => 'Сезон',
        'id'            => 'season_id',
        'type'             => 'title',
        'classes' => 'width-300px',
        'label_cb' => 'season_display_cb',
        'column' => array(
            'position' => 2,
            'name'     => 'Сезон',
        ),
        'display_cb' => 'season_display_cb',
        'escape_cb' => 'season_escape_cb',
    ));

    $cmb_season->add_field(array(
        'name'          => 'Начало',
        'id'            => 'season_from',
        'type'             => 'text',
        'attributes'     => array(
            'readonly' => 'readonly'
        )
    ));

    $cmb_season->add_field(array(
        'name'          => 'Конец',
        'id'            => 'season_to',
        'type'             => 'text',
        'attributes'     => array(
            'readonly' => 'readonly'
        )
    ));

    $cmb_season->add_field(array(
        'name'          => 'Блокировать оплату',
        'id'            => 'season_bloked',
        'type'             => 'checkbox'
    ));
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function season_display_cb($field_args, $field)
{
?>
    <div class="custom-column-display <?php echo $field->row_classes(); ?>">
        <p><?= $field->escaped_value(); ?></p>
    </div>
<?php
}

function season_escape_cb($value, $field_args, $field)
{
    return get_the_title($value);
}

/**
 * Adds a submenu page under a custom post type parent.
 */
function season_register_page()
{
    add_submenu_page(
        'edit.php?post_type=season_interval',
        'Генератор сезонов',
        'Генератор сезонов',
        'manage_options',
        'season-generator',
        'season_ref_page_callback'
    );
}

/**
 * Display callback for the submenu page.
 */
function season_ref_page_callback()
{
    get_template_part("admin/season-interval", null, []);
}

add_action('admin_menu', 'season_register_page');
