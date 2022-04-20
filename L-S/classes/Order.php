<?php

namespace LsFactory;

class Order {

    /**
     * required
     */
    public $contact;

    /**
     * required
     */
    public $calendarId;

    /**
     * required
     */
    public int $houseId;

    /**
     * required
     */
    public $dateStart;

    /**
     * required
     */
    public $dateEnd;

    /**
     * required
     */
    public $peopleCount;


    public $isTerem = false;
    public $comment;


    public $paymentMethod;
    public $prepaidType;
    public $childCount;
    public $babyBed;
    public $bathHouseWhite;
    public $bathHouseBlack;
    public $smallAnimalCount;
    public $bigAnimalCount;
    public $foodBreakfast;
    public $foodLunch;
    public $foodDinner;

}


/*          
            paymentMethod: this.settings.paymentMethod,
            prepaidType: this.settings.prepaidType,
            count: peopleCount,
            childs: childCounts,
            babyBed: babyBed,

            bathHouseWhite: this.settings.bathHouseWhite,
            bathHouseBlack: this.settings.bathHouseBlack,
            smallAnimalCount: this.settings.smallAnimalCount,
            bigAnimalCount: this.settings.bigAnimalCount,

            foodBreakfast: this.settings.foodBreakfast,
            foodLunch: this.settings.foodLunch,
            foodDinner: this.settings.foodDinner,
            
            orderTitle: calendar.name,
            orderType: 'Домик:',
            cid: cid,
            wsb_test: this.settings.webpaySandbox.wsb_test,
 */