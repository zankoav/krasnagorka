<?php

if (!defined('ABSPATH')) { exit; }

/**
 * Setup image sizes
 */
add_action( 'after_setup_theme', function(){

    add_image_size( 'icon-menu', 24, 24, false );

});