<?php

/**
 * Created by PhpStorm.
 * User: alexandrzanko
 * Date: 11/22/19
 * Time: 2:39 PM
 */

class Booking_Form_Controller extends WP_REST_Controller
{

    public function register_routes()
    {
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

    public function create_order_permissions_check($request)
    {
        return true;
    }

    public function booking_lead_permissions_check($request)
    {
        return true;
    }

    public function booking_lead($request)
    {
        $response = $this->insertWPLead($request);
        return new WP_REST_Response($response, 200);
    }

    private function insertWPLead($request)
    {

        $type     = $request['type'];
        $orderId  = $request['orderId'];
        $response = ['status' => 'error'];
        $dateFrom = date("Y-m-d", strtotime($request['dateFrom']));
        $dateTo = date("Y-m-d", strtotime($request['dateTo']));
        $objectIds  = $request['objectIds'];

        $this->removeOrder($orderId);

        if ($type != 'remove' and empty($orderId) and !empty($objectIds)) {
            $kalendars = array_map('intval', $objectIds);
            $kalendars = array_unique($kalendars);
            $result = $this->isAvailableOrder($kalendars[0], $dateFrom, $dateTo);
            if (!$result) {
                $response['status'] = 'busy';
                return $response;
            }
        }

        if ($type != 'remove') {

            $totalPrice = $request['totalPrice'];
            $havePayed  = $request['havePayed'];
            $comment    = $request['comment'];

            $contactName   = $request['contactName'];
            $contactPhone  = $request['contactPhone'];
            $contactEmail  = $request['contactEmail'];
            $contactStatus = $request['contactStatus'];

            $client   = $this->get_post_by_meta(['meta_key' => 'sbc_client_phone', 'meta_value' => $contactPhone]);
            $clientId = null;
            $addedName   = empty($contactPhone) ? (empty($contactEmail) ? '' : $contactEmail) : $contactPhone;

            if (empty($client)) {
                $client_data = array(
                    'post_title'   => $contactName . ' ' . $addedName,
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => 23,
                    'post_type'    => 'sbc_clients'
                );
                // Вставляем данные в БД
                $clientId = wp_insert_post(wp_slash($client_data));
            } else {
                $clientPostArr = array();
                $clientPostArr['ID'] = $client->ID;
                $clientPostArr['post_title'] = $contactName . ' ' . $addedName;

                // Обновляем данные в БД
                wp_update_post(wp_slash($clientPostArr));
                $clientId = $client->ID;
            }

            if (!empty($contactEmail)) {
                update_post_meta($clientId, 'sbc_client_email', $contactEmail);
            }

            if (!empty($contactPhone)) {
                update_post_meta($clientId, 'sbc_client_phone', $contactPhone);
            }

            if (!empty($contactStatus)) {
                $contactStatusIds = [$contactStatus];
                $contactStatusIds = array_map('intval', $contactStatusIds);
                wp_set_object_terms($clientId, $contactStatusIds, 'sbc_clients_type');
            }

            $post_data = array(
                'post_title'   => date("Y-m-d H:i:s"),
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => 23,
                'post_type'    => 'sbc_orders'
            );

            // Вставляем данные в БД
            $post_id = wp_insert_post(wp_slash($post_data));

            if (is_wp_error($post_id)) {
                $response['message'] = $post_id->get_error_message();
            } else {
                if (!empty($contactName)) {
                    $contactTemplate = $clientId . " " . $contactName . " " . $contactPhone . " " . $contactEmail . " <a href='https://krasnagorka.by/wp-admin/post.php?post=" . $clientId . "&action=edit' target='_blank' class='edit-link'>Редактировать</a>";

                    update_post_meta($post_id, 'sbc_order_client', $contactTemplate);
                    $this->update_all_clients_orders($clientId, $contactTemplate);
                }
                if (!empty($type)) {
                    update_post_meta($post_id, 'sbc_order_select', $type);
                }
                if (!empty($dateFrom)) {
                    update_post_meta($post_id, 'sbc_order_start', $dateFrom);
                }
                if (!empty($dateTo)) {
                    update_post_meta($post_id, 'sbc_order_end', $dateTo);
                }
                if (!empty($totalPrice)) {
                    update_post_meta($post_id, 'sbc_order_price', $totalPrice);
                }
                if (!empty($havePayed)) {
                    update_post_meta($post_id, 'sbc_order_prepaid', $havePayed);
                }
                if (!empty($comment)) {
                    update_post_meta($post_id, 'sbc_order_desc', $comment);
                }

                if (!empty($objectIds)) {
                    $objectIds = array_map('intval', $objectIds);
                    $objectIds = array_unique($objectIds);
                    wp_set_object_terms($post_id, $objectIds, 'sbc_calendars');
                }

                $response['orderId'] = $post_id;
            }
        }

        $response['status'] = 'success';

        return $response;
    }

    private function update_all_clients_orders($clientId, $contactTemplate)
    {
        $args = array(
            'meta_query'     => array(
                array(
                    'key'   => 'sbc_order_client',
                    'value' => "$clientId",
                    'compare' => 'LIKE'
                )
            ),
            'post_type'      => 'sbc_orders',
            'posts_per_page' => '-1'
        );

        $posts = get_posts($args);

        foreach ($posts as $post) {
            update_post_meta($post->ID, 'sbc_order_client', $contactTemplate);
        }
    }

    private function get_post_by_meta($args = array())
    {

        // Parse incoming $args into an array and merge it with $defaults - caste to object ##
        $args = (object) wp_parse_args($args);

        // grab page - polylang will take take or language selection ##
        $args = array(
            'meta_query'     => array(
                array(
                    'key'   => $args->meta_key,
                    'value' => $args->meta_value
                )
            ),
            'post_type'      => 'sbc_clients',
            'posts_per_page' => '1'
        );

        // run query ##
        $posts = get_posts($args);

        // check results ##
        if (!$posts || is_wp_error($posts)) return false;

        // test it ##
        #pr( $posts[0] );

        // kick back results ##
        return $posts[0];
    }

    private function removeOrder($orderId)
    {
        if (!empty($orderId)) {
            $orderId = (int) $orderId;
            delete_post_meta($orderId, 'sbc_order_client');
            delete_post_meta($orderId, 'sbc_order_select');
            delete_post_meta($orderId, 'sbc_order_start');
            delete_post_meta($orderId, 'sbc_order_end');
            delete_post_meta($orderId, 'sbc_order_price');
            delete_post_meta($orderId, 'sbc_order_prepaid');
            delete_post_meta($orderId, 'sbc_order_desc');

            wp_delete_post($orderId, true);
        }
    }

    private function isAvailableOrder($calendarId, $dateStart, $dateEnd)
    {
        $result = false;

        if (isset($calendarId, $dateStart, $dateEnd)) {
            $result = true;
            $ordersQuery = new WP_Query;
            $orders = $ordersQuery->query(array(
                'post_type' => 'sbc_orders',
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => 'sbc_calendars',
                        'terms' => [$calendarId]
                    ]
                ],
                'meta_query' => array(
                    array(
                        'key'     => 'sbc_order_end',
                        'value'   => $dateStart,
                        'compare' => '>=',
                    )
                )
            ));

            $parseResult = [];

            foreach ($orders  as $order) {
                $orderId = $order->ID;
                $start = get_post_meta($orderId, 'sbc_order_start', true);
                $startTime = strtotime($start);
                $start = date('Y-m-d', $startTime);
                $end = get_post_meta($orderId, 'sbc_order_end', true);
                $endTime = strtotime($end);
                $end = date('Y-m-d', $endTime);
                $parseResult[] = [$start, $end];
            }

            foreach ($parseResult as $r) {
                $from = $r[0];
                $to = $r[1];

                if ($dateStart >= $from and $dateStart < $to) {
                    $result = false;
                }

                if ($dateEnd > $from and $dateEnd <= $to) {
                    $result = false;
                }

                if ($dateStart < $from and $dateEnd > $to) {
                    $result = false;
                }
            }
        }

        return $result;
    }

    public function create_order($request)
    {

        $spam = $request['message'];

        if (!empty($spam)) {
            return new WP_Error('Fail', 'Please call you administrator', array('status' => 404));
        }

        $result = true;
        $calendarId = $request['id'];
        $dateStart = date("Y-m-d", strtotime($request['dateStart']));
        $dateEnd = date("Y-m-d", strtotime($request['dateEnd']));
        $isHouse = $request['orderType'] === 'Домик:';

        if (empty($calendarId)) {
            require_once WP_PLUGIN_DIR . '/amo-integration/AmoIntegration.php';
            $href = 'https://krasnagorka.by/booking-form';
            $type = 'booking-form';
            new AmoIntegration($type, $request['data'], $href);
        } else {
            $result = false;

            if ($isHouse && $this->isAvailableOrder($calendarId, $dateStart, $dateEnd)) {
                $response = $this->insertWPLead([
                    "type" => "reserved",
                    "objectIds" => [$calendarId],
                    "dateFrom" => $dateStart,
                    "dateTo" => $dateEnd,
                    "comment" => $request['comment'],
                    "contactName" => $request['fio'],
                    "contactPhone" => $request['phone'],
                    "contactEmail" => $request['email']
                ]);
                $result = $response['status'] === 'success';
                if ($result) {
                    $eventTabId = $request['eventTabId'];
                    if(!empty($eventTabId)){

                        $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
                        Logger::log($tabHouses);
                        $freshPrice = 0;//getFreshPrice( $eventTabId, );

                        if(!empty($freshPrice)){
                            $request['data'] .= '&freshPrice=' . $freshPrice;
                        }
                    }


                    $request['data'] .= '&orderId=' . $response['orderId'];
                    
                    require_once WP_PLUGIN_DIR . '/amo-integration/AmoIntegration.php';
                    $href = 'https://krasnagorka.by/booking-form';
                    $type = 'booking-form';
                    new AmoIntegration($type, $request['data'], $href);
                }
            }
        }

        return new WP_REST_Response($result, 200);
    }
}
