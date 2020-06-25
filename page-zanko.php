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
        'client_secret' =>  'dR4ABwqkSqF0oSU7KKmtDBLDqdWnQMdi27eHl7nrm3f0DgRPpH95OwgNWLcYbj98',
        'grant_type' => 'authorization_code',
        'code' => 'def50200d1e23b55b47d6fb4fef60b023c3ec8d1c129c0634d1d1ab505e017f0adefcb8ce581328c991592899c643269517c344ce0ea83f71a7aa6fd02e63de98a88804852879a7edd51451efb3a8d3fe99468d0f3d17d62ee0028b50a3697559562a6e678449b42733fa8a79ae86883c212ae3db2e97fe9ccbecc3244deae66d868428681a52bb7eb87d962000613c0ef82433c2f2d70e638128812277c61fe6628ddbd73908308245b672e020fba3c4e1b42e4f1a04312c72545e81a8ecbebc289ef92884fdd64c9dc3e3e3c361e709aaeec579a0d30226246750c788739ad0253b0eacf84c1e36f5cde42c177e497c996289feac5c6cefb2310f061f600ae7dfd075d8bb77eaa38537b291558e8529c67f5ddf6f993de275943f26e3e7919397c89d3ce95de040f94999fa70adfec7f8cbc8eb29ee5b28588eb38b13af2e1ff62e2762826fec896114ca49700659b17fa2c4d4e78ccb4b7fc9451a79c6ba55b1534fde1dc6c5ba7ddd7db69918e72e15a35716f7621cfd5a07f66ae298c94450a2fedd0b69a6f4d23a2a43e531575d4be0a384447b84927111774e38cc3ead2631c224b022d3f53300721b61491985b48146418bfb7a123e3be71ff29ba0c',
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

    var_dump($response);
    die;
    ?>