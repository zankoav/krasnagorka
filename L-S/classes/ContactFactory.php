<?php
namespace LsFactory;

use LsFactory\Contact;
use LsFactory\ContactException;

class ContactFactory {

    public static function initContactByRequest($data){
        
        $contact = new Contact();

        if(empty($data['fio'])){
            throw new ContactException('Empty fio');
        }

        if(empty($data['phone'])){
            throw new ContactException('Empty phone');
        }

        if(empty($data['email'])){
            throw new ContactException('Empty email');
        }

        if(empty($data['passport'])){
            throw new ContactException('Empty passport');
        }

        $contact->fio = $data['fio'];
        $contact->phone = $data['phone'];
        $contact->email = $data['email'];
        $contact->passport = $data['passport'];

        return $contact;
    }
}
