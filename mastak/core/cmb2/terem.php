<?php

	function mastak_terem_submenu_page() {

		$prefix = 'mastak_terem_';

		/**
		 * Registers options page menu item and form.
		 */
		$cmb_options = new_cmb2_box( array(
			'id'           => $prefix . 'page',
			'title'        => esc_html__( 'Настройка Терема', 'krasnagorka' ),
			'object_types' => array( 'options-page' ),
			/*
			 * The following parameters are specific to the options-page box
			 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			 */
			'option_key'   => 'mastak_terem_appearance_options',
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
		) );

		$cmb_options->add_field( array(
			'name' => __( 'Галерея', 'krasnagorka' ),
			'id'   => 'title_gallary',
			'type' => 'title',
		) );

		$group_field_event = $cmb_options->add_field( array(
			'id'      => 'gallary',
			'type'    => 'group',
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options' => array(
				'group_title'   => __( 'Ряд {#}', 'krasnagorka' ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Добавить Ряд', 'krasnagorka' ),
				'remove_button' => __( 'Удалить Ряд', 'krasnagorka' ),
				'sortable'      => true,
				// beta
				'closed'        => true, // true to have the groups closed by default
			),
		) );

		$cmb_options->add_group_field( $group_field_event, array(
			'name' => 'Заголовок',
			'desc' => 'Заголовок ряда картинок',
			'id'   => 'subtitle',
			'type' => 'textarea_small'
		) );

		$cmb_options->add_group_field( $group_field_event, array(
			'name' => 'Галерея',
			'desc' => 'Картинки ряда',
			'id'   => 'gallary',
			'type' => 'file_list'
		) );


		$cmb_options->add_field( array(
			'name' => __( 'Календари', 'krasnagorka' ),
			'id'   => 'title_kalendar',
			'type' => 'title',
		) );

		$group_field_kalendar = $cmb_options->add_field( array(
			'id'      => 'kalendar',
			'type'    => 'group',
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options' => array(
				'group_title'   => __( 'Терем {#}', 'krasnagorka' ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Добавить Терем', 'krasnagorka' ),
				'remove_button' => __( 'Удалить Терем', 'krasnagorka' ),
				'sortable'      => true,
				// beta
				'closed'        => true, // true to have the groups closed by default
			),
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Название',
			'id'   => 'title',
			'type' => 'text'
		) );


		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Описание',
			'id'   => 'description',
			'type' => 'textarea'
		) );
		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => __( 'Календарь', 'krasnagorka' ),
			'desc' => __( 'Календарь шорткод', 'krasnagorka' ),
			'id'   => 'calendar',
			'type' => 'text'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Картинка',
			'id'   => 'picture',
			'type' => 'file'
		) );

		// Icons description
		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Минимальное количество человек',
			'id'   => 'min_people',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Максимальное количество человек',
			'id'   => 'max_people',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество двухспальных кроватей',
			'id'   => 'double_bed',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество односпальных кроватей',
			'id'   => 'single_bed',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество сан. узлов с душем',
			'id'   => 'toilet_and_shower',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество сан. узлов',
			'id'   => 'toilet',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество спальных комнат',
			'id'   => 'bed_rooms',
			'type' => 'text_small'
		) );

		$cmb_options->add_group_field( $group_field_kalendar, array(
			'name' => 'Количество трех-спальных-двух-ярусных кроватей',
			'id'   => 'triple_bed',
			'type' => 'text_small'
		) );

	}

	add_action( 'cmb2_admin_init', 'mastak_terem_submenu_page' );