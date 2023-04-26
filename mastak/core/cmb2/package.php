<?php

add_action('init', 'register_post_type_package');

function register_post_type_package()
{
	register_post_type(
		'package',
		array(
			'label'               => null,
			'labels'              => array(
				'name'               => 'Пакетное предложение', // основное название для типа записи
				'singular_name'      => 'Пакет', // название для одной записи этого типа
				'add_new'            => 'Добавить Пакет', // для добавления новой записи
				'add_new_item'       => 'Добавить Пакет', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактировать Пакет', // для редактирования типа записи
				'new_item'           => 'Новый Пакет', // текст новой записи
				'view_item'          => 'Посмотреть Пакет', // для просмотра записи этого типа.
				'search_items'       => 'Искать Пакет', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Пакеты', // название меню
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
			'menu_position'       => 8,
			//    'menu_icon'           => null,
			'menu_icon'           => 'dashicons-buddicons-groups',
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

}

add_action('cmb2_admin_init', 'cmb_package');

function cmb_package()
{

	$cmb_package = new_cmb2_box(array(
		'id'           => 'package_option',
		'title'        => esc_html__('Настройка Пакетного тура', 'krasnagorka'),
		'object_types' => array('package')
    ));

	$cmb_package->add_field(array(
		'name'            => 'Начало пакетного тура',
		'id'              => 'package_start',
		'description'     => __('Дата включительно', 'krasnagorka'),
		'type'            => 'text_date',
		'attributes'      => array(
			'required'    => 'required'
		)
	));

	$cmb_package->add_field(array(
		'name'            => 'Конец пакетного тура',
		'id'              => 'package_end',
		'description'     => __('Дата включительно', 'krasnagorka'),
		'type'            => 'text_date',
		'attributes'      => array(
			'required'    => 'required'
		)
	));

    $cmb_package->add_field(array(
        'name'    => __( 'Копировать ссылку на форму бронирования', 'krasnagorka' ),
        'id'      => 'package_source',
        'type'    => 'package_link'
    ));
}

function cmb2_render_package_link_func( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		
    $view = '<div class="package-link"><button type="button" class="js-package-link button-secondary" data-id="'.$object_id.'">Копировать ссылку</button><p><a targe="_blank" href="https://krasnagorka.by/booking-form/?package-id='.$object_id.'">https://krasnagorka.by/booking-form/?package-id='.$object_id.'</a></p></div>';
    $view .= $field_type_object->_desc( true );
    echo $view;
}

add_action( 'cmb2_render_package_link', 'cmb2_render_package_link_func', 10, 5 );