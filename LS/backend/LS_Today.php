<?php 
    class LS_Today{
        private static $monthList=["0","Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря"];
        public static function today(){
            $dateMonth=[
                'day'=>date("j"),
                'month'=>self::$monthList[date("n")]
            ];
            return $dateMonth;
        }
    }