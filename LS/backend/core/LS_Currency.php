<?php
class LS_Currency extends CookieHelper {

    const RUB = 'rub';
    const EUR = 'eur';
    const USD = 'usd';
    const BYN = 'byn';
    const CURRENCY = 'currency';

    public static function getImage($abr){
        
        switch ($abr) {
            case self::EUR:
                $result = self::EUR;
                break;
            case self::RUB:
                $result = self::RUB;
                break;
            case self::USD:
                $result = self::USD;
                break;
            default:
                $result = self::BYN;  
                break;
        }
        return get_template_directory_uri() . "/LS/frontend/assets/img/$result.svg";
    }
    public function getCurrency() {
        $currency= $this->getCookieValue( self::CURRENCY ) ?? self::BYN;
        $image=self::getImage($currency);
        return (object)[
            'abbreviation'=>$currency,
            'image'=>$image
        ];
    }
    
    public function changePrice($price=1) {
        $rate=$this->getCurrency()->abbreviation;
        return ls_cb_conversion_price_in_abbreviation($rate,$price);  
    }
}