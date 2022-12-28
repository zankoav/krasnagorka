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

    public ?string $eventTabId;
    public ?string $eventId;
    public ?string $variantId;
    public array $note;
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

    public int $leadId;

    public int $price;
    public int $subprice;
    
    public int $foodPrice;
    public int $accommodationPrice;

    public function eventVariant(){
        $result = null;
        if(!empty($this->variantId)){
            $title = get_the_title($this->variantId);
            $per_day = get_post_meta($this->variantId, 'variant_description_per_day', 1);
            $single = get_post_meta($this->variantId, 'variant_description_single', 1);
            $result = [
                'id' => $this->variantId,
                'title' => $title,
                'description' => $per_day
            ];
            if(!empty($single)){
                $result['description'] = empty($per_day) ? $single : "$per_day, $single";
            }
        }
        return $result;
    }

    public function getHouseLink(){
        $calendars  = get_the_terms($this->id, 'sbc_calendars');
        $calendarSlug = $calendars[0]->slug;
        $calendarId = $calendars[0]->term_id;
        $calendarShortCode = '[sbc_calendar id="' . $calendarId . '" slug="' . $calendarSlug . '"]';
        return getHouseLinkByShortCode($calendarShortCode);
    }

    public function getEventLink(){
        return  get_permalink( $this->eventId );
    }

    public function getEventTitle(){
        return  get_the_title( $this->eventId );
    }

    public function isBookedOnly(){
        return (
            $this->paymentMethod === null && 
            $this->prepaidType === null
        );
    }

    public function getMailTemplete(){
        return $this->mail->template;
    }
    
    public function getPaymentMethod(){
        $arr = [
            null => '-',
            self::METHOD_OFFICE => 'В офисе',
            self::METHOD_CARD => 'Картой',
            self::METHOD_CARD_LAYTER => 'Картой позже',
        ];
        return $arr[$this->paymentMethod];
    }

    public function isBabyBedMessage(){
        return $this->babyBed ? 'Да' : 'Нет';
    }

}