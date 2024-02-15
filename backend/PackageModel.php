<?php
namespace LsModel;

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

class PackageModel extends ModelImpl
{

    private $packageId;
    private $package;

    public function setPackageId($packageId){
        $this->packageId = $packageId;
        $this->package = $this->getPackageValue();
    }

    protected function scenario(){
        return 'Package';
    }

    protected function createModel(){
        $bookingSettings = get_option('mastak_booking_appearance_options');
        $showPrice = $bookingSettings['booking_price_show'] == 'on';
        $showPayments = false;

        if($showPrice){
            $showPayments = $bookingSettings['booking_payments_show'] == 'on';
            $minPrepaidPrice = $bookingSettings['booking_payments_min_price'] ?? "0";
            $minPrepaidPrice = str_replace(",",".", $minPrepaidPrice);
            $minPrepaidPrice = floatval($minPrepaidPrice);
            
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

        if(isset($_GET['obj'])){
            $bookingId = $_GET['obj'];
        }

        $eventId  = $_GET['eventId'];
        $variantId = $_GET['var'];
        $people = $_GET['people'];

        if(!empty($eventId) && !empty($eventTabId)){
            $intervalId = get_post_meta($eventTabId, 'mastak_event_tab_type_10_interval', 1);
            $dateFrom  = get_post_meta($intervalId, "season_from", 1);
            $dateTo    = get_post_meta($intervalId, "season_to", 1);
        }
        
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
        $pageBannerSrc = get_option('mastak_booking_appearance_options')['mastak_booking_pageimage'];
        
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

        $babyBeadPrice = $bookingSettings['baby_bed_price'] ?? "0";
        $babyBeadPrice = str_replace(",",".", $babyBeadPrice);
        $babyBeadPrice = floatval($babyBeadPrice);

        $bathHouseBlackPrice = $bookingSettings['bath_house_black_price'] ?? "0";
        $bathHouseBlackPrice = str_replace(",",".", $bathHouseBlackPrice);
        $bathHouseBlackPrice = floatval($bathHouseBlackPrice);

        $bathHouseWhitePrice = $bookingSettings['bath_house_white_price'] ?? "0";
        $bathHouseWhitePrice = str_replace(",",".", $bathHouseWhitePrice);
        $bathHouseWhitePrice = floatval($bathHouseWhitePrice);

        $foodBreakfastPrice = $bookingSettings['food_breakfast_price'] ?? "0";
        $foodBreakfastPrice = str_replace(",",".", $foodBreakfastPrice);
        $foodBreakfastPrice = floatval($foodBreakfastPrice);

        $foodLunchPrice = $bookingSettings['food_lunch_price'] ?? "0";
        $foodLunchPrice = str_replace(",",".", $foodLunchPrice);
        $foodLunchPrice = floatval($foodLunchPrice);

        $foodDinnerPrice = $bookingSettings['food_dinner_price'] ?? "0";
        $foodDinnerPrice = str_replace(",",".", $foodDinnerPrice);
        $foodDinnerPrice = floatval($foodDinnerPrice);

        $foodTripleSalePrice = $bookingSettings['food_triple_sale_price'] ?? "0";
        $foodTripleSalePrice = str_replace(",",".", $foodTripleSalePrice);
        $foodTripleSalePrice = floatval($foodTripleSalePrice);

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
            'package' => $this->package,
            'seasons'       => $this->getAllSeasons($selectedSeasonId),
            'pageTitle'     => get_the_title(),
            'pageBannerSrc' => $pageBannerSrc,
            'foodTripleSalePrice' => $foodTripleSalePrice,
            'mainContent'   => [
                "title"         => $title,
                "type"          => $type,
                "contractOffer" => $this->themeOptions['contract_offer']
            ],
            "babyBedPrice" => $babyBeadPrice,
            "bathHouseBlackPrice" => $bathHouseBlackPrice,
            "bathHouseWhitePrice" => $bathHouseWhitePrice,
            
            "foodBreakfastPrice" => $foodBreakfastPrice,
            "foodLunchPrice" => $foodLunchPrice,
            "foodDinnerPrice" => $foodDinnerPrice,
            "foodAvailable" => $bookingSettings['food_available'] == 'on',
            "foodNotAvailableText" => $bookingSettings['food_not_available_text'] ?? ''
        ];

        if (!empty($dateFrom) and !empty($dateTo)) {
            $result['dateFrom'] = $dateFrom;
            $result['dateTo']   = $dateTo;
        }

        if (!empty($eventTabId)) {
            $result['eventTabId'] = $eventTabId;
        }

        if (!empty($eventId)) {
            $result['eventId'] = $eventId;
        }

        if (!empty($people)) {
            $result['people'] = $people;
        }

        if (!empty($teremRoom)) {
            $result['mainContent']['title'] = $teremRoom;
        }

        if (!empty($result['eventTabId']) and !empty($calendarId) and !empty($result['dateFrom']) and !empty($result['dateTo'])) {

            $result['pay'] = false;
            $result['house'] = [
                'calendarId' => $calendarId
            ];
            $_eventTabId = $result['eventTabId'];
            $_dateFrom = $result['dateFrom'];
            $_dateTo = $result['dateTo'];

            if(!empty($eventId) && !empty($eventTabId)){
                $tab = new Type_10($eventTabId);
                $selectedCalendar = $tab->getSelectedCalendar($calendarId, $variantId );
                $price = empty($selectedCalendar['calendar']['new_price']) ? $selectedCalendar['calendar']['old_price'] : $selectedCalendar['calendar']['new_price'];
                $result['price'] = ($price + $selectedCalendar['variant']->pricePerDay) * (count($selectedCalendar['interval']['days']) - 1) * $people + $selectedCalendar['variant']->priceSingle;

                $dFrom = new DateTime($result['dateFrom']);
                $dFrom = $dFrom->modify('-1 day')->format('Y-m-d');

                $result['eventModel'] = [
                    'id' => $eventId,
                    'title' => get_the_title($eventId),
                    'variant' => $selectedCalendar['variant']->title,
                    'variantId' => $selectedCalendar['variant']->id,
                    'content' => [$selectedCalendar['variant']->descriptionPerDay, $selectedCalendar['variant']->descriptionSingle]
                    
                ];
                $result['dateFrom'] = $dFrom;

            }else{
                $result['price'] = $this->getPriceFromEvent(
                    $_eventTabId,
                    $calendarId,
                    $_dateFrom,
                    $_dateTo
                );
            }
            

            $result['total'] = [
                "accommodation" =>  $result['price'],
                "total_price" => $result['price'],
                "only_booking_order" => [
                    "message" => "!!! Message",
                    "enabled" => false
                ]
            ];

            $result['eventTabMessageInfo'] = 'При заказе горящего предложения, вы не можете изменить объект и даты проживания';

            if(!empty($eventId) && !empty($eventTabId)){
                $result['eventTabMessageInfo'] = '';
            }

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

        return $result;
    }

    private function getPackageValue(){

        $services = get_post_meta($this->packageId,'package_services', 1);
        $servicesFormatted = [];

        foreach ((array) $services as $key => $entry) {
            if (isset($entry['service'])) {
                $servicesFormatted[] = $entry['service'];
            }
        }

        $calendars = get_post_meta($this->packageId,'package_calendars', 1);
        $calendarsFormatted = [];

        foreach ((array) $calendars as $key => $entry) {
            if (isset($entry['calendar']) && isset($entry['package_price'])) {
                $calendarId = intval($entry['calendar']);
                $packagePrice = str_replace(",",".", $entry['package_price']);
                $packagePrice = floatval($packagePrice);
                $calendarsFormatted[$calendarId] = [
                    "id" => $calendarId,
                    "price_person_night" => $packagePrice,
                    "min_people" => intval($entry['package_people_min'])
                ];
            }
        }

        $depricatedStr = get_post_meta($this->packageId, 'package_depricated_days', 1);
        $daysDepricated = [];
        if (!empty($depricatedStr)) {
            $daysDepricated = preg_split('/\r\n|\r|\n/', $depricatedStr);
        }

        return [
            "id" => $this->packageId,
            "title" => get_the_title($this->packageId),
            "start_date" => get_post_meta($this->packageId,'package_start', 1),
            "end_date" => get_post_meta($this->packageId,'package_end', 1),
            "min_night" => intval(get_post_meta($this->packageId,'package_night_min', 1)),
            "services" => $servicesFormatted,
            "calendars" => $calendarsFormatted,
            "depricatedDayes" => $daysDepricated
        ];
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
        $intervalsQuery = new \WP_Query;
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

        $packageCalendars = array_keys($this->package['calendars']);

        $result = [];
        foreach ($terms as $term) {

            if(! in_array($term->term_id, $packageCalendars)){
                continue;
            }

            $isAvailable = get_term_meta($term->term_id, 'kg_calendars_visible', 1);
           
            if (!$isAvailable) {
                continue;
            }

            $isTeremRoom = get_term_meta($term->term_id, 'kg_calendars_terem', 1);
            $isDeprecateBabyBed = get_term_meta($term->term_id, 'kg_calendars_deprecate_baby_bed', 1);
            $isDeprecateAnimals = get_term_meta($term->term_id, 'kg_calendars_deprecate_animals', 1);
            $maxChild = get_term_meta($term->term_id, 'kg_calendars_max_child', 1);

            $selected = $calendarId == $term->term_id;
            $result[] = [
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'isTerem' => $isTeremRoom,
                'isDeprecatedBabyBed' => $isDeprecateBabyBed == 'on',
                'isDeprecateAnimals' => $isDeprecateAnimals == 'on',
                'maxChild' => intval($maxChild),
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

    private function getPriceFromEvent($eventTabId, $calendarId, $dateStart, $dateEnd)
    {
        $freshPrice = null;
        $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
        foreach ($tabHouses as $tabHouse) {
            $dateTabStart = date("Y-m-d", strtotime($tabHouse['from']));
            $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
            if ($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd) {
                $newPrice = str_replace(",",".", $tabHouse['new_price']);
                $newPrice  = floatval($newPrice );
                $freshPrice = $newPrice ;
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

        $queryHouse = new \WP_Query(array(
            'post_type'      => 'house',
            'posts_per_page' => -1
        ));

        $houses = $queryHouse->get_posts();


        $query = new \WP_Query(array(
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
            $season["order"] = get_post_meta($post->ID, "season_order", true);
            $season["current"] = $selectedSeasonId == null ? ($post->ID == $current_season_id) : ($post->ID == $selectedSeasonId);
            $housesResult = [];

            foreach($calendarsFromTerem as $room_name => $room_id){
                $roomPrice = get_post_meta($post->ID, "room_price_$room_id", true);
                $roomPrice = str_replace(",",".", $roomPrice);
                $roomPrice = floatval($roomPrice);

                $roomMinPeople = get_post_meta($post->ID, "room_min_people_$room_id", true);
                $roomMinDays = get_post_meta($post->ID, "room_min_days_$room_id", true);
                $roomMinPercent = get_post_meta($post->ID, "room_min_percent_$room_id", true);

                $roomSmallAnimalPrice = get_post_meta($post->ID, "room_small_animal_price_$room_id", true) ?? 0;
                $roomSmallAnimalPrice = str_replace(",",".", $roomSmallAnimalPrice);
                $roomSmallAnimalPrice = floatval($roomSmallAnimalPrice);

                $roomBigAnimalPrice = get_post_meta($post->ID, "room_big_animal_price_$room_id", true) ?? 0;
                $roomBigAnimalPrice = str_replace(",",".", $roomBigAnimalPrice);
                $roomBigAnimalPrice = floatval($roomBigAnimalPrice);

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
                $housePrice = str_replace(",",".", $housePrice);
                $housePrice = floatval($housePrice);

                $houseMinPeople = get_post_meta($post->ID, "house_min_people_$house->ID", true);
                $houseMinDays = get_post_meta($post->ID, "house_min_days_$house->ID", true);
                $houseMinPercent = get_post_meta($post->ID, "house_min_percent_$house->ID", true);

                $houseSmallAnimalPrice = get_post_meta($post->ID, "house_small_animal_price_$house->ID", true) ?? 0;
                $houseSmallAnimalPrice = str_replace(",",".", $houseSmallAnimalPrice);
                $houseSmallAnimalPrice = floatval($houseSmallAnimalPrice);
                
                $houseBigAnimalPrice = get_post_meta($post->ID, "house_big_animal_price_$house->ID", true) ?? 0;
                $houseBigAnimalPrice = str_replace(",",".", $houseBigAnimalPrice);
                $houseBigAnimalPrice = floatval($houseBigAnimalPrice);

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
