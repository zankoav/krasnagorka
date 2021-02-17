<?php
    require __DIR__ . '/LS_Booking_Form_Controller.php';

    add_action('rest_api_init', function () {
        (new LS_Booking_Form_Controller())->register_routes();
    });