<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

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
        $apiClient->setAccessToken(new \League\OAuth2\Client\Token\AccessToken([
                'access_token' => 'zankoav',
                'refresh_token' => 'zankoav',
                'expires' => 1893456000,
                'baseDomain' => 'krasnogorka.amocrm.ru',
            ]));


        try {
            $leadsCollection = $leadsService->get();
            var_dump("FIRST",$leadsCollection);
            $leadsCollection = $leadsService->nextPage($leadsCollection);
            var_dump("SECOND",$leadsCollection);
        } catch (AmoCRMApiException $e) {
            printError($e);
            die;
        }

    
    ?>