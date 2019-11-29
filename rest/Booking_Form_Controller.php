<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 11/22/19
     * Time: 2:39 PM
     */

    class Booking_Form_Controller extends WP_REST_Controller {

        public function register_routes(){
            $namespace = 'krasnagorka/v1';
            $path = '/order/';

            register_rest_route( $namespace, $path, [
                array(
                    'methods'             => 'POST',
                    'callback'            => array( $this, 'create_order' ),
                    'permission_callback' => array( $this, 'create_order_permissions_check' )
                ),
            ]);
        }

        public function create_order_permissions_check($request) {
            return true;
        }

        public function create_order($request) {

            $spam = $request['message'];

            if (!empty($spam)) {
                return new WP_Error( 'Fail', 'Please call you administrator', array( 'status' => 404 ) );
            }

            $href = 'https://krasnagorka.by/booking-form';
            $type = 'booking-form';
            $data = [
                'fio' => $request['fio'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'dateStart' => $request['dateStart'],
                'dateEnd' => $request['dateEnd'],
                'bookingTitle' => $request['bookingTitle'],
                'bookingType' => $request['bookingType'],
                'passportId' => $request['passportId'],
                'comment' => $request['comment'],
                'cid' => $request['cid']
            ];

            require_once WP_PLUGIN_DIR.'/amo-integration/AmoIntegration.php';
            new AmoIntegration($type, $request['data'], $href);
            return new WP_REST_Response(['status'=> $request['data']], 200);
        }

    }