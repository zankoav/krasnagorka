<?php
namespace LsFactory;

use LsFactory\Variant;
use Ls\Wp\Log as Log;


class VariantFactory {

    public static function getVaraintById($id, $settings = []){
        
        $variant = new Variant();
        $variant->id = $id;
        $variant->title = get_the_title($id);
        $variant->pricePerDay = intval(get_post_meta($id, 'variant_price_per_day', 1));
        $variant->descriptionPerDay = get_post_meta($id, 'variant_description_per_day', 1);

        $variant->priceSingle  = intval(get_post_meta($id, 'variant_price_single', 1));
        $variant->descriptionSingle  = get_post_meta($id, 'variant_description_single', 1);
        return $variant;
    }

    
}
