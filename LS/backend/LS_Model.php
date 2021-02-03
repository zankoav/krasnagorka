<?php

class LS_Model{
  
    private static $today;
    private static $objContent;
    private static $weather;
    private static $contact;
    private static $devise;
    public static function dataObj(){
        self::$devise=LS_setDevice();
        self::$today=LS_Today::today();
        self::$objContent=LS_Assets::objContent();
        self::$weather=ls_get_weatherObj();
        return $model=(object)[
            "devise"=>self::$devise,
            "today"=>self::$today,
            "objContent"=>self::$objContent,
            "weather"=>self::$weather,
            "contact"=>(object)[
                "a1"=>"+375 29 320 19 19",
                "mts"=>"+375 29 701 19 19",
                "life"=>"+375 25 920 19 19",
                "email"=>"info@krasnagorka.by"
            ]
        ];  
    }
}
?>


