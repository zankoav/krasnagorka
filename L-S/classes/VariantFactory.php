<?php
namespace LsFactory;

use LsFactory\Variant;
use Ls\Wp\Log as Log;


class VariantFactory {

    public static function getVaraintById($id, $settings = []){
        
        $variant = new Variant();
        $variant->id = $id;
        $variant->title = get_the_title($id);
        $food = get_post_meta($id, 'variant_food', 1);
        if($food) {
            $variant->breakfast = in_array('breakfast', $food);
            $variant->lunch = in_array('lunch', $food);
            $variant->dinner = in_array('dinner', $food);
        }
        $variant->whiteBath = get_post_meta($id, 'variant_white_bath', 1) == 'on';
        $variant->blackBath = get_post_meta($id, 'variant_black_bath', 1) == 'on';
        $sale = get_post_meta($id, 'variant_sale', 1);
        $variant->sale = !empty($sale) ? intval($sale) : 0;
        
        if($variant->breakfast){
            $variant->price += !empty($settings['food_breakfast_price']) ? intval($settings['food_breakfast_price']) : 0;
        }

        if($variant->lunch){
            $variant->price += !empty($settings['food_lunch_price']) ? intval($settings['food_lunch_price']) : 0;
        }

        if($variant->dinner){
            $variant->price += !empty($settings['food_dinner_price']) ? intval($settings['food_dinner_price']) : 0;
        }

        if($variant->breakfast && $variant->lunch && $variant->dinner){
            $variant->price -= !empty($settings['food_triple_sale_price']) ? intval($settings['food_triple_sale_price']) : 0;
        }

        if($variant->whiteBath){
            $variant->price += !empty($settings['bath_house_white_price']) ? intval($settings['bath_house_white_price']) : 0;
        }

        if($variant->blackBath){
            $variant->price += !empty($settings['bath_house_black_price']) ? intval($settings['bath_house_black_price']) : 0;
        }

        $variant->price -= $variant->sale;

        return $variant;
    }

    
}
