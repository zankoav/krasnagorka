<?php

namespace LsFactory;

use LsFactory\Contact;

class Order {

    public int $id;

    /**
     * required
     */
    public Contact $contact;

    /**
     * required
     */
    public string $type;

    /**
     * required
     */
    public int $calendarId;

    /**
     * required
     */
    public int $houseId;

    /**
     * required
     */
    public string $dateStart;

    /**
     * required
     */
    public string $dateEnd;

    /**
     * required
     */
    public int $peopleCount;

    public bool $isTerem = false;
    public string $calendarName;
    public string $comment;
    public string $paymentMethod;
    public string $prepaidType;
    public int $childCount;
    public bool $babyBed;
    public int $bathHouseWhite;
    public int $bathHouseBlack;
    public int $smallAnimalCount;
    public int $bigAnimalCount;
    public int $foodBreakfast;
    public int $foodLunch;
    public int $foodDinner;
    public array $sourceValue;

/*
    //AmoCrm 
    public string $sbc_order_passport;
    public int $sbc_order_count_people;
    public string $sbc_lead_id; // TODO: need to update name
    public string $sbc_webpay_transaction_id; // TODO: need to update name
    public string $sbc_task_id; // TODO: need to update name

    //Payment 
    public string $sbc_order_payment_method;
    public int $sbc_order_prepaid_percantage;
    public string $sbc_order_prepaid_source;
    public string $sbc_order_prepaid_value;

    //Info 
    public string $sbc_order_client;
    public string $sbc_order_select;
    public string $sbc_order_taxonomy_select;
    public string $sbc_order_taxonomy_check;
    public string $sbc_order_start;
    public string $sbc_order_end;
    public string $sbc_order_price;
    public string $sbc_order_prepaid;
    public string $sbc_order_desc;
    public int $sbc_order_people_count;
    public int $sbc_order_childs;
    public int $sbc_order_bath_house_white;
    public int $sbc_order_bath_house_black;
    public int $sbc_order_small_animlas_count;
    public int $sbc_order_big_animlas_count;
    public bool $sbc_order_baby_bed;
    public int $sbc_order_food_breakfast;
    public int $sbc_order_food_lunch;
    public int $sbc_order_food_dinner;
*/

}