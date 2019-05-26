<?php

	add_action( 'after_setup_theme', 'mastak_register_nav_menu' );
	function mastak_register_nav_menu() {
		register_nav_menu( 'mastak', 'Мастак меню в шапке' );
	}

	// И там, где нужно выводим меню так:
	function mastak_nav_menu() {
		// main navigation menu
		$args = array(
			'theme_location'    => 'mastak',
		);

		// print menu
		wp_nav_menu( $args );
	}

	// Изменяет основные параметры меню
	add_filter( 'wp_nav_menu_args', 'filter_wp_menu_args' );
	function filter_wp_menu_args( $args ) {
		if ( $args['theme_location'] === 'mastak' ) {
			$args['container']  = false;
			$args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
			$args['menu_class'] = 'menu-main__list menu-list';
		}
		return $args;
	}
// Изменяем атрибут id у тега li
	add_filter( 'nav_menu_item_id', 'filter_menu_item_css_id', 10, 4 );
	function filter_menu_item_css_id( $menu_id, $item, $args, $depth ) {
		return $args->theme_location === 'mastak' ? '' : $menu_id;
	}
// Изменяем атрибут class у тега li
	add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes', 10, 4 );
	function filter_nav_menu_css_classes( $classes, $item, $args, $depth ) {
		if ( $args->theme_location === 'mastak' ) {
			$classes = [
				'menu-list__item'
			];

			if (in_array('menu-item-has-children', $item->classes)) {
				$classes[] = 'menu-list__item--submenu';
			}
		}
		return $classes;
	}


// Добавляем классы ссылкам
	add_filter( 'nav_menu_link_attributes', 'filter_nav_menu_link_attributes', 10, 4 );
	function filter_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
		if ( $args->theme_location === 'mastak' ) {
			$atts['class'] = 'menu-list__item-href';

			if (in_array('menu-item-has-children', $item->classes)) {
				$atts['class']  .= ' menu-list__item-href menu-list__item-href--submenu';
			}
			if ( $item->current ) {
				$atts['class'] .= ' menu-list__item-href--active';
			}
		}
		return $atts;
	}
