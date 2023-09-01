<?php

namespace LsFactory;

class Variant {
    
    /**
     * required
     */
    public int $id;

    public string $title;

    public float $pricePerDay = 0;
    public string $descriptionPerDay;

    public float $priceSingle = 0;
    public string $descriptionSingle;
}
