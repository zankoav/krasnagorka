<?php
    if (!defined('ABSPATH')) {
        exit;
    }?>


    <h1>Hello Alexandr</h1>
    <p>Testing ...</p>

    <?php
        $clientId = 'ivan.6113446@gmail.com';
        $clientSecret = '20b87286dec1a72badab4db93cfef117fb9fedf6';
        $redirectUri = 'krasnogorka';

        if ( ! class_exists( '\AmoCRM\Client\AmoCRMApiClient' ) ) 
            return;

        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        var_dump($apiClient);

    
    ?>