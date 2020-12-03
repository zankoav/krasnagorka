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

// HELP https://www.amocrm.ru/developers/content/oauth/step-by-step
