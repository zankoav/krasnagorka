<?php
class LS_Booking_Form_Controller extends WP_REST_Controller
{

    public function register_routes()
    {
        $namespace = 'krasnagorka/v1';
        $path      = '/ls/house/';

        register_rest_route($namespace, $path, [
            array(
                'methods'             => 'GET',
                'callback'            => array($this, 'order_house')
            ),
        ]);
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
            if ($metaId == $calendarId) {
                $imageId = get_post_thumbnail_id();
                $picture = wp_get_attachment_image_url($imageId, 'welcome_tab_laptop');
                $houseInfo = [
                    'id' => $houseId,
                    'peopleMaxCount' => get_post_meta($houseId, "max_people", true),
                    'picture' => $picture,
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
}
