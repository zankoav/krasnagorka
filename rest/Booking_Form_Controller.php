<?php

use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\TagModel;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;

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

        $amocrm_lead_path      = '/create-amocrm-lead/';

        register_rest_route($namespace, $amocrm_lead_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'create_amocrm_lead'),
                'permission_callback' => array($this, 'create_amocrm_lead_permissions_check')
            ),
        ]);


        $amocrm_v4_path      = '/amo-v4/';

        register_rest_route($namespace, $amocrm_v4_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'amocrm_v4'),
                'permission_callback' => array($this, 'amocrm_v4_permissions_check')
            ),
        ]);
    }

    public function create_order_permissions_check($request)
    {
        return true;
    }

    public function amocrm_v4_permissions_check($request)
    {
        return true;
    }

    public function booking_lead_permissions_check($request)
    {
        return true;
    }

    public function create_amocrm_lead_permissions_check($request)
    {
        return true;
    }

    public function booking_lead($request)
    {
        $response = $this->insertWPLead($request);
        return new WP_REST_Response($response, 200);
    }

    public function amocrm_v4($request)
    {
        $response = [
            'exceptions' => [],
            'steps'=>[]
        ];

        $clientId = '79aac717-18fc-4495-8a5f-7124a70de05d';
        $clientSecret = 'h1MPktXuLLrCPrEneoFP7kh2rlVllzaxkzfivOK2xWzOTxFHqtIu26VDUIaEyOpG';
        $redirectUri = 'https://krasnagorka.by';
        $code = 'def502000fbd47b384ca66f1c806a90c0255d176b3c774243eeb100a7858487c3adfbb5e1725fe2ac5a779ec5df93953672838939dd5dafcf89e87cdce028d68eae1760655eceb4a020e3c42020e654fe5fd50f59e0102a07098677a661c81ca3ad30e28b63c88075a06158fb074b0e93d7cc0b4801943c43afcf3059acef227bec274b75c7757ddee960384eaee4502c12f7717bb9d3ac583466564044e9c5976d4ee42a741a449266475f6086ea0ff3dfd9adc2f1c2f5dd750661d69d15b343898bad73e9fcfb2e484e2a0fcab0f4616988a5d192cd44de662154ea62ed486ee7f6fea0bf30114a358e21452a7a8f3cf2f35718e1607075634fe55a3ae2b85961583b698eec38a24173d398b665a6c23e7a91a0adb5e8705b926119c8218fee68647020f2e40e8382eff50fbf35a29748c73593c23a0793bebca23f80cb8108adbda27b7dcbe61ce47020bf811d3c58dc371906fc9ccf124d400bc91642ae58ece09c82ac1f337a5f95ceb16db9b6dc29baca9ff4753a577349917b155e123a2be6fe1d01693bfc9a616e71948e23a47c1eb31c3c9dac1e89b4515dc30cb5aa2b988368a3a2f31513b6a14612fae888db801ddb5b07a2a622cb9b87b28196c';
        $link = 'https://krasnogorka.amocrm.ru/oauth2/access_token';

        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $accessToken = getToken();
        $apiClient
            ->setAccountBaseDomain('krasnogorka.amocrm.ru')
            ->setAccessToken($accessToken)
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    saveToken(
                        [
                            'access_token' => $accessToken->getToken(),
                            'refresh_token' => $accessToken->getRefreshToken(),
                            'expires_in' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ]
                    );
                });

        $leadsService = $apiClient->leads();
        $lead = new LeadModel();
        $lead->setName('ZANKO ALEXANDR FROM V4');
        $lead->setStatusId(19518940);
        $lead->setTags((new TagsCollection())
           ->add(
                (new TagModel())
                    ->setId(500)
                    ->setName('Страница Бронирования')
            )
        );
        
        try {
            $lead = $leadsService->addOne($lead);
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle().' <<< addOne lead >>> '.$e->getDescription();
        }

        $contactPhone = '+375298888888';
        $contactEmail = 'zankoav@gmail.com';

        //Получим контакт по ID, сделку и привяжем контакт к сделке
        try {
            $contactsFilter = new ContactsFilter();
            $contactsFilter->setQuery($contactPhone);
            $response['steps'][] = ' <<< before contacts(1) get >>> ';
            $contactsCollection = $apiClient->contacts()->get($contactsFilter);
            $response['steps'][] = ' <<< after contacts(1) get >>> ';
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle().' <<< get contacts >>> '.$e->getDescription();
        }

        if(!empty($contactsCollection) and $contactsCollection->count() > 0 ){
            $contact = $contactsCollection->first();
            $response['steps'][] = ' <<< get first(1) contact >>> ';

            $customFields = $contact->getCustomFieldsValues();
                $emailField = $customFields->getBy('fieldCode', 'EMAIL');
                if(empty($emailField)){
                    $emailField = (new MultitextCustomFieldValuesModel())->setFieldCode('EMAIL');
                    $customFields->add($emailField);
                }
                $emailField->setValues(
                    (new MultitextCustomFieldValueCollection())
                        ->add(
                            (new MultitextCustomFieldValueModel())
                                ->setEnum('WORK')
                                ->setValue($contactEmail)
                        )
                );

                try {
                    $response['steps'][] = ' <<< get before contacts updateOne >>> ';
                    $contact = $apiClient->contacts()->updateOne($contact);
                    $response['steps'][] = ' <<< get after contacts updateOne >>> ';
                } catch (AmoCRMApiException $e) {
                    $response['exceptions'][] = $e->getTitle().' <<< updateOne contacts >>> '.$e->getDescription();                
                }

        }else{
            try {
                $contactsFilter->setQuery($contactEmail);
                $response['steps'][] = ' <<< before contacts(2) get >>> ';
                $contactsCollection = $apiClient->contacts()->get($contactsFilter);
                $response['steps'][] = ' <<< after contacts(2) get >>> ';
            } catch (AmoCRMApiException $e) {
                $response['exceptions'][] = $e->getTitle().' <<< get contacts >>> '.$e->getDescription();            
            }

            if(!empty($contactsCollection) and $contactsCollection->count() > 0 ){
                $contact = $contactsCollection->first();
                $response['steps'][] = ' <<< get first(2) contact >>> ';
                
                $customFields = $contact->getCustomFieldsValues();
                $phoneField = $customFields->getBy('fieldCode', 'PHONE');
                if(empty($phoneField)){
                    $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
                    $customFields->add($phoneField);
                }
                $phoneField->setValues(
                    (new MultitextCustomFieldValueCollection())
                        ->add(
                            (new MultitextCustomFieldValueModel())
                                ->setEnum('WORKDD')
                                ->setValue($contactPhone)
                        )
                );

                try {
                    $response['steps'][] = ' <<< get before contacts updateOne >>> ';
                    $contact = $apiClient->contacts()->updateOne($contact);
                    $response['steps'][] = ' <<< get after contacts updateOne >>> ';
                } catch (AmoCRMApiException $e) {
                    $response['exceptions'][] = $e->getTitle().' <<< updateOne contacts >>> '.$e->getDescription();                
                }

            }else{
                $contact = new ContactModel();
                $contact->setName('ZANKO_AV');
                
                $contactCustomFields = new CustomFieldsValuesCollection();
                $phoneFieldValueModel = new MultitextCustomFieldValuesModel();
                $phoneFieldValueModel->setFieldCode('PHONE');
                $phoneFieldValueModel->setValues(
                    (new MultitextCustomFieldValueCollection())
                        ->add(
                            (new MultitextCustomFieldValueModel())
                                ->setEnum('WORKDD')
                                ->setValue($contactPhone)
                        )
                );
                
                $emailFieldValueModel = new MultitextCustomFieldValuesModel();
                $emailFieldValueModel->setFieldCode('EMAIL');
                $emailFieldValueModel->setValues(
                    (new MultitextCustomFieldValueCollection())
                        ->add(
                            (new MultitextCustomFieldValueModel())
                                ->setEnum('WORK')
                                ->setValue($contactEmail)
                        )
                );

                $contactCustomFields->add($phoneFieldValueModel);
                $contactCustomFields->add($emailFieldValueModel);

                $contact->setCustomFieldsValues($contactCustomFields);

                try {
                    $response['steps'][] = ' <<< before contacts addOne >>> ';
                    $contact = $apiClient->contacts()->addOne($contact);
                    $response['steps'][] = ' <<< after contacts addOne >>> ';
                } catch (AmoCRMApiException $e) {
                    $response['exceptions'][] = $e->getTitle().' <<< addOne contacts >>> '.$e->getDescription();
                }
                
            }
        }
        $links = new LinksCollection();
        $links->add($contact);

        try {
            $response['steps'][] = ' <<< before link lead >>> ';
            $apiClient->leads()->link($lead, $links);
            $response['steps'][] = ' <<< after link lead >>> ';
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle().' <<< link >>> '.$e->getDescription();
        }

        Logger::log('zanko page:'.json_encode($response));
        return new WP_REST_Response($response, 200);
    }

    public function create_amocrm_lead($request)
    {
        $result = ['status'=>'error'];
        try{
            if(isset($request['data'])){
                require_once WP_PLUGIN_DIR . '/amo-integration/AmoIntegration.php';
                $href = 'https://krasnagorka.by/booking-form';
                $type = 'booking-form';
                $amo = new AmoIntegration($type, $request['data'], $href);
                $result['status'] = 'success';
            }
        }catch(Exception $e){
            $result['message'] = $e->getMessage();
        }
        return new WP_REST_Response($result, 200);
    }

    public function create_order($request)
    {
        $result = true;
        
        try{
            $spam = $request['message'];

            if (!empty($spam)) {
                return new WP_Error('Fail', 'Please call you administrator', array('status' => 404));
            }
            $calendarId = $request['id'];
            $dateStart = date("Y-m-d", strtotime($request['dateStart']));
            $dateEnd = date("Y-m-d", strtotime($request['dateEnd']));
            $isHouse = $request['orderType'] === 'Домик:';

            if (!empty($calendarId)) {
                $result = false;

                if ($isHouse && $this->isAvailableOrder($calendarId, $dateStart, $dateEnd, false)) {
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
                            $freshPrice = null;
                            foreach($tabHouses as $tabHouse){
                                $dateTabStart = date("Y-m-d", strtotime($tabHouse['from']));
                                $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
                                if($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd){
                                    $freshPrice = $tabHouse['new_price'];
                                    break;
                                }
                            }

                            if(!empty($freshPrice)){
                                $request['data'] .= '&freshPrice=' . $freshPrice;
                            }
                        }

                        $request['data'] .= '&orderId=' . $response['orderId'];
                    }
                }
            }
            if($result){
                $result = $request['data'];
            }
        }catch(Exception $e){
            Logger::log("Exception:".$e->getMessage());
            return false;
        }

        return new WP_REST_Response($result, 200);
    }

    private function insertWPLead($request)
    {
            $type     = $request['type'];
            $orderId  = $request['orderId'];
            
            $dateFrom = date("Y-m-d", strtotime($request['dateFrom']));
            $dateTo = date("Y-m-d", strtotime($request['dateTo']));
            $objectIds  = $request['objectIds'];

            

            if ($type != 'remove') {

                $kalendars = array_map('intval', $objectIds);
                $kalendars = array_unique($kalendars);
                $result = $this->isAvailableOrder($kalendars[0], $dateFrom, $dateTo, $orderId);
                if (!$result) {
                    $response['status'] = 'busy';
                    return $response;
                }else{
                    $this->removeOrder($orderId);
                }

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
            }else{
                $this->removeOrder($orderId);
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

    private function isAvailableOrder($calendarId, $dateStart, $dateEnd, $orderIdFromCrm)
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
                $parseResult[] = [$start, $end, $orderId];
            }

            foreach ($parseResult as $r) {
                $from = $r[0];
                $to = $r[1];
                $orId = $r[2];

                if ($dateStart >= $from and $dateStart < $to) {
                    if($orderIdFromCrm != false){
                        if($orderIdFromCrm != $orId){
                            $result = false;
                        }
                    }else{
                        $result = false;
                    }
                }

                if ($dateEnd > $from and $dateEnd <= $to) {
                    if($orderIdFromCrm != false){
                        if($orderIdFromCrm != $orId){
                            $result = false;
                        }
                    }else{
                        $result = false;
                    }
                }

                if ($dateStart < $from and $dateEnd > $to) {
                    if($orderIdFromCrm != false){
                        if($orderIdFromCrm != $orId){
                            $result = false;
                        }
                    }else{
                        $result = false;
                    }
                }
            }
        }

        return $result;
    }

}
