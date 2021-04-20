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

	register_post_type(
		'sale',
		array(
			'label'               => null,
			'labels'              => array(
				'name'               => 'Cкидка', // основное название для типа записи
				'singular_name'      => 'Cкидка', // название для одной записи этого типа
				'add_new'            => 'Добавить Cкидку', // для добавления новой записи
				'add_new_item'       => 'Добавить Cкидку', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактировать Cкидку', // для редактирования типа записи
				'new_item'           => 'Новая Cкидка', // текст новой записи
				'view_item'          => 'Посмотреть Cкидку', // для просмотра записи этого типа.
				'search_items'       => 'Искать Cкидку', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Cкидки', // название меню
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
			'menu_icon'           => 'dashicons-buddicons-groups',
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

	$cmb_season = new_cmb2_box(array(
		'id'           => 'seasons_option',
		'title'        => esc_html__('Настройка Цен Сезона', 'krasnagorka'),
		'object_types' => array('season'), // Post type
	));

	foreach ($houses as $house_id => $house_title) {
		$cmb_season->add_field(array(
			'name' => __($house_title, 'krasnagorka'),
			'id'   =>  'house_price_' . $house_id,
			'type'         => 'text_money',
			'before_field' => 'BYN'
		));
		$cmb_season->add_field(array(
			'name' => "$house_title (мин. кол-во людей)",
			'id'   =>  'house_min_people_' . $house_id,
			'type'            => 'text_small',
		));
	}

	$cmb_season->add_field(array(
		'name'            => 'Порядок',
		'id'              => 'season_order',
		'description'     => __('Сортировка чем больше - тем выше в списке (0 до 100)', 'krasnagorka'),
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
		'name'          => 'Начало',
		'id'            => 'season_from',
		'type' 			=> 'text',
		'attributes' 	=> array(
			'readonly' => 'readonly'
		)
	));

	$cmb_season->add_field(array(
		'name'          => 'Конец',
		'id'            => 'season_to',
		'type' 			=> 'text',
		'attributes' 	=> array(
			'readonly' => 'readonly'
		)
	));

	$cmb_season->add_field(array(
		// 'name'          => 'Сезон',
		'id'            => 'season_id',
		'type' 			=> 'title',
		'description' => 'OK',
		'label_cb' => 'season_display_cb',
		'column' => array(
			'position' => 2,
			'name'     => 'Сезон',
		),
		'display_cb' => 'season_display_cb',
		'escape_cb' => 'season_escape_cb',
	));

	$cmb_season->add_field(array(
		'name'          => 'Блокировать оплату',
		'id'            => 'season_bloked',
		'type' 			=> 'checkbox'
	));
}


add_action('cmb2_admin_init', 'mastak_sales');

function mastak_sales()
{

	$cmb_sale = new_cmb2_box(array(
		'id'           => 'sale_option',
		'title'        => esc_html__('Локализация скидки', 'krasnagorka'),
		'object_types' => array('sale'), // Post type
	));

	$cmb_sale->add_field(array(
		'name'          => 'Календарь',
		'id'            => 'sale_calendar',
		'type'           => 'select',
		'show_option_none' => true,
		'default'          => 'custom',
		'options_cb'     => 'cmb2_get_term_options',
		'get_terms_args' => array(
			'taxonomy'   => 'sbc_calendars',
			'hide_empty' => false,
		),
		'attributes' => array(
			'data-validation' => 'required',
		),
	));

	$cmb_sale->add_field(array(
		'name'          => 'Сезон',
		'id'            => 'sale_season',
		'type'             => 'select',
		'show_option_none' => true,
		'default'          => 'custom',
		'options_cb'       => 'show_seasons_options',
		'attributes' => array(
			'data-validation' => 'required',
		),
	));

	$cmb_sale->add_field(array(
		'name'          => 'Настройки скидки',
		'id'            => 'settings_title_id',
		'type' 			=> 'title'
	));

	$cmb_sale->add_field(array(
		'name'          => 'Человек >=',
		'id'            => 'sale_people_min',
		'type' 			=> 'text_small'
	));

	$cmb_sale->add_field(array(
		'name'          => 'Дней >=',
		'id'            => 'sale_days_min',
		'type' 			=> 'text_small'
	));

	$cmb_sale->add_field(array(
		'name'          => 'Процент',
		'id'            => 'sale_percentage',
		'type' 			=> 'text_small',
		'attributes'      => array(
			'type'    => 'number',
			'min' => '1',
			'data-validation' => 'required'
		),
		'after_field' => '%'
	));

	$cmb_sale->add_field(array(
		'name'          => 'Подсказка о скидке',
		'id'            => 'sale_help_message',
		'type' 			=> 'textarea_small',
		'attributes' => array(
			'data-validation' => 'required',
		),
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
