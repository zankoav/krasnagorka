<?php
namespace LsFactory;

use LsFactory\Contact;
use LsFactory\ContactException;

class ContactFactory {

    public static function initContactByRequest($data = []){
        
        $contact = new Contact();
        $contact->fio = $data['fio'];
        $contact->phone = $data['phone'];
        $contact->email = $data['email'];
        $contact->passport = $data['passport'];
        
        self::validateContact($contact);

        return $contact;
    }

    public static function validateContact(Contact $contact){

        if(empty($contact->fio)){
            throw new ContactException('Empty fio');
        }

        if(empty($contact->phone)){
            throw new ContactException('Empty phone');
        }

        if(empty($contact->email)){
            throw new ContactException('Empty email');
        }

        if(empty($contact->passport)){
            throw new ContactException('Empty passport');
        }
    }
}
