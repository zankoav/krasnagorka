<?php

/**
 * Created by PhpStorm.
 * User: alexandrzanko
 * Date: 10/28/19
 * Time: 9:27 AM
 */
use Ls\Wp\Log as Log;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\TasksCollection;
use AmoCRM\Models\TaskModel;
use AmoCRM\Exceptions\AmoCRMApiException;

use AmoCRM\Collections\CustomFieldsValuesCollection;

use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;

use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;


class Model
{

    private $baseModel;
    private $DAYS = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

    public function __construct()
    {
        $this->baseModel = get_option('mastak_theme_options');
    }

    public function getPopupContacts()
    {
        $options = $this->baseModel;
        return [
            'a1'      => $options['mastak_theme_options_a1'],
            'mts'     => $options['mastak_theme_options_mts'],
            'life'    => $options['mastak_theme_options_life'],
            'email'   => $options['mastak_theme_options_email'],
            'time'    => $options['mastak_theme_options_time'],
            'weekend' => $options['mastak_theme_options_weekend'],
        ];
    }

    private function updateWeather()
    {
        $api     = "https://api.darksky.net/forecast/81b61e0936068afa7f3b5d5443c9f690/55.773202,27.072710?lang=ru&exclude=minutely,hourly,flags,alerts&units=auto";
        $weather = json_decode(file_get_contents($api), true);
        $result  = [];
        if (!empty($weather) and isset($weather["daily"]) and isset($weather["daily"]["data"])) {

            $days   = $weather["daily"]["data"];
            $result = [
                'day'         => date('w', $days[1]["time"]),
                'temperature' => round($days[1]["temperatureMax"]),
                'icon'        => "https://darksky.net/images/weather-icons/" . $days[1]["icon"] . ".png",
                'description' => $days[1]["summary"],
                'firstDay'    => [
                    'day'  => $this->DAYS[date('w', $days[2]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[2]["icon"] . ".png"
                ],
                'secondDay'   => [
                    'day'  => $this->DAYS[date('w', $days[3]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[3]["icon"] . ".png"
                ],
                'thirdDay'    => [
                    'day'  => $this->DAYS[date('w', $days[4]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[4]["icon"] . ".png"
                ]
            ];
        }
        update_option('krasnagorka_weather', json_encode($result));
        return $result;
    }

    public function getWeather()
    {

        $weatherStr = get_option('krasnagorka_weather');

        if (!empty($weatherStr)) {
            $weatherArray = json_decode($weatherStr, true);
            if ($weatherArray['day'] != date('w')) {
                return $this->updateWeather();
            } else {
                return $weatherArray;
            }
        } else {
            return $this->updateWeather();
        }
        return $this->updateWeather();
    }

    public function getMainMenu()
    {
        $menuItemsChildren = [];
        $menuItemsParents  = [];
        $items             = wp_get_nav_menu_items(3);
        foreach ($items as $item) {
            if ($item->menu_item_parent == 0) {
                $menuItemsParents[$item->ID] = [
                    'key'   => $item->ID,
                    'label' => $item->title,
                    'href'  => $item->url,
                ];
            } else {
                $menuItemsChildren[] = [
                    'key'    => $item->ID,
                    'label'  => $item->title,
                    'href'   => $item->url,
                    'parent' => $item->menu_item_parent
                ];
            }
        }

        foreach ($menuItemsChildren as $child) {
            if (empty($menuItemsParents[$child['parent']]['subItems'])) {
                $menuItemsParents[$child['parent']]['subItems'] = [$child];
            } else {
                $menuItemsParents[$child['parent']]['subItems'][] = $child;
            }
        }
        return array_values($menuItemsParents);
    }

    public function getFooterBottom()
    {
        $footer_logo_id  = $this->baseModel['footer_logo_id'];
        $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo')[0];
        $unp             = wpautop($this->baseModel['mastak_theme_options_unp']);
        $unp             = str_replace("\n", "", $unp);

        return [
            "logo"    => $footer_logo_src,
            'unp'     => $unp,
            "socials" => [
                [
                    'value' => 'insta',
                    'url'   => $this->baseModel['mastak_theme_options_instagram'],
                ],
                [
                    'value' => 'fb',
                    'url'   => $this->baseModel['mastak_theme_options_facebook'],
                ],
                [
                    'value' => 'ok',
                    'url'   => $this->baseModel['mastak_theme_options_odnoklassniki'],
                ],
                [
                    'value' => 'vk',
                    'url'   => $this->baseModel['mastak_theme_options_vkontakte'],
                ],
                [
                    'value' => 'youtube',
                    'url'   => $this->baseModel['mastak_theme_options_youtube'],
                ],
                [
                    'value' => 'telegram',
                    'url'   => $this->baseModel['mastak_theme_options_telegram'],
                ]
            ]
        ];
    }

    public function getCurrencies()
    {

        return [
            'byn' => 1,
            'rur' => get_option('rur_currency'),
            'usd' => get_option('usd_currency'),
            'eur' => get_option('eur_currency')
        ];
    }

    public function getBookingModel()
    {
        $bookingSettings = get_option('mastak_booking_appearance_options');
        $showPrice = $bookingSettings['booking_price_show'] == 'on';
        $showPayments = false;

        if($showPrice){
            $showPayments = $bookingSettings['booking_payments_show'] == 'on';
            $minPrepaidPrice = intval($bookingSettings['booking_payments_min_price']);
            $prepaidPercantage = intval($bookingSettings['booking_payments_type_percentage']);
            $prepaidOptions = [
                [
                    "label"=> "100%",
                    "value"=> 100
                ]
            ];

            if(isset($prepaidPercantage)){
                $prepaidOptions[] = [
                    "label"=> $prepaidPercantage . '%',
                    "value"=> $prepaidPercantage
                ];
            }
        }
        
        $bookingId = $_GET['booking'];
        $eventTabId = $_GET['eventTabId'];
        $dateFrom  = $_GET['from'];
        $dateTo    = $_GET['to'];
        $teremRoom = $_GET['terem'];
        $calendarId = $_GET['calendarId'];
        $title     = null;
        $type      = null;

        if (isset($bookingId)) {

            $post = get_post($bookingId);
            if (!empty($post) and ($post->post_type === 'house' or $post->post_type === 'event')) {
                $title = str_replace("\"", "\\\"", $post->post_title);
                if ($post->post_type === 'house') {
                    $type = 'Домик:';
                } else if ($post->post_type === 'event') {
                    $type = 'Акция:';
                }
            }
        }

        $maxCount = 99;
        if (!empty($calendarId)) {
            $maxCount = (int) get_term_meta($calendarId, 'kg_calendars_persons_count', 1);
        }

        if ($maxCount == 0) {
            $maxCount = 99;
        }
        $sandbox = get_webpay_sandbox();
        $pageBannerSrc = get_the_post_thumbnail_url(get_the_ID(), wp_is_mobile() ? 'header_tablet_p' : 'header_laptop_hd');
        $weather       = $this->getWeather();

        $selectedSeasonId = null;
        if (!empty($dateFrom) and !empty($dateTo)) {
            $selectedSeasonId = self::getSelectedSeasonId($dateFrom);
        }
        $textFullCard =  !empty($bookingSettings['text_full_card']) ? $bookingSettings['text_full_card'] : '';
        $textPartCard =  !empty($bookingSettings['text_part_card']) ? $bookingSettings['text_part_card'] : '';
        $textFullLaterCard =  !empty($bookingSettings['text_full_later_card']) ? $bookingSettings['text_full_later_card'] : '';
        $textPartLaterCard =  !empty($bookingSettings['text_part_later_card']) ? $bookingSettings['text_part_later_card'] : '';
        $textFullOffice =  !empty($bookingSettings['text_full_office']) ? $bookingSettings['text_full_office'] : '';
        $textPartOffice =  !empty($bookingSettings['text_part_office']) ? $bookingSettings['text_part_office'] : '';

        $result        = [
            'id'                => $calendarId,
            'admin'             => $showPrice,
            'webpaySandbox'     => $sandbox,
            'payment'           => $showPayments,
            'paymentMethod'     => $showPayments ? 'card' : '',
            'prepaidType'       => $showPayments ? 100 : '',
            'textFullCard'          => $textFullCard,
            'textPartCard'          => $textPartCard,
            'textFullLaterCard'     => $textFullLaterCard,
            'textPartLaterCard'     => $textPartLaterCard,
            'textFullOffice'        => $textFullOffice,
            'textPartOffice'        => $textPartOffice,
            'minPrice'          => $minPrepaidPrice,
            'prepaidOptions'    => $prepaidOptions,
            'maxCount'      => $maxCount,
            'houses'        => $this->getHouses(),
            'calendars'     => $this->getCalendars($calendarId),
            'mainMenu'      => $this->getMainMenu(),
            'seasons'       => $this->getAllSeasons($selectedSeasonId),
            'weather'       => $weather,
            'currencies'    => $this->getCurrencies(),
            'pageTitle'     => get_the_title(),
            'pageBannerSrc' => $pageBannerSrc,
            'popupContacts' => $this->getPopupContacts(),
            'mainContent'   => [
                "title"         => $title,
                "type"          => $type,
                "contractOffer" => $this->baseModel['contract_offer']
            ],
            "footerBottom"  => $this->getFooterBottom(),
            "babyBedPrice" => !empty($bookingSettings['baby_bed_price']) ? intval($bookingSettings['baby_bed_price']) : null,
            "bathHouseBlackPrice" => !empty($bookingSettings['bath_house_black_price']) ? intval($bookingSettings['bath_house_black_price']) : null,
            "bathHouseWhitePrice" => !empty($bookingSettings['bath_house_white_price']) ? intval($bookingSettings['bath_house_white_price']) : null,
            

            "foodBreakfastPrice" => !empty($bookingSettings['food_breakfast_price']) ? intval($bookingSettings['food_breakfast_price']) : 0,
            "foodLunchPrice" => !empty($bookingSettings['food_lunch_price']) ? intval($bookingSettings['food_lunch_price']) : 0,
            "foodDinnerPrice" => !empty($bookingSettings['food_dinner_price']) ? intval($bookingSettings['food_dinner_price']) : 0,
            "foodAvailable" => $bookingSettings['food_available'] == 'on',
            "foodNotAvailableText" => $bookingSettings['food_not_available_text']
        ];

        if (!empty($dateFrom) and !empty($dateTo)) {
            $result['dateFrom'] = $dateFrom;
            $result['dateTo']   = $dateTo;
        }

        if (!empty($eventTabId)) {
            $result['eventTabId'] = $eventTabId;
        }

        if (!empty($teremRoom)) {
            $result['mainContent']['title'] = $teremRoom;
        }

        if (!empty($result['eventTabId']) and !empty($calendarId) and !empty($result['dateFrom']) and !empty($result['dateTo'])) {

            $result['pay'] = true;
            $_eventTabId = $result['eventTabId'];
            $_dateFrom = $result['dateFrom'];
            $_dateTo = $result['dateTo'];

            $result['price'] = $this->getPriceFromEvent(
                $_eventTabId,
                $calendarId,
                $_dateFrom,
                $_dateTo
            );

            if ($result['pay']) {
                $SecretKey = '2091988';
                $wsb_seed = strtotime("now");
                $wsb_storeid = $sandbox['wsb_storeid'];
                $wsb_order_num = "gg-1";
                $wsb_test = $sandbox['wsb_test'];
                $wsb_currency_id = 'BYN';
                $wsb_total = $result['price'];
                $wsb_signature = sha1($wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $SecretKey);

                $result['webpay'] = [
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
                        'wsb_invoice_item_name[0]' => $result['mainContent']['title'],
                        'wsb_invoice_item_quantity[0]' => '1',
                        'wsb_invoice_item_price[0]' => $wsb_total,
                        'wsb_total' => $wsb_total,
                        'wsb_cancel_return_url' => "https://krasnagorka.by?order=$wsb_order_num",
                        'wsb_return_url' => "https://krasnagorka.by/booking-form?order=$wsb_order_num",
                    ]
                ];
            }

            if (isset($_GET['clear'])) {
                $this->tryToClearOrder($_GET['clear']);
            }
        }

        return json_encode($result);
    }

    public static function getSelectedSeasonId($dateFrom){
        $id = null;
        
        $firstSeasonIntervalParams = array(
            'post_type' => 'season_interval',
            'posts_per_page' => 1,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'relation' => 'AND',
                    [
                        'key'     => 'season_from',
                        'value'   => $dateFrom,
                        'type'    => 'DATE',
                        'compare' => '<='
                    ],
                    [
                        'key'     => 'season_to',
                        'value'   => $dateFrom,
                        'type'    => 'DATE',
                        'compare' => '>='
                    ]
                ]
            ]
        );
        $intervalsQuery = new WP_Query;
        $intervals = $intervalsQuery->query($firstSeasonIntervalParams);
        if(count($intervals) > 0){
            $id = get_post_meta($intervals[0]->ID,'season_id', 1);
        }

        return $id;
    }

    private function getHouses()
    {
        $result = [];
        $posts = get_posts(['post_type'   => 'house', 'numberposts' => -1]);

        foreach ($posts as $post) {
            $result[] = [
                'id' => $post->ID,
                'name' => $post->post_title
            ];
        }
        return $result;
    }

    private function getCalendars($calendarId)
    {
        $terms = get_terms(['taxonomy' => 'sbc_calendars']);
        $result = [];
        foreach ($terms as $term) {

            $isAvailable = get_term_meta($term->term_id, 'kg_calendars_visible', 1);
            $isTeremRoom = get_term_meta($term->term_id, 'kg_calendars_terem', 1);
            $isDeprecateBabyBed = get_term_meta($term->term_id, 'kg_calendars_deprecate_baby_bed', 1);
            $isDeprecateAnimals = get_term_meta($term->term_id, 'kg_calendars_deprecate_animals', 1);

            if (!$isAvailable) {
                continue;
            }
            $selected = $calendarId == $term->term_id;
            $result[] = [
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'isTerem' => $isTeremRoom,
                'isDeprecatedBabyBed' => $isDeprecateBabyBed == 'on',
                'isDeprecateAnimals' => $isDeprecateAnimals == 'on',
                'isTerem' => $isTeremRoom,
                'selected' => $selected
            ];
        }
        return $result;
    }

    private function tryToClearOrder($orderId)
    {

        try {
            $orderId = (int) $orderId;
            if (is_int($orderId) and $orderId != 0) {

                delete_post_meta($orderId, 'sbc_order_client');
                delete_post_meta($orderId, 'sbc_order_select');
                delete_post_meta($orderId, 'sbc_order_start');
                delete_post_meta($orderId, 'sbc_order_end');
                delete_post_meta($orderId, 'sbc_order_price');
                delete_post_meta($orderId, 'sbc_order_prepaid');
                delete_post_meta($orderId, 'sbc_order_desc');


                $this->clearBookingAtAmoCRM($orderId);

                wp_delete_post($orderId, true);
            }
        } catch (Exception $e) {
            Logger::log("Exception: tryToClearOrder" . $orderId);
        }
    }

    private function clearBookingAtAmoCRM($orderId)
    {
        $taskId = get_post_meta($orderId, 'sbc_task_id', 1);
        $leadId = get_post_meta($orderId, 'sbc_lead_id', 1);

        try {
            $apiClient = Booking_Form_Controller::getAmoCrmApiClient();
            $task = $apiClient->tasks()->getOne($taskId);
            $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
                ->setText('Попытайтеся вернуть клиента на оплату')
                ->setCompleteTill(mktime(date("H"), date("i") + 30))
                ->setEntityType(EntityTypesInterface::LEADS)
                ->setEntityId($leadId)
                ->setDuration(1 * 60 * 60) // 1 час
                ->setResponsibleUserId(2373844);

            $task = $apiClient->tasks()->updateOne($task);

            $lead = $apiClient->leads()->getOne($leadId);
            $leadCustomFields = new CustomFieldsValuesCollection();

            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue(null)
                    )
            );
            $leadCustomFields->add($typeFieldValueModel);

            $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            $orderIdFieldValueModel->setFieldId(639191);
            $orderIdFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue(null)
                    )
            );
            $leadCustomFields->add($orderIdFieldValueModel);


            $lead->setCustomFieldsValues($leadCustomFields);
            $apiClient->leads()->updateOne($lead);
        } catch (AmoCRMApiException $e) {
            Logger::log("AmoCRMApiException:" . $e->getMessage());
        }
    }

    private function redirect_to_404()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit();
    }

    private function getPriceFromEvent($eventTabId, $calendarId, $dateStart, $dateEnd)
    {
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
        return $freshPrice;
    }

    private function getAllSeasons($selectedSeasonId = null)
    {

        $calendarsFromTerem = [
            'Терем 1'=>18,
            'Терем 2'=>19,
            'Терем 3'=>20,
            'Терем 4'=>21,
            'Терем 5'=>22,
            'Терем 6'=>23,
            'Терем 7'=>24,
            'Терем 8'=>25,
            'Терем 9'=>26,
            'Терем 10'=>27,
            'Терем 11'=>28,
            'Терем 12'=>29
        ];

        $queryHouse = new WP_Query(array(
            'post_type'      => 'house',
            'posts_per_page' => -1
        ));

        $houses = $queryHouse->get_posts();


        $query = new WP_Query(array(
            'post_type'      => 'season',
            'posts_per_page' => -1
        ));

        $current_season_id = get_option('mastak_theme_options')['current_season'];

        $seasons = [];
        $posts   = $query->get_posts();
        foreach ($posts as $post) {
            $season = [];
            $season["id"] = $post->ID;
            $season["name"] = $post->post_title;
            $season["current"] = $selectedSeasonId == null ? ($post->ID == $current_season_id) : ($post->ID == $selectedSeasonId);
            $housesResult = [];

            foreach($calendarsFromTerem as $room_name => $room_id){
                $roomPrice = get_post_meta($post->ID, "room_price_$room_id", true);
                $roomMinPeople = get_post_meta($post->ID, "room_min_people_$room_id", true);
                $roomMinDays = get_post_meta($post->ID, "room_min_days_$room_id", true);
                $roomMinPercent = get_post_meta($post->ID, "room_min_percent_$room_id", true);

                $roomSmallAnimalPrice = intval(get_post_meta($post->ID, "room_small_animal_price_$room_id", true) ?? 0);
                $roomBigAnimalPrice = intval(get_post_meta($post->ID, "room_big_animal_price_$room_id", true) ?? 0);

                $roomPeoplesForSalesEntities = get_post_meta($post->ID, "room_people_for_sale_$room_id", true);

                $roomPeoplesForSales = [];

                foreach ((array) $roomPeoplesForSalesEntities as $key => $entry) {

                    $roomPeoplesForSale = [];

                    if (isset($entry['sale_percent']) and isset($entry['sale_people'])) {

                        $roomPeoplesForSale['people'] = $entry['sale_people'];
                        $roomPeoplesForSale['percent'] = $entry['sale_percent'];

                        $roomPeoplesForSales[] = $roomPeoplesForSale;
                    }
                    // Do something with the data
                }

                $housesResult[] = [
                    'id' => $room_id,
                    'price' => $roomPrice,
                    'minPeople' => $roomMinPeople,
                    'minDays' => $roomMinDays,
                    'minPercent' => $roomMinPercent,
                    'smallAnimalPrice' => $roomSmallAnimalPrice,
                    'bigAnimalPrice' => $roomBigAnimalPrice,
                    'peoplesForSales' => $roomPeoplesForSales
                ];
            }

            foreach ($houses as $house) {
                $housePrice = get_post_meta($post->ID, "house_price_$house->ID", true);

                $houseMinPeople = get_post_meta($post->ID, "house_min_people_$house->ID", true);
                $houseMinDays = get_post_meta($post->ID, "house_min_days_$house->ID", true);
                $houseMinPercent = get_post_meta($post->ID, "house_min_percent_$house->ID", true);

                $houseSmallAnimalPrice = intval(get_post_meta($post->ID, "house_small_animal_price_$house->ID", true) ?? 0);
                $houseBigAnimalPrice = intval(get_post_meta($post->ID, "house_big_animal_price_$house->ID", true) ?? 0);

                $housePeoplesForSalesEntities = get_post_meta($post->ID, "house_people_for_sale_$house->ID", true);

                $housePeoplesForSales = [];

                foreach ((array) $housePeoplesForSalesEntities as $key => $entry) {

                    $housePeoplesForSale = [];

                    if (isset($entry['sale_percent']) and isset($entry['sale_people'])) {

                        $housePeoplesForSale['people'] = $entry['sale_people'];
                        $housePeoplesForSale['percent'] = $entry['sale_percent'];

                        $housePeoplesForSales[] = $housePeoplesForSale;
                    }

                    
                    // Do something with the data
                }

                $housesResult[] = [
                    'id' => $house->ID,
                    'price' => $housePrice,
                    'minPeople' => $houseMinPeople,
                    'minDays' => $houseMinDays,
                    'minPercent' => $houseMinPercent,
                    'smallAnimalPrice' => $houseSmallAnimalPrice,
                    'bigAnimalPrice' => $houseBigAnimalPrice,
                    'peoplesForSales' => $housePeoplesForSales
                ];
            }

            $season["houses"] = $housesResult;

            $seasons[] = $season;
        }

        return $seasons;
    }
}
