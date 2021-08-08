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
        $result = [];
        $houseId = $request['house'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $peopleCount = $request['peopleCount'];

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
        $intervals = $leftAndRightSeasonQuery->query($leftAndRightSeasonArgs);
        foreach( $intervals as $interval ){
            $result[$interval->ID] = [
                'date_from' => get_post_meta($interval->ID,'season_from',1),
                'date_to' => get_post_meta($interval->ID,'season_to',1),
                'season_id' => get_post_meta($interval->ID,'season_id',1)
            ];
        }
        
        return new WP_REST_Response( $result, 200);
    }
}
