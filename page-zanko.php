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
        $redirectUri = 'https://krasnogorka.by';

        if ( ! class_exists( '\AmoCRM\Client\AmoCRMApiClient' ) ) 
            return;

        // $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        // $apiClient
        //     ->setAccountBaseDomain('krasnogorka.amocrm.ru')
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
        'code' => 'def50200bf6c4d47543506c05a25caa8672c89400d4769947b1a72b1e03c8869574ce2dc1ae747e4487ef1d2a9f9d339a75c7262751f26c090b2b1f83f8921a1d41ff4e92f23f8f1e35b8d711a490ea837ede22dbd6d86eef1e012d021db25582b8491d0c2bd21edfbfa4a6646391d4724db282947c899582ce9b6775156455ad5fcde80c6b4b5e47be0f7ff402519615f985e48bd2d23cf501b5fcf54981b50aad1f8f311b7751a5a0c766ef9ebf2725fbc00b6c12b5c3ca7c6b6e1e3e281acaa7b77776f55488df5038bdb90d18f1ba8637a29b1051f3eebbb3189621132816546dc608b4fa22ce56830494bd07d4a46449f19022dbeabf915af1d187c0cdb4fd6fe97adf89d5a0523b1e238a55e26e00748ef29f25521041b2ed514a8a4e1c8d041a3e2241c4111edfddb57fa526a654612833c72f3038b20344832b420eae3228b9929d1b84efafe5d0e3ab64050e6b68180be2eb0ca05088311200cf3d8ac3ee1299acc1af6671270f56ee069ce9169450e0fd095a151c92d1401f1992b1899b664f095af3823b6bb8aa39fcb646fd1e3c1fafadbc29e94146dd9b15e4517921d2e7c83247f742ba0a80a222853dced2986faffe1917525a23612c1e36e',
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