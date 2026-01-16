<?php

namespace LsCalculate;

use Ls\Wp\Log as Log;

class PackageCalculate extends CalculateImpl
{
    protected function scenario()
    {
        return 'Package';
    }

    protected function calculate($request)
    {
        $packageId = $request['packageId'];
        $calendarId = $request['calendarId'];
        $dateStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        $houseId = $request['house'];
        $babyBed = $request['babyBed'];
        $bathHouseWhite = $request['bathHouseWhite'];
        $bathHouseBlack = $request['bathHouseBlack'];
        $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1) == 'on';
        $peopleCount = $request['peopleCount'];

        $min_night = intval(get_post_meta($packageId, 'package_night_min', 1));

        $calendars = get_post_meta($packageId, 'package_calendars', 1);
        $title = get_the_title($packageId);
        $bookingSettings = get_option('mastak_booking_appearance_options');

        $min_people;
        $price_person_night;
        $price_person_night_weekend;

        foreach ((array) $calendars as $key => $entry) {
            if ($calendarId == intval($entry['calendar'])) {
                $min_people = intval($entry['package_people_min']);
                $price_person_night = str_replace(",", ".", $entry['package_price']);
                $price_person_night = floatval($price_person_night);
                $price_person_night_weekend = str_replace(",", ".", $entry['package_price_weekend']);
                $price_person_night_weekend = floatval($price_person_night_weekend);
                break;
            }
        }

        $dateEndDT = new \DateTime($dateEnd);

        $period = new \DatePeriod(
            new \DateTime($dateStart),
            new \DateInterval('P1D'),
            $dateEndDT->modify('+1 day')
        );

        $daysCount = iterator_count($period);
        $daysWorkday = [];
        $daysWeekend = [];

        $weekendsStr = get_post_meta($packageId, 'package_weekends', 1);
        $weekends = [];
        if (!empty($weekendsStr)) {
            $weekends = preg_split('/\r\n|\r|\n/', $weekendsStr);
        }

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');

            if (in_array($day, $weekends)) {
                $daysWeekend[] = $day;
            } else {
                $daysWorkday[] = $day;
            }
        }

        $daysWeekendCount = count($daysWeekend);
        $daysWorkdayCount = count($daysWorkday);
        $totalDays = $daysWeekendCount + $daysWorkdayCount;



        $services = get_post_meta($packageId, 'package_services', 1);
        $servicesFormatted = [];

        foreach ((array) $services as $key => $entry) {
            if (isset($entry['service'])) {
                if ($entry['service'] == '1') {
                    $servicesFormatted[] = [
                        'id' => '1',
                        'title' => "Количество приемов пищи на 1 чел.",
                        'count' => intval(2 + ($totalDays - 1) * 3)
                    ];
                }

                if ($entry['service'] == '2') {
                    $servicesFormatted[] = [
                        'id' => '2',
                        'title' => 'Количество сеансов на квадроцикле',
                        'count' => intval($peopleCount * 0.5)
                    ];
                }

                if ($entry['service'] == '3') {
                    $servicesFormatted[] = [
                        'id' => '3',
                        'title' => 'Количество сеансов в кедровой бочке',
                        'count' => intval($peopleCount)
                    ];
                }

                if ($entry['service'] == '4') {
                    $servicesFormatted[] = [
                        'id' => '4',
                        'title' => 'Количество сеансов на канатной дороге',
                        'count' => intval($peopleCount)
                    ];
                }

                if ($entry['service'] == '5') {
                    $seanseCount = $peopleCount < 4 ? 1 : 2;
                    $servicesFormatted[] = [
                        'id' => '5',
                        'title' => "Количество сеансов ({$seanseCount}ч.) бани ",
                        'count' => 1
                    ];
                }

                if ($entry['service'] == '6') {
                    $servicesFormatted[] = [
                        'id' => '6',
                        'title' => "Количество приемов пищи на 1 чел.",
                        'count' => intval($totalDays)
                    ];
                }
            }
        }


        $error = false;

        if ($peopleCount < $min_people) {
            $error = 'Хакеры!!! Минимальное количество человек';
        }

        if ($daysCount < $min_night) {
            $error = 'Хакеры!!! Минимальное количество ночей';
        }

        $accomodationPrice = $daysWeekendCount * $peopleCount * $price_person_night_weekend;
        $accomodationPrice += $daysWorkdayCount * $peopleCount * $price_person_night;

        $result = [
            'error' => $error,
            'only_booking_order' => [
                'enabled' => false
            ],
            'title' => $title,
            'id' => $packageId,
            'services' => $servicesFormatted,
            'accommodation' => $accomodationPrice,
            'total_price' => $accomodationPrice
        ];

        $babyBedAvailable = \LS_Booking_Form_Controller::isAvailableBabyBed($days, $calendarId, $houseId, $isTeremRoom);

        if ($babyBedAvailable) {
            $result['baby_bed_available'] = $babyBedAvailable;

            if ($babyBed) {
                $babyBedPrice = intval($bookingSettings['baby_bed_price']);
                $babyBedTotalPrice = $babyBedPrice * $daysCount;

                $result['baby_bed'] = [
                    'total_price' => $babyBedTotalPrice,
                    'price' => $babyBedPrice,
                    'days' => $daysCount,
                    'discount' => 0
                ];

                $result['total_price'] += $babyBedTotalPrice;
            }
        }

        $saleDayes = get_post_meta($packageId, 'package_sale_days', 1);
        $salePercent =  get_post_meta($packageId, 'package_sale_percent', 1);
        $result['days_sale'] = false;

        if (!empty($saleDayes) && !empty($salePercent) && $daysCount >= intval($saleDayes)) {
            $result['days_sale'] = true;
            $result['sub_price'] = $result['total_price'];
            $result['total_price'] = round($result['total_price'] * (1 - intval($salePercent) / 100), 2);
        }

        $days = [];
        foreach ($period as $key => $value) {
            $days[] = $value->format('Y-m-d');
        }
        
        $result['only_booking_order'] = \LS_Booking_Form_Controller::isOnlyBookingOrder($days, $calendarId, $houseId, $isTeremRoom);

        $bathHouseWhitePrice = str_replace(",", ".", $bookingSettings['bath_house_white_price']);
        $bathHouseWhitePrice  = floatval($bathHouseWhitePrice);

        if (!empty($bathHouseWhite) and !empty($bathHouseWhitePrice)) {
            $bathHouseWhite = intval($bathHouseWhite);
            $bathHouseWhiteTotalPrice = $bathHouseWhitePrice * $bathHouseWhite;
            $result['bath_house_white'] = [
                'total_price' => $bathHouseWhiteTotalPrice,
                'price' => $bathHouseWhitePrice,
                'count' => $bathHouseWhite
            ];
            $result['total_price'] += $bathHouseWhiteTotalPrice;
        }

        $bathHouseBlackPrice = str_replace(",", ".", $bookingSettings['bath_house_black_price']);
        $bathHouseBlackPrice  = floatval($bathHouseBlackPrice);

        if (!empty($bathHouseBlack) and !empty($bathHouseBlackPrice)) {

            $bathHouseBlack = intval($bathHouseBlack);
            $bathHouseBlackTotalPrice = $bathHouseBlackPrice * $bathHouseBlack;
            $result['bath_house_black'] = [
                'total_price' => $bathHouseBlackTotalPrice,
                'price' => $bathHouseBlackPrice,
                'count' => $bathHouseBlack
            ];
            $result['total_price'] += $bathHouseBlackTotalPrice;
        }

        return $result;
    }

}
