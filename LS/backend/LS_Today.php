<?php 
    class LS_Today{
        private static $monthList=[
            "Января",
            "Февраля",
            "Марта",
            "Апреля",
            "Мая",
            "Июня",
            "Июля",
            "Августа",
            "Сентября",
            "Октября",
            "Ноября",
            "Декабря"
        ];

        public static function today(){
            $dateMonth=(object)[
                'day'=>date("j"),
                'month'=>self::$monthList[date("n")-1]
            ];
            return $dateMonth;
        }
    }