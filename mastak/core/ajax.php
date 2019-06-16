<?php
    function calendar_action() {
        if(isset($_POST['calendar']/*$_POST['id'], $_POST['slug']*/)){
            $id = 27;//$_POST['id'];
            $slug = "terem-10";$_POST['slug'];

            echo do_shortcode("[sbc_calendar id=\"$id\" slug=\"$slug\"]");
        }
        wp_die();
    }
    add_action( 'wp_ajax_calendar_action', 'calendar_action' );
    add_action( 'wp_ajax_nopriv_calendar_action', 'calendar_action' );

