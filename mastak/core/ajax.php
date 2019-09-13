<?php
    function calendar_action() {
        if (isset($_POST['id'], $_POST['slug'])) {
            $id   = $_POST['id'];
            $slug = $_POST['slug'];
            echo do_shortcode("[sbc_calendar id=\"$id\" slug=\"$slug\"]");
        }
        wp_die();
    }

    add_action('wp_ajax_calendar_action', 'calendar_action');
    add_action('wp_ajax_nopriv_calendar_action', 'calendar_action');

    function comments_action() {
        if (isset($_POST['range'])) {
            $range = $_POST['range'];
            echo json_encode(['range' => $range, 'status' => 1]);
        }
        wp_die();
    }

    add_action('wp_ajax_calendar_action', 'comments_action');
    add_action('wp_ajax_nopriv_calendar_action', 'comments_action');

