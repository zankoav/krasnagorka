<?php
namespace LsFactory;

use LsFactory\Variant;
use Ls\Wp\Log as Log;


class VariantFactory {

    public static function getVaraintById($id){
        
        $variant = new Variant();
        $variant->id = $id;
        $variant->title = get_the_title($id);

        $variant->pricePerDay = get_post_meta($id, 'variant_price_per_day', 1);
        $variant->pricePerDay = str_replace(",",".", $variant->pricePerDay);
        $variant->pricePerDay = floatval($variant->pricePerDay);

        $variant->descriptionPerDay = get_post_meta($id, 'variant_description_per_day', 1);

        $variant->priceSingle  = get_post_meta($id, 'variant_price_single', 1);
        $variant->priceSingle = str_replace(",",".", $variant->priceSingle);
        $variant->priceSingle = floatval($variant->priceSingle);

        $variant->descriptionSingle  = get_post_meta($id, 'variant_description_single', 1);
        return $variant;
    }

    
}
