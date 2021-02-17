<?php
class LS_Booking_Form_Controller extends WP_REST_Controller{
    
    public function register_routes(){
        $namespace = 'krasnagorka/v1';
        $path      = '/ls/house/';

        register_rest_route($namespace, $path, [
            array(
                'methods'             => 'GET',
                'callback'            => array($this, 'order_house'),
                'permission_callback' => array($this, '__return_true')
            ),
        ]);
    }
       
    public function order_house( WP_REST_Request $request){
        $calendarId = $id;
        $query = new WP_Query( [ 'post_type' => 'house' ] );          
        $houseInfo=new class{};
        while ( $query->have_posts() ) { $query->the_post();
            $metaId=get_post_meta(get_the_ID(), "mastak_house_calendar", true);
            $metaId=preg_replace ('/[^0-9]/','',$metaId);
            if  ($metaId==$calendarId){
                $houseInfo->houseId=get_the_ID();
                $houseInfo->minHuman=get_post_meta(get_the_ID(), "min_people", true);
                $houseInfo->maxHuman=get_post_meta(get_the_ID(), "max_people", true);
                $houseInfo->houseFoto=get_post_meta(get_the_ID(), "mastak_house_header_image", true);
                $houseInfo->houseName=get_post_meta(get_the_ID(), "mastak_house_subtitle", true);
                break;
            }      
        } 
        return new WP_REST_Response($houseInfo, 200);      
    } 
}