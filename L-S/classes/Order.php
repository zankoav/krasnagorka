<?php

namespace LsFactory;

use LsFactory\Contact;

class Order {

    public const TYPE_RESERVED = 'reserved';
    public const TYPE_PREPAID = 'prepaid';
    public const TYPE_BOOKED = 'booked';

    public const METHOD_OFFICE = 'office';
    public const METHOD_CARD = 'card';
    public const METHOD_CARD_LAYTER = 'card_layter';

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
    public ?string $paymentMethod;
    public ?int $prepaidType;
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
}