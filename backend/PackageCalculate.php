<?php
namespace LsCalculate;

use Ls\Wp\Log as Log;

class PackageCalculate extends CalculateImpl
{
    protected function scenario(){
        return 'Package';
    }

    protected function calculate($request){

        $packageId = $request['packageId'];
        $calendarId = $request['calendarId'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $house = $request['house'];
        $peopleCount = $request['peopleCount'];

        $babyBed = $request['babyBed'];
        $smallAnimalCount = $request['smallAnimalCount'];
        $bigAnimalCount = $request['bigAnimalCount'];
        
        $foodBreakfast = $request['foodBreakfast'];
        $foodDinner = $request['foodDinner'];
        $foodLunch = $request['foodLunch'];

        $services = get_post_meta($packageId,'package_services', 1);
        $servicesFormatted = [];

        foreach ((array) $services as $key => $entry) {
            if (isset($entry['service'])) {
                $servicesFormatted[] = $entry['service'];
            }
        }

        $min_night = intval(get_post_meta($packageId,'package_night_min', 1));

        $calendars = get_post_meta($packageId,'package_calendars', 1);
        $calendarsFormatted = [];
        $min_people;
        $price_person_night;

        foreach ((array) $calendars as $key => $entry) {
            if (isset($entry['calendar']) && isset($entry['package_price'])) {
                $calendarId = intval($entry['calendar']);
                $calendarsFormatted[$calendarId] = [
                    "id" => $calendarId,
                    "price_person_night" => floatval($entry['package_price']),
                    "min_people" => intval($entry['package_people_min'])
                ];

                if($calendarId == intval($entry['calendar'])){
                    $min_people = intval($entry['package_people_min']);
                    $price_person_night = floatval($entry['package_price']);
                    break;
                }
            }
        }

        $dateEndDT = new \DateTime($dateEnd);

        $period = new \DatePeriod(
            new \DateTime($dateStart),
            new \DateInterval('P1D'),
            $dateEndDT->modify( '+1 day' )
        );

        $daysCount = iterator_count($period);


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
        $error = false;

        if($peopleCount < $min_people){
            $error = 'Хакеры!!! Минимальное количество человек';
        }

        if($daysCount < $min_night){
            $error = 'Хакеры!!! Минимальное количество ночей';
        }

        $price = $daysCount * $peopleCount * $price_person_night;

        return [
            'error' => $error,
            'daysCount' => $daysCount,
            'min_night' => $min_night,
            'min_people' => $min_people,
            'price_person_night' => $price_person_night,
            'servicesFormatted' => $servicesFormatted,
            'accommodation' => $price,
            'total_price' => $price
        ];
    }

}
