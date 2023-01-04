<?php

/**
 * Adds a submenu page under a custom post type parent.
 */
function telegram_bot_page()
{
    add_menu_page( 'Телеграм Бот', 'Телеграм Бот', 'read', 'telegram-bot', 'telegram_bot_ref_page_callback', 'dashicons-email-alt2', 2 );

}

/**
 * Display callback for the submenu page.
 */
function telegram_bot_ref_page_callback()
{
	get_template_part("admin/telegram-bot", null, []);
}

add_action('admin_menu', 'telegram_bot_page');
