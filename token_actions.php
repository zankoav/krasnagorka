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
        'code' => 'def50200fe6bd3fca0884d334f39588bd8e39531f69342f8eb8371218d604847d21ccd5a0460c85e84f9ea2f0261f842d1a1d807cbcf3981bf74c3441b644428fdbafe17fefe9623368ffecfc74072de13760e07c7083e04faed8152e104705a439ba05875a2c4448ab00e021bd9a0221b977b8c3944d1605aef13ab2567b72d6d8f010c9b400e5874689793cd66f4c9be6d4ad4d2756cb3132dcda36e4071028fc5d4ca0f92c68e59068164a77458958db36f21ede1e53721939fb64bf3e24b07e57fd9e244db593d853ecad84157ce8e6bfc3e6dcfa33ce84194fde4e2532f4a844e65a8080e359df00087d213cf4e5f8c5f093def8eaf11d46d8c03c070d795f2390bdd8caf3912a702a7ffb47ba36200067e1a25a1b94952eb9016a8d9133ebca8f206b0961a96d88f7e282bbdb7c1eb3a4056efc1832084139c01a06e16dd60a097ed1238a9adecb35037fa294cb00992e2dd0bddfe41f7e1d55ca35951935ff7467223b16fe476025edfddb85faf38ef1bb55ac23fe5f28eae2432084b694186d922347a142f8557ce25aae77a7c3059abd3a90f53650e989faa9d200c3a1b51dd257ceeb799970199300f16c8b8cd8bffefb9b7c58205479b0b4fe8d2',
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
