<?php
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
    }

    public function calculate_permissions_check($request)
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

    public function calculate($request)
    {
        $seasonsIntervals = [];
        $houseId = $request['house'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $peopleCount = (int)$request['peopleCount'];

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


        $intervals = $this->firstCalculeate($dateStart, $dateEnd);

        if(count($intervals) == 2){
            $fromDates = [
                get_post_meta($intervals[0]->ID,'season_from',1),
                get_post_meta($intervals[1]->ID,'season_from',1)
            ];
            asort($fromDates);
            $fromDates = array_values($fromDates);
            $intervals = $this->secondCalculeate($fromDates);
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
            $housePrice = (float)get_post_meta($season->ID, 'house_price_'.$houseId, 1);
            $houseMinPeople = (float)get_post_meta($season->ID, 'house_min_people_'.$houseId, 1);
            $houseMinDays = (float)get_post_meta($season->ID, 'house_min_days_'.$houseId, 1);
            $houseMinPercent = (float)get_post_meta($season->ID, 'house_min_percent_'.$houseId, 1);

            $result['seasons_group'][$season->ID]['house_price'] = $housePrice;
            $result['seasons_group'][$season->ID]['house_min_people'] = $houseMinPeople;
            $result['seasons_group'][$season->ID]['house_min_days'] = $houseMinDays;
            $result['seasons_group'][$season->ID]['house_min_percent'] = $houseMinPercent;

            $basePrice = $housePrice;

            $seasonDaysCount = count($result['seasons_group'][$season->ID]['days']);
        
            if(!empty($houseMinDays) && !empty($houseMinPercent) && ($seasonDaysCount < $houseMinDays)){
                $basePrice *= (1 + (float)$houseMinPercent / 100);
            }

            $basePeopleCount = (int)$peopleCount;

            if($peopleCount < $houseMinPeople){
                $basePrice =  (float)$housePrice * (float)$houseMinPeople;
                $basePeopleCount = null;
            }

            $result['seasons_group'][$season->ID]['price_block'] = [
                'title' =>  $season->post_title,
                'season_id' =>  $season->ID,
                'base_price' => $basePrice,
                'days_count' => $seasonDaysCount,
                'base_people_count' => $basePeopleCount,
                'days_sale' => (float)$daysSale
            ];

            $housePeoplesForSalesEntities = get_post_meta($season->ID, 'house_people_for_sale_'.$houseId, 1);
            $housePeoplesForSales = [];

            foreach ((array)$housePeoplesForSalesEntities as $key => $entry) {
                if (isset($entry['sale_percent']) and isset($entry['sale_people'])) {
                    $housePeoplesForSales[$entry['sale_people']] = $entry['sale_percent'];
                }
            }

            ksort($housePeoplesForSales);
            LS_WP_Logger::info('housePeoplesForSales: ' . json_encode($housePeoplesForSales));


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
            
            $result['seasons_group'][$season->ID]['price_block']['total'] = round(($basePrice * (1 - $deltaSale / 100) ) * (empty($basePeopleCount) ? 1 : $basePeopleCount) * $seasonDaysCount, 2);
            $result['total_price'] += $result['seasons_group'][$season->ID]['price_block']['total'];
        }
                
        return new WP_REST_Response( $result, 200);
    }


    private function firstCalculeate($dateStart, $dateEnd)
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

    private function secondCalculeate($fromDates)
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
