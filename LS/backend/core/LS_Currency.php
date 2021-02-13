<?php
class LS_Currency extends GetCookie {

    const RUB = 'rub';
    const EUR = 'eur';
    const USD = 'usd';
    const BYN = 'byn';
    const CURRENCY = 'currency';

    public static function getImage($abr){
        switch ($abr) {
            case 'byn':
                return get_template_directory_uri() . "/LS/frontend/src/img/byn.8ed77d.svg";
                break;
            case 'eur':
                return get_template_directory_uri() . "/LS/frontend/src/img/eur.7b4534.svg";
                break;
            case 'rub':
                return get_template_directory_uri() . "/LS/frontend/src/img/rub.7a8b3a.svg";
                break;
            case 'usd':
                return get_template_directory_uri() . "/LS/frontend/src/img/usd.aefba3.svg";
                break;
        }
    }
    public function getCurrency() {
        $currency= $this->getCookieValue( self::CURRENCY );
        $image=self::getImage($currency);
        if ( ! empty ($currency) ) {
            return 
            (object)[
                'abbreviation'=>$currency,
                'image'=>$image
            ];
        } else {
            return 
            (object)[
                'abbreviation'=>self::BYN,
                'image'=>getImage(self::BYN)
            ];
        }
    }
    public function changePrice($price=1) {
        $rate=$this->getCurrency()->abbreviation;
        return ls_cb_conversion_price_in_abbreviation($rate,$price);  
    }
}