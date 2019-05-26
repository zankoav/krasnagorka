<?php


//require( trailingslashit( get_template_directory() ) . 'inc/calendar/admin/types.php' );

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

if ( file_exists( dirname( __FILE__ ) . '/cmb2-taxonomy/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2-taxonomy/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2-taxonomy/init.php';
}

if ( CALENDAR_VENDOR . 'cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php' ) {
    include_once CALENDAR_VENDOR . 'cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php';
}

