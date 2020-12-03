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
        'code' => 'def5020015ac4a1a2722ffdc8ada6d65bcea39ed3cac17968919e2d238fcb12a8eb0875922619072ace9c401511235d468dec74273db30ea902353b1081e889af81e2b5709d582859e5d601e2cf81fd8ffc2c1f5f6011c63edbf3fd047bf419e9c1e5a1c6b740c0b4d8457f9f262384121a63243dfa8aeb367e7b371fb366c9af05d1cf1a0752292263c350909d5be20eba7811fa3c7caa773bbc046eeb7485dcc322e1def5ee0ad64605194e30274872bf757010af24b409233b405c4aa5608f269972bf11214cdee3f696b176956a49e9001dd8073276c1d509c92c5dda9b262088797f1259c3178cd66a2609a619f6966d16e0c3c5868e62f892947e45ae07a106f07d6cbc09fa6ce0f6481379d461695b8eb33a55647adb70490ebe106d1ea9347778b1da3b0051e8f4e65980758c4bcb3ba7900a59c451fdd5b7d48a45d6a89fc0567a83a83ab60c18b1167c5b4576786a906bcbdbfeaf7757346479c312a67e256bc1971a69994a712e279f132aea562913540fb4c1e6226bc4b43fc9c58b2adaba7a9967d555717f1b1584aa113fbd858fc7365aef4e96acc33c2509108c6f85e85d18cdc98dbdd535db342631e027596f3521976276ee21d413cc8bf',
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