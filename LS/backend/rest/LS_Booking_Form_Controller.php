<?php
use Ls\Wp\Log as Log;

class LS_Booking_Form_Controller extends WP_REST_Controller
{

    public function register_routes()
    {
        $namespace = 'krasnagorka/v1';

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

        register_rest_route($namespace, '/ls/current-season/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'current_season'),
                'permission_callback' => array($this, 'current_season_permissions_check')
            ),
        ]);
    }

    public function calculate_permissions_check($request)
    {
        return true;
    }

    public function current_season_permissions_check($request)
    {
        return true;
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
            foreach ( (array) $daysSalesEntries as $key => $entry ) {
                if(isset($entry['sale'])){
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

    public function current_season($request){
        $selectedSeasonId = Model::getSelectedSeasonId($request['dateStart']);
        return new WP_REST_Response( ['seasonId' => $selectedSeasonId], 200);
    }

    public function calculate($request)
    {
        $result = self::calculateResult($request);
        return new WP_REST_Response( $result, 200);
    }

    public static function calculateResult($request){
        $seasonsIntervals = [];
        $houseId = $request['house'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $peopleCount = (int)$request['peopleCount'];
        $calendarId = (int)$request['calendarId'];
        $isTerem = $request['isTerem'];

        $dateEndDT = new DateTime($dateEnd);

        $period = new DatePeriod(
            new DateTime($dateStart),
            new DateInterval('P1D'),
            $dateEndDT->modify( '+1 day' )
        );

        $days = [];
        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');    
        }

        $bookingSettings = get_option('mastak_booking_appearance_options');
        $isRemoveIncreaseFromShortOrder = $bookingSettings['remove_increase_from_short_order'] == 'on';
        if($isRemoveIncreaseFromShortOrder){
            $numberShortOrder = isset($bookingSettings['number_short_order']) ?  (int)$bookingSettings['number_short_order'] : 0;
            Log::info('numberShortOrder', $numberShortOrder);
            $sizeOfDays = count($days);
            if(($numberShortOrder + 1) == $sizeOfDays){
                $firstDay = $days[0];
                $lastDay = end($days);

                Log::info('firstDay', $firstDay);
                Log::info('lastDay', $lastDay);
            }
        }
        
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
        
        foreach($houseDaysSalesResult as $dayesNumber => $sale){
            $daySaleNext = [
                'sale' => $sale,
                'dayesNumber' => $dayesNumber
            ];
            if(count($days) < $dayesNumber){
                break;
            }else{
                $daysSale = $sale;
                $daySaleNext = null;
            }
        }


        $intervals = self::firstCalculeate($dateStart, $dateEnd);

        if(count($intervals) == 2){
            $fromDates = [
                get_post_meta($intervals[0]->ID,'season_from',1),
                get_post_meta($intervals[1]->ID,'season_from',1)
            ];
            asort($fromDates);
            $fromDates = array_values($fromDates);
            $intervals = self::secondCalculeate($fromDates);
        }

        foreach( $intervals as $interval ){
            $seasonsIntervals[] = [
                'date_from' => get_post_meta($interval->ID,'season_from',1),
                'date_to' => get_post_meta($interval->ID,'season_to',1),
                'season_id' => get_post_meta($interval->ID,'season_id',1)
            ];
        }

        $result = [
            'total_price' => 0,
            'days_count' => count($days),
            'day_sale_next' => $daySaleNext,
            'seasons_group' => []
        ];

        foreach($days as $day) {
            foreach($seasonsIntervals as $interval) {
                if($interval['date_from'] <= $day and $interval['date_to'] >= $day){
                    $season = $result['seasons_group'][$interval['season_id']];
                    if(empty($season)){
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
            if($isTerem){
                $prefix = 'room';
                $houseId = $calendarId;
            }
            $housePrice = (float)get_post_meta($season->ID, $prefix.'_price_'.$houseId, 1);
            $houseMinPeople = get_post_meta($season->ID, $prefix.'_min_people_'.$houseId, 1);
            $houseMinPeople = (float)str_replace(",", ".", $houseMinPeople);
            $houseMinDays = (float)get_post_meta($season->ID, $prefix.'_min_days_'.$houseId, 1);
            $houseMinPercent = (float)get_post_meta($season->ID, $prefix.'_min_percent_'.$houseId, 1);

            $result['seasons_group'][$season->ID]['house_price'] = $housePrice;
            $result['seasons_group'][$season->ID]['house_min_people'] = $houseMinPeople;
            $result['seasons_group'][$season->ID]['house_min_days'] = $houseMinDays;
            $result['seasons_group'][$season->ID]['house_min_percent'] = $houseMinPercent;

            $basePrice = $housePrice;
            $seasonDaysCount = count($result['seasons_group'][$season->ID]['days']);
        
            $basePeopleCount = $peopleCount;

            if($peopleCount < $houseMinPeople){
                $basePrice *= (float)$houseMinPeople;
                $basePeopleCount = null;
            }

            $basePriceWithoutUpper = null;

            $percentTotal = 0;


            $daysUpperPersents = self::getDaysUpperPersent($season->ID, $prefix.'_days_count_upper_'.$houseId);

            $upperPercent = false;
            if(count($daysUpperPersents) > 0){    
                foreach($daysUpperPersents as $day => $persent){
                    if(count($days) <= intval($day)){
                        $upperPercent = intval($persent);
                        break;
                    }
                }
            }
            
            if($upperPercent){
                $basePriceWithoutUpper = $basePrice;
                $percentTotal -= $upperPercent;
                $houseMinPercent = $upperPercent;
            }else if(!empty($houseMinDays) && !empty($houseMinPercent) && ($seasonDaysCount < $houseMinDays)){
                $basePriceWithoutUpper = $basePrice;
                $percentTotal -= $houseMinPercent;
            }

            $result['seasons_group'][$season->ID]['price_block'] = [
                'title' =>  $season->post_title,
                'season_id' =>  $season->ID,
                'base_price' => $basePrice,
                'min_percent' => $houseMinPercent,
                'base_price_without_upper' => $basePriceWithoutUpper,
                'days_count' => $seasonDaysCount,
                'base_people_count' => $basePeopleCount,
                'days_sale' => (float)$daysSale
            ];

            $housePeoplesForSalesEntities = get_post_meta($season->ID, $prefix.'_people_for_sale_'.$houseId, 1);
            $housePeoplesForSales = [];

            foreach ((array)$housePeoplesForSalesEntities as $key => $entry) {
                if (isset($entry['sale_percent']) and isset($entry['sale_people'])) {
                    $housePeoplesForSales[$entry['sale_people']] = $entry['sale_percent'];
                }
            }

            ksort($housePeoplesForSales);

            $peopleSale = null;
            $peopleSaleNext = null;
            
            foreach((array)$housePeoplesForSales as $peopleNumber => $sale){
                
                $peopleSaleNext = [
                    'sale' => $sale,
                    'people' => $peopleNumber
                ];

                if($peopleCount < $peopleNumber){
                    break;
                }else{
                    $peopleSale = $sale;
                    $peopleSaleNext = null;
                }
            }

            $result['seasons_group'][$season->ID]['price_block']['people_sale'] = $peopleSale;
            $result['seasons_group'][$season->ID]['price_block']['people_sale_next'] = $peopleSaleNext;

            $deltaSale = 0;

            if(!empty($peopleSale)){
                    $deltaSale += $peopleSale;
            }

            if(!empty($daysSale)){
                    $deltaSale += $daysSale;
            }

            $percentTotal += $deltaSale;

            $priceBlockTotal = round(
                ($basePrice * (1 - $percentTotal / 100) ) * 
                (empty($basePeopleCount) ? 1 : $basePeopleCount) * 
                $seasonDaysCount
            , 2);
            
            $result['seasons_group'][$season->ID]['price_block']['total'] = $priceBlockTotal;
            $result['total_price'] += $result['seasons_group'][$season->ID]['price_block']['total'];
            $result['total_price'] = intval($result['total_price']);
        }
        return $result;
    }

    private static function getDaysUpperPersent($seasonId, $metaKey){
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
