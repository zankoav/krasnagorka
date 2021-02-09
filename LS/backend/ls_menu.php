<?php
	add_action( 'after_setup_theme', 'ls_register_nav_menu' );

	function ls_register_nav_menu() {
		register_nav_menu( 'ls', 'LS меню в шапке' );
	}
	function ls_nav_menu() {
		wp_nav_menu([
			'theme_location'    => 'ls'
		]);
	}

	// Изменяет основные параметры меню
	add_filter( 'wp_nav_menu_args', 'filter_wp_menu_args' );

	function filter_wp_menu_args( $args ) {
		if ( $args['theme_location'] === 'ls' ) {
			$args['container']  = false;
			$args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
			$args['menu_class'] = 'menu';
		}
		return $args;
	}
// Изменяем атрибут class у тега li
	add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes', 10, 4 );
	function filter_nav_menu_css_classes( $classes, $item, $args, $depth ) {
		if ( $args->theme_location === 'ls' ) {
			$classes = [
				'menu__item'
			];

			if (in_array('menu-item-has-children', $item->classes)) {
				$classes[] = 'menu__item-sub-menu';
			}
		}
		return $classes;
	}
	// Добавляем классы ссылкам
	add_filter( 'nav_menu_link_attributes', 'filter_nav_menu_link_attributes', 10, 4 );
	function filter_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
		if ( $args->theme_location === 'ls' ) {
			$atts['class'] = 'menu-list__item-href';

			if (in_array('menu-item-has-children', $item->classes)) {
				$atts['class'] = 'menu__item menu__item-sub-menu';
			}
			if ( $item->current ) {
				$atts['class']= 'menu__item menu__item_active';
			}
		}
		return $atts;
	}



	//Изменяем CSS вложенного ul
	add_filter( 'nav_menu_submenu_css_class', 'change_wp_nav_menu', 10, 3 );

	function change_wp_nav_menu( $classes, $args, $depth ) {
		$classes[] = 'menu__sub-menu';
		return $classes;
	}