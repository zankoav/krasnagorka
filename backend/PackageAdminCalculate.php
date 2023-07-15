<?php
namespace LsCalculate;

use Ls\Wp\Log as Log;

class PackageAdminCalculate extends CalculateImpl
{
    protected function scenario(){
        return 'PackageAdmin';
    }

    protected function calculate($request){
        $peopleCount = 1;
        $days = 1;
        $calendarId = (int)$request['calendarId'];
        $intervallId = $request['intervallId'];

        $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1);
        $seasonId = get_post_meta($intervallId, 'season_id', true);
        $keyPrice = $isTeremRoom ? 'room_price_' : 'house_price_';
        $keyPrice .= $calendarId;
        $basePrice = get_post_meta($seasonId, $keyPrice, true);
        return [
            'is_terem' => $isTeremRoom,
            'calendar_id' => $calendarId,
            'total_price' => floatval($basePrice)
        ];
    }

}
