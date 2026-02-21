<?php

namespace LsFactory;

use LsFactory\Variant;
use Ls\Wp\Log as Log;


class VariantFactory
{

    public static function getVaraintById($id)
    {

        $variant = new Variant();
        $variant->id = $id;
        $variant->title = get_the_title($id);

        $pricePerDay = get_post_meta($id, 'variant_price_per_day', 1) ?? "0";
        $pricePerDay = str_replace(",", ".", $pricePerDay);
        $variant->pricePerDay = floatval($pricePerDay);

        $variant->descriptionPerDay = get_post_meta($id, 'variant_description_per_day', 1);

        $variant->priceSingle  = intval(get_post_meta($id, 'variant_price_single', 1)) ?? "0";
        $variant->priceSingle = str_replace(",", ".", $variant->priceSingle);
        $variant->priceSingle = floatval($variant->priceSingle);

        $variant->descriptionSingle  = get_post_meta($id, 'variant_description_single', 1);
        return $variant;
    }
}
