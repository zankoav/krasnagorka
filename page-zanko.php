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
        $clientId = '79aac717-18fc-4495-8a5f-7124a70de05d';
        $clientSecret = 'o63UxjypFwePtB00nsIxeNNzvcVvXks90jOPQHuduVZ5Usfp7GkMToPUlIV8uxpe';
        $redirectUri = 'https://krasnagorka.by';
        $code = 'def502000fbd47b384ca66f1c806a90c0255d176b3c774243eeb100a7858487c3adfbb5e1725fe2ac5a779ec5df93953672838939dd5dafcf89e87cdce028d68eae1760655eceb4a020e3c42020e654fe5fd50f59e0102a07098677a661c81ca3ad30e28b63c88075a06158fb074b0e93d7cc0b4801943c43afcf3059acef227bec274b75c7757ddee960384eaee4502c12f7717bb9d3ac583466564044e9c5976d4ee42a741a449266475f6086ea0ff3dfd9adc2f1c2f5dd750661d69d15b343898bad73e9fcfb2e484e2a0fcab0f4616988a5d192cd44de662154ea62ed486ee7f6fea0bf30114a358e21452a7a8f3cf2f35718e1607075634fe55a3ae2b85961583b698eec38a24173d398b665a6c23e7a91a0adb5e8705b926119c8218fee68647020f2e40e8382eff50fbf35a29748c73593c23a0793bebca23f80cb8108adbda27b7dcbe61ce47020bf811d3c58dc371906fc9ccf124d400bc91642ae58ece09c82ac1f337a5f95ceb16db9b6dc29baca9ff4753a577349917b155e123a2be6fe1d01693bfc9a616e71948e23a47c1eb31c3c9dac1e89b4515dc30cb5aa2b988368a3a2f31513b6a14612fae888db801ddb5b07a2a622cb9b87b28196c';
        $link = 'https://krasnogorka.amocrm.ru/oauth2/access_token';

        if ( ! class_exists( '\AmoCRM\Client\AmoCRMApiClient' ) ) 
            return;

        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $apiClient->setAccountBaseDomain('krasnogorka.amocrm.ru');

        
        //     ->setAccessToken(new \League\OAuth2\Client\Token\AccessToken([
        //         'access_token' => '123456',
        //         'refresh_token' => '123456',
        //         'expires' => 1893456000,
        //         'baseDomain' => 'krasnogorka.amocrm.ru'
        //     ]));


        // try {
        //     $request = $apiClient->getRequest();
        //     $queryResult = $request->get('api/v4/leads');
        //     var_dump($queryResult); die;

        // } catch( AmoCRMApiException $e ) {
        //     var_dump($request->getLastRequestInfo()); die;
        // }

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











        $subdomain = 'krasnogorka'; //Поддомен нужного аккаунта
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

    /** Соберем данные для запроса */
    $data = [
        'client_id' =>  '79aac717-18fc-4495-8a5f-7124a70de05d',
        'client_secret' =>  '98zhrLVJwYsmsj1XWaqNwv6ck78S8csI56agkcOfkzPxF1jevRPuubp6GHfU9tqK',
        'grant_type' => 'authorization_code',
        'code' => 'def50200c35564f06d372ec7d4b732d8f1c2d9c57b9e69745600394919b75843dc0f545d0d5bd6454e3dc464e20e1c466ca32b54cb7a11ea0df269e5274963aa9cf5e1619098a537c2ca47662bf698a69bf54d92a47042142042393cec8bbf6d213ac2b7ffaa3c801e03ea712d9bcad663c51c6f09e6e0b2b49b34b2eca81ee92834c7a35153c598dfdce610a84f50f294b2b3b79193407229b2e005bfc01541ca9cdf185e3df699aea1acb6a664a6b76bf0265c3f3f9f951e93a9cb33bd6f4ccca5cfd96c27ec7b3256563692da2f13321acf87117de1bb070161d68bc3f105ee0483f9d2eaee334465ecca6e370ccefc20b45c1bc532f9ddfae5b354a7dbb01ba884019902adbbe8b319fc515098d180aa304103f1575b64f3bb5d5dc38bc2ffa7c9bf235e64345b1134b1d0024ae2b59f13e154c0271242597d6afea41280bc294d9b4f64d65f3a86c015c076777e4587604b9d026b718850b64055dbe326014b53009bbfe063697e227edae11a5be152585d2f210b4d570e8f340b660433a5fd1fe92cadb504b345bfaf285a9a88e017ae2926e68544372f888164c3472a88eba8d37772f43a792077c9095f882de890673dddadf00ec91c58887191a50c',
        'redirect_uri' => 'https://krasnagorka.by',
    ];

    /**
     * Нам необходимо инициировать запрос к серверу.
     * Воспользуемся библиотекой cURL (поставляется в составе PHP).
     * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
     */
    $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    /** Устанавливаем необходимые опции для сеанса cURL  */
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
    curl_setopt($curl,CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    curl_setopt($curl,CURLOPT_HEADER, false);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
    $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
    $code = (int)$code;
    $errors = [
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    ];

    try
    {
        /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
        if ($code < 200 || $code > 204) {
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
        }
    }
    catch(\Exception $e)
    {
        die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    }

    /**
     * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
     * нам придётся перевести ответ в формат, понятный PHP
     */
    $response = json_decode($out, true);

    $access_token = $response['access_token']; //Access токен
    $refresh_token = $response['refresh_token']; //Refresh токен
    $token_type = $response['token_type']; //Тип токена
    $expires_in = $response['expires_in']; //Через сколько действие токена истекает

    saveToken($response);

    var_dump('OK');
    die;
    ?>