<?php

namespace LsFactory;

use LsFactory\Contact;

class Order {

    /**
     * required
     */
    public Contact $contact;

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

}