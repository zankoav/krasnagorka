<?php
    require __DIR__ . '/Booking_Form_Controller.php';
    require __DIR__ . '/AmoCRM_Controller.php';

    add_action('rest_api_init', function () {
        (new Booking_Form_Controller())->register_routes();
        (new AmoCRM_Controller())->register_routes();
    });