<?php

namespace LsFactory;

class Variant {
    
    /**
     * required
     */
    public int $id;

    public string $title;

    public int $pricePerDay = 0;
    public string $descriptionPerDay;

    public int $priceSingle = 0;
    public string $descriptionSingle;
}
