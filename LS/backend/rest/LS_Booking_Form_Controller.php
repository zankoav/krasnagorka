<?php
class LS_Booking_Form_Controller extends WP_REST_Controller{
    
    public function register_routes(){
        $namespace = 'krasnagorka/v1';
        $path      = '/ls/house/';
        
        register_rest_route($namespace, $path, [
            array(
                'methods'             => 'GET',
                'callback'            => array($this, 'order_house')                
            ),
        ]);
    }
    public function order_house($request){
        $query = new WP_Query([ 
            'post_type' => 'house',
            'posts_per_page' => -1
        ]);   
        $calendarId = trim($request['calendarId']);   
        if  ($calendarId==''){
            exit ('enter calendarID');
        }
        $houseInfo=[];
        foreach ($query as $house ) {
            $query->the_post();
            $metaId=get_post_meta(get_the_ID(), "mastak_house_calendar", true);
            $metaId=preg_replace ('/[^0-9]/','',$metaId);
            if  ($metaId==$calendarId){
                $houseInfo=[
                    'houseId'=>get_the_ID(),
                    'description'=>get_post_meta(get_the_ID(), "mastak_house_small_description", true),
                    'Human'=>get_post_meta(get_the_ID(), "max_people", true),
                    'housePicture'=>get_post_meta(get_the_ID(), "mastak_house_header_image", true),
                    'houseTitle'=>get_the_title()
                ];
                break;
            }  else{$houseInfo='this house not found';} 
        }      
        return new WP_REST_Response($houseInfo, 200);  // addres wordpress/wp-json/krasnagorka/v1/ls/house/?calendarId=5
    }    
}   