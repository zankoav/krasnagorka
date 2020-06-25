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
        $redirectUri = 'https://krasnogorka.amocrm.ru/private/api/auth.php';

        if ( ! class_exists( '\AmoCRM\Client\AmoCRMApiClient' ) ) 
            return;

        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $apiClient
            ->setAccountBaseDomain('krasnogorka.amocrm.ru');
        //     ->setAccessToken(new \League\OAuth2\Client\Token\AccessToken([
        //         'access_token' => '123456',
        //         'refresh_token' => '123456',
        //         'expires' => 1893456000,
        //         'baseDomain' => 'krasnogorka.amocrm.ru'
        //     ]));

        // $leadsService = $apiClient->leads();

        // try {
        //     $leadsCollection = $leadsService->get();
        //     var_dump("FIRST", $leadsCollection);
        //     // $leadsCollection = $leadsService->nextPage($leadsCollection);
        //     // var_dump("SECOND",$leadsCollection);
        // } catch (AmoCRMApiException $e) {
        //     printError($e);
        //     die;
        // }


        if (!isset($_GET['code'])) {
            $state = bin2hex(random_bytes(16));
            $_SESSION['oauth2state'] = $state;
            if (isset($_GET['button'])) {
                echo $apiClient->getOAuthClient()->getOAuthButton(
                    [
                        'title' => 'Установить интеграцию',
                        'compact' => true,
                        'class_name' => 'className',
                        'color' => 'default',
                        'error_callback' => 'handleOauthError',
                        'state' => $state,
                    ]
                );
                die;
            } else {
                $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
                    'state' => $state,
                    'mode' => 'post_message',
                ]);
                header('Location: ' . $authorizationUrl);
                die;
            }
        } elseif (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        }
        
        /**
         * Ловим обратный код
         */
        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);
        
            if (!$accessToken->hasExpired()) {
                saveToken([
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $apiClient->getAccountBaseDomain(),
                ]);
            }
        } catch (Exception $e) {
            die((string)$e);
        }
        
        $ownerDetails = $apiClient->getOAuthClient()->getResourceOwner($accessToken);
        
        printf('Hello, %s!', $ownerDetails->getName());
    
    ?>