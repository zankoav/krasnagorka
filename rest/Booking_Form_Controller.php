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

use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\DateCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateTimeCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateTimeCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\DateTimeCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;

use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;

use AmoCRM\Models\CustomFieldsValues\PriceCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\PriceCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\PriceCustomFieldValueModel;

use AmoCRM\Collections\CustomFieldsValuesCollection;

use AmoCRM\Collections\CatalogElementsCollection;
use AmoCRM\Filters\CatalogElementsFilter;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\CatalogModel;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\NotesCollection;
use AmoCRM\Models\NoteType\CommonNote;


/**
 * Created by PhpStorm.
 * User: alexandrzanko
 * Date: 11/22/19
 * Time: 2:39 PM
 */

class Booking_Form_Controller extends WP_REST_Controller
{
    public const CALENDAR_OBJECTS_MAPPING = [
        17 => 1036665,
        37 => 1036663,
        18 => 1036661,
        19 => 1036659,
        20 => 1036657,
        21 => 1036655,
        22 => 1036653,
        23 => 1036651,
        24 => 1036649,
        25 => 1036647,
        26 => 1036645,
        27 => 1036643,
        28 => 1036641,
        29 => 1036639,
        14 => 1036585,
        13 => 1036583,
        15 => 10393,
        9 => 10391,
        43=> 1663367,
        16 => 10389
    ];

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

        $pay_path  = '/pay/';

        register_rest_route($namespace, $pay_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'pay'),
                'permission_callback' => array($this, 'pay_permissions_check')
            ),
        ]);

        $success_notify_path = '/pay-success/';

        register_rest_route($namespace, $success_notify_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'pay_success'),
                'permission_callback' => array($this, 'pay_success_permissions_check')
            ),
        ]);

        $amocrm_v4_path      = '/amo-v4/';

        register_rest_route($namespace, $amocrm_v4_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'amocrm_v4_test'),
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

    public function pay_permissions_check($request)
    {
        return true;
    }

    public function pay_success_permissions_check($request)
    {
        return true;
    }

    /**
     * Create/Remove Lead form AmoCRM 
     */
    public function booking_lead($request)
    {
        $request['dateFrom'] = (int)$request['dateFrom'] + 3*3600;
        $request['dateTo'] = (int)$request['dateTo'] + 3*3600;
        $request['dateFrom'] = is_numeric($request['dateFrom']) ? $request['dateFrom'] : strtotime($request['dateFrom']);
        $request['dateTo'] = is_numeric($request['dateTo']) ? $request['dateTo'] : strtotime($request['dateTo']);
        $response = $this->insertWPLead($request);
        return new WP_REST_Response($response, 200);
    }

    public function amocrm_v4($request)
    {

        $contactName = 'Александр Занько';
        $contactPhone = '+375292228338';
        $contactEmail = 'zankoav@gmail.com';
        $contactPassport = 'GGFFTTOOPPRRTT';

        $dateFrom = '2020-08-20';
        $dateTo = '2020-08-23';
        $contactPeople = 11;
        $contactComment = 'Test comment';//+
        $calendarId = 43; //+
        $type = 'reserved'; //+
        $freshPrice = 109; //+
        $orderId = 987; //+

        $commentNote = '';

        if (!empty($freshPrice)) {
            $commentNote .= 'Горящее предложение: '.$freshPrice." руб.\n";
        }

        if (!empty($contactPeople)) {
            $commentNote .= 'Количество человек: '.$contactPeople."\n";
        }

        if (!empty($contactPassport)) {
            $commentNote .= 'Паспорт №: '.$contactPassport."\n";
        }

        if (!empty($contactComment)) {
            $commentNote .= 'Комментарий: '.$contactComment;
        }
        

        $response = [
            'exceptions' => [],
            'steps'=>[]
        ];

        $calendarObjects = [
            '17' => 1036665,
            '37' => 1036663,
            '18' => 1036661,
            '19' => 1036659,
            '20' => 1036657,
            '21' => 1036655,
            '22' => 1036653,
            '23' => 1036651,
            '24' => 1036649,
            '25' => 1036647,
            '26' => 1036645,
            '27' => 1036643,
            '28' => 1036641,
            '29' => 1036639,
            '14' => 1036585,
            '13' => 1036583,
            '15' => 10393,
            '9' => 10391,
            '43'=> 1663367,
            '16' => 10389
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
        $lead->setName('Сделка с сайта test');
        $lead->setStatusId(19518940);
        $lead->setTags((new TagsCollection())
           ->add(
                (new TagModel())
                    ->setId(1181317)
                    ->setName('Страница Бронирования')
            )
        );
        $leadCustomFields = new CustomFieldsValuesCollection();

        $houseElement = null;
        
        if(!empty($freshPrice)){
            $lead->setPrice($freshPrice);
        }

        if(!empty($calendarId) and !empty($calendarObjects[$calendarId])){
            try{
                $catalogElementsFilter = new CatalogElementsFilter();
                $catalogElementsFilter->setIds([$calendarObjects[$calendarId]]);
                $catalogElementsService = $apiClient->catalogElements(1321);
                if(!empty($catalogElementsService)){
                    $catalogElementsCollection = $catalogElementsService->get($catalogElementsFilter);
                    if( !empty($catalogElementsCollection) and $catalogElementsCollection->count() > 0){
                        $houseElement = $catalogElementsCollection->first();
                        $houseElement->setQuantity(1);
                    }
                }
            }catch(AmoCRMApiException $e){
                $response['exceptions'][] = $e->getTitle().' <<< getOne catalog >>> '.$e->getDescription();
                Logger::log('Exceptions:'.$e->getTitle().' <<< getOne catalog >>> '.$e->getDescription());
            }
        }

        if(!empty($orderId)){
            $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            $orderIdFieldValueModel->setFieldId(639191);
            $orderIdFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                        ->setValue($orderId)
                )
            );
            $leadCustomFields->add($orderIdFieldValueModel);
        }

        if(!empty($type)){
            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                        ->setValue($type)
                )
            );
            $leadCustomFields->add($typeFieldValueModel);
        }

        if(!empty($contactComment)){
            $commentFieldValueModel = new TextCustomFieldValuesModel();
            $commentFieldValueModel->setFieldId(357377);
            $commentFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                        ->setValue($contactComment)
                )
            );
            $leadCustomFields->add($commentFieldValueModel);
        }

        // if(!empty($dateFrom)){
        //     $dateFromFieldValueModel = new TextCustomFieldValueModel();
        //     $dateFromFieldValueModel->setFieldId(66211);
        //     // $dateFrom = DateTime::createFromFormat('Y-m-d', $dateFrom)->getTimestamp();
        //     $dateFromFieldValueModel->setValues(
        //         (new TextCustomFieldValueCollection())
        //             ->add((new TextCustomFieldValueModel())
        //                 ->setValue($dateFrom)
        //         )
        //     );
        //     $leadCustomFields->add($dateFromFieldValueModel);
        //     Logger::log('TIME:'.$dateFrom);
        // }

        // if(!empty($dateTo)){
        //     $dateToFieldValueModel = new DateCustomFieldValuesModel();
        //     $dateToFieldValueModel->setFieldId(66213);
        //     $dateToFieldValueModel->setValues(
        //         (new DateCustomFieldValueCollection())
        //             ->add((new DateCustomFieldValueModel())
        //                 ->setValue($dateTo)
        //         )
        //     );
        //     $leadCustomFields->add($dateToFieldValueModel);
        // }

        if($leadCustomFields->count() > 0){
            $lead->setCustomFieldsValues($leadCustomFields);
        }
        
        try {
            $lead = $leadsService->addOne($lead);
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle().' <<< addOne lead >>> '.$e->getDescription();
            Logger::log('Exceptions:'.$e->getTitle().' <<< addOne lead >>> '.$e->getDescription());
        }

        if(isset($lead, $houseElement)){
            //Привяжем к сделке наш элемент
            $links = new LinksCollection();
            $links->add($houseElement);
            try {
                $apiClient->leads()->link($lead, $links);
            } catch (AmoCRMApiException $e) {
                $response['exceptions'][] = $e->getTitle().' <<< addOne lead >>> '.$e->getDescription();
                Logger::log('Exceptions:'.$e->getTitle().' <<< addOne lead >>> '.$e->getDescription());
            }
        }

        $notesCollection = new NotesCollection();
        $messageNote = new CommonNote();
        $messageNote->setEntityId($lead->getId())
            ->setText($commentNote);
        $notesCollection->add($messageNote);

        try {
            $leadNotesService = $apiClient->notes(EntityTypesInterface::LEADS);
            $notesCollection = $leadNotesService->add($notesCollection);
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle().' <<< addOne lead >>> '.$e->getDescription();
            Logger::log('Exceptions:'.$e->getTitle().' <<< addOne lead >>> '.$e->getDescription());
        }
        

        //Получим контакт по ID, сделку и привяжем контакт к сделке
        // try {
        //     $contactsFilter = new ContactsFilter();
        //     $contactsFilter->setQuery($contactPhone);
        //     $response['steps'][] = ' <<< before contacts(1) get >>> ';
        //     $contactsCollection = $apiClient->contacts()->get($contactsFilter);
        //     $response['steps'][] = ' <<< after contacts(1) get >>> ';
        // } catch (AmoCRMApiException $e) {
        //     $response['exceptions'][] = $e->getTitle().' <<< get contacts >>> '.$e->getDescription();
        // }

        // if(!empty($contactsCollection) and $contactsCollection->count() > 0 ){
        //     $contact = $contactsCollection->first();
        //     $response['steps'][] = ' <<< get first(1) contact >>> ';

        //     $customFields = $contact->getCustomFieldsValues();
        //         $emailField = $customFields->getBy('fieldCode', 'EMAIL');
        //         if(empty($emailField)){
        //             $emailField = (new MultitextCustomFieldValuesModel())->setFieldCode('EMAIL');
        //             $customFields->add($emailField);
        //         }
        //         $emailField->setValues(
        //             (new MultitextCustomFieldValueCollection())
        //                 ->add(
        //                     (new MultitextCustomFieldValueModel())
        //                         ->setEnum('WORK')
        //                         ->setValue($contactEmail)
        //                 )
        //         );

        //         try {
        //             $response['steps'][] = ' <<< get before contacts updateOne >>> ';
        //             $contact = $apiClient->contacts()->updateOne($contact);
        //             $response['steps'][] = ' <<< get after contacts updateOne >>> ';
        //         } catch (AmoCRMApiException $e) {
        //             $response['exceptions'][] = $e->getTitle().' <<< updateOne contacts >>> '.$e->getDescription();                
        //         }

        // }else{
        //     try {
        //         $contactsFilter->setQuery($contactEmail);
        //         $response['steps'][] = ' <<< before contacts(2) get >>> ';
        //         $contactsCollection = $apiClient->contacts()->get($contactsFilter);
        //         $response['steps'][] = ' <<< after contacts(2) get >>> ';
        //     } catch (AmoCRMApiException $e) {
        //         $response['exceptions'][] = $e->getTitle().' <<< get contacts >>> '.$e->getDescription();            
        //     }

        //     if(!empty($contactsCollection) and $contactsCollection->count() > 0 ){
        //         $contact = $contactsCollection->first();
        //         $response['steps'][] = ' <<< get first(2) contact >>> ';
                
        //         $customFields = $contact->getCustomFieldsValues();
        //         $phoneField = $customFields->getBy('fieldCode', 'PHONE');
        //         if(empty($phoneField)){
        //             $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
        //             $customFields->add($phoneField);
        //         }
        //         $phoneField->setValues(
        //             (new MultitextCustomFieldValueCollection())
        //                 ->add(
        //                     (new MultitextCustomFieldValueModel())
        //                         ->setEnum('WORKDD')
        //                         ->setValue($contactPhone)
        //                 )
        //         );

        //         try {
        //             $response['steps'][] = ' <<< get before contacts updateOne >>> ';
        //             $contact = $apiClient->contacts()->updateOne($contact);
        //             $response['steps'][] = ' <<< get after contacts updateOne >>> ';
        //         } catch (AmoCRMApiException $e) {
        //             $response['exceptions'][] = $e->getTitle().' <<< updateOne contacts >>> '.$e->getDescription();                
        //         }

        //     }else{
        //         $contact = new ContactModel();
        //         $contact->setName('ZANKO_AV');
                
        //         $contactCustomFields = new CustomFieldsValuesCollection();
        //         $phoneFieldValueModel = new MultitextCustomFieldValuesModel();
        //         $phoneFieldValueModel->setFieldCode('PHONE');
        //         $phoneFieldValueModel->setValues(
        //             (new MultitextCustomFieldValueCollection())
        //                 ->add(
        //                     (new MultitextCustomFieldValueModel())
        //                         ->setEnum('WORKDD')
        //                         ->setValue($contactPhone)
        //                 )
        //         );
                
        //         $emailFieldValueModel = new MultitextCustomFieldValuesModel();
        //         $emailFieldValueModel->setFieldCode('EMAIL');
        //         $emailFieldValueModel->setValues(
        //             (new MultitextCustomFieldValueCollection())
        //                 ->add(
        //                     (new MultitextCustomFieldValueModel())
        //                         ->setEnum('WORK')
        //                         ->setValue($contactEmail)
        //                 )
        //         );

        //         $contactCustomFields->add($phoneFieldValueModel);
        //         $contactCustomFields->add($emailFieldValueModel);

        //         $contact->setCustomFieldsValues($contactCustomFields);

        //         try {
        //             $response['steps'][] = ' <<< before contacts addOne >>> ';
        //             $contact = $apiClient->contacts()->addOne($contact);
        //             $response['steps'][] = ' <<< after contacts addOne >>> ';
        //         } catch (AmoCRMApiException $e) {
        //             $response['exceptions'][] = $e->getTitle().' <<< addOne contacts >>> '.$e->getDescription();
        //         }
                
        //     }
        // }
        // $links = new LinksCollection();
        // $links->add($contact);

        // try {
        //     $response['steps'][] = ' <<< before link lead >>> ';
        //     $apiClient->leads()->link($lead, $links);
        //     $response['steps'][] = ' <<< after link lead >>> ';
        // } catch (AmoCRMApiException $e) {
        //     $response['exceptions'][] = $e->getTitle().' <<< link >>> '.$e->getDescription();
        // }

        // Logger::log('zanko page:'.json_encode($response));
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
            $request['dateStart'] = is_numeric($request['dateStart']) ? $request['dateStart'] : strtotime($request['dateStart']);
            $request['dateEnd'] = is_numeric($request['dateEnd']) ? $request['dateEnd'] : strtotime($request['dateEnd']);
       
            $dateStart = date("Y-m-d", $request['dateStart']);
            $dateEnd = date("Y-m-d", $request['dateEnd']);
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

    public function pay($request)
    {
        $resultStatus = 501;
        $result = [];

        $spam = $request['message'];

        if (!empty($spam)) {
            return new WP_Error('Fail', 'Please call you administrator', array('status' => 500));
        }

        // 1. Create order and get order ID
        $order = $this->createOrderForPay($request);
        if($order['status'] === 2 and isset($order['orderId'])){
            $resultStatus = 502;
            // 2. Create At Amocrm Lead Id
            // $leadId = $this->createLeadForPay($request, $order);

            // if(isset($leadId)){
                $secret_key = '2091988';
                $wsb_seed = strtotime("now");
                $wsb_storeid = '515854557';
                $wsb_order_num = $order['orderId'];
                $wsb_test = '1';
                $wsb_currency_id = 'BYN';
                $wsb_total = $order['price'];
                $wsb_signature = sha1($wsb_seed.$wsb_storeid.$wsb_order_num.$wsb_test.$wsb_currency_id.$wsb_total.$secret_key);

                $result = [
                    "names" => [
                        '*scart'
                    ],
                    "values" => [
                        'wsb_storeid' => $wsb_storeid,
                        'wsb_store' => 'OOO Краснагорка',
                        'wsb_order_num' => $wsb_order_num,
                        'wsb_currency_id' => $wsb_currency_id,
                        'wsb_version' => "2",
                        'wsb_language_id' => "russian",
                        'wsb_seed' => $wsb_seed,
                        'wsb_test' => $wsb_test,
                        'wsb_signature' => $wsb_signature,
                        'wsb_invoice_item_name[0]' => $request['orderTitle'],
                        'wsb_invoice_item_quantity[0]' => '1',
                        'wsb_invoice_item_price[0]' => $wsb_total,
                        'wsb_total' => $wsb_total,
                        'wsb_notify_url' => 'https://krasnagorka.by/wp-json/krasnagorka/v1/pay-success/',
                        'wsb_cancel_return_url' => "https://krasnagorka.by/booking-form?order=$wsb_order_num",
                        'wsb_return_url' => "https://krasnagorka.by/payed-success",
                    ]
                ];
                $resultStatus = 200;
            // }
        }
        return new WP_REST_Response($result, $resultStatus);
    }

    public function pay_success($request){
        Logger::log('pay_success:'.$_POST['site_order_id']);
        $order = $this->getOrderById($_POST['site_order_id']);
        $checkOutList = $this->generateMailCheckOut($order);
        wp_mail( 
            [
                $order['email']
            ], 
            'Успешная оплата в Красногорке', 
            $checkOutList 
        );
    }

    private function generateMailCheckOut($order){
        $message = 'Error message :(';
        try{
            $price =  $order['price'];
            $start =  $order['start'];
            $end =  $order['end'];
            $message = "<h2>Успешная оплата от Краснагорки</h2><p>Цена: $price</p><p>Дата заезда: $start</p><p>Дата выезда: $end</p>";
        }catch(Exception $e){
            Logger::log("getOrderById Exception:".$e->getMessage());
        }
        return $message ;
    }

    private function getOrderById($orderID){
        $order = [];
        try{
            $order['start'] = get_post_meta($orderID, 'sbc_order_start', 1);
            $order['end'] = get_post_meta($orderID, 'sbc_order_end', 1);
            $order['price'] = get_post_meta($orderID, 'sbc_order_price', 1);
            $order['email'] = 'zankoav@gmail.com';
        }catch(Exception $e){
            Logger::log("getOrderById Exception:".$e->getMessage());
        }
        return $order;
    }

    private function createOrderForPay($request){
        $result = ['status' => 0];
        try{
            $calendarId = $request['id'];
            $request['dateStart'] = is_numeric($request['dateStart']) ? $request['dateStart'] : strtotime($request['dateStart']);
            $request['dateEnd'] = is_numeric($request['dateEnd']) ? $request['dateEnd'] : strtotime($request['dateEnd']);
       
            $dateStart = date("Y-m-d", $request['dateStart']);
            $dateEnd = date("Y-m-d", $request['dateEnd']);

            if ($this->isAvailableOrder($calendarId, $dateStart, $dateEnd, false)) {

                $clientId = $this->initClient($request);

                $order_data = array(
                    'post_title'   => date("Y-m-d H:i:s"),
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => 23,
                    'post_type'    => 'sbc_orders'
                );

                // Вставляем данные в БД
                $order_id = wp_insert_post(wp_slash($order_data));

                if (is_wp_error($order_id)) {
                    $result['message'] = $order_id->get_error_message();
                } else {

                    $eventTabId = $request['eventTabId'];
                    $price = null;
                    if(!empty($eventTabId)){
                        $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
                        foreach($tabHouses as $tabHouse){
                            $dateTabStart = date("Y-m-d", strtotime($tabHouse['from']));
                            $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
                            if($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd){
                                $price = $tabHouse['new_price'];
                                break;
                            }
                        }
                    }

                    $contactTemplate = $clientId . " " . $request['fio'] . " " . $request['phone'] . " " . $request['email'] . " <a href='https://krasnagorka.by/wp-admin/post.php?post=" . $clientId . "&action=edit' target='_blank' class='edit-link'>Редактировать</a>";
                    update_post_meta($order_id, 'sbc_order_client', $contactTemplate);
                    $this->update_all_clients_orders($clientId, $contactTemplate);
                    update_post_meta($order_id, 'sbc_order_select', 'reserved');
                    update_post_meta($order_id, 'sbc_order_start', $dateStart);
                    update_post_meta($order_id, 'sbc_order_end', $dateEnd);
                    update_post_meta($order_id, 'sbc_order_price', $price);
                    update_post_meta($order_id, 'sbc_order_prepaid', '0');
                    update_post_meta($order_id, 'sbc_order_desc', $request['comment']);

                    $objectIds = array_map('intval', [$calendarId]);
                    $objectIds = array_unique($objectIds);
                    wp_set_object_terms($order_id, $objectIds, 'sbc_calendars');
                    $result['status'] = 2;
                    $result['orderId'] = $order_id;
                    $result['price'] = $price;
                }
            }else{
                $result['status'] = 1;
            }
        }catch(Exception $e){
            Logger::log("createOrderForPay Exception:".$e->getMessage());
        }
        return $result;
    }

    private function initClient($request)
    {
        $clientId = null;
        $client = $this->get_client_by_meta(['meta_key' => 'sbc_client_email', 'meta_value' => $request['email']]);
        if($client === false){
            $client_data = array(
                'post_title'   => $request['fio'] . ' ' . $request['phone'],
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => 23,
                'post_type'    => 'sbc_clients'
            );
            $clientId = wp_insert_post(wp_slash($client_data));
            update_post_meta($clientId, 'sbc_client_email', $request['email']);
            update_post_meta($clientId, 'sbc_client_phone', $request['phone']);
        }else{
            $clientId = $client->ID;
            update_post_meta($clientId, 'sbc_client_phone', $request['phone']);
        }

        return $clientId;
    }

    private function createLeadForPay($orderData, $orderId){
        $leadId = null;
        try{

        }catch(Exception $e){
            Logger::log("createLeadForPay Exception:".$e->getMessage());
        }
        return $leadId;
    }
    
    private function getAmoCrmCatalogByCalendars($amocrm_catalogs_ids){
        $calendars = [];
        $calendarObjectsReverse = [
            1036665 => 17,
            1036663 => 37,
            1036661 => 18,
            1036659 => 19,
            1036657 => 20,
            1036655 => 21,
            1036653 => 22,
            1036651 => 23,
            1036649 => 24,
            1036647 => 25,
            1036645 => 26,
            1036643 => 27,
            1036641 => 28,
            1036639 => 29,
            1036585 => 14,
            1036583 => 13,
            10393 => 15,
            10391 => 9,
            1663367=> 43,
            10389 => 16
        ];

        
        foreach($amocrm_catalogs_ids as $value){
            $calendars[] = $calendarObjectsReverse[$value];
        }
        return $calendars;
    }

    private function insertWPLead($request)
    {
            $type     = $request['type'];
            $orderId  = $request['orderId'];
            $request['dateFrom'] = is_numeric($request['dateFrom']) ? $request['dateFrom'] : strtotime($request['dateFrom']);
            $request['dateTo'] = is_numeric($request['dateTo']) ? $request['dateTo'] : strtotime($request['dateTo']);
            $dateFrom = date("Y-m-d", $request['dateFrom']);
            $dateTo = date("Y-m-d", $request['dateTo']);
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

                $client   = $this->get_client_by_meta(['meta_key' => 'sbc_client_phone', 'meta_value' => $contactPhone]);
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

    private function get_client_by_meta($args = array())
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


    public function amocrm_v4_test(){

        $price = 112; 
        $peopleCount = 9;
        $dateFrom = '2020-08-20';
        $dateTo = '2020-08-23';
        $orderId = 192;
        $calendarId = 43;
        $comment = 'Комментарий тестовый';

        $contactName = 'Александр Занько';
        $contactPhone = '+375295558386';
        $contactEmail = 'zankoav@yandex.ru';
        $contactPassport = 'GG Gl HF';

        try {

            $apiClient = $this->getAmoCrmApiClient();

            $orderType = 'reserved';
            $commentNote = "Спец. предложение: $price руб.\nКоличество человек: $peopleCount\nПаспорт №: $contactPassport\nКомментарий: $comment";
            $leadName = 'Сделка через WEBPAY';
            $statusId = 35452366; // id воронки

            $leadsService = $apiClient->leads();
            $lead = new LeadModel();
            $lead->setName($leadName);
            $lead->setStatusId($statusId);
            $lead->setPrice($price);
            $lead->setTags((new TagsCollection())
            ->add(
                    (new TagModel())
                        ->setId(1181317)
                        ->setName('Страница Бронирования')
                )
            );

            $leadCustomFields = new CustomFieldsValuesCollection();

            // Order ID
            $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            $orderIdFieldValueModel->setFieldId(639191);
            $orderIdFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                        ->setValue($orderId)
                )
            );
            $leadCustomFields->add($orderIdFieldValueModel);
            
            // Order Type
            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                        ->setValue($orderType)
                )
            );
            $leadCustomFields->add($typeFieldValueModel);

            // Comment
            $commentFieldValueModel = new TextCustomFieldValuesModel();
            $commentFieldValueModel->setFieldId(357377);
            $commentFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                        ->setValue($comment )
                )
            );
            $leadCustomFields->add($commentFieldValueModel);

            // Date From
            $dateFromFieldValueModel = new DateCustomFieldValuesModel();
            $dateFromFieldValueModel->setFieldId(66211);
            $dateFromModel = new DateCustomFieldValueModel();
            $dateFromModel->setValue($dateFrom);
            $dateFromModelCollection = new DateCustomFieldValueCollection();
            $dateFromModelCollection->add($dateFromModel);
            $dateFromFieldValueModel->setValues($dateFromModelCollection);
            $leadCustomFields->add($dateFromFieldValueModel);

            // Date To 
            $dateToFieldValueModel = new DateCustomFieldValuesModel();
            $dateToFieldValueModel->setFieldId(66213);
            $dateToModel = new DateCustomFieldValueModel();
            $dateToModel->setValue($dateTo);
            $dateToModelCollection = new DateCustomFieldValueCollection();
            $dateToModelCollection->add($dateToModel);
            $dateToFieldValueModel->setValues($dateToModelCollection);
            $leadCustomFields->add($dateToFieldValueModel);

            $lead->setCustomFieldsValues($leadCustomFields);

            $houseElement = null;
            $catalogElementsFilter = new CatalogElementsFilter();
            $catalogElementsFilter->setIds([self::CALENDAR_OBJECTS_MAPPING[$calendarId]]);
            $catalogElementsService = $apiClient->catalogElements(1321);
            $catalogElementsCollection = $catalogElementsService->get($catalogElementsFilter);
            $houseElement = $catalogElementsCollection->first();
            $houseElement->setQuantity(1);

            $lead = $leadsService->addOne($lead);

            $links = new LinksCollection();
            $links->add($houseElement);
            $apiClient
                ->leads()
                ->link($lead, $links);

            $notesCollection = new NotesCollection();
            $messageNote = new CommonNote();
            $messageNote
                ->setEntityId($lead->getId())
                ->setText($commentNote);
            $notesCollection->add($messageNote);
            $apiClient
                ->notes(EntityTypesInterface::LEADS)
                ->add($notesCollection);


            $contact = null;

            $contactsFilter = new ContactsFilter();
            $contactsFilter->setQuery($contactPhone);
            $contactsCollection = $apiClient->contacts()->get($contactsFilter);

            if($contactsCollection->count() > 0 ){
                $contact = $contactsCollection->first();
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

                if(!empty($contactPassport)){
                    $passportFieldValueModel = new TextCustomFieldValuesModel();
                    $passportFieldValueModel->setFieldId(638673);
                    $passportFieldValueModel->setValues(
                        (new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                            ->setValue($contactPassport)));
                    $customFields->add($passportFieldValueModel);
                }
                
                $contact = $apiClient->contacts()->updateOne($contact);

            }else{
                $contactsFilter->setQuery($contactEmail);
                $contactsCollection = $apiClient->contacts()->get($contactsFilter);

                if($contactsCollection->count() > 0 ){
                    $contact = $contactsCollection->first();
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

                    if(!empty($contactPassport)){
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                ->setValue($contactPassport)));
                        $customFields->add($passportFieldValueModel);
                    }

                    $contact = $apiClient->contacts()->updateOne($contact);

                }else{
                    Logger::log('$contact view');    
                    $contact = new ContactModel();
                    $contact->setName($contactName);
                    
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

                    if(!empty($contactPassport)){
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                ->setValue($contactPassport)));
                        $contactCustomFields->add($passportFieldValueModel);
                    }

                    $contact = $apiClient->contacts()->addOne($contact);  
                    Logger::log('$contact :'.$contact->getId());    
                }
            }
            
            $links = new LinksCollection();
            $links->add($contact);

            $apiClient->leads()->link($lead, $links);

        } catch (AmoCRMApiException $e) {
            Logger::log('Exceptions:'.$e->getTitle().' <<< addOne lead >>> '.$e->getDescription());
        }
        return new WP_REST_Response(['status' => 1], 200);
    }

    private function getAmoCrmApiClient(){

        $clientId = '79aac717-18fc-4495-8a5f-7124a70de05d';
        $clientSecret = 'h1MPktXuLLrCPrEneoFP7kh2rlVllzaxkzfivOK2xWzOTxFHqtIu26VDUIaEyOpG';
        $redirectUri = 'https://krasnagorka.by';

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

        return $apiClient;
    }

}
