<?php
    function calendar_action() {
        if(isset($_POST['calendar'])){
            $calendar = str_replace('/', '', $_POST['calendar']);
            echo $calendar;//do_shortcode($_POST['calendar']);
        }
        wp_die();
    }
    add_action( 'wp_ajax_calendar_action', 'calendar_action' );
    add_action( 'wp_ajax_nopriv_calendar_action', 'calendar_action' );

