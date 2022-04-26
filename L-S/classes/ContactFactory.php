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

    public static function insert(Contact $contact){
        $client   = self::get_client_by_meta(['meta_key' => 'sbc_client_phone', 'meta_value' => $contact->phone]);
        $clientId = null;

        if (empty($client)) {
            $client_data = array(
                'post_title'   => $contact->fio . ' ' . $contact->phone,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_author'  => 23,
                'post_type'    => 'sbc_clients'
            );
            // Вставляем данные в БД
            $clientId = wp_insert_post(wp_slash($client_data));
        } else {
            $clientId = $client->ID;
        }

        if (!empty($contact->email)) {
            update_post_meta($clientId, 'sbc_client_email', $contact->email);
        }

        if (!empty($contact->phone)) {
            update_post_meta($clientId, 'sbc_client_phone', $contact->phone);
        }

        $contact->id = $clientId;
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

    private static function get_client_by_meta($args = array())
    {

        // Parse incoming $args into an array and merge it with $defaults - caste to object ##
        $args = (object) wp_parse_args($args);

        // grab page - polylang will take take or language selection ##
        $args = array(
            'meta_query'     => array(
                array(
                    'key'   => $args->meta_key,
                    'value' => $args->meta_value
                )
            ),
            'post_type'      => 'sbc_clients',
            'posts_per_page' => '1'
        );

        // run query ##
        $posts = get_posts($args);

        // check results ##
        if (!$posts || is_wp_error($posts)) return false;

        // test it ##
        #pr( $posts[0] );

        // kick back results ##
        return $posts[0];
    }
}
