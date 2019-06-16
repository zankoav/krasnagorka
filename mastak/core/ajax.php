<?php
    function calendar_action() {
        if(isset($_POST['calendar'])){
            echo do_shortcode('[sbc_calendar id="28" slug="terem-11"]');
        }
        wp_die();
    }
    add_action( 'wp_ajax_calendar_action', 'calendar_action' );
    add_action( 'wp_ajax_nopriv_calendar_action', 'calendar_action' );

