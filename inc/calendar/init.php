<?php


$theme_path = get_stylesheet_directory();
$theme_uri = get_stylesheet_directory_uri();

define( 'CALENDAR_ROOT', $theme_path . '/inc/calendar/' );
define( 'CALENDAR_ROOT_URI', $theme_uri . '/inc/calendar/' );
define( 'CALENDAR_VENDOR', $theme_path . '/inc/calendar/vendor/' );
define( 'CALENDAR_VENDOR_URI', $theme_uri . '/inc/calendar/vendor/' );

require( CALENDAR_VENDOR . 'init.php' );


require( CALENDAR_ROOT . 'functions.php' );

require( CALENDAR_ROOT . 'admin/types.php' );

require( CALENDAR_ROOT . 'admin/fields.php' );