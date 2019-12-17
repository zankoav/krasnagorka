<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 11/22/19
     * Time: 2:39 PM
     */

    class Booking_Form_Controller extends WP_REST_Controller {

        public function register_routes() {
            $namespace = 'krasnagorka/v1';
            $path      = '/order/';

            register_rest_route($namespace, $path, [
                array(
                    'methods'             => 'POST',
                    'callback'            => array($this, 'create_order'),
                    'permission_callback' => array($this, 'create_order_permissions_check')
                ),
            ]);

            $amocrm_path = '/amocrm/';

            register_rest_route($namespace, $amocrm_path, [
                array(
                    'methods'             => 'POST',
                    'callback'            => array($this, 'booking_lead'),
                    'permission_callback' => array($this, 'booking_lead_permissions_check')
                ),
            ]);
        }

        public function create_order_permissions_check($request) {
            return true;
        }

        public function booking_lead_permissions_check($request) {
            return true;
        }

        public function booking_lead($request) {
            $type = $request['type'];
            $response = ['status' => 'error'];
            if ($type != 'remove') {
                $objectIds    = $request['objectIds'];
                $response['objectIds'] = $objectIds;
                $contactName = $request['contactName'];
                $dateFrom    = $request['dateFrom'];
                $dateTo      = $request['dateTo'];
                $totalPrice  = $request['totalPrice'];
                $havePayed   = $request['havePayed'];
                $comment     = $request['comment'];

                $post_data = array(
                    'post_title'   => $contactName . ' ' . date("Y-m-d H:i:s"),
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => 23,
                    'post_type'    => 'sbc_orders'
//                    'tax_input' => array('sbc_calendars' => $objectIds)
                );


                // Вставляем данные в БД
                $post_id = wp_insert_post(wp_slash($post_data));

                if( is_wp_error($post_id) ){
                    $response['message'] = $post_id->get_error_message();
                }
                else {
                    update_post_meta($post_id, 'sbc_order_client', $contactName);
                    update_post_meta($post_id, 'sbc_order_select', $type);
                    update_post_meta($post_id, 'sbc_order_start', $dateFrom);
                    update_post_meta($post_id, 'sbc_order_end', $dateTo);
                    update_post_meta($post_id, 'sbc_order_price', $totalPrice);
                    update_post_meta($post_id, 'sbc_order_prepaid', $havePayed);
                    update_post_meta($post_id, 'sbc_order_desc', $comment);
                    $response['status'] = 'success';
                    $response['orderId'] = $post_id;
                }
            }

            return new WP_REST_Response($response, 200);
        }

        public function create_order($request) {

            $spam = $request['message'];

            if (!empty($spam)) {
                return new WP_Error('Fail', 'Please call you administrator', array('status' => 404));
            }

            $href = 'https://krasnagorka.by/booking-form';
            $type = 'booking-form';
            $data = [
                'fio'          => $request['fio'],
                'phone'        => $request['phone'],
                'email'        => $request['email'],
                'dateStart'    => $request['dateStart'],
                'dateEnd'      => $request['dateEnd'],
                'bookingTitle' => $request['bookingTitle'],
                'bookingType'  => $request['bookingType'],
                'passportId'   => $request['passportId'],
                'comment'      => $request['comment'],
                'cid'          => $request['cid']
            ];

            require_once WP_PLUGIN_DIR . '/amo-integration/AmoIntegration.php';
            new AmoIntegration($type, $request['data'], $href);
            return new WP_REST_Response(['status' => $request['data']], 200);
        }

    }