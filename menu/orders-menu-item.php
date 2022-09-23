<?php

/**
 * Adds a submenu page under a custom post type parent.
 */
function order_view_page()
{
    add_menu_page( 'Заказы на ближайшие 10 дней', 'Заказы', 'read', 'orders-view', 'orders_ref_page_callback', 'dashicons-palmtree', 1 );

}

/**
 * Display callback for the submenu page.
 */
function orders_ref_page_callback()
{
	get_template_part("admin/orders-view-page", null, []);
}

add_action('admin_menu', 'order_view_page');
