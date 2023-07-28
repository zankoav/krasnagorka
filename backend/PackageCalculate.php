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
        $houseId = $request['house'];
        $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1) == 'on';
        $peopleCount = $request['peopleCount'];

        $babyBed = $request['babyBed'];
        $smallAnimalCount = $request['smallAnimalCount'];
        $bigAnimalCount = $request['bigAnimalCount'];
        
        $foodBreakfast = $request['foodBreakfast'];
        $foodDinner = $request['foodDinner'];
        $foodLunch = $request['foodLunch'];

        $min_night = intval(get_post_meta($packageId,'package_night_min', 1));

        $calendars = get_post_meta($packageId,'package_calendars', 1);
        $calendarsFormatted = [];
        $min_people;
        $price_person_night;

        foreach ((array) $calendars as $key => $entry) {
            if($calendarId == intval($entry['calendar'])){
                $min_people = intval($entry['package_people_min']);
                $price_person_night = floatval($entry['package_price']);
                break;
            }
        }

        $dateEndDT = new \DateTime($dateEnd);

        $period = new \DatePeriod(
            new \DateTime($dateStart),
            new \DateInterval('P1D'),
            $dateEndDT->modify( '+1 day' )
        );

        $days = [];
        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');    
        }

        $daysCount = iterator_count($period);


        $services = get_post_meta($packageId,'package_services', 1);
        $servicesFormatted = [];

        foreach ((array) $services as $key => $entry) {
            if (isset($entry['service'])) {
                if($entry['service'] == '1'){
                    $servicesFormatted[] = [
                        'id' => '1',
                        'title' => 'Количество приемов пищи',
                        'count' => intval($peopleCount * (2 + ($daysCount - 1 ) * 3))
                    ];
                }

                if($entry['service'] == '2'){
                    $servicesFormatted[] = [
                        'id' => '2',
                        'title' => 'Количество сеансов на квадроцикле',
                        'count' => intval($peopleCount * $daysCount * 0.25)
                    ];
                }

                if($entry['service'] == '3'){
                    $servicesFormatted[] = [
                        'id' => '3',
                        'title' => 'Количество сеансов в кедровой бочке',
                        'count' => intval($daysCount / 2) * $peopleCount
                    ];
                }

                if($entry['service'] == '4'){
                    $servicesFormatted[] = [
                        'id' => '4',
                        'title' => 'Количество сеансов на канатной дороге',
                        'count' => intval($daysCount / 2) * $peopleCount
                    ];
                }

                if($entry['service'] == '5'){
                    $seanseCount = $peopleCount < 4 ? 1 : 2;
                    $servicesFormatted[] = [
                        'id' => '5',
                        'title' => "Количество сеансов по {$seanseCount}ч.",
                        'count' => intval($daysCount / 2)
                    ];
                }
            }
        }
        
        
        $error = false;

        if($peopleCount < $min_people){
            $error = 'Хакеры!!! Минимальное количество человек';
        }

        if($daysCount < $min_night){
            $error = 'Хакеры!!! Минимальное количество ночей';
        }

        $price = $daysCount * $peopleCount * $price_person_night;
        $babyBedAvailable = \LS_Booking_Form_Controller::isAvailableBabyBed($days, $calendarId, $houseId, $isTeremRoom);
        return [
            'error' => $error,
            'baby_bed_available' => $babyBedAvailable,
            'services' => $servicesFormatted,
            'accommodation' => $price,
            'total_price' => $price
        ];
    }

}
