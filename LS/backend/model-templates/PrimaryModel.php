<?php
class PrimaryModel extends BaseModel{
    public function getModel(){
        $devise=LS_setDevice();
        $today=LS_Today::today();
        $objContent=LS_Assets::objContent();
        $weather=ls_get_weatherObj();
        return (object)[
            "devise"=>$devise,
            "today"=>$today,
            "objContent"=>$objContent,
            "weather"=>$weather,
            "contact"=>(object)[
                "a1"=>"+375 29 320 19 19",
                "mts"=>"+375 29 701 19 19",
                "life"=>"+375 25 920 19 19",
                "email"=>"info@krasnagorka.by"
            ]
        ];  
    }


}