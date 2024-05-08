<?php

use Ls\Wp\Log as Log;
use LsModel\BaseModel as BaseModel;
use LsCalculate\PackageAdminCalculate as PackageAdminCalculate;
use LsCalculate\PackageCalculate as PackageCalculate;


class LS_Booking_Form_Controller extends WP_REST_Controller
{

    public function register_routes()
    {
        $namespace = 'krasnagorka/v1';

        register_rest_route($namespace, '/ls/event-tab/', [
            array(
                'methods'             => 'GET',
                'callback'            => array($this, 'event_tab')
            ),
        ]);

        register_rest_route($namespace, '/ls/house/', [
            array(
                'methods'             => 'GET',
                'callback'            => array($this, 'order_house')
            ),
        ]);

        register_rest_route($namespace, '/ls/calculate/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'calculate'),
                'permission_callback' => array($this, 'calculate_permissions_check')
            ),
        ]);

        register_rest_route($namespace, '/ls/telegram/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'telegram'),
                'permission_callback' => array($this, 'telegram_permissions_check')
            ),
        ]);

        register_rest_route($namespace, '/ls/current-season/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'current_season'),
                'permission_callback' => array($this, 'current_season_permissions_check')
            ),
        ]);

        register_rest_route($namespace, '/ls/check-order/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'check_order'),
                'permission_callback' => array($this, 'check_order_permissions_check')
            ),
        ]);
    }

    public function check_order_permissions_check($request)
    {
        return true;
    }

    public function calculate_permissions_check($request)
    {
        return true;
    }

    public function telegram_permissions_check($request)
    {
        return true;
    }

    public function current_season_permissions_check($request)
    {
        return true;
    }

    public function check_order($request)
    {
        $calendarId = $request['calendarId'];
        $dateStart = date("Y-m-d", strtotime($request['dateStart']));
        $dateEnd =  date("Y-m-d", strtotime($request['dateEnd']));
        $toDay = date("Y-m-d");

        if (empty($calendarId) or empty($dateStart) or empty($dateEnd)) {
            return new WP_REST_Response(['error' => 'Invalid data'], 400);
        }

        $result = [
            'available' => true
        ];

        if ($toDay > $dateStart) {
            $result['available'] = false;
            $result['message'] = 'Упс! Устаревшая бронь :(';
            return new WP_REST_Response($result, 200);
        }

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

        foreach ($orders  as $item) {
            $orderId = $item->ID;
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
                $result['available'] = false;
            }

            if ($dateEnd > $from and $dateEnd <= $to) {
                $result['available'] = false;
            }

            if ($dateStart < $from and $dateEnd > $to) {
                $result['available'] = false;
            }
        }

        if (!$result['available']) {
            $result['message'] = 'Упс! Бронь уже занята :(';
        }

        return new WP_REST_Response($result, 200);
    }

    /**
     * addres wordpress/wp-json/krasnagorka/v1/ls/event-tab/?tabId=5  
     */
    public function event_tab($request)
    {
        $tabId = absint($request['tabId']);
        $tab = new Type_10($tabId);
        return new WP_REST_Response($tab->getData(), 200);
    }

    public function order_house($request)
    {
        $query = new WP_Query([
            'post_type' => 'house',
            'posts_per_page' => -1
        ]);
        $calendarId = trim($request['calendarId']);
        $isTeremCalendar = trim($request['isTeremCalendar']) == 'on';
        if ($calendarId == '') {
            exit('enter calendarID');
        }
        $houseInfo = [];
        foreach ($query as $house) {
            $query->the_post();
            $houseId = get_the_ID();
            $metaId = get_post_meta($houseId, "mastak_house_calendar", true);
            $isTerem = get_post_meta($houseId, 'mastak_house_is_it_terem', true);
            $metaId = preg_replace('/[^0-9]/', '', $metaId);


            $daysSalesEntries = get_post_meta($houseId, "sale_days", true);
            $daysSales = [];
            foreach ((array) $daysSalesEntries as $key => $entry) {
                if (isset($entry['sale'])) {
                    $daysSales[] = $entry;
                }
            }


            if ($metaId == $calendarId) {
                $imageId = get_post_thumbnail_id();
                $picture = wp_get_attachment_image_url($imageId, 'welcome_tab_laptop');
                $houseInfo = [
                    'id' => $houseId,
                    'peopleMaxCount' => get_post_meta($houseId, "max_people", true),
                    'picture' => $picture,
                    'daysSales' => $daysSales,
                    'link' => get_the_permalink($houseId),
                    'title' => get_the_title()
                ];
                break;
            } else if ($isTeremCalendar and $isTerem) {
                $imageId = get_post_thumbnail_id();
                $picture = wp_get_attachment_image_url($imageId, 'welcome_tab_laptop');
                $maxCount = (int) get_term_meta($calendarId, 'kg_calendars_persons_count', 1);
                $term = get_term($calendarId);
                $houseInfo = [
                    'id' => $houseId,
                    'peopleMaxCount' => $maxCount,
                    'daysSales' => $daysSales,
                    'isTerem' => true,
                    'calendarId' => $calendarId,
                    'link' => get_the_permalink($houseId),
                    'picture' => $picture,
                    'title' => $term->name
                ];
                break;
            } else {
                $houseInfo = 'this house not found';
            }
        }
        return new WP_REST_Response($houseInfo, 200);  // addres wordpress/wp-json/krasnagorka/v1/ls/house/?calendarId=5
    }

    public function current_season($request)
    {
        $selectedSeasonId = BaseModel::getSelectedSeasonId($request['dateStart']);
        return new WP_REST_Response(['seasonId' => $selectedSeasonId], 200);
    }

    public function telegram($request)
    {
        $calendarId = intval($request['calendarId']);
        $dateFrom = $request['dateFrom'];
        $dateTo = $request['dateTo'];

        $oldPrice = intval($request['oldPrice']);
        $newPrice = intval($request['newPrice']);

        $dateEndDT = new \DateTime($dateTo);
        $period = new \DatePeriod(
            new \DateTime($dateFrom),
            new \DateInterval('P1D'),
            $dateEndDT
        );
        $night_count = iterator_count($period);
        $newPricePerNight = round($newPrice  / $night_count);
        $oldPricePerNight = round($oldPrice / $night_count);

        $index = intval($request['index']);
        $tabId = $request['postId'];

        $tabItems = get_post_meta($tabId, 'mastak_event_tab_type_8_items', 1);
        $tabItem = $tabItems[$index];

        $house = getHouseByCalendarId($calendarId);
        $houseId = $house['id'];
        if (empty($tabItem['image'])) {
            $house['photo'] = get_the_post_thumbnail_url($houseId, 'full');
        } else {
            $house['photo'] = $tabItem['image'];
        }
        $house['link'] = get_the_permalink($houseId);
        $house['calendar'] = get_term($calendarId, 'sbc_calendars')->name;

        $description = $tabItem["tg_description"];
        $saleText = $tabItem["sale_text"];

        $orderDateFrom = date("Y-m-d", strtotime($dateFrom));
        $orderDateTo = date("Y-m-d", strtotime($dateTo));

        $orderLink = "https://krasnagorka.by/booking-form/?eventTabId=$tabId&booking=$houseId&calendarId=$calendarId&from=$orderDateFrom&to=$orderDateTo";

        if ($house['terem'] == 'on') {
            $calendarTitle = $house['calendar'];
            $orderLink .= "&terem=$calendarTitle";
        }

        $result = [
            'tg' => [
                'token' => '5949739525:AAED7FFZliBqmxkBuFb0RfFhi271dh7YJIs',
                'chat_id' => '1001643080340' //1001643080340// 1001716089662
            ],
            'photo' => $house['photo'],
            'house' => [
                'is_terem' => $house['terem'],
                'sale_text' => $saleText,
                'link' => $house['link'],
                'calendar' => $house['calendar']
            ],
            'date' => [
                'from' => date("d.m.Y", strtotime($dateFrom)),
                'to' => date("d.m.Y", strtotime($dateTo))
            ],
            'sale' => intval(100 - ($newPrice * 100) / $oldPrice),
            'sale_per_night' => intval(100 - ($newPricePerNight * 100) / $oldPricePerNight),
            'price' => [
                'old' => $oldPrice,
                'new' => $newPrice,
                'per_night_old' => $oldPricePerNight,
                'per_night_new' => $newPricePerNight
            ],
            'order_link' => $orderLink,
            'description' => $description
        ];

        return new WP_REST_Response($result, 200);
    }

    public function calculate($request)
    {
        $scenario = $request['scenario'];
        $result = null;

        if ($scenario === 'Package') {
            $calculateModel = new PackageCalculate();
            $result = $calculateModel->response($request);
        } else {
            $result = self::calculateResult($request);
        }

        return new WP_REST_Response($result, 200);
    }

    public static function calculateResult($request)
    {

        $response;

        $isAdminEvent = $request['is_admin_event'];
        $intervallId = $request['intervallId'];

        if ($isAdminEvent && isset($intervallId)) {
            $calculateModel = new PackageAdminCalculate();
            $response = $calculateModel->response($request);
            return new WP_REST_Response($response, 200);
        }


        $seasonsIntervals = [];
        $houseId = $request['house'] ?? $request['houseId'];
        $calendarId = (int)$request['calendarId'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $peopleCount = (int)$request['peopleCount'];
        $eventTabId = $request['eventTabId'] != null ? intval($request['eventTabId']) : null;
        $eventId = intval($request['eventId']);
        $variantId = intval($request['variantId']);
        $isTerem = $request['isTerem'];

        if ($isAdminEvent) {
            $house = getHouseByCalendarId($calendarId);
            $houseId = $house['id'];

            $dateStart = date("Y-m-d", strtotime('+1 day', strtotime($request['dateFrom'])));
            $dateEnd = date("Y-m-d", strtotime($request['dateTo']));

            if (!empty($intervallId)) {
                $dateStart = get_post_meta($intervallId, "season_from", true);
                $dateStart = date("Y-m-d", strtotime($dateStart));
                $dateEnd = get_post_meta($intervallId, "season_to", true);
                $dateEnd = date("Y-m-d", strtotime($dateEnd));
            }

            $isTerem = $house['terem'];

            if (isset($request['peopleCount'])) {
                $peopleCount = (int)$request['peopleCount'];
            } else {
                if ($isTerem) {
                    $peopleCount = (int) get_term_meta($calendarId, 'kg_calendars_persons_count', 1);
                } else {
                    $peopleCount = (int) get_post_meta($houseId, "max_people", true);
                }
            }
        }


        $smallAnimalCount = intval($request['smallAnimalCount']);
        $bigAnimalCount = intval($request['bigAnimalCount']);
        $bathHouseWhite = $request['bathHouseWhite'];
        $bathHouseBlack = $request['bathHouseBlack'];

        $bookingSettings = get_option('mastak_booking_appearance_options');

        $dateEndDT = new DateTime($dateEnd);

        $period = new DatePeriod(
            new DateTime($dateStart),
            new DateInterval('P1D'),
            $dateEndDT->modify('+1 day')
        );

        $days = [];
        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');
        }

        /**
         * is short order window
         */
        $removeOrderIncrease = self::isShortOrderWindow($days, $calendarId, $houseId, $isTerem);

        /**
         * is only booking order
         */
        $onlyBookingOrder = self::isOnlyBookingOrder($days, $calendarId, $houseId, $isTerem);

        if (empty($eventId) and !empty($eventTabId)) {
            $onlyBookingOrder = false;
        }

        $result = [
            'total_price' => 0,
            'days_count' => count($days),
            'seasons_group' => [],
            'only_booking_order' => $onlyBookingOrder,
            'baby_bed_available' => self::isAvailableBabyBed($days, $calendarId, $houseId, $isTerem)
        ];

        if ($eventTabId != null and $eventTabId != 0) {
            if (!empty($eventId)) {
                $tab = new Type_10($eventTabId);
                $selectedCalendar = $tab->getSelectedCalendar($calendarId, $variantId);
                $price = empty($selectedCalendar['calendar']['new_price']) ? $selectedCalendar['calendar']['old_price'] : $selectedCalendar['calendar']['new_price'];
                $result['total_price'] = ($price + $selectedCalendar['variant']->pricePerDay) * (count($selectedCalendar['interval']['days']) - 1) * $peopleCount + $selectedCalendar['variant']->priceSingle;
            } else {
                $result['total_price'] = self::getEventTotalPrice($eventTabId, $calendarId, $dateStart, $dateEnd);
            }
            $result['accommodation'] = $result['total_price'];
        } else {
            $houseDaysSales = get_post_meta($houseId, 'sale_days', 1);
            $houseDaysSalesResult = [];
            foreach ((array)$houseDaysSales as $key => $entry) {
                if (isset($entry['sale']) and isset($entry['dayes'])) {
                    $houseDaysSalesResult[$entry['dayes']] = $entry['sale'];
                }
            }
            ksort($houseDaysSalesResult);

            $daysSale = null;
            $daySaleNext = null;

            foreach ($houseDaysSalesResult as $dayesNumber => $sale) {
                $daySaleNext = [
                    'sale' => $sale,
                    'dayesNumber' => $dayesNumber
                ];
                if (count($days) < $dayesNumber) {
                    break;
                } else {
                    $daysSale = $sale;
                    $daySaleNext = null;
                }
            }

            $result['day_sale_next'] = $daySaleNext;

            $intervals = self::firstCalculeate($dateStart, $dateEnd);

            if (count($intervals) == 2) {
                $fromDates = [
                    get_post_meta($intervals[0]->ID, 'season_from', 1),
                    get_post_meta($intervals[1]->ID, 'season_from', 1)
                ];
                asort($fromDates);
                $fromDates = array_values($fromDates);
                $intervals = self::secondCalculeate($fromDates);
            }

            foreach ($intervals as $interval) {
                $seasonsIntervals[] = [
                    'date_from' => get_post_meta($interval->ID, 'season_from', 1),
                    'date_to' => get_post_meta($interval->ID, 'season_to', 1),
                    'season_id' => get_post_meta($interval->ID, 'season_id', 1)
                ];
            }

            foreach ($days as $day) {
                foreach ($seasonsIntervals as $interval) {
                    if ($interval['date_from'] <= $day and $interval['date_to'] >= $day) {
                        $season = $result['seasons_group'][$interval['season_id']];
                        if (empty($season)) {
                            $result['seasons_group'][$interval['season_id']] = [
                                'season_id' => $interval['season_id'],
                                'days' => []
                            ];
                        }
                        $result['seasons_group'][$interval['season_id']]['days'][] = $day;
                        continue;
                    }
                }
            }

            $seasonsQuery = new WP_Query(array(
                'post_type'      => 'season',
                'posts_per_page' => -1,
                'post__in' => array_keys($result['seasons_group'])
            ));

            $seasons   = $seasonsQuery->get_posts();
            foreach ($seasons as $season) {
                $prefix = 'house';
                if ($isTerem) {
                    $prefix = 'room';
                    $houseId = $calendarId;
                }
                $housePrice = (float)get_post_meta($season->ID, $prefix . '_price_' . $houseId, 1);
                $houseMinPeople = get_post_meta($season->ID, $prefix . '_min_people_' . $houseId, 1);
                $houseMinPeople = (float)str_replace(",", ".", $houseMinPeople);
                $houseMinDays = (float)get_post_meta($season->ID, $prefix . '_min_days_' . $houseId, 1);
                $houseMinPercent = (float)get_post_meta($season->ID, $prefix . '_min_percent_' . $houseId, 1);

                $houseSmallAnimalPrice = (float)(get_post_meta($season->ID, $prefix . '_small_animal_price_' . $houseId, 1) ?? 0);
                $houseBigAnimalPrice = (float)(get_post_meta($season->ID, $prefix . '_big_animal_price_' . $houseId, 1) ?? 0);

                $result['seasons_group'][$season->ID]['house_price'] = $housePrice;
                $result['seasons_group'][$season->ID]['house_min_people'] = $houseMinPeople;
                $result['seasons_group'][$season->ID]['house_min_days'] = $houseMinDays;
                $result['seasons_group'][$season->ID]['house_min_percent'] = $houseMinPercent;
                $result['seasons_group'][$season->ID]['house_small_animal_price'] = $houseSmallAnimalPrice;
                $result['seasons_group'][$season->ID]['house_big_animal_price'] = $houseBigAnimalPrice;

                $basePrice = $housePrice;
                $seasonDaysCount = count($result['seasons_group'][$season->ID]['days']);

                $basePeopleCount = $peopleCount;

                if ($peopleCount < $houseMinPeople and empty($intervallId)) {
                    $basePrice *= (float)$houseMinPeople;
                    $basePeopleCount = null;
                }

                $basePriceWithoutUpper = null;

                $percentTotal = 0;



                $upperPercent = false;

                if (!$removeOrderIncrease) {
                    $daysUpperPersents = self::getDaysUpperPersent($season->ID, $prefix . '_days_count_upper_' . $houseId);
                    if (count($daysUpperPersents) > 0) {
                        foreach ($daysUpperPersents as $day => $persent) {
                            if (count($days) <= intval($day)) {
                                $upperPercent = intval($persent);
                                break;
                            }
                        }
                    }
                }

                if ($upperPercent) {
                    $basePriceWithoutUpper = $basePrice;
                    // if(!$onlyBookingOrder['hide_upper']){
                    $percentTotal -= $upperPercent;
                    $houseMinPercent = $upperPercent;
                    // }
                } else if (!empty($houseMinDays) && !empty($houseMinPercent) && ($seasonDaysCount < $houseMinDays) && $seasonDaysCount == count($days)) {
                    $basePriceWithoutUpper = $basePrice;
                    // if(!$onlyBookingOrder['hide_upper'] and empty($intervallId)){
                    //     $percentTotal -= $houseMinPercent;
                    // }
                    if (empty($intervallId)) {
                        $percentTotal -= $houseMinPercent;
                    }
                }

                if (!$upperPercent) {
                    $percentTotal -= $houseMinPercent;
                    $houseMinPercent = null;
                    $basePriceWithoutUpper = null;
                }

                $result['seasons_group'][$season->ID]['price_block'] = [
                    'title' =>  $season->post_title,
                    'season_id' =>  $season->ID,
                    'base_price' => $basePrice,
                    'min_percent' => $houseMinPercent,
                    'base_price_without_upper' => $basePriceWithoutUpper,
                    'days_count' => $seasonDaysCount,
                    'base_people_count' => $basePeopleCount,
                    'days_sale' => (float)$daysSale,
                    'small_animals_price' => $houseSmallAnimalPrice,
                    'big_animals_price' => $houseBigAnimalPrice,
                    'small_animals_count' => $smallAnimalCount,
                    'big_animals_count' => $bigAnimalCount
                ];

                $housePeoplesForSalesEntities = get_post_meta($season->ID, $prefix . '_people_for_sale_' . $houseId, 1);
                $housePeoplesForSales = [];

                foreach ((array)$housePeoplesForSalesEntities as $key => $entry) {
                    if (isset($entry['sale_percent']) and isset($entry['sale_people'])) {
                        $housePeoplesForSales[$entry['sale_people']] = $entry['sale_percent'];
                    }
                }

                ksort($housePeoplesForSales);

                $peopleSale = null;
                $peopleSaleNext = null;

                foreach ((array)$housePeoplesForSales as $peopleNumber => $sale) {

                    $peopleSaleNext = [
                        'sale' => $sale,
                        'people' => $peopleNumber
                    ];

                    if ($peopleCount < $peopleNumber) {
                        break;
                    } else {
                        $peopleSale = $sale;
                        $peopleSaleNext = null;
                    }
                }

                $result['seasons_group'][$season->ID]['price_block']['people_sale'] = $peopleSale;
                $result['seasons_group'][$season->ID]['price_block']['people_sale_next'] = $peopleSaleNext;

                $deltaSale = 0;

                if (!empty($peopleSale)) {
                    $deltaSale += $peopleSale;
                }

                if (!empty($daysSale)) {
                    $deltaSale += $daysSale;
                }

                if (!$isAdminEvent) {
                    $percentTotal += $deltaSale;
                }

                $priceBlockTotal = round(
                    ($basePrice * (1 - $percentTotal / 100)) *
                        (empty($basePeopleCount) ? 1 : $basePeopleCount) *
                        $seasonDaysCount,
                    2
                );

                $smallAnimalBlockTotal = $seasonDaysCount * $houseSmallAnimalPrice * $smallAnimalCount;

                if (!empty($daysSale)) {
                    $smallAnimalBlockTotal = round($smallAnimalBlockTotal * (1 - $daysSale / 100));
                }

                $bigAnimalBlockTotal = $seasonDaysCount * $houseBigAnimalPrice * $bigAnimalCount;

                if (!empty($daysSale)) {
                    $bigAnimalBlockTotal = round($bigAnimalBlockTotal * (1 - $daysSale / 100));
                }

                $result['seasons_group'][$season->ID]['price_block']['total'] = $priceBlockTotal;

                $result['seasons_group'][$season->ID]['price_block']['small_animals_total'] = $smallAnimalBlockTotal;
                $result['seasons_group'][$season->ID]['price_block']['big_animals_total'] = $bigAnimalBlockTotal;

                $result['total_price'] += $priceBlockTotal;
                $result['total_price'] += $smallAnimalBlockTotal;
                $result['total_price'] += $bigAnimalBlockTotal;
                $result['total_price'] = $result['total_price'];
                $result['accommodation_price'] = $result['total_price'];
            }
        }

        $babyBed = $request['babyBed'];
        if ($babyBed) {
            $dayCount = intval($result['days_count']);

            $babyBedPrice = str_replace(",", ".", $bookingSettings['baby_bed_price']);
            $babyBedPrice  = floatval($babyBedPrice);

            $babyBedTotalPrice = $babyBedPrice * $dayCount;
            if (!empty($daysSale)) {
                $babyBedTotalPrice =  $babyBedTotalPrice * (1 - $daysSale / 100);
            }
            $result['total_price'] += $babyBedTotalPrice;

            $result['baby_bed'] = [
                'total_price' => $babyBedTotalPrice,
                'price' => $babyBedPrice,
                'days' => $dayCount,
                'discount' => $daysSale
            ];
        }

        $bathHouseWhitePrice = str_replace(",", ".", $bookingSettings['bath_house_white_price']);
        $bathHouseWhitePrice  = floatval($bathHouseWhitePrice);

        if (!empty($bathHouseWhite) and !empty($bathHouseWhitePrice)) {
            $bathHouseWhite = intval($bathHouseWhite);
            $bathHouseWhiteTotalPrice = $bathHouseWhitePrice * $bathHouseWhite;
            $result['bath_house_white'] = [
                'total_price' => $bathHouseWhiteTotalPrice,
                'price' => $bathHouseWhitePrice,
                'count' => $bathHouseWhite
            ];
            $result['total_price'] += $bathHouseWhiteTotalPrice;
        }

        $bathHouseBlackPrice = str_replace(",", ".", $bookingSettings['bath_house_black_price']);
        $bathHouseBlackPrice  = floatval($bathHouseBlackPrice);

        if (!empty($bathHouseBlack) and !empty($bathHouseBlackPrice)) {

            $bathHouseBlack = intval($bathHouseBlack);
            $bathHouseBlackTotalPrice = $bathHouseBlackPrice * $bathHouseBlack;
            $result['bath_house_black'] = [
                'total_price' => $bathHouseBlackTotalPrice,
                'price' => $bathHouseBlackPrice,
                'count' => $bathHouseBlack
            ];
            $result['total_price'] += $bathHouseBlackTotalPrice;
        }

        $foodAvailable = $bookingSettings['food_available'] == 'on';

        if ($foodAvailable) {

            $foodBreakfastPrice = $bookingSettings['food_breakfast_price'] ?? "0";
            $foodBreakfastPrice = str_replace(",", ".", $foodBreakfastPrice);
            $foodBreakfastPrice = floatval($foodBreakfastPrice);

            $foodLunchPrice = $bookingSettings['food_lunch_price'] ?? "0";
            $foodLunchPrice = str_replace(",", ".", $foodLunchPrice);
            $foodLunchPrice = floatval($foodLunchPrice);

            $foodDinnerPrice = $bookingSettings['food_dinner_price'] ?? "0";
            $foodDinnerPrice = str_replace(",", ".", $foodDinnerPrice);
            $foodDinnerPrice = floatval($foodDinnerPrice);

            $foodBreakfastCount = intval($request['foodBreakfast']);
            $foodLunchCount = intval($request['foodLunch']);
            $foodDinnerCount = intval($request['foodDinner']);

            $foodTripleSale = 0;

            if (!empty($bookingSettings['food_triple_sale_price'])) {
                $foodTripleSalePrice = $bookingSettings['food_triple_sale_price'] ?? "0";
                $foodTripleSalePrice = str_replace(",", ".", $foodTripleSalePrice);
                $foodTripleSalePrice = floatval($foodTripleSalePrice);

                if ($foodBreakfastCount > 0 && $foodLunchCount > 0 && $foodDinnerCount > 0) {
                    $foodTripleSale = $foodTripleSalePrice * min($foodBreakfastCount, $foodLunchCount, $foodDinnerCount);
                }
            }

            if ($isAdminEvent) {
                $foodTripleSale = 0;
            }

            $foodVariant = $request['foodVariant'];
            $foodPackageSale = 0;
            if (!empty($foodVariant) and $foodVariant != 'custom' and $foodVariant != 'no_food') {
                $foodTripleSale = 0;
                $foodPackageSale = $bookingSettings["food_package_" . $foodVariant . "_sale"] ?? "0";
                $foodPackageSale = str_replace(",", ".", $foodPackageSale);
                $foodPackageSale = floatval($foodPackageSale);
            }

            $result['food'] = [
                'breakfast' => [
                    'total_price' => $foodBreakfastPrice * $foodBreakfastCount,
                    'price' => $foodBreakfastPrice,
                    'count' => $foodBreakfastCount
                ],
                'lunch' => [
                    'total_price' => $foodLunchPrice * $foodLunchCount,
                    'price' => $foodLunchPrice,
                    'count' => $foodLunchCount
                ],
                'dinner' => [
                    'total_price' => $foodDinnerPrice * $foodDinnerCount,
                    'price' => $foodDinnerPrice,
                    'count' => $foodDinnerCount
                ],
                'total_price' => (100 - $foodPackageSale) / 100 * ($foodBreakfastPrice * $foodBreakfastCount + $foodLunchPrice * $foodLunchCount + $foodDinnerPrice * $foodDinnerCount - $foodTripleSale),
                'sale' => $foodTripleSale,
                'packageSale' => $foodPackageSale,
            ];

            $result['total_price'] += $result['food']['total_price'];
        }

        return $result;
    }

    public static function isAvailableBabyBed($days, $calendarId, $houseId, $isTerem)
    {
        $bookingSettings = get_option('mastak_booking_appearance_options');
        $babyBedTotalCount = !empty($bookingSettings['baby_bed_count']) ? intval($bookingSettings['baby_bed_count']) : 0;

        $cId = false;
        if ($isTerem) {
            $cId = $calendarId;
        } else {
            $calendarShortCode =  get_post_meta($houseId, "mastak_house_calendar", true);
            $cId = getCalendarId($calendarShortCode);
        }

        $dateStart = date("Y-m-d", strtotime('-1 day', strtotime($days[0])));
        $dateEnd = end($days);
        $ordersQuery = new WP_Query;
        $orders = $ordersQuery->query(array(
            'post_type' => 'sbc_orders',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'sbc_order_end',
                    'value'   => $dateStart,
                    'compare' => '>=',
                ),
                array(
                    'key'     => 'sbc_order_start',
                    'value'   => $dateEnd,
                    'compare' => '<='
                )
            )
        ));

        $babyBedCount = $babyBedTotalCount;
        foreach ($orders as $order) {
            if ($babyBedCount > 0) {
                $isBabyBedExist = get_post_meta($order->ID, 'sbc_order_baby_bed', 1) == 'on';
                if ($isBabyBedExist) {
                    $babyBedCount--;
                }
            }
        }

        return $babyBedCount > 0;
    }

    private static function getEventTotalPrice($eventTabId, $calendarId, $dateStart, $dateEnd)
    {
        $tabHouses = get_post_meta($eventTabId, 'mastak_event_tab_type_8_items', 1);
        $price = 0;
        foreach ($tabHouses as $tabHouse) {
            $dateTabStart = date("Y-m-d", strtotime('+1 day', strtotime($tabHouse['from'])));
            $dateTabEnd = date("Y-m-d", strtotime($tabHouse['to']));
            if ($tabHouse['calendar'] == $calendarId and $dateTabStart == $dateStart and $dateTabEnd == $dateEnd) {
                $newPrice = str_replace(",", ".", $tabHouse['new_price']);
                $newPrice  = floatval($newPrice);
                $price = $newPrice;
                break;
            }
        }
        return $price;
    }

    private static function isOnlyBookingOrder($days, $calendarId, $houseId, $isTerem)
    {
        $result = false;
        $bookingSettings = get_option('mastak_booking_appearance_options');
        $isOrderWithWindowsEnabled = $bookingSettings['order_with_windows_enabled'] == 'on';
        $isOrderWithWindowsMessage = $bookingSettings['order_with_windows_message'];

        if ($isOrderWithWindowsEnabled) {
            $windowNumber = intval($bookingSettings['number_of_days']);
            $dateStart = date("Y-m-d", strtotime('-1 day', strtotime($days[0])));
            $dateEnd = end($days);

            $right = [
                date("Y-m-d", strtotime("+1 day", strtotime($dateEnd))),
                date("Y-m-d", strtotime("+$windowNumber day", strtotime($dateEnd)))
            ];

            $left = [
                date("Y-m-d", strtotime("-$windowNumber day", strtotime($dateStart))),
                date("Y-m-d", strtotime("-1 day", strtotime($dateStart)))
            ];

            $cId = false;
            if ($isTerem) {
                $cId = $calendarId;
            } else {
                $calendarShortCode =  get_post_meta($houseId, "mastak_house_calendar", true);
                $cId = getCalendarId($calendarShortCode);
            }

            $ordersQuery = new WP_Query;
            $orders = $ordersQuery->query(array(
                'post_type' => 'sbc_orders',
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => 'sbc_calendars',
                        'terms' => [$cId]
                    ]
                ],
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'sbc_order_end',
                        'value'   => $left,
                        'type'      =>  'date',
                        'compare' =>  'between'
                    ),
                    array(
                        'key'     => 'sbc_order_start',
                        'value'   =>  $right,
                        'type'      =>  'date',
                        'compare' =>  'between'
                    )
                )
            ));
            $numOrder = count($orders);
            $result = $numOrder > 0;

            if ($result) {
                $ordersQuery = new WP_Query;
                $orders = $ordersQuery->query(array(
                    'post_type' => 'sbc_orders',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => 'sbc_calendars',
                            'terms' => [$cId]
                        ]
                    ],
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'sbc_order_start',
                            'value'   => $left[1],
                            'type'      =>  'date',
                            'compare' =>  '='
                        ),
                        array(
                            'key'     => 'sbc_order_end',
                            'value'   =>  $right[0],
                            'type'      =>  'date',
                            'compare' =>  '='
                        )
                    )
                ));
                $result = ($numOrder - count($orders)) > 0;
            }
        }

        $data = [
            'enabled' => $result,
            'message' => $isOrderWithWindowsMessage
        ];

        return $data;
    }

    private static function isShortOrderWindow($days, $calendarId, $houseId, $isTerem)
    {

        $result = false;
        $bookingSettings = get_option('mastak_booking_appearance_options');
        $isRemoveIncreaseFromShortOrder = $bookingSettings['remove_increase_from_short_order'] == 'on';

        if ($isRemoveIncreaseFromShortOrder) {
            $cId = false;
            if ($isTerem) {
                $cId = $calendarId;
            } else {
                $calendarShortCode =  get_post_meta($houseId, "mastak_house_calendar", true);
                $cId = getCalendarId($calendarShortCode);
            }

            $dateStart = date("Y-m-d", strtotime('-1 day', strtotime($days[0])));
            $dateEnd = end($days);
            $ordersQuery = new WP_Query;
            $orders = $ordersQuery->query(array(
                'post_type' => 'sbc_orders',
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => 'sbc_calendars',
                        'terms' => [$cId]
                    ]
                ],
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'sbc_order_end',
                        'value'   => $dateStart,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => 'sbc_order_start',
                        'value'   => $dateEnd,
                        'compare' => '='
                    )
                )
            ));
            $result = count($orders) === 2;
        }
        return $result;
    }

    private static function getDaysUpperPersent($seasonId, $metaKey)
    {
        $result = [];
        $entities = get_post_meta($seasonId, $metaKey, 1);

        foreach ((array)$entities as $key => $entry) {
            if (isset($entry['sale_day']) and isset($entry['upper_percent'])) {
                $result[$entry['sale_day']] = (int)$entry['upper_percent'];
            }
        }

        ksort($result);
        return $result;
    }

    private static function firstCalculeate($dateStart, $dateEnd)
    {
        $leftAndRightSeasonArgs = array(
            'post_type' => 'season_interval',
            'posts_per_page' => -1,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'relation' => 'AND',
                    [
                        'key'     => 'season_from',
                        'value'   => $dateStart,
                        'type'    => 'DATE',
                        'compare' => '<='
                    ],
                    [
                        'key'     => 'season_to',
                        'value'   => $dateStart,
                        'type'    => 'DATE',
                        'compare' => '>='
                    ]
                ],
                [
                    'relation' => 'AND',
                    [
                        'key'     => 'season_from',
                        'value'   => $dateEnd,
                        'type'    => 'DATE',
                        'compare' => '<='
                    ],
                    [
                        'key'     => 'season_to',
                        'value'   => $dateEnd,
                        'type'    => 'DATE',
                        'compare' => '>='
                    ]
                ]
            ]
        );

        $leftAndRightSeasonQuery = new WP_Query;
        return $leftAndRightSeasonQuery->query($leftAndRightSeasonArgs);
    }

    private static function secondCalculeate($fromDates)
    {
        $args = array(
            'post_type' => 'season_interval',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key'     => 'season_from',
                    'value'   => $fromDates,
                    'type'    => 'DATE',
                    'compare' => 'BETWEEN'
                ]
            ]
        );

        $query = new WP_Query;
        return $query->query($args);
    }
}
