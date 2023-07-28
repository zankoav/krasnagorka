<?php
namespace LsCalculate;

use Ls\Wp\Log as Log;

class PackageCalculate extends CalculateImpl
{
    protected function scenario(){
        return 'Package';
    }

    protected function calculate($request){
        // $peopleCount = 1;
        // $days = 1;
        // $calendarId = (int)$request['calendarId'];
        // $intervallId = $request['intervallId'];

        // $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1) == 'on';
        // $seasonId = get_post_meta($intervallId, 'season_id', true);
        // $keyPrice = "room_price_$calendarId";
        // if(!$isTeremRoom){
        //     $house = getHouseByCalendarId($calendarId);
        //     $houseId = $house['id'];
        //     $keyPrice = "house_price_$houseId";
        // }
        // $basePrice = get_post_meta($seasonId, $keyPrice, true);
        return [
            // 'is_terem' => $isTeremRoom,
            // 'calendar_id' => $calendarId,
            'total_price' => 1000
        ];
    }

}
