<?php
use Ls\Wp\Log as Log;

use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\TagModel;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\ContactsCollection;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\TasksCollection;
use AmoCRM\Models\TaskModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;

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
        43 => 1663367,
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

        $webhook_path      = '/amocrm-webhook/';

        register_rest_route($namespace, $webhook_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'change_contact'),
                'permission_callback' => array($this, 'change_contact_permissions_check')
            ),
        ]);

        $call_path      = '/amocrm-call/';

        register_rest_route($namespace, $call_path, [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'amocrm_call'),
                'permission_callback' => array($this, 'amocrm_call_permissions_check')
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

    public function change_contact_permissions_check($request)
    {
        return true;
    }

    public function amocrm_call_permissions_check($request)
    {
        return true;
    }

    public function amocrm_call($request)
    {

        //Получим сделку
        // try {

        //     $leadId = (int)$_POST['leads']['status'][0]['id'];
        //     $apiClient = self::getAmoCrmApiClient();
        //     $lead = $apiClient->leads()->getOne($leadId, [LeadModel::CONTACTS]);
        //     //Получим основной контакт сделки
        //     /** @var ContactsCollection $leadContacts */
        //     $leadContacts = $lead->getContacts();
        //     if ($leadContacts) {
        //         $leadMainContact = $leadContacts->getBy('isMain', true);
        //         $contact =  $apiClient->contacts()->getOne($leadMainContact->getId(), [ContactModel::LEADS]);
        //         $leads =  $contact->getLeads()->toArray();
        //         $ids = [];
        //         foreach ($leads as $item) {
        //             $ids[] = $item['id'];
        //         }
        //         $filter = new LeadsFilter();
        //         $filter->setIds($ids);
        //         $leads = $apiClient->leads()->get($filter)->toArray();
        //         $counter = 0;
        //         foreach ($leads as $l) {
        //             if ($l['status_id'] == 142) {
        //                 $counter++;
        //             }
        //         }
        //         if ($counter > 2) {
        //             $contactCustomFields = new CustomFieldsValuesCollection();
        //             $typeFieldValueContact = new SelectCustomFieldValuesModel();
        //             $typeFieldValueContact->setFieldId(72295);

        //             $tCollection = new SelectCustomFieldValueCollection();
        //             $tModel = new SelectCustomFieldValueModel();
        //             $tModel->setEnumId(149825);
        //             $tCollection->add($tModel);
        //             $typeFieldValueContact->setValues($tCollection);
        //             $contactCustomFields->add($typeFieldValueContact);
        //             $contact->setCustomFieldsValues($contactCustomFields);
        //             $contact = $apiClient->contacts()->updateOne($contact);
        //         }
        //     }
        // } catch (AmoCRMApiException $e) {
        // } catch (Exception $e) {
        // }
    }


    public function change_contact($request)
    {
        //Получим сделку
        try {

            $leadId = (int)$_POST['leads']['status'][0]['id'];
            $apiClient = self::getAmoCrmApiClient();
            $lead = $apiClient->leads()->getOne($leadId, [LeadModel::CONTACTS]);
            //Получим основной контакт сделки
            /** @var ContactsCollection $leadContacts */
            $leadContacts = $lead->getContacts();
            if ($leadContacts) {
                $leadMainContact = $leadContacts->getBy('isMain', true);
                $contact =  $apiClient->contacts()->getOne($leadMainContact->getId(), [ContactModel::LEADS]);
                $leads =  $contact->getLeads()->toArray();
                $ids = [];
                foreach ($leads as $item) {
                    $ids[] = $item['id'];
                }
                $filter = new LeadsFilter();
                $filter->setIds($ids);
                $leads = $apiClient->leads()->get($filter)->toArray();
                $counter = 0;
                foreach ($leads as $l) {
                    if ($l['status_id'] == 142) {
                        $counter++;
                    }
                }
                if ($counter > 2) {
                    $contactCustomFields = new CustomFieldsValuesCollection();
                    $typeFieldValueContact = new SelectCustomFieldValuesModel();
                    $typeFieldValueContact->setFieldId(72295);

                    $tCollection = new SelectCustomFieldValueCollection();
                    $tModel = new SelectCustomFieldValueModel();
                    $tModel->setEnumId(149825);
                    $tCollection->add($tModel);
                    $typeFieldValueContact->setValues($tCollection);
                    $contactCustomFields->add($typeFieldValueContact);
                    $contact->setCustomFieldsValues($contactCustomFields);
                    $contact = $apiClient->contacts()->updateOne($contact);
                }
            }
        } catch (AmoCRMApiException $e) {

        } catch (Exception $e) {

        }
    }

    /**
     * Create/Remove Lead form AmoCRM 
     */
    public function booking_lead($request)
    {
        $request['dateFrom'] = (int)$request['dateFrom'] + 3 * 3600;
        $request['dateTo'] = (int)$request['dateTo'] + 3 * 3600;
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
        $contactComment = 'Test comment'; //+
        $calendarId = 43; //+
        $type = 'reserved'; //+
        $freshPrice = 109; //+
        $orderId = 987; //+

        $commentNote = '';

        if (!empty($freshPrice)) {
            $commentNote .= 'Горящее предложение: ' . $freshPrice . " руб.\n";
        }

        if (!empty($contactPeople)) {
            $commentNote .= 'Количество человек: ' . $contactPeople . "\n";
        }

        if (!empty($contactPassport)) {
            $commentNote .= 'Паспорт №: ' . $contactPassport . "\n";
        }

        if (!empty($contactComment)) {
            $commentNote .= 'Комментарий: ' . $contactComment;
        }


        $response = [
            'exceptions' => [],
            'steps' => []
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
            '43' => 1663367,
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
                }
            );

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

        if (!empty($freshPrice)) {
            $lead->setPrice($freshPrice);
        }

        if (!empty($calendarId) and !empty($calendarObjects[$calendarId])) {
            try {
                $catalogElementsFilter = new CatalogElementsFilter();
                $catalogElementsFilter->setIds([$calendarObjects[$calendarId]]);
                $catalogElementsService = $apiClient->catalogElements(1321);
                if (!empty($catalogElementsService)) {
                    $catalogElementsCollection = $catalogElementsService->get($catalogElementsFilter);
                    if (!empty($catalogElementsCollection) and $catalogElementsCollection->count() > 0) {
                        $houseElement = $catalogElementsCollection->first();
                        $houseElement->setQuantity(1);
                    }
                }
            } catch (AmoCRMApiException $e) {
                $response['exceptions'][] = $e->getTitle() . ' <<< getOne catalog >>> ' . $e->getDescription();
                Logger::log('Exceptions:' . $e->getTitle() . ' <<< getOne catalog >>> ' . $e->getDescription());
            }
        }

        if (!empty($orderId)) {
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

        if (!empty($type)) {
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

        if (!empty($contactComment)) {
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

        if ($leadCustomFields->count() > 0) {
            $lead->setCustomFieldsValues($leadCustomFields);
        }

        try {
            $lead = $leadsService->addOne($lead);
        } catch (AmoCRMApiException $e) {
            $response['exceptions'][] = $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription();
            Logger::log('Exceptions:' . $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription());
        }

        if (isset($lead, $houseElement)) {
            //Привяжем к сделке наш элемент
            $links = new LinksCollection();
            $links->add($houseElement);
            try {
                $apiClient->leads()->link($lead, $links);
            } catch (AmoCRMApiException $e) {
                $response['exceptions'][] = $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription();
                Logger::log('Exceptions:' . $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription());
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
            $response['exceptions'][] = $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription();
            Logger::log('Exceptions:' . $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription());
        }
        return new WP_REST_Response($response, 200);
    }

    public function create_amocrm_lead($request)
    {
        // Log::info('#2 create_amocrm_lead', $request);
        $result = ['status' => 'error'];
        try {
            if (isset($request['data'])) {
                require_once WP_PLUGIN_DIR . '/amo-integration/AmoIntegration.php';
                $href = 'https://krasnagorka.by/booking-form';
                $type = 'booking-form';
                $amo = new AmoIntegration($type, $request['data'], $href);
                $result['status'] = 'success';
                $orderData = get_order_data($request['orderId']);
                if($request['paymentMethod'] == 'card_layter' || $request['paymentMethod'] == 'office'){
                    $result['template'] = $this->sendMail($orderData);
                }
                // $this->addTaskForLead($orderData['leadId'], $orderData['orderId'], 'Помочь клиенту определиться с заказом');
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        return new WP_REST_Response($result, 200);
    }

    public function create_order($request)
    {
        // Log::info('#1 create_order', $request);
        $result = [
            'status' => true
        ];
        try {
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
                $result['status'] = false;

                if ($isHouse && $this->isAvailableOrder($calendarId, $dateStart, $dateEnd, false)) {
                    $eventTabId = $request['eventTabId'];
                    $totalPrice = null;
                
                    if(empty($eventTabId)){
                        $tempDate = new DateTime($dateStart);
                        $priceData = LS_Booking_Form_Controller::calculateResult([
                            'house' => $request['houseId'],
                            'dateStart' => $tempDate->modify('+1 day')->format('Y-m-d'),
                            'dateEnd' => $dateEnd,
                            'peopleCount' => $request['count'],
                            'calendarId' => $calendarId,
                            'isTerem' => $request['isTerem'],
                        ]);
                        $totalPrice = $priceData['total_price'];
                    }
                    
                    $response = $this->insertWPLead([
                        "type" => "reserved",
                        "wsb_test" => $request["wsb_test"],
                        "passport" => $request["passport"],
                        "objectIds" => [$calendarId],
                        "dateFrom" => $dateStart,
                        "dateTo" => $dateEnd,
                        "totalPrice" => $totalPrice,
                        "comment" => $request['comment'],
                        "childs" => $request['childs'],
                        "peopleCount" => $request['count'],
                        "contactName" => $request['fio'],
                        "contactPhone" => $request['phone'],
                        "contactEmail" => $request['email'],
                        "paymentMethod" => $request['paymentMethod'],
                        "paymentMethod" => $request['paymentMethod'],
                        "prepaidType" => $request['prepaidType']
                    ]);
                    $result['status'] = $response['status'] === 'success';
                    $result['redirect'] = $response['redirect'];
                    if ($result['status']) {
                        $eventTabId = $request['eventTabId'];
                        if (!empty($eventTabId)) {

                            $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
                            $freshPrice = null;
                            foreach ($tabHouses as $tabHouse) {
                                $dateTabStart = date("Y-m-d", strtotime($tabHouse['from']));
                                $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
                                if ($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd) {
                                    $freshPrice = $tabHouse['new_price'];
                                    break;
                                }
                            }

                            if (!empty($freshPrice)) {
                                $request['data'] .= '&freshPrice=' . $freshPrice;
                            }
                        }else{
                            $request['data'] .= '&freshPrice=' . $totalPrice;
                        }

                        $request['data'] .= '&orderId=' . $response['orderId'];
                        $request['orderId'] = $response['orderId'];
                    }
                }
            }
            if ($result['status']) {
                $result['data'] = $request['data'];
                $result['orderId'] = $request['orderId'];
                $result['prepaidType'] = $request['prepaidType'];
                $result['paymentMethod'] = $request['paymentMethod'];
            }
        } catch (Exception $e) {
            Logger::log("Exception:" . $e->getMessage());
            return false;
        }

        return new WP_REST_Response($result, 200);
    }

    // public function addTaskForLead($leadId, $orderId, $message){

    //     $apiClient = self::getAmoCrmApiClient();

    //     //Создадим задачу
    //     $tasksCollection = new TasksCollection();
    //     $task = new TaskModel();
    //     $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
    //         ->setText($message)
    //         ->setCompleteTill(mktime(date("H"), date("i") + 30))
    //         ->setEntityType(EntityTypesInterface::LEADS)
    //         ->setEntityId(intval($leadId))
    //         ->setDuration(1 * 60 * 60) // 1 час
    //         ->setResponsibleUserId(2373844);
    //     $tasksCollection->add($task);

    //     try {
    //         $tasksCollection = $apiClient->tasks()->add($tasksCollection);
    //         $taskToStore = $tasksCollection->first();
    //         update_post_meta($orderId, 'sbc_task_id', $taskToStore->getId());
    //     } catch (AmoCRMApiException $e) {
    //         Log::error('Exceptions: ' . $e->getTitle(), $e->getDescription());
    //     }
    // }

    public static function createAmoCrmTask($message, $leadId){

        $apiClient = self::getAmoCrmApiClient();

        //Создадим задачу
        $tasksCollection = new TasksCollection();
        $task = new TaskModel();
        $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
            ->setText($message)
            ->setCompleteTill(mktime(date("H"), date("i") + 30))
            ->setEntityType(EntityTypesInterface::LEADS)
            ->setEntityId(intval($leadId))
            ->setDuration(1 * 60 * 60) // 1 час
            ->setResponsibleUserId(2373844);
        $tasksCollection->add($task);

        try {
            $tasksCollection = $apiClient->tasks()->add($tasksCollection);
        } catch (AmoCRMApiException $e) {
            Log::error('Exceptions: ' . $e->getTitle(), $e->getDescription());
        }
    }

    private function sendMail($request, $isWebPaySuccess = false){
        $emailTo = $request['email'];
        $data = $request;

        $prepaidType = $request['prepaidType'];
        $paymentMethod = $request['paymentMethod'];

        $subject = '';
        $templatePath = '';

        if($paymentMethod == 'card_layter' and !$isWebPaySuccess){
            $subject = 'Заявка на бронирование';
            $templatePath = $prepaidType == 100 ? "L-S/mail/templates/tmpl-pay-full-confirm" : "L-S/mail/templates/tmpl-pay-partial-confirm";
        }else if($paymentMethod == 'office' and !$isWebPaySuccess){
            $subject = 'Заявка на бронирование';
            $templatePath = "L-S/mail/templates/tmpl-office";
        }else if($isWebPaySuccess){
            $subject = 'Подтверждение бронирования';
            $templatePath = $prepaidType == 100 ? "L-S/mail/templates/tmpl-pay-full" : "L-S/mail/templates/tmpl-pay-partial";
        }
        
        if(!empty($subject) and !empty($templatePath)){
            $template = LS_Mailer::getTemplate($templatePath, $data);
            $result = LS_Mailer::sendMail($emailTo, $subject, $template);
        }

        return $template;
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
        if ($order['status'] === 2 and isset($order['orderId'])) {
            $resultStatus = 502;
            // 2. Create At Amocrm Lead Id

            $leadData = [
                'price' => $order['price'],
                'peopleCount' => $request['count'],
                'dateFrom' => $request['dateStart'],
                'dateTo' => $request['dateEnd'],
                'orderId' => $order['orderId'],
                'calendarId' => $request['id'],
                'comment' => $request['comment'],
                'eventTabId' => $request['eventTabId'],
                'paymentMethod' => $request['paymentMethod']
            ];

            $contactData = [
                'contactName' => $request['fio'],
                'contactPhone' => $request['phone'],
                'contactEmail' => $request['email'],
                'contactPassport' => $request['passport']
            ];

            $leadId = $this->initAmoCrmLead($leadData, $contactData);
            $sandbox = get_webpay_sandbox($request['wsb_test']);

            if (isset($leadId)) {

                update_post_meta($order['orderId'], 'sbc_lead_id', $leadId);

                $secret_key = '2091988';
                $wsb_seed = strtotime("now");
                $wsb_storeid = $sandbox['wsb_storeid'];
                $wsb_order_num = $order['orderId'];
                $wsb_test = $sandbox['wsb_test'];
                $wsb_currency_id = 'BYN';
                $wsb_total = $order['price'];
                $wsb_signature = sha1($wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $secret_key);

                $result = [
                    "names" => [
                        '*scart'
                    ],
                    "values" => [
                        'wsb_storeid' => $wsb_storeid,
                        'wsb_store' => 'ИП Терещенко Иван Игоревич', 
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
                        'wsb_notify_url' => 'https://krasnagorka.by/wp-json/krasnagorka/v1/pay-success',
                        'wsb_return_url' => "https://krasnagorka.by/payed-success",
                    ]
                ];
                $resultStatus = 200;
                $result['status'] = 2;
            }
        } else if ($order['status'] === 1) {
            $resultStatus = 200;
            $result['status'] = 1;
        }
        return new WP_REST_Response($result, $resultStatus);
    }

    public function pay_success($request)
    {
        $order = get_order_data($_POST['site_order_id']);

        $prepaidType = $order['prepaidType'];
        $transaction_id = get_post_meta($_POST['site_order_id'], 'sbc_webpay_transaction_id', 1);

        if (isset($_POST['transaction_id']) and empty($transaction_id)) {
            
            update_post_meta($_POST['site_order_id'], 'sbc_webpay_transaction_id', $_POST['transaction_id']);

            if(!empty($order['prepaidType']) and $order['prepaidType'] != 100){
                $prepaidType = intval($prepaidType);
                update_post_meta($_POST['site_order_id'], 'sbc_order_select', 'prepaid');
                update_post_meta($_POST['site_order_id'], 'sbc_order_prepaid', $order['subprice']);
            }else{
                update_post_meta($_POST['site_order_id'], 'sbc_order_select', 'booked');
                update_post_meta($_POST['site_order_id'], 'sbc_order_prepaid', $order['price']);
            }
    
            $this->sendMail($order, true);

            ob_start();
            generateGuestMemo();
            $guestMemoMail = ob_get_contents();
            ob_end_clean();

            wp_mail([
                    $order['email']
                ],
                'Памятка гостя',
                $guestMemoMail
            );

            try {
                $this->updateAmoCrmLead($order);
            } catch (AmoCRMApiException $e) {
                Log::error("AmoCRMApiException Exception:" , $e->getTitle());
            }
        }
    }

    private function updateAmoCrmLead($order)
    {
        $leadId = $order['leadId'];

        $state = [
            'price' => intval($order['price']),
            'status' => 'booked',
            'col' => 35452474,
            'message' => 'Клиент оплатил 100%. Передать информацию Юре.'
        ];

        if(!empty($order['prepaidType']) and $order['prepaidType'] != 100){
            $state['price'] =  intval($order['subprice']);
            $state['status'] =  'prepaid';
            $state['col'] =  43023853;

            $prepaidType = intval($order['prepaidType']);
            $state['message'] = "Клиент оплатил $prepaidType%. Передать информацию Юре.";
        }

        if (!empty($leadId)) {
            $apiClient = self::getAmoCrmApiClient();
            $lead = $apiClient->leads()->getOne($leadId);
            $lead->setStatusId($state['col']);

            $leadCustomFields = new CustomFieldsValuesCollection();

            $payedFieldValueModel = new NumericCustomFieldValuesModel();
            $payedFieldValueModel->setFieldId(282777);
            $payedFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())->setValue(
                            $state['price']
                        )
                    )
            );
            $leadCustomFields->add($payedFieldValueModel);

            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue($state['status'])
                    )
            );
            $leadCustomFields->add($typeFieldValueModel);


            $lead->setCustomFieldsValues($leadCustomFields);

            $apiClient->leads()->updateOne($lead);


            $taskId = get_post_meta($order['orderId'], 'sbc_task_id', 1);
            if(!empty($taskId)){
                try {
                    $task = $apiClient->tasks()->getOne($taskId);
                   
                    $task->setTaskTypeId(2126242)
                        ->setText($state['message'])
                        ->setCompleteTill(mktime(date("H"), date("i") + 30))
                        ->setEntityType(EntityTypesInterface::LEADS)
                        ->setEntityId($lead->getId())
                        ->setDuration(1 * 60 * 60) // 1 час
                        ->setResponsibleUserId(2373844);
    
                    $task = $apiClient->tasks()->updateOne($task);
                } catch (AmoCRMApiException $e) {
                    Log::error("tasks exception:" , $e->getMessage());
                }  
            }
        }
    }

    private function getOrderById($orderID)
    {
        $order = [];
        try {
            $order['start'] = get_post_meta($orderID, 'sbc_order_start', 1);
            $order['end'] = get_post_meta($orderID, 'sbc_order_end', 1);
            $order['price'] = get_post_meta($orderID, 'sbc_order_price', 1);
            $order['leadId'] = get_post_meta($orderID, 'sbc_lead_id', 1);
            $order['email'] = getEmailFromOrder($orderID);
        } catch (Exception $e) {
            Logger::log("getOrderById Exception:" . $e->getMessage());
        }
        return $order;
    }

    private function createOrderForPay($request)
    {
        $result = ['status' => 0];
        try {
            $calendarId = $request['id'];
            $babyBed = $request['babyBed'] == 'true';
            Log::info('babyBed 2', $request['babyBed']);
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
                    if (!empty($eventTabId)) {
                        $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
                        foreach ($tabHouses as $tabHouse) {
                            $dateTabStart = date("Y-m-d", strtotime($tabHouse['from']));
                            $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
                            if ($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd) {
                                $price = $tabHouse['new_price'];
                                break;
                            }
                        }
                    }

                    $contactTemplate = $clientId . " " . $request['fio'] . " " . $request['phone'] . " " . $request['email'] . " <a href='https://krasnagorka.by/wp-admin/post.php?post=" . $clientId . "&action=edit' target='_blank' class='edit-link'>Редактировать</a>";
                    update_post_meta($order_id, 'sbc_order_client', $contactTemplate);
                    $this->update_all_clients_orders($clientId, $contactTemplate);
                    update_post_meta($order_id, 'sbc_order_select', 'reserved');

                    update_post_meta($order_id, 'sbc_order_payment_method', $request['paymentMethod']);
                    update_post_meta($order_id, 'sbc_order_prepaid_percantage', $request['prepaidType']);

                    update_post_meta($order_id, 'sbc_order_prepaid', '0');
                    update_post_meta($order_id, 'sbc_order_start', $dateStart);
                    update_post_meta($order_id, 'sbc_order_end', $dateEnd);
                    update_post_meta($order_id, 'sbc_order_price', $price);
                    if($babyBed){
                        Log::info('+');
                        update_post_meta($order_id, 'sbc_order_baby_bed', 'on');
                    }
                    update_post_meta($order_id, 'sbc_order_passport', $request['passport']);
                    update_post_meta($order_id, 'sbc_order_count_people', $request['count']);
                    update_post_meta($order_id, 'sbc_order_desc', $request['comment']."\nКоличество человек: ".$request['count']);

                    $objectIds = array_map('intval', [$calendarId]);
                    $objectIds = array_unique($objectIds);
                    wp_set_object_terms($order_id, $objectIds, 'sbc_calendars');
                    $result['status'] = 2;
                    $result['orderId'] = $order_id;
                    $result['price'] = $price;
                }
            } else {
                $result['status'] = 1;
            }
        } catch (Exception $e) {
            Logger::log("createOrderForPay Exception:" . $e->getMessage());
        }
        return $result;
    }

    private function initClient($request)
    {
        $clientId = null;
        $client = $this->get_client_by_meta(['meta_key' => 'sbc_client_email', 'meta_value' => $request['email']]);
        if ($client === false) {
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
        } else {
            $clientId = $client->ID;
            update_post_meta($clientId, 'sbc_client_phone', $request['phone']);
        }

        return $clientId;
    }

    private function getAmoCrmCatalogByCalendars($amocrm_catalogs_ids)
    {
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
            1663367 => 43,
            10389 => 16
        ];


        foreach ($amocrm_catalogs_ids as $value) {
            $calendars[] = $calendarObjectsReverse[$value];
        }
        return $calendars;
    }

    private function insertWPLead($request)
    {
        $type     = $request['type'];
        $orderId  = $request['orderId'];
        $leadId  = $request['leadId'];
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
            } else {
                $this->removeOrder($orderId);
            }

            $totalPrice = $request['totalPrice'];
            $havePayed  = $request['havePayed'];
            

            $contactName   = $request['contactName'];
            $contactPhone  = $request['contactPhone'];
            $contactEmail  = $request['contactEmail'];
            $contactStatus = $request['contactStatus'];
            $childs = $request['childs'];
            $peopleCount = $request['peopleCount'];
            $comment  = empty($request['comment']) ? "Количество человек: $peopleCount" : $request['comment']."\nКоличество человек: $peopleCount";
            $babyBed = $request['babyBed'] == 'true';
            Log::info('babyBed 1', $request['babyBed']);
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
                if (!empty($peopleCount)) {
                    update_post_meta($post_id, 'sbc_order_people_count', $peopleCount);
                    update_post_meta($post_id, 'sbc_order_count_people', $peopleCount);
                }

                if (!empty($request['passport'])) {
                    update_post_meta($post_id, 'sbc_order_passport', $request['passport']);
                }
                    
                if (!empty($leadId)) {
                    update_post_meta($post_id, 'sbc_lead_id', $leadId);
                }

                if (!empty($childs)) {
                    update_post_meta($post_id, 'sbc_order_childs', $childs);
                }

                if ($babyBed) {
                    Log::info('+');
                    update_post_meta($post_id, 'sbc_order_baby_bed', 'on');
                }


                $paymentMethod  = $request['paymentMethod'];
                if (!empty($paymentMethod)) {
                    update_post_meta($post_id, 'sbc_order_payment_method', $paymentMethod);
                }

                $prepaidType  = $request['prepaidType'];
                $sandbox = get_webpay_sandbox($request['wsb_test']);

                if (!empty($prepaidType)) {
                    $prepaidType = intval($prepaidType);
                    update_post_meta($post_id, 'sbc_order_prepaid_percantage', $prepaidType);

                    if($paymentMethod == 'card_layter' || $paymentMethod == 'card'){

                        $secret_key = '2091988';
                        $wsb_seed = strtotime("now");
                        $wsb_storeid = $sandbox['wsb_storeid'];
                        $wsb_order_num = $post_id;
                        $wsb_test = $sandbox['wsb_test'];
                        $wsb_currency_id = 'BYN';
                        $wsb_total = (int)($totalPrice * $prepaidType / 100);
                        if($prepaidType == 100){
                            $wsb_total = $totalPrice;
                        }
                        $wsb_signature = sha1($wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $secret_key);

                        $sourceValue = [
                            "names" => [
                                '*scart'
                            ],
                            "values" => [
                                'wsb_storeid' => $wsb_storeid,
                                'wsb_store' => 'ИП Терещенко Иван Игоревич', 
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
                                'wsb_notify_url' => 'https://krasnagorka.by/wp-json/krasnagorka/v1/pay-success',
                                'wsb_return_url' => "https://krasnagorka.by/payed-success",
                            ]
                        ];
                        $solt = "lightning-soft";
                        $source = md5($post_id . $solt);
                        update_post_meta($post_id, 'sbc_order_prepaid_source', $source);
                        update_post_meta($post_id, 'sbc_order_prepaid_value', json_encode($sourceValue, JSON_UNESCAPED_UNICODE));
                        if($paymentMethod == 'card') { 
                            $response['redirect'] = $sourceValue;
                        }
                    }
                }

                if (!empty($objectIds)) {
                    $objectIds = array_map('intval', $objectIds);
                    $objectIds = array_unique($objectIds);
                    wp_set_object_terms($post_id, $objectIds, 'sbc_calendars');
                }

                $response['orderId'] = $post_id;
            }
        } else {
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
                    if ($orderIdFromCrm != false) {
                        if ($orderIdFromCrm != $orId) {
                            $result = false;
                        }
                    } else {
                        $result = false;
                    }
                }

                if ($dateEnd > $from and $dateEnd <= $to) {
                    if ($orderIdFromCrm != false) {
                        if ($orderIdFromCrm != $orId) {
                            $result = false;
                        }
                    } else {
                        $result = false;
                    }
                }

                if ($dateStart < $from and $dateEnd > $to) {
                    if ($orderIdFromCrm != false) {
                        if ($orderIdFromCrm != $orId) {
                            $result = false;
                        }
                    } else {
                        $result = false;
                    }
                }
            }
        }

        return $result;
    }

    private function initAmoCrmLead($leadData, $contactData)
    {
        $price = $leadData['price'];
        $peopleCount = $leadData['peopleCount'];
        $dateFrom = $leadData['dateFrom'];
        $dateTo = $leadData['dateTo'];
        $orderId = $leadData['orderId'];
        $calendarId = $leadData['calendarId'];
        $comment = $leadData['comment'];
        $paymentMethod = $leadData['paymentMethod'];

        $contactName =  $contactData['contactName'];
        $contactPhone = $contactData['contactPhone'];
        $contactEmail = $contactData['contactEmail'];
        $contactPassport = $contactData['contactPassport'];

        /**
         * @var LeadModel $lead
         */
        $lead = null;
        try {
            $messagePrice = isset($leadData['eventTabId']) ? 'Спец. предложение' : 'Сумма:';
            $apiClient = self::getAmoCrmApiClient();

            $orderType = 'reserved';
            $commentNote = "ФИО: $contactName\n$messagePrice: $price руб.\nКоличество человек: $peopleCount\nПаспорт №: $contactPassport\nКомментарий: $comment";
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
                            ->setValue($comment)
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

            try {
                $contactsCollection = $apiClient->contacts()->get($contactsFilter);
            } catch (AmoCRMApiException $e) {
                Logger::log('Exceptions: contact phone ' . $e->getTitle());
            }

            if (!empty($contactsCollection) and $contactsCollection->count() > 0) {
                $contact = $contactsCollection->first();
                $contact->setName($contactName);
                $customFields = $contact->getCustomFieldsValues();

                $emailField = $customFields->getBy('fieldCode', 'EMAIL');
                if (empty($emailField)) {
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

                if (!empty($contactPassport)) {
                    $passportFieldValueModel = new TextCustomFieldValuesModel();
                    $passportFieldValueModel->setFieldId(638673);
                    $passportFieldValueModel->setValues(
                        (new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                                ->setValue($contactPassport))
                    );
                    $customFields->add($passportFieldValueModel);
                }

                $contact = $apiClient->contacts()->updateOne($contact);
            } else {
                $contactsFilter->setQuery($contactEmail);

                try {
                    $contactsCollection = $apiClient->contacts()->get($contactsFilter);
                } catch (AmoCRMApiException $e) {
                    Logger::log('Exceptions: contact email ' . $e->getTitle());
                }

                if (!empty($contactsCollection) and $contactsCollection->count() > 0) {
                    $contact = $contactsCollection->first();
                    $contact->setName($contactName);

                    $customFields = $contact->getCustomFieldsValues();
                    $phoneField = $customFields->getBy('fieldCode', 'PHONE');
                    if (empty($phoneField)) {
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

                    if (!empty($contactPassport)) {
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                    ->setValue($contactPassport))
                        );
                        $customFields->add($passportFieldValueModel);
                    }

                    $contact = $apiClient->contacts()->updateOne($contact);
                } else {
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

                    if (!empty($contactPassport)) {
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                    ->setValue($contactPassport))
                        );
                        $contactCustomFields->add($passportFieldValueModel);
                    }

                    $contact = $apiClient->contacts()->addOne($contact);
                }
            }

            $links = new LinksCollection();
            $links->add($contact);

            $apiClient->leads()->link($lead, $links);


            // Создадим задачу
            $tasksCollection = new TasksCollection();
            $task = new TaskModel();
            $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
                ->setText('Помочь клиенту определиться с заказом')
                ->setCompleteTill(mktime(date("H"), date("i") + 30))
                ->setEntityType(EntityTypesInterface::LEADS)
                ->setEntityId($lead->getId())
                ->setDuration(1 * 60 * 60) // 1 час
                ->setResponsibleUserId(2373844);
            $tasksCollection->add($task);

            try {
                $tasksCollection = $apiClient->tasks()->add($tasksCollection);
                $taskToStore = $tasksCollection->first();
                update_post_meta($orderId, 'sbc_task_id', $taskToStore->getId());
            } catch (AmoCRMApiException $e) {
                Logger::log('Exceptions: ' . $e->getTitle() . ' <<< tasksCollection >>> ' . $e->getDescription());
            }

        } catch (AmoCRMApiException $e) {
            Logger::log('Exceptions: ' . $e->getTitle() . ' <<< addOne lead >>> ' . $e->getDescription());
        }
        return $lead->getId();
    }

    public static function getAmoCrmApiClient()
    {

        $clientId = 'fcead59e-467f-482d-ab48-4df278e0bc1c';
        $clientSecret = 'tUiAfQfEvIepyj1mLX0T7Zzbot8fpil1zIOoYfXqmZNSF7f4dqRR20dYy0qnlGIW';
        $redirectUri = 'https://krasnagorka.by/wp-content/themes/krasnagorka/token_actions.php';
        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $accessToken = getToken();
        $apiClient
            ->setAccountBaseDomain('krasnogorka.amocrm.ru')
            ->setAccessToken($accessToken)
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    // LS_WP_Logger::info('Refresh Token' , $accessToken->getRefreshToken());
                    saveToken(
                        [
                            'access_token' => $accessToken->getToken(),
                            'refresh_token' => $accessToken->getRefreshToken(),
                            'expires_in' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ]
                    );
                }
            );
        return $apiClient;
    }

    public function amocrm_v4_test()
    {
        $email = getEmailFromOrder('15618');
        return new WP_REST_Response(['status' => 1, 'email' => $email], 200);
    }

    public static function clear_order($leadId){
            $apiClient = self::getAmoCrmApiClient();
            $lead = $apiClient->leads()->getOne((int)$leadId);
            $leadCustomFields = new CustomFieldsValuesCollection();

            // Order ID
            $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            $orderIdFieldValueModel->setFieldId(639191);
            $orderIdFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue(null)
                    )
            );
            $leadCustomFields->add($orderIdFieldValueModel);

            // Order Type
            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue(null)
                    )
            );
            $leadCustomFields->add($typeFieldValueModel);

            $lead->setCustomFieldsValues($leadCustomFields);

            $lead = $apiClient->leads()->updateOne($lead);
            return $lead->getId();
    }
}

add_action('wp', 'refresh_amo_crm_api_client');
function refresh_amo_crm_api_client()
{
    if (!wp_next_scheduled('refresh_amo_crm')) {
        wp_schedule_event(time(), 'twicedaily', 'refresh_amo_crm');
    }
}

add_action('refresh_amo_crm', 'refresh_amo');
function refresh_amo()
{
    Booking_Form_Controller::getAmoCrmApiClient();
}
