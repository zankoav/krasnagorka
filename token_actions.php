<?php

use League\OAuth2\Client\Token\AccessToken;

define('TOKEN_FILE', dirname(__FILE__).'/token_info.json');

/**
 * @param array $accessToken
 */
function saveToken($accessToken)
{
    if (
        isset($accessToken)
        && isset($accessToken['access_token'])
        && isset($accessToken['refresh_token'])
        && isset($accessToken['expires_in'])
        && isset($accessToken['baseDomain'])
    ) {
        $data = [
            'access_token' => $accessToken['access_token'],
            'expires' => $accessToken['expires_in'],
            'refresh_token' => $accessToken['refresh_token'],
            'baseDomain' => $accessToken['baseDomain'],
        ];

        file_put_contents(TOKEN_FILE, json_encode($data));
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

/**
 * @return AccessToken
 */
function getToken()
{
    if (!file_exists(TOKEN_FILE)) {
        exit('Access token file not found');
    }

    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['access_token'])
        && isset($accessToken['refresh_token'])
        && isset($accessToken['expires'])
    ) {
        return new AccessToken([
            'access_token' => $accessToken['access_token'],
            'refresh_token' => $accessToken['refresh_token'],
            'expires' => $accessToken['expires'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

function refreshToken(){
    $subdomain = 'krasnogorka'; //Поддомен нужного аккаунта
    $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

    /** Соберем данные для запроса */
    $data = [
        'client_id' => '79aac717-18fc-4495-8a5f-7124a70de05d',
        'client_secret' => 'h1MPktXuLLrCPrEneoFP7kh2rlVllzaxkzfivOK2xWzOTxFHqtIu26VDUIaEyOpG',
        'grant_type' => 'authorization_code',
        'code' => 'def502005b911744d98bd6011b7288877f17090b53e01d338c4679ca956242b4405d39fa502c49041ec37bbf48ef46046195999c4abb96bc38bfcb41c30ed12921d04e5c16be17b08140049dc6229c156ae80f1988ffb7e9c9b22463699d4c65a7e39e716b50c1c6d0ba5fd1308df4d4156bd204cf0308135060056c0adab40e13dddefb0241f25ef5617156ee278706d8e87d3b4297eb82aeb35498e2f34240163652073e4ea61eb69ae607d068ee501738f0a9b90331b21f98367521b95233fa64aeb51738b5f64bbea1cd1fceb53601fc6014c6aacbd314e86e4f613d32b71d1abbdf24036c5c2665f8d14be6c7229201d81bfcb3e114217cca810c133d63c862e475e0de0b35691c1e45d9aa711c0aadd57de110cf8815e19dbd2084a240df1c39c8b46553762297aefc80dd73037d3bc5af02ef5b256d198ce30906a0aff9204ff273f602f9cd4b411d3e3880c91a59f435e16a30805a59b9002dd7b1dc7ae5dab90e8595a3cbe17c3978f676e64a955bd279154d42da6fdfbebb5914fcb29a1954bdbb9da1217b78e51f75063cd5ff7bce26e309e22c3b77609e4c0fb842e5b96dc693c4f8bf116c17d24130c80a32d99838954b548c3ed0d62611a495',
        'redirect_uri' => 'https://krasnagorka.by/',
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
    var_dump($response);
}

// refreshToken();